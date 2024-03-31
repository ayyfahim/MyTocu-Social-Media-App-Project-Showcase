<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Journal;

use Spatie\Searchable\Search;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class SearchController extends Controller
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

    public function index(Request $request)
    {
        $phrase = $request->search_query;

        if (!$phrase) {
            abort(404);
        }

        $searchResults = (new Search())
            ->registerModel(User::class, 'name', 'email')
            ->registerModel(Post::class, 'title')
            ->registerModel(Journal::class, 'description')
            ->search($phrase);

        $users = $searchResults->groupByType()->get('users');

        $posts = $searchResults->groupByType()->get('posts');
        $posts = paginate($posts, 6);
        $posts->withPath(url('render-search-posts/') . "/" . $phrase);

        $journals = $searchResults->groupByType()->get('journals');
        $journals = paginate($journals, 3);
        $journals->withPath(url('render-search-journals/') . "/" . $phrase);

        return view('search.index', [
            'searchResults' => $searchResults,
            'searchText' => $phrase,
            'users' => $users,
            'posts' => $posts,
            'journals' => $journals,
        ]);

        /**
           return view('search.index', [
                'phrases' => $request->search,
                'users' => User::search($request->search)
                                        ->get(),
                'posts' => Post::search($request->search)
                                        ->get(),
                'journals' => Journal::search($request->search)
                                        ->get(),
            ]);
         */
    }
}
