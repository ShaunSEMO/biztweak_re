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

        return view('site.home', compact(['user']));
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

        return view('site.home', compact(['user']));

    }

    public function addCompany($id) {
        $user = User::find($id);
        return view('site.bizProfile.addCompany', compact(['user','id']));
    }

    public function saveCompany($id, Request $request) {
        $company = new biz_profile;
        $company->user_id = $id;
        $company->name = $request->input('name');

        if($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/img/biz_logos', $filenameWithExt);
        } else {
            $fileNameToStore = 'No image here.';
        }
        $company->logo = 'storage/img/biz_logos/'.$request->file('image')->getClientOriginalName();

        $company->registered  = $request->input('registered');
        $company->reg_number  = $request->input('reg_number');
        $company->location  = $request->input('location');
        $company->industry  = $request->input('industry');
        $company->biz_phase  = $request->input('biz_phase');
        $company->save();

        return redirect('/');

    }

    public function manageCompany($id) {
        $company = biz_profile::find($id);
        $user = User::find($company->user_id);
        return view('site.bizProfile.manageCompany', compact(['company', 'user']));
    }

    public function editCompany ($id, Request $request) {
        $company = biz_profile::find($id);
        $company->name = $request->input('name');

        if($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/img/biz_logos', $filenameWithExt);
            $company->logo = 'storage/img/biz_logos/'.$request->file('image')->getClientOriginalName();

        } else {
            $noImage = 'No image was selected';
        }
        
        $company->registered  = $request->input('registered');
        $company->reg_number  = $request->input('reg_number');
        $company->location  = $request->input('location');
        $company->industry  = $request->input('industry');
        $company->biz_phase  = $request->input('biz_phase');
        $company->save();

        return redirect('/'.$id.'/manage-company');
    }
}
