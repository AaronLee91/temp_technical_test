<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comments;
use App\Models\User;
use Auth;
use Validator;

class StatisticsController extends Controller
{
    public $successStatus = 200;

    /**
     * Create a new controller instance.
     *
     * @return mixed
     */
    public function __construct()
    {
        //
    }

    /**
     *
     * @return array
     */
    public function index()
    {
        $users = User::where('id', '>', 0)->get();
        $result = array();
        $result['article_count'] = Article::where('id', '>', 0)->count();
        $result['comments_count'] = Comments::where('id', '>', 0)->count();
        $result['users_count'] = $users->count();

        $user_comment_count = [];
        foreach ($users as $key => $user) {
            $user_comment_count[$key]['name'] = $user->name;
            $user_comment_count[$key]['email'] = $user->email;
            $user_comment_count[$key]['comments_count'] = $user->getCommentsCount();
        }

        $result['users_comment_count'] = (count($user_comment_count) > 0) ? $user_comment_count : [];
        // $user['number_of_comments'] = !empty($user->getCommentsCount()) ? $user->getCommentsCount() : 0;
        // $user['number_of_articles'] = !empty($user->getArticlesCount()) ? $user->getArticlesCount() : 0;
        return response()->json(['success' => $result], $this->successStatus);
    }

    // /* details api
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function commentsCount()
    // {
    //     $user = Auth::user();
    //     return response()->json(['success' => $user], $this-> successStatus);
    // }
}