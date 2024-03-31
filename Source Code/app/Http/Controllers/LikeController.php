<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use App\Liste;
use App\Comment;
use App\Events\JournalLikeStored;
use App\Events\ListLikeStored;
use App\Events\PostLikeStored;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ListLikeNotification;
use App\Notifications\PostLikeNotification;
use App\Notifications\JournalLikeNotification;

class LikeController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrDeleteLike(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $post_id = $request['postId'];
        $journal_id = $request['journalId'];
        $list_id = $request['listId'];
        $comment_id = $request['commentId'];
        $is_like = $request['isLike'];
        $update = 0;
        $user = Auth::user();

        /** List Like */

        if ($list_id) {

            $list = Liste::find($list_id);

            if (!$list) {
                return null;
            }

            $like = $list->likes->where('user_id', $user->id)->first();


            if ($like) {

                $already_like = $like->like;
                $update = 0;
                if ($already_like == $is_like) {
                    $like->delete();
                    $list = Liste::find($list_id);
                    $like_count = $list->likes->where('like', 1)->count();
                    return response()->json([
                        'count' => $like_count,
                    ]);
                }
            } else {
                $like = $list->likes()->create([
                    'like'     => $is_like,
                    'user_id'  => $user->id,
                ]);

                event(new ListLikeStored($like));

                $list = Liste::find($list_id);
                $like_count = $list->likes->where('like', 1)->count();
                return response()->json([
                    'count' => $like_count,
                ]);
            }
        }

        /** Post Like */

        if ($post_id) {
            $post = Post::find($post_id);

            if (!$post) {
                return null;
            }

            $like = $post->likes->where('user_id', $user->id)->first();


            if ($like) {

                $already_like = $like->like;
                $update = 0;
                if ($already_like == $is_like) {
                    $like->delete();
                    $post = Post::find($post_id);
                    $like_count = $post->likes->where('like', 1)->count();
                    return response()->json([
                        'count' => $like_count,
                    ]);
                }
            } else {
                $like = $post->likes()->create([
                    'like'     => $is_like,
                    'user_id'  => $user->id,
                ]);

                event(new PostLikeStored($like));

                $post = Post::find($post_id);
                $like_count = $post->likes->where('like', 1)->count();
                return response()->json([
                    'count' => $like_count,
                ]);
            }
        }

        /** Journal Like */

        if ($journal_id) {

            $journal = Journal::find($journal_id);
            if (!$journal) {
                return null;
            }

            $like = $journal->likes()->where('user_id', $user->id)->first();


            if ($like) {
                $already_like = $like->like;
                $update = 0;
                if ($already_like == $is_like) {
                    $like->delete();

                    $journal = Journal::find($journal_id);
                    $like_count = $journal->likes->where('like', 1)->count();
                    return response()->json([
                        'count' => $like_count,
                    ]);
                }
            } else {
                $like = $journal->likes()->create([
                    'like'     => $is_like,
                    'user_id'  => $user->id,
                ]);

                event(new JournalLikeStored($like));

                $journal = Journal::find($journal_id);

                $like_count = $journal->likes->where('like', 1)->count();
                return response()->json([
                    'count' => $like_count,
                ]);
            }
        }

        /** Comment Like */

        if ($comment_id) {

            $comment = Comment::find($comment_id);

            if (!$comment) {
                return null;
            }

            $like = $comment->likes()->where('user_id', $user->id)->first();


            if ($like) {
                $already_like = $like->like;
                $update = 0;
                if ($already_like == $is_like) {
                    $like->delete();
                    $comment = Comment::find($comment_id);
                    $like_count = $comment->likes->where('like', 1)->count();
                    return response()->json([
                        'count' => $like_count,
                    ]);
                }
            } else {
                $comment->likes()->create([
                    'like'     => $is_like,
                    'user_id'  => $user->id,
                ]);

                $comment = Comment::find($comment_id);

                $like_count = $comment->likes->where('like', 1)->count();
                return response()->json([
                    'count' => $like_count,
                ]);
            }
        }
    }
}
