<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\biz_profile;
use App\Models\assessment;
use App\Models\category;
use App\Models\phase;
use App\Models\answer;
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

        return redirect()->back();

    }

    public function addCompany($id) {
        $user = User::find($id);
        return view('site.bizProfile.addCompany', compact(['user','id']));
    }

    public function saveCompany($id, Request $request) {
        $phase_id = phase::where('phase','=', $request->input('biz_phase'))->first()->id;
        $company = new biz_profile;
        $company->user_id = $id;
        $company->phase_id = $phase_id;
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
        $phase = $company->phase->phase;
        $user = User::find($company->user_id);
        
        $assessments = assessment::where('phase', '=', $company->biz_phase)->get();
        // $curr_category = assessment::where('phase', '=', $company->biz_phase)->first()->category;
        $categories = category::where($phase, '=', 1)->get();

        return view('site.bizProfile.manageCompany', compact(['company', 'user', 'phase', 'assessments', 'categories']));
    }

    public function editCompany ($id, Request $request) {
        $phase_id = phase::where('phase','=', $request->input('biz_phase'))->first()->id;
        $company = biz_profile::find($id);
        $company->phase_id = $phase_id;
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

    public function saveAssessment($user_id, Request $request) {
        $assessments = assessment::all();
        $asses_id = [];


        foreach ($assessments as $asses){ 
            array_push($asses_id, $asses->id);
        }

        for ($i = 0; $i < count($asses_id); $i++) {
            $name = 'assessment_id_'.$asses_id[$i];
            $q_name = 'question'.$asses_id[$i];

            if (isset($request->$name)) {
                $answer = new answer;
                $answer->user_id = $user_id;
                $answer->assessment_id = $asses_id[$i];
                $answer->answer = $request->$q_name;
                $answer->save();
            }
        }
        return redirect('/'.$request->input('company_id').'/manage-company');
    }

    public function reportSumm($company_id) {
        $company = biz_profile::find($company_id);
        $user = User::find($company->user_id);
        
        return view('site.report-summary', compact(['company', 'user']));
    }
}
