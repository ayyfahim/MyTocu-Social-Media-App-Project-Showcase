<?php

namespace App\Http\Controllers;

use App\Liste;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UserTabsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function userLists(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $lists = Liste::where('user_id', auth()->id())->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18);
        $lists->withPath(url('render-auth-lists'));
        return view('user.lists', compact('lists'));
    }

    public function userJournals(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $journals = Journal::where('user_id', auth()->id())->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18);
        $journals->withPath(url('render-auth-journal'));
        return view('user.journals', compact('journals'));
    }

    public function userFriends(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        /**
         * It still works but that's a very long query -_-

        $lists = [];
        $friends_lists_each = auth()->user()->getFriends()->each(function ($user) use (&$lists) {
            $lists = array_merge($lists, $user->lists->all());
        });
        $lists = paginate($lists, 18);
        $lists->withPath(url('render-friends-lists'));

        $journals = [];
        $friends_journals_each = auth()->user()->getFriends()->each(function ($user) use (&$journals) {
            $journals = array_merge($journals, $user->journals->all());
        });
        $journals = paginate($journals, 18);
        $journals->withPath(url('render-friends-journals'));

         */

        // Get Friends and their ID's into an array
        $friends = auth()->user()->getFriends();
        $user_friends_id = $friends->pluck('id')->toArray();

        // Get Friend Lists and Journals
        $lists = Liste::whereIn('user_id', $user_friends_id)->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18)->withPath(url('render-friends-lists'));
        $journals = Journal::whereIn('user_id', $user_friends_id)->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18)->withPath(url('render-friends-journals'));

        return view('user.friends', compact('lists', 'journals', 'friends'));
    }

    public function userExplore(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $lists = Liste::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18);
        $lists->withPath(url('render-all-lists'));

        $journals = Journal::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18);
        $journals->withPath(url('render-all-journals'));

        return view('user.explore', compact('lists', 'journals'));
    }
}
