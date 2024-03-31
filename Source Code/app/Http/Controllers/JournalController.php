<?php

namespace App\Http\Controllers;

use App\User;
use App\Journal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendJournalCreateMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\Notifications\JournalCreateNotification;
use App\Notifications\JournalUpdateNotification;

class JournalController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('getImage', 'show');
        $this->middleware('verified')->except('getImage', 'show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Create a Journal');
        return view('journal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If a journal has image
        if ($request->file('journal_image')) {

            $this->validate($request, [
                'description' => 'required|max:1000',
                'journal_image'  => 'image|max:10240'
            ]);

            // Saving the Image
            $image = $request->file('journal_image');
            $cropped_image = $request->cropped_image;
            $filename = time() . '.' . $image->extension();
            Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/journals/' . $filename));

            // Making a unique slug
            $slug = Str::slug(auth()->user()->name, '-');
            $slug = $slug . '-' . now()->timestamp;

            // Saving the Journal
            $journal = Journal::create([
                'description' => $request->description,
                'journal_image'  => $filename,
                'user_id' => Auth::user()->id,
                'slug' => $slug
            ]);

            return redirect()->route('journal.show', $journal->slug)->with('success', 'Journal was created successfully!');
        } else {

            $this->validate($request, [
                'description' => 'required|max:1000'
            ]);

            // Making a unique slug
            $slug = Str::slug(auth()->user()->name, '-');
            $slug = $slug . '-' . now()->timestamp;

            // Saving the Journal
            $journal = Journal::create([
                'description' => $request->input('description'),
                'user_id'   => Auth::user()->id,
                'slug' => $slug
            ]);

            return redirect()->route('journal.show', $journal->slug)->with('success', 'Journal was created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        if ($journal->user && $journal->user->status == 0) {
            $condition = true;
        } else if ($journal->userWithTrashed == auth()->user()) {
            $condition = true;
        } else if (auth()->user()->isFriendWith($journal->user)) {
            $condition = true;
        }

        if ($condition) {
            //SEO
            $meta_title = "Journal by " . $journal->user->name;
            $meta_description = $journal->description . env('APP_DESC');
            $meta_url = route('journal.show', $journal->slug);
            if ($journal->journal_image) {
                $image = route('image.journal', $journal->journal_image);
            }
            $keywords = "mytocu, journal";

            SEOMeta::setTitle($meta_title);
            SEOMeta::setDescription($meta_description);
            SEOMeta::addKeyword($keywords);
            OpenGraph::setUrl($meta_url);
            if ($journal->journal_image) {
                OpenGraph::addImage($image);
            }

            OpenGraph::setTitle($meta_title)
                ->setDescription($meta_description)
                ->setType('article')
                ->setArticle([
                    'published_time' => $journal->created_at->toW3CString(),
                    'modified_time' => $journal->created_at->toW3CString(),
                    'expiration_time' => $journal->created_at->toW3CString(),
                    'author' => $journal->user->name,
                    'section' => 'list',
                    'tag' => $keywords
                ]);

            $comments = $journal->comments;
            $auth_user = Auth::user();
            return view('journal.show', compact('journal', 'auth_user', 'comments'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        if (Auth::user() != $journal->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this journal.');
            }
        }

        SEOMeta::setTitle('Edit Journal');
        return view('journal.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        if (Auth::user() != $journal->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this journal.');
            }
        }

        $this->validate($request, [
            'description' => 'required|max:1000',
        ]);

        $journal->description = $request->description;

        if ($request->file('journal_image')) {
            $image = $request->file('journal_image');
            $cropped_image = $request->cropped_image;
            $filename = time() . '.' . $image->extension();
            $file = [
                storage_path('uploads/journals/' . $journal->journal_image),
            ];
            File::delete($file);
            Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/journals/' . $filename));
            $journal->journal_image = $filename;
        }

        $journal->save();

        $journal_update = $journal;

        return redirect()->route('journal.show', $journal->slug)->with('success', 'Journal was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {

        if (Auth::user() != $journal->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to delete this journal.');
            }
        }

        $file = [
            storage_path('uploads/journals/' . $journal->journal_image),
        ];
        File::delete($file);

        $journal->delete();

        return redirect('/')->with('success', 'Journal deleted successfully.');
    }

    /**
     * Crop the Journal Image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cropImage(Request $request)
    {
        $journal_id = $request->journal_id;
        $journal = Journal::find($journal_id);

        $journal_image = $_POST['journal_image'];
        list($type, $journal_image) = explode(';', $journal_image);
        list(, $journal_image)      = explode(',', $journal_image);
        $journal_image = base64_decode($journal_image);

        $filename = $journal->journal_image;
        file_put_contents(storage_path('uploads/journals/') . $filename, $journal_image);
        $journal->update([
            'journal_image'  => $filename,
        ]);
    }

    /**
     * Get the Journal Image.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImage($filename)
    {
        $file = storage_path('uploads/journals/' . $filename);
        return response()->file($file);
    }
}
