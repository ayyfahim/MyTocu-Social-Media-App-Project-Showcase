<?php

namespace App\Http\Controllers;

use App\Liste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class ListController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('verified')->except('show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Create a list of your favorite things');
        return view('list.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'post_title' => 'required|max:100',
            'list_title' => 'required|max:100',
            'description' => 'required|max:500'
        ]);

        $image = $request->file('post_image');
        $cropped_image = $request->cropped_image;
        $filename = time() . '.' . $image->extension();
        Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/posts/' . $filename));

        $list = Auth::user()->lists()->create([
            'title' => $request->list_title,
        ]);

        $list->slug =  $list->slug . '-' . now()->timestamp;
        $list->save();

        $post = $list->posts()->create([
            'title'     => $request->post_title,
            'description' => $request->description,
            'post_image'  => $filename,
            'user_id' => Auth::id(),
        ]);

        // List Observer for notifications

        return redirect()->route('list.show', $list->slug)->withSuccess('List created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $list = Liste::where('slug', $slug)->with('userWithTrashed', 'posts', 'likes')->first();

        $condition = false;

        if ($list->user && $list->user->status == 0) {
            $condition = true;
        } else if ($list->userWithTrashed == auth()->user()) {
            $condition = true;
        } else if (auth()->user()->isFriendWith($list->user)) {
            $condition = true;
        }

        if ($condition) {
            //SEO
            $meta_title = $list->title . " by " . $list->user->name;
            $meta_description = $list->title . ' is a list created by ' . $list->user->name . '.' . env('APP_DESC');
            $meta_url = route('list.show', $list->slug);
            $image = route('image.post', $list->posts->last()->post_image);
            $keywords = "mytocu, lists, posts, " . implode(', ', $list->posts->pluck('title')->toArray());

            SEOMeta::setTitle($meta_title);
            SEOMeta::setDescription($meta_description);
            OpenGraph::setUrl($meta_url);
            OpenGraph::addImage($image);

            OpenGraph::setTitle($meta_title)
                ->setDescription($meta_description)
                ->setType('article')
                ->setArticle([
                    'published_time' => $list->created_at->toW3CString(),
                    'modified_time' => $list->created_at->toW3CString(),
                    'expiration_time' => $list->created_at->toW3CString(),
                    'author' => $list->user->name,
                    'section' => 'list',
                    'tag' => $keywords
                ]);

            $comments = $list->comments;
            return view('list.show', compact('list', 'comments'));
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $list = Liste::where('slug', $slug)->with('user')->first();

        if (Auth::user() != $list->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this list.');
            }
        }

        SEOMeta::setTitle('Edit List: ' . $list->title);

        return view('list.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function update($slug, Request $request)
    {
        $list = Liste::where('slug', $slug)->with('user')->first();

        if (Auth::user() != $list->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this list.');
            }
        }

        if ($request->post_title) {

            // Validating Post
            $this->validate($request, [
                'post_title' => 'required|max:100',
                'list_title' => 'required|max:100',
                'description' => 'required|max:500'
            ]);

            // Making The Image
            $image = $request->file('post_image');
            $cropped_image = $request->cropped_image;
            $filename = time() . '.' . $image->extension();
            Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/posts/' . $filename));

            // Creating Post
            $post = $list->posts()->create([
                'title'     => $request->post_title,
                'description' => $request->description,
                'post_image'  => $filename,
                'user_id' => auth()->id()
            ]);

            // Updating the List Title
            if ($request->list_title) {
                $list->update([
                    'title' => $request->list_title
                ]);
                $list->slug =  $list->slug . '-' . now()->timestamp;
                $list->save();
            }
        } else {
            // Updating the List Title
            $list->update([
                'title' => $request->list_title
            ]);
            $list->slug =  $list->slug . '-' . now()->timestamp;
            $list->save();
        }

        return redirect()->route('list.show', $list->slug)->with('success', 'List updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function delete($slug)
    {
        $list = Liste::where('slug', $slug)->with('user')->first();

        if (Auth::user() != $list->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError("You're not authorized to delete this list.");
            }
        }

        foreach ($list->posts as $post) {
            $file = [storage_path('uploads/posts/' . $post->post_image)];
            File::delete($file);
        }

        $list->delete();

        return redirect('/')->withSuccess('List successfully deleted.');
    }
}
