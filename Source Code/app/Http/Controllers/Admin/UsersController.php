<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index', [
            'users' => User::withTrashed()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        if (Gate::denies('edit-users')) {
            return redirect()->route('admin.users.index');
        }
        return view('dashboard.users.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        if (Gate::denies('edit-users')) {
            return redirect()->route('admin.users.index');
        }

        $user->roles()->sync($request->roles);
        $user->gender = $request->gender;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        return view('dashboard.users.view', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        if (Gate::denies('delete-users')) {
            return redirect()->route('admin.users.index');
        }
        $user->roles()->detach();
        $user->forceDelete();
        return redirect()->route('admin.users.index');
    }
}
