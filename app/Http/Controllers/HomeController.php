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
use App\Models\assess_field;
use App\Models\field_score;
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

        return redirect('/'.$company->id.'/manage-company2');

    }

    public function manageCompany($id) {
        $company = biz_profile::find($id);
        $phase = $company->phase->phase;
        $user = User::find($company->user_id);
        $assessment_complete = 0 == count(answer::where('biz_id', '=', $company->id)->get());
        
        $assessments = assessment::where('phase', '=', $company->biz_phase)->get();
        // $curr_category = assessment::where('phase', '=', $company->biz_phase)->first()->category;
        $categories = category::where($phase, '=', 1)->get();

        $dissapear_scripts = [];

        foreach ($categories as $categ) {
            foreach ($categ->assessments as $assessment) {
                array_push($dissapear_scripts, 
                "<script>
                    jQuery(document).ready(function(){
                        var inputs = $('#yes_no_group_".$assessment->id." input');
                
                        inputs.on('change', function() {
                            $('#yes_no_group_".$assessment->id."').css({ 'display': 'none'})
                        })
                        console.log(".$assessment->id.")
                    });
                </script>"
                );
            };
        }

        // return response($dissapear_scripts);
        return view('site.bizProfile.manageCompany', compact(['company', 'user', 'phase', 'assessments', 'categories', 'assessment_complete', 'dissapear_scripts']));
    }

    public function manageCompany2($id) {
        $company = biz_profile::find($id);
        $phase = $company->phase->phase;
        $user = User::find($company->user_id);
        $assessment_complete = 0 == count(answer::where('biz_id', '=', $company->id)->get());
        
        $assessments = assessment::where('phase', '=', $company->biz_phase)->get();
        // $curr_category = assessment::where('phase', '=', $company->biz_phase)->first()->category;
        $categories = category::where($phase, '=', 1)->get();

        $dissapear_scripts = [];

        foreach ($categories as $categ) {
            foreach ($categ->assessments as $assessment) {
                array_push($dissapear_scripts, 
                "<script>
                    jQuery(document).ready(function(){
                        var inputs = $('#yes_no_group_".$assessment->id." input');
                
                        inputs.on('change', function() {
                            $('#yes_no_group_".$assessment->id."').css({ 'display': 'none'})
                        })
                        console.log(".$assessment->id.")
                    });
                </script>"
                );
            };
        }

        // return response($assessment_complete);
        return view('site.bizProfile.manageCompany2', compact(['company', 'user', 'phase', 'assessments', 'categories', 'assessment_complete', 'dissapear_scripts']));
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
        // response($request->input('test'));
    }

    public function saveAssessment($user_id, $company_id, Request $request) {
        $assessments = assessment::all();
        $asses_id = [];
        $asses_cate_id = [];
        $cate_ids = [];
        $cate_ids_int = [];
        $answers_per_cate_count = [];
        $yes_answers_per_cate_count = [];
        $score = null;

        $biz_viability = new field_score;
        $biz_viability->user_id = $user_id;
        $biz_viability->biz_id = $company_id;
        $biz_viability->field_name = "Biz viability";
        $biz_viability->field_desc = 'Take this assessment if you want to know if your business idea can work.';
        $biz_viability->field_score = 0;
        $biz_viability->save();

        $customer_revenue = new field_score;
        $customer_revenue->user_id = $user_id;
        $customer_revenue->biz_id = $company_id;
        $customer_revenue->field_name = "Get customers and revenue";
        $customer_revenue->field_desc = 'Get desc from Arthur';
        $customer_revenue->field_score = 0;
        $customer_revenue->save();

        $market_viability = new field_score;
        $market_viability->user_id = $user_id;
        $market_viability->biz_id = $company_id;
        $market_viability->field_name = "Market viability";
        $market_viability->field_desc = 'Take this assessment if you want to test the market readiness of your business.';
        $market_viability->field_score = 0;
        $market_viability->save();
        
        $investor_readiness = new field_score;
        $investor_readiness->user_id = $user_id;
        $investor_readiness->biz_id = $company_id;
        $investor_readiness->field_name = "Investor readiness";
        $investor_readiness->field_desc = 'Take this assessment to find out what you need to get your business investor ready.';
        $investor_readiness->field_score = 0;
        $investor_readiness->save();

        $scale_viability = new field_score;
        $scale_viability->user_id = $user_id;
        $scale_viability->biz_id = $company_id;
        $scale_viability->field_name = "Scale viability";
        $scale_viability->field_desc = 'Take this assessment if you want to test what your business needs to scale.';
        $scale_viability->field_score = 0;
        $scale_viability->save();

        $employee_performance = new field_score;
        $employee_performance->user_id = $user_id;
        $employee_performance->biz_id = $company_id;
        $employee_performance->field_name = "Employee performance";
        $employee_performance->field_desc = 'take this assessment to test the quality of employee systems you have.';
        $employee_performance->field_score = 0;
        $employee_performance->save();

        $financial = new field_score;
        $financial->user_id = $user_id;
        $financial->biz_id = $company_id;
        $financial->field_name = "Financial";
        $financial->field_desc = 'Take this assessment to measure how you are doing in managing your finances.';
        $financial->field_score = 0;
        $financial->save();

        foreach ($assessments as $asses){ 
            array_push($asses_id, $asses->id);
            array_push($asses_cate_id, $asses->category_id);
        }

        for ($i = 0; $i < count($asses_id); $i++) {
            $id_name = 'assessment_id_'.$asses_id[$i];
            $q_name = 'question'.$asses_id[$i];
            $cate_name = 'category_id_'.$asses_id[$i];
            $po_outcome_name = 'po_outcome'.$asses_id[$i];
            $ne_outcome_name = 'ne_outcome'.$asses_id[$i];
            $recom_name = 'recom'.$asses_id[$i];

            if (isset($request->$id_name)) {
                $answer = new answer;
                $answer->user_id = $user_id;
                $answer->category_id = $request->$cate_name;
                $answer->assessment_id = $asses_id[$i];
                $answer->biz_id = $company_id;
                $answer->answer = $request->$q_name;
                $answer->recom = $request->$recom_name;
                if($request->$q_name == 1) {
                    $answer->outcome = $request->$po_outcome_name;
                } else {
                    $answer->outcome = $request->$ne_outcome_name;
                }
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
                    $score = ($yes_answer_count / $answer_count) * 100;

                    $biz_score = new biz_score;
                    $biz_score->user_id = $user_id;
                    $biz_score->category_id = $int;
                    $biz_score->group_id = category::where('id', '=', $int)->first()->group_id;
                    $biz_score->biz_id = $company_id;
                    $biz_score->category_title = category::where('id', '=', $int)->first()->category_title;
                    $biz_score->field_id = category::where('id', '=', $int)->first()->field_id;
                    $biz_score->score = $score;

                }
            }
            $biz_score->save();
        } 

        $biz_scores = biz_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->get();

        $biz_viability_list = ['Value proposition','Customer segments', 'Proof of concept','delivery expertise', 'market intelligence','revenue streams','key activities', 'cost structure', 'functional capability', 'key resources', 'financial management'];
        $customer_revenue_list = ['customer relationships', 'channels', 'customer segments', 'customers', 'business and customers','marketing and sales', 'revenue streams'];
        $market_viability_list = ['Market intelligence', 'delivery expertise', 'business and customers', 'ownership and mindset', 'marketing and sales', 'value proposition', 'key activities', 'customer segments', 'e-commerce'];
        $investor_readiness_list = ['value proposition','customer segments', 'proof of concept', 'minimum viable product', 'channels', 'revenue streams', 'cost structure', 'unique selling point', 'employees', 'turnover', 'marketing and sales', 'ownership and mindset','business and customers','growth strategy', 'financial management', 'compliance and certification', 'legal', 'commercial contract agreements'];
        $scale_viability_list = ['current alternatives','channels', 'key partners', 'cost structure', 'customer relationships', 'business process management','marketing and sales', 'employee satifaction', 'growth strategy', 'delivery expertise', 'market intelligence', 'financial management'];
        $employee_performance_list = ['business process management', 'ownership and mindset','employee satisfaction'];
        $financial_list = ['cost structure', 'financial management', 'revenue streams', 'e-commerce'];
        $field_list = ['biz viability', 'Get customers and revenue', 'market viability', 'investor readiness', 'scale viability', 'employee performance', 'financial'];


        // Save biz viability scores
        $biz_viability_scores = [];
        foreach($biz_viability_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($biz_viability_scores, $score->score); 
                    }
                }
        }
        $biz_viability = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Biz viability')->first();
        if (count($biz_viability_scores)!= 0) {
            $biz_viability->field_score = (array_sum($biz_viability_scores) / (count($biz_viability_scores) * 100)) * 100;
        } else {
            $biz_viability->field_score = 0;
        }
        $biz_viability->save();

        // Save customer and revenue scores
        $customer_revenue_scores = [];
        foreach($customer_revenue_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($customer_revenue_scores, $score->score); 
                    }
                }
        }
        $customer_revenue = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Get customers and revenue')->first();
        if (count($customer_revenue_scores)!= 0) {
            $customer_revenue->field_score = (array_sum($customer_revenue_scores) / (count($customer_revenue_scores) * 100)) * 100;
        } else {
            $customer_revenue->field_score = 0;
        }
        $customer_revenue->save();

        // Save market viability scores
        $market_viability_scores = [];
        foreach($market_viability_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($market_viability_scores, $score->score); 
                    }
                }
        }
        $market_viability = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Market viability')->first();
    
        if (count($market_viability_scores)!= 0) {
            $market_viability->field_score = (array_sum($market_viability_scores) / (count($market_viability_scores) * 100)) * 100;
        } else {
            $market_viability->field_score = 0;
        }
        $market_viability->save();

        // Save investor readiness scores
        $investor_readiness_scores = [];
        foreach($investor_readiness_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($investor_readiness_scores, $score->score); 
                    }
                }
        }
        $investor_readiness = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Investor readiness')->first();
        if (count($investor_readiness_scores)!= 0) {
            $investor_readiness->field_score = (array_sum($investor_readiness_scores) / (count($investor_readiness_scores) * 100)) * 100;
        } else {
            $investor_readiness->field_score = 0;
        }
        $investor_readiness->save();

        // Save scale viability scores
        $scale_viability_scores = [];
        foreach($scale_viability_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($scale_viability_scores, $score->score); 
                    }
                }
        }
        $scale_viability = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Scale viability')->first();
        if (count($scale_viability_scores)!= 0) {
            $scale_viability->field_score = (array_sum($scale_viability_scores) / (count($scale_viability_scores) * 100)) * 100;
        } else {
            $scale_viability->field_score = 0;
        }
        $scale_viability->save();

        // Save employee performance scores
        $employee_performance_scores = [];
        foreach($employee_performance_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($employee_performance_scores, $score->score); 
                    }
                }
        }
        $employee_performance = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Employee performance')->first();
        if (count($employee_performance_scores)!= 0) {
            $employee_performance->field_score = (array_sum($employee_performance_scores) / (count($employee_performance_scores) * 100)) * 100;
        } else {
            $employee_performance->field_score = 0;
        }
        $employee_performance->save();

        // Save finance scores
        $financial_scores = [];
        foreach($financial_list as $item) {
                foreach($biz_scores as $score){
                    if (strtolower($item) == strtolower($score->category_title) ) {
                        array_push($financial_scores, $score->score); 
                    }
                }
        }
        $financial = field_score::where('user_id', '=', $user_id)->where('biz_id', '=', $company_id)->where('field_name', '=', 'Financial')->first();
        if (count($financial_scores)!= 0) {
            $financial->field_score = (array_sum($financial_scores) / (count($financial_scores) * 100)) * 100;
        } else {
            $financial->field_score = 0;
        }
        $financial->save();

        $ideation_priority = [
            ['value proposition', 3],
            ['Customer segment', 3],
            ['Functional Capability', 1],
            ['Proof of concept', 2],
            ['Revenue streams', 1],
            ['Cost structure', 1],
            ['Compliance', 2],
        ];

        $startup_priority = [
            ['Customer relationships', 1],
            ['Channels', 3],
            ['E-commerce', 1],
            ['Functional capabilities', 1],
            ['Customer segments', 3],
            ['Business and customers', 1],
            ['Marketing and sales', 2],
            ['Revenue streams', 2],
            ['Ownership and mindset', 2],
        ];

        $earlystage_priority = [
            ['Market intelligence', 2],
            ['Delivery expertise', 1],
            ['E-commerce', 1],
            ['Business and customers', 1],
            ['Ownership and mindset', 1],
            ['Marketing and sales', 1],
            ['value proposition', 3],
            ['Customer segments', 3],
            ['Current alternatives', 1],
            ['Key partners', 1],
            ['Channels', 2],
        ];

        $accelerate_priority = [
            ['value proposition', 1],
            ['Customer segments', 1],
            ['Functional capabilities', 1],
            ['Industry specific compliance', 1],
            ['Best practices', 1],
            ['Legal: Constitutional Docs. Compliance', 1],
            ['Legal: Commercial contract agreements', 1],
            ['Channels', 1],
            ['Traction', 3],
            ['Revenue', 2],
            ['Financial management', 3],
            ['Cost structure', 1],
            ['Unique selling point', 2],
            ['Ownership and mindset', 1],
            ['Business and customers', 1],
            ['Growth strategy', 1],
            ['Current alternatives', 1],
            ['Key partners', 1],
            ['Business process management', 1],
            ['Employee satisfaction', 1],
        ];

        foreach($biz_scores as $score) {
            if (User::find($user_id)->biz_profiles->where('id','=',$company_id)->first()->phase_id = 5) {
                foreach($ideation_priority as $priority) {
                    if (strtolower($score->category_title) == strtolower($priority[0])) {
                        $no_within_count = count(answer::where('user_id','=', $user_id)->where('answer', '=', 0)->where('category_id','=',$score->category_id)->get());
                        $score->priority_score = $no_within_count * $priority[1];
                        $score->save();
                    }
                }
            }
        }

        foreach($biz_scores as $score) {
            if (User::find($user_id)->biz_profiles->where('id','=',$company_id)->first()->phase_id = 2) {
                foreach($startup_priority as $priority) {
                    if (strtolower($score->category_title) == strtolower($priority[0])) {
                        $no_within_count = count(answer::where('user_id','=', $user_id)->where('answer', '=', 0)->where('category_id','=',$score->category_id)->get());
                        $score->priority_score = $no_within_count * $priority[1];
                        $score->save();
                    }
                }
            }
        }

        foreach($biz_scores as $score) {
            if (User::find($user_id)->biz_profiles->where('id','=',$company_id)->first()->phase_id = 3) {
                foreach($earlystage_priority as $priority) {
                    if (strtolower($score->category_title) == strtolower($priority[0])) {
                        $no_within_count = count(answer::where('user_id','=', $user_id)->where('answer', '=', 0)->where('category_id','=',$score->category_id)->get());
                        $score->priority_score = $no_within_count * $priority[1];
                        $score->save();
                    }
                }
            }
        }

        foreach($biz_scores as $score) {
            if (User::find($user_id)->biz_profiles->where('id','=',$company_id)->first()->phase_id = 4) {
                foreach($accelerate_priority as $priority) {
                    if (strtolower($score->category_title) == strtolower($priority[0])) {
                        $no_within_count = count(answer::where('user_id','=', $user_id)->where('answer', '=', 0)->where('category_id','=',$score->category_id)->get());
                        $score->priority_score = $no_within_count * $priority[1];
                        $score->save();
                    }
                }
            }
        }

        foreach($biz_scores as $score) {
            if (User::find($user_id)->biz_profiles->where('id','=',$company_id)->first()->phase_id = 1) {
                foreach($ideation_priority as $priority) {
                    if (strtolower($score->category_title) == strtolower($priority[0])) {
                        $no_within_count = count(answer::where('user_id','=', $user_id)->where('answer', '=', 0)->where('category_id','=',$score->category_id)->get());
                        $score->priority_score = $no_within_count * $priority[1];
                        $score->save();
                    }
                }
            }
        }
        

        // return response($biz_viability_scores);
        return redirect('/'.$request->input('company_id').'/report-summary');
    }

    public function reportSumm($company_id) {
        $company = biz_profile::find($company_id);
        $user = User::find($company->user_id);
        $answers = answer::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->get();
        $biz_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->get();
        $field_scores = field_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->get();
        $concept_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 1)->get();
        $structure_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->get();

        foreach ($biz_scores as $score) {
            foreach($answers as $answer) {
                if ($answer->category_id == $score->category_id) {
                    $answer->biz_score_id = $score->id;
                    $answer->save();
                }
            }
        }

        $scores = [];
        $cate_scores = [];
        $charts_js = [];
        $concept_charts_js = [];
        $structure_charts_js = [];

        foreach ($biz_scores as $the_score) {
            array_push($scores, [$the_score->category_title, $the_score->score]);
            array_push($cate_scores, [$the_score->id, $the_score->category_title, $the_score->score]);
        }

        foreach($concept_scores as $c_score) {
            array_push($concept_charts_js, [$c_score->category_title, $c_score->score]);
        }

        foreach($structure_scores as $c_score) {
            array_push($structure_charts_js, [$c_score->category_title, $c_score->score]);
        }

        foreach($field_scores as $the_score_js) {
            $score_diff = 100 - $the_score_js->field_score;
            array_push($charts_js,
                "<script>
                google.charts.load('current', {packages:['corechart', 'bar']});
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
        
                    var data = google.visualization.arrayToDataTable([
                    ['Category', 'Score'],
                    ['Complete',".$the_score_js->field_score."],
                    ['',".$score_diff."]
                    ]);
        
                    var options = {
                        pieHole: 0.45,
                        animation:{
                            'startup': true,
                            duration: 1000,
                            easing: 'out'
                          },
                        legend: 'none',
                        slices: {
                            0: { color: '#5BD4D9' },
                            1: { color: 'transparent' }
                        }

                    };
        
                    var chart = new google.visualization.PieChart(document.getElementById('chart_".$the_score_js->id."'));
                    chart.draw(data, options);
                }
            </script>"
            );
        }

        $biz_score_slices = [];

        foreach($biz_scores as $b_score) {
            array_push($biz_score_slices, [$b_score->category_title, $b_score->score]);
        }


        // return response($field_scores);                
        return view('site.report-summary', compact(['user','company', 'scores', 'biz_scores', 'cate_scores', 'charts_js', 'field_scores', 'concept_charts_js','structure_charts_js','biz_score_slices']));
    }

    public function fullReport($company_id) {
        $company = biz_profile::find($company_id);
        $user = User::find($company->user_id);   
        $cate_groups = cate_groups::all();
        $biz_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->get();
        $concept_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 1)->get();
        $structure_scores = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->get();

        $conc_vp_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Value proposition')->first();
        $conc_cs_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Customer segments')->first();
        $conc_poc_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Proof of concept')->first();

        $struct_talent_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Talent')->first();
        $struct_bpm_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Business process management')->first();
        $struct_fm_score = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('category_title', '=', 'Financial Management')->first();
        
        $concept_best_performing = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 1)->where('score', '>=', 60)->get();
        $concept_major_gaps = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 1)->where('score', '<', 60)->get();
        $concept_other_assessment = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 1)->where('score', '<', $concept_major_gaps[count($concept_major_gaps)-1]->score)->where('score', '>', $concept_best_performing[count($concept_best_performing)-1]->score)->get();

        $structure_priority_scores = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('priority_score', '>=', 6)->orderBy('priority_score', 'asc')->get();
        $structure_priority_scores = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('priority_score', '>=', 6)->orderBy('priority_score', 'asc')->get();
        $structure_priority_scores = biz_score::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('priority_score', '>=', 6)->orderBy('priority_score', 'asc')->get();

        $structure_best_performing = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('score', '>=', 60)->get();
        $structure_major_gaps = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('score', '<', 60)->get();
        $structure_other_assessment = biz_score::where('user_id', '=', $user->id)->where('biz_id', '=', $company_id)->where('group_id', '=', 2)->where('score', '<', $structure_major_gaps[count($structure_major_gaps)-1]->score)->where('score', '>', $structure_best_performing[count($structure_best_performing)-1]->score)->get();


        $structure_priority_outcomes = [];

        $concept_charts_js = [];
        $structure_charts_js = [];

        foreach($concept_scores as $c_score) {
            array_push($concept_charts_js, [$c_score->category_title, $c_score->score]);
        }

        foreach($structure_scores as $c_score) {
            array_push($structure_charts_js, [$c_score->category_title, $c_score->score]);
        }

        $market_intelligence_recs = ['market research','market segmentation','competitor analysis','ideal customer profile','unique selling point','competitive advantage','sam som tam','total addressable market','proof of concept'];
        $strategic_planning_recs = ['lean start-up strategy','business plan','scale strategy','boot strapping strategy','value proposition canvas','elevator pitch','crm','revenue models'];
        $financial_management_recs = ['budgeting and forecasting','reconciliations','cash flow management','p&l statement + balance sheet','pricing','costing'];
        $marketing_and_sales_recs = ['social media marketing','monitoring and evaluation','sales planning','product/service pricing','auditing and review','marketing plan','marketing strategy','sales funnel','customer acquisition plan','sales personnel'];
        $product_dev_recs = ['saas','equipment & materials','e-commerce'];
        $talent_management_recs = ['owner & management commitment','founder skills & expertise','training & content development','organizational design and development','employee satisfaction','employee skills & performance'];
        $process_management_recs = ['process development','process auditing & review','non-conformance & corrective actions management','communication and tracking'];
        $legal_recs = ['company law','corporate law','labour law','finance law'];

        $answers = answer::where('user_id','=', $user->id)->where('biz_id', '=', $company_id)->get();

        $mi_recs = [];
        $sp_recs = [];
        $fm_recs = [];
        $mas_recs = [];
        $pd_recs = [];
        $tm_recs = [];
        $pm_recs = [];
        $le_recs = [];

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $market_intelligence_recs)) {
                if (in_array($answer->recom, $mi_recs) != true) {
                    array_push($mi_recs, $answer->recom);
                }
            }
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $strategic_planning_recs)) {
                if (in_array($answer->recom, $sp_recs) != true) {
                    array_push($sp_recs, $answer->recom);
                }
            }

            
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $financial_management_recs)) {
                if (in_array($answer->recom, $fm_recs) != true) {
                    array_push($fm_recs, $answer->recom);
                }
            }
        }
        
        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $marketing_and_sales_recs)) {
                if (in_array($answer->recom, $mas_recs) != true) {
                    array_push($mas_recs, $answer->recom);
                }
            }
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $product_dev_recs)) {
                if (in_array($answer->recom, $pd_recs) != true) {
                    array_push($pd_recs, $answer->recom);
                }
            }
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $talent_management_recs)) {
                if (in_array($answer->recom, $tm_recs) != true) {
                    array_push($tm_recs, $answer->recom);
                }
            }
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $process_management_recs)) {
                if (in_array($answer->recom, $pm_recs) != true) {
                    array_push($pm_recs, $answer->recom);
                }
            }
        }

        foreach ($answers as $answer) {
            if (in_array(strtolower($answer->recom), $legal_recs)) {
                if (in_array($answer->recom, $le_recs) != true) {
                    array_push($le_recs, $answer->recom);
                }
            }
        }
        
        return view('site.full-report', 
                    compact([
                        'user', 
                        'company', 
                        'cate_groups', 
                        'concept_charts_js',
                        'structure_charts_js', 
                        'concept_best_performing', 
                        'concept_major_gaps', 
                        'structure_priority_scores',
                        'structure_best_performing', 
                        'structure_major_gaps', 
                        'biz_scores',
                        'mi_recs',
                        'sp_recs', 
                        'fm_recs',
                        'mas_recs',
                        'pd_recs',
                        'tm_recs',
                        'pm_recs',
                        'le_recs',
                        'concept_other_assessment',
                        'structure_other_assessment',
                        'conc_vp_score', 
                        'conc_cs_score',
                        'conc_poc_score',
                        'struct_talent_score',
                        'struct_bpm_score',
                        'struct_fm_score',
                        ]));
    }

    public function foo_bar() {
        $category = category::find(89);
        $category->delete();
        // $concept_cates = [72, 65, 62, 61, 68, 73, 75, 82, 74,87, 83,80, 63];
        // $structure_cates = [85, 67, 69, 86, 64, 66, 84, 71, 70, 81, 78, 79, 60];

        // $categories = category::all();

        // foreach($categories as $category) {
        //     if(in_array($category->id, $concept_cates)) {
        //         $category->group_id = 1;
        //         $category->save();
        //     } elseif(in_array($category->id, $structure_cates)) {
        //         $category->group_id = 2;
        //         $category->save();
        //     }
        // }

        // $categories = category::all();
        // $biz_scores = biz_score::all();
        
        // $biz_viability_list = ['Value proposition','Customer segments', 'Proof of concept','delivery expertise', 'market intelligence','revenue streams','key activities', 'cost structure', 'functional capability', 'key resources', 'financial management'];
        // $customer_revenue_list = ['customer relationships', 'channels', 'customer segments', 'customers', 'business and customers','marketing and sales', 'revenue streams'];
        // $market_viability_list = ['Market intelligence', 'delivery expertise', 'business and customers', 'ownership and mindset', 'marketing and sales', 'value proposition', 'key activities', 'customer segments', 'e-commerce'];
        // $investor_readiness_list = ['value proposition','customer segments', 'proof of concept', 'minimum viable product', 'channels', 'revenue streams', 'cost structure', 'unique selling point', 'employees', 'turnover', 'marketing and sales', 'ownership and mindset','business and customers','growth strategy', 'financial management', 'compliance and certification', 'legal', 'commercial contract agreements'];
        // $scale_viability_list = ['current alternatives','channels', 'key partners', 'cost structure', 'customer relationships', 'business process management','marketing and sales', 'employee satifaction', 'growth strategy', 'delivery expertise', 'market intelligence', 'financial management'];
        // $employee_performance_list = ['business process management', 'ownership and mindset','employee satisfaction'];
        // $financial_list = ['cost structure', 'financial management', 'revenue streams', 'e-commerce'];

        // foreach($categories as $category) {
        //     foreach($biz_scores as $score) {
        //         $score->biz_field = $category->biz_field;
        //         $score->save();
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($biz_viability_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Biz viability';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($customer_revenue_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Get customers and revenue';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($market_viability_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Market viability';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($investor_readiness_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Investor readiness';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($scale_viability_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Scale viability';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {
        //     foreach($employee_performance_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Employee performance';
        //             $category->save();
        //         }
        //     }
        // }

        // foreach($categories as $category) {  
        //     foreach($financial_list as $item) {
        //         if (strtolower($item) == strtolower($category->category_title)) {
        //             $category->biz_field = 'Financial';

        //             $category->save();

        //         }
        //     }
        // }
        

    }
}
