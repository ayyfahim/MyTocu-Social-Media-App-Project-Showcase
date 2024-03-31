<?php

namespace App\Http\Controllers\Admin;

use App\Frontend\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about_us = AboutUs::all();
        return view('dashboard.about-us.index', compact('about_us'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.about-us.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'about_name' => 'required',
            'about_title' => 'required',
            'background_image' => 'required|file|mimes:jpeg',
        ]);

        $banner_image =  time() . '.' . $request->background_image->extension();
        Image::make($request->background_image)->save(public_path('images/about_us/banner/' . $banner_image));

        $about_us =     AboutUs::create([
            'name' => $request->about_name,
            'title' => $request->about_title,
            'image' => $banner_image,
            'aboutus-trixFields' => request('aboutus-trixFields'),
            'attachment-aboutus-trixFields' => request('attachment-aboutus-trixFields'),
            'status' => '1',
        ]);

        AboutUs::whereNotIn('id', [$about_us->id])->update(['status' => '0']);

        return back()->withSuccess('About Us added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Frontend\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function edit(AboutUs $aboutUs)
    {
        return view('dashboard.about-us.edit', compact('aboutUs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Frontend\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AboutUs $aboutUs)
    {
        if($request->background_image){
            $banner_image =  time() . '.' . $request->background_image->extension();
            Image::make($request->background_image)->save(public_path('images/about_us/banner/' . $banner_image));
            $aboutUs->image = $banner_image;
        }

        $aboutUs->name = $request->about_name;
        $aboutUs->title = $request->about_title;
        $aboutUs['aboutus-trixFields'] = request('aboutus-trixFields');
        $aboutUs['attachment-aboutus-trixFields'] = request('attachment-aboutus-trixFields');
        $aboutUs->status = '1';
        $aboutUs->save();

        return back()->withSuccess('About Us updated successfully');
    }

    /**
     * Activate the resource.
     *
     * @param  \App\Frontend\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function activate(AboutUs $aboutUs)
    {
        AboutUs::where('id', $aboutUs->id)->update(['status' => '1']);
        AboutUs::whereNotIn('id', [$aboutUs->id])->update(['status' => '0']);
        return back()->withSuccess('About Us activated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Frontend\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutUs $aboutUs)
    {

        $file = [
            public_path('images/about_us/banner/' . $aboutUs->image),
        ];

        File::delete($file);
        $aboutUs->delete();

        return back()->withSuccess('About Us deleted Successfully');
    }
}
