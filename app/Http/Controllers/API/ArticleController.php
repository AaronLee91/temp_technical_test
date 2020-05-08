<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Str;
use Auth;
use Validator;

class ArticleController extends Controller
{
    public $successStatus = 200;

    /**
     * API to Display a listing of the articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all Articles, ordered by the newest first
        $articles = Article::latest()->get();
        if ($articles) {
            foreach ($articles as $key => &$article) {
                $article['comments_count'] = $article->getCommentsCount();
            }

            return response()->json(['success' => $articles], $this->successStatus);
        }
        return response()->json(['error' => 'No rticle Not Found!'], $this->successStatus);
    }

    /**
     * API to Display a listing of the articles.
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function read_one($id)
    {
        // Get all Articles, ordered by the newest first
        $article = Article::find($id);

        if ($article) {
            foreach ($article->comments as $key => &$comment) {
                $comment['commenters_name'] = $comment->user()->select('users.name')->first()->name;
            }
            $article['comments'] = $article->comments;
            return response()->json(['success' => $article], $this->successStatus);
        } else {
            return response()->json(['error' => "Article Not Found!"], 401);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:articles|min:5|max:100',
            'description' => 'required|string|min:5|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::user()) {
            $input = $request->all();

            // Create slug from title
            $input['slug'] = Str::slug($input['title'], '-');
            $input['user_id'] = Auth::user()->id;

            // Create and save article with validated data
            $article = Article::create($input);

            return response()->json(['success' => $article], $this->successStatus);
        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $article_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {

        // Validate posted form data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:articles|min:5|max:100',
            'description' => 'required|string|min:5|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::user()) {
            $input = $request->all();

            // Find article by ID
            $article = Article::find($article_id);

            if ($article) {
                // Populate additional required fields. 
                $input['slug'] = Str::slug($input['title'], '-');
                $input['article_id'] = $article;

                $article->update($input);

                return response()->json(['success' => $article], $this->successStatus);
            } else {
                return response()->json(['error' => 'Article Not Found!'], 401);
            }


        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $article_id
     * @return \Illuminate\Http\Response
     */
    public function delete($article_id)
    {
        if (Auth::user()) {
            // Find article by ID
            $article = Article::find($article_id);
            $article_slug = $article['slug'];

            if ($article) {
                $article->delete();
                return response()->json(['success' => $article_slug . " deleted"], $this->successStatus);
            } else {
                return response()->json(['error' => 'Article Not Found!'], 401);
            }


        } else {
            return response()->json(['error' => 'User not authenticated!'], 401);
        }
    }
}
