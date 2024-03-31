<?php

namespace App\Http\Controllers;

use Image;
use App\Blog;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Blogs');
        SEOMeta::setDescription('MyTocu is a social network site that allows you to connect with people based on what they’ve expressed as their best experiences or the things they love.');
        OpenGraph::setTitle('Blogs')
            ->setDescription('MyTocu is a social network site that allows you to connect with people based on what they’ve expressed as their best experiences or the things they love.');
        return view('blog.index', [
            'blogs' => Blog::latest()->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Create Blog');
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-blogs')) {
            return redirect()->route('blog.store');
        }

        $request->validate([
            'blog_title' => 'required',
            'blog_image' => 'required',
            'blog-trixFields' => 'required',
        ]);

        $image = $request->file('blog_image');
        $filename = time() . '.' . $image->extension();
        Image::make($image)->save(storage_path('uploads/blogs/' . $filename));

        $create = Blog::create([
            'title' => $request->blog_title,
            'blog-trixFields' => request('blog-trixFields'),
            'attachment-blog-trixFields' => request('attachment-blog-trixFields'),
            'image' => $filename,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('blog.create')->with('success', 'Blog successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        SEOMeta::setTitle($blog->title);
        SEOMeta::setDescription(str_limit(strip_tags($blog->trixRichText->first()->content), '446'));
        OpenGraph::setTitle($blog->title)
            ->setDescription(str_limit(strip_tags($blog->trixRichText->first()->content), '446'))
            ->setType('article')
            ->setArticle([
                'published_time' => $blog->created_at->toW3CString(),
                'modified_time' => $blog->created_at->toW3CString(),
                'expiration_time' => $blog->created_at->toW3CString(),
                'author' =>  $blog->user->name,
            ]);

        return view('blog.show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Display the specified image.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function getImage($filename)
    {
        $file = storage_path('uploads/blogs/' . $filename);
        return response()->file($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        if (Gate::denies('manage-blogs')) {
            return redirect()->route('blog.store');
        }

        return view('blog.edit', [
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        if (Gate::denies('manage-blogs')) {
            return redirect()->route('blog.store');
        }

        if ($request->file('blog_image')) {
            $file = [
                storage_path('uploads/blogs/' . $blog->image),
            ];
            File::delete($file);
            $image = $request->file('blog_image');
            $filename = time() . '.' . $image->extension();
            Image::make($image)->save(storage_path('uploads/blogs/' . $filename));
            $blog->image = $filename;
        }

        $blog->title = $request->blog_title;
        $blog['blog-trixFields'] = request('blog-trixFields');
        $blog['attachment-blog-trixFields'] = request('attachment-blog-trixFields');
        $blog->save();

        return redirect()->route('blog.edit', $blog->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if (Gate::denies('manage-blogs')) {
            return redirect()->route('blog.store');
        }

        $blog->delete();
        return redirect()->route('blog.index');
    }
}
