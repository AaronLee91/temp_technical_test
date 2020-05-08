<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class ArticleController extends Controller
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
        // Get all Articles, ordered by the newest first
        $articles = Article::latest()->get();

        // Pass Article Collection to view
        return view('articles.index', compact('articles'));
        // return view('articles.index', compact(['articles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate posted form data
        $validated = $request->validate([
            'title' => 'required|string|unique:articles|min:5|max:100',
            'description' => 'required|string|min:5|max:2000',
        ]);

        // Create slug from title
        $validated['slug'] = Str::slug($validated['title'], '-');
        $validated['user_id'] = Auth::user()->id;

        // Create and save article with validated data
        $article = Article::create($validated);

        // Redirect the user to the created article with a success notification
        return redirect(route('articles.show', [$article->slug]))->with('notification', 'Article created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        // Pass current article to view
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        // Validate posted form data
        $validated = $request->validate([
            'title' => 'required|string|unique:articles|min:5|max:100',
            'description' => 'required|string|min:5|max:2000',
        ]);

        // Create slug from title
        $validated['slug'] = Str::slug($validated['title'], '-');

        // Update Article with validated data
        $article->update($validated);

        // Redirect the user to the created Article woth an updated notification
        return redirect(route('articles.index', [$article->slug]))->with('notification', 'Article updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $Article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        // Delete the specified Article
        $article->delete();

        // Redirect user with a deleted notification
        return redirect(route('articles.index'))->with('notification', '"' . $article->title .  '" deleted!');
    }
}
