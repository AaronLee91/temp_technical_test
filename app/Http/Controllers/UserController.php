<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Storage;

class UserController extends Controller
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
    
    /* Profile
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function profile(){ 
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update_profile_picture(Request $request){

    	// Handle the user upload of profile picture
    	if($request->hasFile('profile_picture')){
    		$profile_picture = $request->file('profile_picture');
    		$filename = time() . '.' . $profile_picture->getClientOriginalExtension();
    		// Save the file
		    $path = $profile_picture->storeAs('public', $filename);

    		$user = Auth::user();
    		$user->profile_picture = $filename;
    		$user->save();
    	}

    	return view('user.profile', compact('user') );

    }
}
