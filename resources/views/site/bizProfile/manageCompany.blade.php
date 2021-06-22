@extends('layouts.app')

@section('content')
<div class="container" style="color: white">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card user-container">
                <div class="card-body" style="text-align:center;">
                    @if (isset($user->profile_picture))
                        <div class="container" style="height: 150px; width: 150px; border-radius: 100px; background-image: url({{ asset($user->profile_picture) }}); background-position: center center; background-size: cover;">
                        </div>
                    @else
                        <span>
                            <i style="font-size: 100px" class="fas fa-user"></i>
                        </span>

                        {!! Form::open(['action' => ['App\Http\Controllers\HomeController@addProfilePic', $user->id], 'files' => true, 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::file('image', ['size'=>10]) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::submit('Save picture', ['class' => 'btn btn-primary btn-sm']) }}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @endif
                    
                    <br>
                    <br>

                    <h2>{{ $user->name }}</h2>
                    @if ($user->user_type = 3)
                        <p>Entrepreneur</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Current company details --}}
            <div class="container"> 
                <div class="user-container row">
                    <div class="col-md-4">
                        <img class="img-fluid" src="{{ asset($company->logo) }}" alt="Company Logo">
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $company->name }}</h3>
                        <br>
                        @if ($company->registered == 1)
                            <p>Registration #: {{ $company->reg_number }}</p>
                        @endif
                        <p>Location: {{ $company->location }}</p>
                        <p>Industry: {{ $company->industry }}</p>
                        @if ($company->biz_phase = 'phase_i')
                            <p>Business phase: I have an idea but don’t know what to do next</p>
                        @elseif ($company->biz_phase = 'phase_ii')
                            <p>I have a business but am not making money</p>
                        @elseif ($company->biz_phase = 'phase_iii')
                            <p>I have products/services but I have poor sales</p>
                        @elseif ($company->biz_phase = 'phase_iv')
                            <p>We are generating revenue, we would like to grow through investment</p>   
                        @elseif ($company->biz_phase = 'phase_v')
                            <p>I would like to be an entrepreneur but don’t know where to start</p>  
                        @endif
                    </div>
                </div> 
            </div>

            <br><br>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Biz Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#assessment" type="button" role="tab" aria-controls="assessment" aria-selected="false">Biz Assessment</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <br>
                    <br>
                    <div class="card user-container">
                        <div class="card-header" style="border-radius: 25px; background-color: #2a8f92; color: white;">You can edit your company profile below</div>
                        <div class="card-body container">
                            {!! Form::open(['action' => ['App\Http\Controllers\HomeController@editCompany', $company->id], 'files' => true, 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
                                <p>Company Name</p>
                                {{ Form::text('name', $company->name, ['class'=>'form-control', 'placeholder'=>'Company name...']) }}
                                <hr>
                                <p>Is your company registered?</p>
                                @if ($company->registered == 0)
                                    {{ Form::label('registered', 'Yes') }}
                                    {{ Form::radio('registered', 1, '',['class'=>'radio']) }}
                                    {{ Form::label('registered', 'No') }}
                                    {{ Form::radio('registered', 0, true, ['class'=>'radio']) }}
                                @elseif($company->registered == 1) 
                                    {{ Form::label('registered', 'Yes') }}
                                    {{ Form::radio('registered', 1, true) }}
                                    {{ Form::label('registered', 'No') }}
                                    {{ Form::radio('registered', 0) }}
                                @endif
                                <hr>
                                <div id='reg_bin'>
                                    <p>Registration Number</p>
                                    {{ Form::text('reg_number', $company->reg_number, ['class'=>'form-control', 'id'=>'reg_number', 'placeholder'=>'Registration number...']) }}
                                    <hr>
                                    <p>Registration Date</p>
                                    {{ Form::date('reg_date', $company->reg_date, ['class'=>'form-control', 'id'=>'reg_date', 'placeholder'=>'Registration date...']) }}
                                    <hr>
                                </div>
                                <p>Company Location</p>
                                {{ Form::text('location', $company->location, ['class'=>'form-control', 'placeholder'=>'Company physical address...']) }}
                                <hr>
                                <p>Business industry</p>
                                {{ Form::select('industry', [
                                    'Admin/Business support' => 'Admin/Business support', 
                                    'Agriculture, Forestry,Fishing and Hunting' => 'Agriculture, Forestry,Fishing and Hunting', 
                                    'Arts, Entertainment and Recreation'=>'Arts, Entertainment and Recreation',
                                    'Constrution'=>'Constrution', 
                                    'Education'=>'Education', 
                                    'Finance and Insurance'=>'Finance and Insurance', 
                                    'Healthcare and Social Assistance'=>'Healthcare and Social Assistance', 
                                    'Hospitality'=>'Hospitality', 
                                    'Information Technology'=>'Information Technology', 
                                    'Manufacturing'=>'Manufacturing', 
                                    'Mining and Mineral processing'=>'Mining and Mineral processing', 
                                    'Professional, Scientific and Technical Services'=>'Professional, Scientific and Technical Services', 
                                    'Real Estate'=>'Real Estate',
                                    'Retail'=>'Retail',
                                    'Transport and Logistics'=>'Transport and Logistics',
                                    'Other'=>'Other'
                                    ],
                                    $company->industry, 
                                    
                                    ['class'=>'form-control']) }}

                                <hr>
                                <p>Business Phase</p>
                                {{ Form::select('biz_phase', [
                                    'phase_i' => 'I have an idea but don’t know what to do next', 
                                    'phase_ii' => 'I have a business but am not making money',
                                    'phase_iii' => 'I have products/services but I have poor sales',
                                    'phase_iv' => 'We are generating revenue, we would like to grow through investment',
                                    'phase_v' => 'I would like to be an entrepreneur but don’t know where to start',
                                ],
                                $phase,
                                ['class'=>'form-control']) }}
                                <hr>
                                <p>Number of employees</p>
                                {{ Form::number('num_employees', $company->num_employees, ['class'=>'form-control', 'id'=>'num_employees', 'placeholder'=>'Number of employees at your company...']) }}
                                <hr>
                                <p>Annual Turnover</p>
                                {{ Form::number('annual_turnover', $company->annual_turnover, ['class'=>'form-control', 'id'=>'annual_turnover', 'placeholder'=>'What is your yearly turnover...']) }}
                                <hr>
                                <p>Monthly Turnover (Over 6 months)</p>
                                {{ Form::number('monthly_turnover', $company->monthly_turnover, ['class'=>'form-control', 'id'=>'monthly_turnover', 'placeholder'=>'What was your monthly turnover in the past 6 months...']) }}
                                <hr>
                                <p>Products/Services</p>
                                {{ Form::textarea('offering', $company->offering, ['class'=>'form-control', 'id'=>'offering', 'placeholder'=>'What products or services is your company offering?']) }}
                                <hr>
                                <p>Since when has your business been in operation?</p>
                                {{ Form::date('start_date', $company->start_date, ['class'=>'form-control', 'id'=>'start_date', 'placeholder'=>'Select date']) }}
                                <hr>
                                <p>Since when has your business been operating on the premise?</p>
                                {{ Form::date('premise_start_date', $company->premise_start_date, ['class'=>'form-control', 'id'=>'premise_start_date', 'placeholder'=>'Select date']) }}
                                <hr>
                                <p>Which bank does your company bank with?</p>
                                {{ Form::select('company_bank', [
                                    'absa' => 'ABSA', 
                                    'nedbank' => 'Nedbank',
                                    'standard_bank' => 'Standard Bank',
                                    'fnb' => 'FNB/RNB',
                                    'tyme_bank' => 'Tyme bank',
                                ], 
                                '',
                                ['class'=>'form-control']) }}
                                <hr>
                                <p>What % of your turnover is</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>Card</p>
                                        {{ Form::number('card_to_perc', $company->card_to_perc, ['class'=>'form-control', 'id'=>'card_to_perc']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <p>Cash</p>
                                        {{ Form::number('cash_to_perc', $company->cash_to_perc, ['class'=>'form-control', 'id'=>'cash_to_perc']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <p>EFT</p>
                                        {{ Form::number('eft_to_perc', $company->eft_to_perc, ['class'=>'form-control', 'id'=>'eft_to_perc']) }}
                                    </div>
                                </div>
                                <br>
                                <br>
                                {{ Form::submit('Save', ['class' => 'btn btn-primary std-btn']) }}

                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
                    <br>
                    <br>
                    @if ($assessment_complete != null)
                    <h3>Biz Assessment</h3>
                    <br>
                        <div class="accordion" id="accordionExample">
                            {!! Form::open(['action' => ['App\Http\Controllers\HomeController@saveAssessment', $user->id, $company->id], 'files' => true, 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                                @foreach ($categories as $category)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $category->id }}">
                                            <button style="color: white; background-color: #2a8f92;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapse{{ $category->id }}">
                                                {{ $category->category_title }}
                                            </button>
                                        </h2>
                                        
                                        <div style="margin-top: 10px;" id="collapse{{ $category->id }}" class="accordion-collapse collapse show container" aria-labelledby="heading{{ $category->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body row" style="background-color: white; color: black; border-radius: 25px; padding: 10px;">
                                                    @foreach ($category->assessments as $assessment)
                                                        <div class="col-md-8">
                                                            <p>{{ $assessment->question_text }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <br>
                                                            {{ Form::hidden('assessment_id_'.$assessment->id, $assessment->id) }}
                                                            {{ Form::hidden('company_id', $company->id) }}
                                                            {{ Form::hidden('category_id_'.$assessment->id, $assessment->category_id) }}
                                                            {{ Form::hidden('po_outcome'.$assessment->id, $assessment->po_outcome) }}
                                                            {{ Form::hidden('ne_outcome'.$assessment->id, $assessment->ne_outcome) }}
                                                            {{ Form::hidden('recom'.$assessment->id, $assessment->recom) }}
                                                            {{ Form::label('question'.$assessment->id, 'Yes') }}
                                                            {{ Form::radio('question'.$assessment->id, 1) }}
                                                            {{ Form::label('question'.$assessment->id, 'No') }}
                                                            {{ Form::radio('question'.$assessment->id, 0) }}
                                                            <br>
                                                        </div>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                @endforeach
                            {{ Form::submit('Save', ['class' => 'btn btn-primary std-btn']) }}
                            {!! Form::close() !!}
                        <br>
                      </div>
                    @else
                        <h3>Assessment Complete</h3>
                        <hr style="max-width: 100px;">
                        <p>Please view the report summary for assessment results</p>
                    @endif
                    <a href="{{ url($company->id.'/report-summary') }}" class="btn btn-primary std-btn"><i class="fas fa-chart-pie"></i>Report Summary</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // var radio = document.getElementById('reg_yes');
    // var radio_no = document.getElementById('reg_no');
    // var reg_bin = document.getElementById('reg_bin');

    // if (radio.checked) {
    //     reg_bin.style.display = 'block'
    // };

    // if (radio_no.checked) {
    //     reg_bin.style.display = 'none'
    // };

    jQuery(document).ready(function(){

        $('.radio').on('change', function() {
        // this, in the anonymous function, refers to the changed-<input>:
        // select the element(s) you want to show/hide:
        $('#reg_bin')
            // pass a Boolean to the method, if the numeric-value of the changed-<input>
            // is exactly equal to 2 and that <input> is checked, the .business-fields
            // will be shown:
            .toggle(+this.value === 1 && this.checked);
        // trigger the change event, to show/hide the .business-fields element(s) on
        // page-load:
        }).change();

    });
</script>
@endsection
