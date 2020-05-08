<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(String $article)
    {
        //
        return view('comments.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate posted form data
        $validated = $request->validate([
            'body' => 'required|string|min:5|max:2000',
        ]);

        // Create slug from title
        $validated['slug'] = Str::slug($request->get("article_slug") . " " . time() . rand(10, 99), '-');
        $validated['user_id'] = Auth::user()->id;
        $validated['article_id'] = Article::where('slug', $request->get("article_slug"))->firstOrFail()->id;


        // Create and save article with validated data
        $article = Comments::create($validated);

        // Redirect the user to the created article with a success notification
        return redirect(route('articles.show', [$request->get("article_slug")]))->with('notification', 'Comment created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comments $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comment)
    {
        // Validate posted form data
        $validated = $request->validate([
            'body' => 'required|string|min:5|max:2000',
        ]);

        $article = Article::where('id', $comment->article_id)->firstOrFail()->slug;

        // Update Article with validated data
        $comment->update($validated);


        // Redirect the user to the article list with an updated notification
        return redirect(route('articles.show', [$article]))->with('notification', 'Comment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comments $comment)
    {

        $article = Article::where('id', $comment->article_id)->firstOrFail()->slug;

        // Delete the specified Comment
        $comment->delete();

        // Redirect user with a deleted notification
        return redirect(route('articles.show', [$article]))->with('notification', '"' . $comment->slug . '" deleted!');
    }
}
