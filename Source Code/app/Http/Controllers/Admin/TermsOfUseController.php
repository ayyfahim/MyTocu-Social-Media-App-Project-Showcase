<?php

namespace App\Http\Controllers\Admin;

use App\Frontend\TermsOfUse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = TermsOfUse::all();
        return view('dashboard.terms-of-use.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.terms-of-use.create');
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
            'term_title' => 'required',
            'termsofuse-trixFields' => 'required',
        ]);

        TermsOfUse::create([
            'term_header' => $request->term_title,
            'termsofuse-trixFields' => request('termsofuse-trixFields'),
            'attachment-termsofuse-trixFields' => request('attachment-termsofuse-trixFields'),
        ]);

        return back()->withSuccess('Term Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Frontend\TermsOfUse  $termsOfUse
     * @return \Illuminate\Http\Response
     */
    public function edit(TermsOfUse $termsOfUse)
    {
        return view('dashboard.terms-of-use.edit', compact('termsOfUse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Frontend\TermsOfUse  $termsOfUse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermsOfUse $termsOfUse)
    {
        $termsOfUse->term_header = $request->term_title;
        $termsOfUse['termsofuse-trixFields'] = request('termsofuse-trixFields');
        $termsOfUse['attachment-termsofuse-trixFields'] = request('attachment-termsofuse-trixFields');
        $termsOfUse->save();
        return back()->withSuccess('Term Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Frontend\TermsOfUse  $termsOfUse
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsOfUse $termsOfUse)
    {
        $termsOfUse->delete();
        return back()->withSuccess('Term Deleted Successfully');
    }
}
