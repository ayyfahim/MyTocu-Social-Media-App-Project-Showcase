<?php

namespace App\Http\Controllers\Admin;

use App\Frontend\PrivacyPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policies = PrivacyPolicy::all();
        return view('dashboard.privacy-policy.index', compact('policies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.privacy-policy.create');
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
            'privacy_policy_title' => 'required',
            'privacypolicy-trixFields' => 'required',
        ]);

        PrivacyPolicy::create([
            'policy_header' => $request->privacy_policy_title,
            'privacypolicy-trixFields' => request('privacypolicy-trixFields'),
            'attachment-privacypolicy-trixFields' => request('attachment-privacypolicy-trixFields'),
        ]);

        return back()->withSuccess('Privacy Policy Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Frontend\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('dashboard.privacy-policy.edit', compact('privacyPolicy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Frontend\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->policy_header = $request->privacy_policy_title;
        $privacyPolicy['privacypolicy-trixFields'] = request('privacypolicy-trixFields');
        $privacyPolicy['attachment-privacypolicy-trixFields'] = request('attachment-privacypolicy-trixFields');
        $privacyPolicy->save();
        return back()->withSuccess('Policy Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Frontend\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();
        return back()->withSuccess('Policy Deleted Successfully');
    }
}
