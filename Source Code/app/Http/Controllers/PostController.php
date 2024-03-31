<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use App\Notifications\PostCreateNotification;
use App\Notifications\PostUpdateNotification;

class PostController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('getImage');
        $this->middleware('verified')->except('getImage');
    }


    public function create()
    {
        return view('post.create');
    }

    public function cropImage(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::find($post_id);

        $post_image = $_POST['post_image'];
        list($type, $post_image) = explode(';', $post_image);
        list(, $post_image)      = explode(',', $post_image);
        $post_image = base64_decode($post_image);

        // $image_extension = explode('.', $post->post_image);
        // $image_extension = end($image_extension);

        $filename = $post->post_image;
        file_put_contents(storage_path('uploads/posts/') . $filename, $post_image);
        // Image::make($image)->save( storage_path('uploads\posts\\' . $filename) );
        // Storage::putFileAs('uploads/posts', $filename, $post_image);
        $post->update([
            'post_image'  => $filename,
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|max:100',
            'description' => 'required|max:500'
        ]);

        $image = $request->file('post_image');
        $cropped_image = $request->cropped_image;
        $filename = time() . '.' . $image->extension();
        // Image::make($image)->save( storage_path('uploads\posts\\' . $filename) );
        Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/posts/' . $filename));

        $post = Post::create([
            'title'     => $request->title,
            'description' => $request->description,
            'post_image'  => $filename,
            'user_id'   => Auth::user()->id,
        ]);

        return redirect('/');
    }

    public function getImage($filename, Request $request)
    {
        $file = storage_path('uploads/posts/' . $filename);
        return response()->file($file);
    }

    public function edit(Post $post)
    {
        if (Auth::user() != $post->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this post.');
            }
        }
        return view('post.edit', compact('post'));
    }


    public function update(Request $request, Post $post)
    {
        if (Auth::user() != $post->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to edit this post.');
            }
        }

        $this->validate($request, [
            'title'       => 'required|max:100',
            'description' => 'required|max:500',
        ]);

        $post->title = $request->title;
        $post->description = $request->description;



        if ($request->post_image) {
            $image = $request->post_image;
            $cropped_image = $request->cropped_image;
            $filename = time() . '.' . $image->extension();

            $file = [
                storage_path('uploads/posts/' . $post->post_image),
            ];
            File::delete($file);

            Image::make(file_get_contents($cropped_image))->save(storage_path('uploads/posts/' . $filename));

            $post->post_image = $filename;
        }

        $post->save();

        return redirect()->route('list.show', $post->list->slug)->with('success', 'Post info updated successfully.');
    }

    public function destroy(Post $post, Request $request)
    {
        if (Auth::user() != $post->user) {
            if (Gate::denies('manage-contents')) {
                return back()->withError('You\'re not authorized to delete this post.');
            }
        }

        if (\App\Liste::find($post->liste_id)->posts->count() <= 1) {
            return redirect()->route('lists.show', $post->liste_id)->with('error', 'You have only one post in this list.');
        }

        $file = [
            storage_path('uploads/posts/' . $post->post_image),
        ];

        File::delete($file);

        $post->delete();

        return redirect()->route('lists.show', $post->liste_id)->with('success', 'You have successfully deleted the post.');
    }
}
