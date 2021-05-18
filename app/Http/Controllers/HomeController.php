<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\biz_profile;
use App\Models\assessment;
use App\Models\category;
use DB;


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
            $company->logo = 'storage/img/biz_logos/'.$request->file('image')->getClientOriginalName();

        } else {
            $fileNameToStore = 'No image here.';
        }

        $company->registered  = $request->input('registered');
        $company->reg_number  = $request->input('reg_number');
        $company->location  = $request->input('location');
        $company->industry  = $request->input('industry');
        $company->biz_phase  = $request->input('biz_phase');
        $company->reg_date  = $request->input('reg_date');
        $company->num_employees  = $request->input('num_employees');
        $company->annual_turnover  = $request->input('annual_turnover');
        $company->monthly_turnover  = $request->input('6mo_turnover');
        $company->offering  = $request->input('offering');
        $company->start_date  = $request->input('start_date');
        $company->premise_start_date  = $request->input('premise_start_date');
        $company->company_bank  = $request->input('company_bank');
        $company->card_to_perc  = $request->input('card_to_perc');
        $company->cash_to_perc  = $request->input('cash_to_perc');
        $company->eft_to_perc  = $request->input('eft_to_perc');
        $company->save();

        return redirect('/');

    }

    public function manageCompany($id) {
        $company = biz_profile::find($id);
        $phase = $company->biz_phase;
        $user = User::find($company->user_id);
        // $assessments = DB::table('assessments')->where('phase', $company->biz_phase);
        $assessments = assessment::where('phase', '=', $company->biz_phase)->get();
        $curr_category = assessment::where('phase', '=', $company->biz_phase)->first()->category;
        $categories = category::where('category_title', '=', $curr_category)->get();

        return view('site.bizProfile.manageCompany', compact(['company', 'user', 'phase', 'assessments', 'categories']));
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
        $company->reg_date  = $request->input('reg_date');
        $company->num_employees  = $request->input('num_employees');
        $company->annual_turnover  = $request->input('annual_turnover');
        $company->monthly_turnover  = $request->input('monthly_turnover');
        $company->offering  = $request->input('offering');
        $company->start_date  = $request->input('start_date');
        $company->premise_start_date  = $request->input('premise_start_date');
        $company->company_bank  = $request->input('company_bank');
        $company->card_to_perc  = $request->input('card_to_perc');
        $company->cash_to_perc  = $request->input('cash_to_perc');
        $company->eft_to_perc  = $request->input('eft_to_perc');
        $company->save();

        return redirect('/'.$id.'/manage-company');
    }
}
