<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Post;
use App\User;
use App\Liste;
use App\Comment;
use App\Events\JournalCommentStored;
use App\Events\ListCommentStored;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ListCommentNotification;
use App\Notifications\PostCommentNotification;
use App\Notifications\JournalCommentNotification;

class CommentController extends Controller
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);

        $list_id = $request['list_id'];
        $journal_id = $request['journal_id'];
        $blog_id = $request['blog_id'];
        $comment_body = $request['body'];
        $user = Auth::user();

        $request->validate([
            'body' => 'required'
        ]);

        if ($blog_id) {

            $blog = Blog::find($blog_id);

            if (!$blog) {
                return null;
            } else {

                $comment = $blog->comments()->create([
                    'body' => $comment_body,
                    'user_id' => $user->id,
                ]);

                return back()->withSuccess('Comment successfully added.');
            }
        }

        if ($list_id) {

            $list = Liste::find($list_id);

            if (!$list) {
                return null;
            } else {

                $comment = $list->comments()->create([
                    'body' => $comment_body,
                    'user_id' => $user->id,
                ]);

                event(new ListCommentStored($comment));

                return back()->withSuccess('Comment successfully added.');
            }
        }

        if ($journal_id) {

            $journal = Journal::find($journal_id);

            if (!$journal) {
                return null;
            } else {
                $comment = $journal->comments()->create([
                    'body' => $comment_body,
                    'user_id' => $user->id,
                ]);

                event(new JournalCommentStored($comment));

                if ($comment->commentable->user) {

                    if ($user->id != $comment->commentable->user->id) {

                        $comment->commentable->user->notify(new JournalCommentNotification($comment));
                    }
                }

                return back()->withSuccess('Comment successfully added.');
            }
        }

        /**
        if($post_id){
            $post = Post::find($post_id);

            if(!$post){
                return null;
            } else {
                $comment = $post->comments()->create([
                            'body' => $comment_body,
                            'user_id' => $user->id,
                        ]);

                if ($comment->commentable->user){

                    if($user->id != $comment->commentable->user->id){

                        $comment->commentable->user->notify(new PostCommentNotification($comment));

                    }
                }

                return back()->withSuccess('Comment successfully added.');
            }
        }
         */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment_body = $request["body"];

        $comment->body = $comment_body;

        $comment->save();

        return response()->json([
            'msg' => $comment->body,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user->id == Auth::user()->id || Auth::user()->id == $comment->commentable->user->id) {
            $comment->delete();
            return back();
        }
        return back()->withSuccess('Comment successfully deleted.');
    }
}
