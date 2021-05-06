<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\biz_profile;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = auth()->user();
        // $businesses = biz_profile::

        return view('home', compact(['user']));
    }

    public function addProfilePic($id, Request $request){
        $user = User::find($id);

        if($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/img/profilePictures', $filenameWithExt);
        } else {
            $fileNameToStore = 'No image here.';
        }

        $user->profile_picture = 'storage/img/profilePictures/'.$request->file('image')->getClientOriginalName();

        $user->save();

        return view('home', compact(['user']));

    }

    public function addCompany($id) {

    }
}
