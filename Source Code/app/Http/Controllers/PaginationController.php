<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\User;
use App\Liste;
use App\Journal;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Illuminate\Database\Eloquent\Builder;

class PaginationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('renderAllLists', 'renderAllJournals', 'renderUserLists', 'renderUserJournal');
        $this->middleware('verified')->except('renderAllLists', 'renderAllJournals', 'renderUserLists', 'renderUserJournal');
    }

    /** For Scrolling
            return [
                'posts' => view('posts.ajax.block')->with(compact('posts'))->render(),
                'next_page' => $posts->nextPageUrl()
            ];
     */

    public function renderAuthLists(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $lists = Liste::where('user_id', auth()->id())->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18);
        $lists->withPath(url('render-auth-lists'));

        return view('list.ajax.block')->with(compact('lists'));
    }

    public function renderAuthJournal(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $journals = Journal::where('user_id', auth()->id())->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18);
        $journals->withPath(url('render-auth-journal'));
        return view('journal.ajax.block')->with(compact('journals'));
    }

    public function renderAllLists(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $lists = Liste::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18);
        $lists->withPath(url('render-all-lists'));
        return view('list.ajax.block')->with(compact('lists'));
    }

    public function renderAllJournals(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $journals = Journal::whereHas('user', function (Builder $query) {
            $query->where('status', 0);
        })->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18);
        $journals->withPath(url('render-all-journals'));
        return view('journal.ajax.block')->with(compact('journals'));
    }

    public function renderFriendLists(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $friends = auth()->user()->getFriends();
        $user_friends_id = $friends->pluck('id')->toArray();

        // Get Friend Lists
        $lists = Liste::whereIn('user_id', $user_friends_id)->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(18)->withPath(url('render-friends-lists'));

        return view('list.ajax.block')->with(compact('lists'));
    }

    public function renderFriendJournals(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $friends = auth()->user()->getFriends();
        $user_friends_id = $friends->pluck('id')->toArray();

        // Get Friend Journals
        $journals = Journal::whereIn('user_id', $user_friends_id)->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(18)->withPath(url('render-friends-journals'));

        return view('journal.ajax.block')->with(compact('journals'));
    }

    public function renderUserLists($slug, Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $user = User::where('slug', $slug)->first();
        $lists = Liste::where('user_id', $user->id)->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(6);
        $lists->withPath($user->slug . '/render-lists');
        return view('list.ajax.block')->with(compact('lists'));
    }

    public function renderUserJournal($slug, Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $user = User::where('slug', $slug)->first();
        $journals = Journal::where('user_id', $user->id)->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(3);
        $journals->withPath($user->slug . '/render-journal');
        return view('journal.ajax.block')->with(compact('journals'));
    }

    public function renderSearchPosts($phrase, Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $searchResults = (new Search())
            ->registerModel(Post::class, 'title')
            ->search($phrase);

        $posts = $searchResults->groupByType()->get('posts');
        $posts = paginate($posts, 6);
        $posts->withPath(url('render-search-posts/') . "/" . $phrase);

        return view('posts.ajax.search')->with(compact('posts'));
    }

    public function renderSearchJournals($phrase, Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $searchResults = (new Search())
            ->registerModel(Journal::class, 'description')
            ->search($phrase);

        $journals = $searchResults->groupByType()->get('journals');
        $journals = paginate($journals, 3);
        $journals->withPath(url('render-search-journals/') . "/" . $phrase);

        return view('journal.ajax.search')->with(compact('journals'));
    }
}
