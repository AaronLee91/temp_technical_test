<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Article;
use Illuminate\Support\Str;
use Auth;
use Validator;

class CommentsController extends Controller
{
    public $successStatus = 200;

    /**
     * Create a new controller instance.
     *
     * @return mixed
     */
    public function __construct()
    {

    }


    /**
     * API to Display a listing of the comments for an article.
     *
     * @param  int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function index($comment_id)
    {
        // Get all Articles, ordered by the newest first
        $comment = Comments::find($comment_id);
        if ($comment) {
            $comment['article'] = $comment->article;

            return response()->json(['success' => $comment], $this->successStatus);
        }
        return response()->json(['error' => 'Comment Not Found!'], $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $article_id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $article_id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|min:5|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::user()) {
            $input['body'] = $request->input('body');

            // Search article by article id
            $article = Article::find($article_id);

            if ($article) {
                // Create slug from title
                $input['slug'] = Str::slug($article->slug . ' ' . time() . rand(10, 99), '-');
                $input['article_id'] = $article_id;
                $input['user_id'] = Auth::user()->id;

                // Create and save article with validated data
                $comment = Comments::create($input);

                return response()->json(['success' => $comment], $this->successStatus);
            } else {
                return response()->json(['error' => "Article Not Found!"], 401);
            }

        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment_id)
    {
        // Validate posted form data
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|min:5|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if ($user = Auth::user()) {
            $input['body'] = $request->input('body');

            // Find article by ID
            $comment = Comments::find($comment_id);

            // Only allow update if comment exist & owner of the comment or admin
            if ($comment && ($user->id === $comment->user_id || $user->isAdmin())) {
                $comment->update($input);

                return response()->json(['success' => $comment], $this->successStatus);
            } else {
                if ($user->id !== $comment->user_id) {
                    return response()->json(['error' => 'User not authorised!!'], 401);
                }
                return response()->json(['error' => 'Comments Not Found!'], 401);
            }


        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function delete($comment_id)
    {
        if ($user = Auth::user()) {
            // Find article by ID
            $comment = Comments::find($comment_id);
            $comment_slug = $comment->slug;

            // Only allow update if comment exist & owner of the comment
            if ($comment && ($user->id === $comment->user_id || $user->isAdmin())) {
                $comment->delete();
                return response()->json(['success' => $comment_slug . " deleted"], $this->successStatus);
            } else {
                if ($user->id !== $comment->user_id) {
                    return response()->json(['error' => 'User not authorised!!'], 401);
                }
                return response()->json(['error' => 'Comments Not Found!'], 401);
            }


        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }
    }
}
