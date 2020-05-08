<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
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
     * API to Display a listing of the articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all Articles, ordered by the newest first
        $users = User::latest()->get();
        if ($users) {
            foreach ($users as $key => &$user) {
                $user['number_of_comments'] = !empty($user->getCommentsCount()) ? $user->getCommentsCount() : 0;
                $user['number_of_articles'] = !empty($user->getArticlesCount()) ? $user->getArticlesCount() : 0;
                foreach ($user->roles()->select('roles.name as name')->get() as $key => $role) {
                    $user['roles'][$key] = $role->name;
                }
            }

            return response()->json(['success' => $users], $this->successStatus);
        }
        return response()->json(['success' => []], $this->successStatus);
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // Handle the user upload of profile picture
        $filename = 'default.jpg';
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename = time() . '.' . $profile_picture->getClientOriginalExtension();
            // Save the file
            $path = $profile_picture->storeAs('public', $filename);
        }

        // Populate additional required field.
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['profile_picture'] = $filename;
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        //Show warning if no default role configured
        if (!$user->assignRole('ROLE_USER')) {
            $success['warning'] = 'No role assigned as default user role not configured.';
        }
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        $user['number_of_comments'] = !empty($user->getCommentsCount()) ? $user->getCommentsCount() : 0;
        $user['number_of_articles'] = !empty($user->getArticlesCount()) ? $user->getArticlesCount() : 0;
        foreach ($user->roles()->select('roles.name as name')->get() as $key => $role) {
            $user['roles'][$key] = $role->name;
        }
        return response()->json(['success' => $user], $this->successStatus);
    }
}