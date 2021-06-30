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
                    <button class="nav-link active" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#assessment" type="button" role="tab" aria-controls="assessment" aria-selected="true">Biz Assessment</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
                    <br>
                    <br>
                    @if ($assessment_complete != null)
                    <h3>Biz Assessment</h3>
                    <br>
                        <div class="accordion" id="accordionExample">
                            {!! Form::open(['action' => ['App\Http\Controllers\HomeController@saveAssessment', $user->id, $company->id], 'files' => true, 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                                @foreach ($categories as $category)
                                    <div class="accordion-item" style="background-color: #2a8f9200">
                                        <h2 class="accordion-header" id="heading{{ $category->id }}">
                                            <button style="color: white; background-color: #2a8f92;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapse{{ $category->id }}">
                                                {{ $category->category_title }}
                                            </button>
                                        </h2>
                                        
                                        <div style="margin-top: 10px;" id="collapse{{ $category->id }}" class="accordion-collapse collapse show container" aria-labelledby="heading{{ $category->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body"  style="background-color: white; color: black; border-radius: 25px; padding: 10px;">
                                                    @foreach ($category->assessments as $assessment)
                                                    <div class="row" id="{{'yes_no_group_'.$assessment->id}}">
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
                        <h3><span style="color: #2a8f92">Assessment</span> Complete</h3>
                        <hr class="std-hr">
                        <p>Please view the report summary for assessment results</p>
                    @endif
                    <a href="{{ url($company->id.'/report-summary') }}" class="btn btn-primary std-btn"><i class="fas fa-chart-pie"></i>Report Summary</a>
                </div>
            </div>

        </div>
    </div>
</div>

@foreach ($dissapear_scripts as $script)
    {!! $script !!}
@endforeach

@endsection
