<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\biz_profile;
use App\Models\assessment;
use App\Models\category;
use App\Models\phase;
use App\Models\answer;
use App\Models\biz_score;
use App\Models\cate_groups;
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

    public function editCompany($id, Request $request) {
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
        $asses_cate_id = [];
        $cate_ids = [];
        $cate_ids_int = [];
        $answers_per_cate_count = [];
        $yes_answers_per_cate_count = [];
        $score = null;

        foreach ($assessments as $asses){ 
            array_push($asses_id, $asses->id);
            array_push($asses_cate_id, $asses->category_id);
        }

        for ($i = 0; $i < count($asses_id); $i++) {
            $id_name = 'assessment_id_'.$asses_id[$i];
            $q_name = 'question'.$asses_id[$i];
            $cate_name = 'category_id_'.$asses_id[$i];

            if (isset($request->$id_name)) {
                $answer = new answer;
                $answer->user_id = $user_id;
                $answer->category_id = $request->$cate_name;
                $answer->assessment_id = $asses_id[$i];
                $answer->answer = $request->$q_name;
                $answer->save();

                if (in_array($answer->category_id, $cate_ids) == false) {
                    array_push($cate_ids, $answer->category_id);
                }
            }

        }
        foreach($cate_ids as $cate_id) {
            array_push($cate_ids_int,(int)$cate_id);
        }

        foreach($cate_ids_int as $int){
            array_push(
            $answers_per_cate_count, 
            count(answer::where([
                ['user_id', '=', $user_id],
                ['category_id', '=', $int]
            ])->get())
            );

            array_push(
                $yes_answers_per_cate_count, 
                count(answer::where([
                    ['user_id', '=', $user_id],
                    ['category_id', '=', $int],
                    ['answer', '=', 1]
                ])->get())
                );

            foreach($answers_per_cate_count as $answer_count) {
                foreach($yes_answers_per_cate_count as $yes_answer_count) {
                    $score = $yes_answer_count / $answer_count * 100;

                    $biz_score = new biz_score;
                    $biz_score->user_id = $user_id;
                    $biz_score->category_id = $int;
                    $biz_score->category_title = category::where('id', '=', $int)->first()->category_title;
                    $biz_score->score = $score;

                }
            }
            $biz_score->save();
        }

        // return response($answers_per_cate_count);
        return redirect('/'.$request->input('company_id').'/report-summary');
    }

    public function reportSumm($company_id) {
        $company = biz_profile::find($company_id);
        $user = User::find($company->user_id);
        $biz_scores = biz_score::where('user_id', '=', $user->id)->get();
        $scores = [];
        $cate_scores = [];
        $charts_js = [];

        foreach ($biz_scores as $the_score) {
            array_push($scores, [$the_score->category_title, $the_score->score]);
            array_push($cate_scores, [$the_score->id, $the_score->category_title, $the_score->score]);
        }

        foreach($biz_scores as $the_score_js) {
            $score_diff = 100 - $the_score_js->score;
            array_push($charts_js,
                "<script>
                google.charts.load('current', {packages:['corechart', 'bar']});
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
        
                    var data = google.visualization.arrayToDataTable([
                    ['Category', 'Score'],
                    ['Positive',     ".$the_score_js->score."],
                    ['Negative',      ".$score_diff."]
                    ]);
        
                    var options = {
                        pieHole: 0.3,
                        animation:{
                            'startup': true,
                            duration: 1000,
                            easing: 'out',
                          },
                        'title': '".$the_score_js->category_title."',

                    };
        
                    var chart = new google.visualization.PieChart(document.getElementById('chart_".$the_score_js->id."'));
                    chart.draw(data, options);
                }
            </script>"
            );
        }


        return view('site.report-summary', compact(['user','company', 'scores', 'biz_scores', 'cate_scores', 'charts_js']));
     
    }

    public function fullReport($company_id) {
        $company = biz_profile::find($company_id);
        $user = User::find($company->id);   
        $cate_groups = cate_groups::all();

        return view('site.full-report', compact(['user', 'company', 'cate_groups']));
    }

    // public function foo_bar() {
    //     $concept_cates = [72, 65, 62, 61, 68, 73, 75, 82, 74,87, 83,80, 63];
    //     $structure_cates = [85, 67, 69, 86, 64, 66, 84, 71, 70, 81, 78, 79, 60];

    //     $categories = category::all();

    //     foreach($categories as $category) {
    //         if(in_array($category->id, $concept_cates)) {
    //             $category->cate_id = 1;
    //             $category->save();
    //         } elseif(in_array($category->id, $structure_cates)) {
    //             $category->cate_id = 2;
    //             $category->save();
    //         }
    //     }
    // }
}
