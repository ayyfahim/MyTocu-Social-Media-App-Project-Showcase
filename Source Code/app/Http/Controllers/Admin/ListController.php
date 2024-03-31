<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Liste;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Liste::latest()->get();
        return view('dashboard.lists.index', compact('lists'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function show(Liste $liste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function edit(Liste $liste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liste $liste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liste $liste)
    {
        //
    }
}
