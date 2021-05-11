@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
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
            <div class="container row">
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
                    <div class="card">
                        <div class="card-header">You can edit your company profile below</div>
                        <div class="card-body container">
                            {!! Form::open(['action' => ['App\Http\Controllers\HomeController@editCompany', $company->id], 'files' => true, 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
                                <p>Company Name</p>
                                {{ Form::text('name', $company->name, ['class'=>'form-control', 'placeholder'=>'Company name...']) }}
                                <hr>
                                <p>Is your company registered?</p>
                                @if ($company->registered == 0)
                                    {{ Form::label('registered', 'Yes') }}
                                    {{ Form::radio('registered', 0) }}
                                    {{ Form::label('registered', 'No') }}
                                    {{ Form::radio('registered', 1, true) }}
                                @elseif($company->registered == 1) 
                                    {{ Form::label('registered', 'Yes') }}
                                    {{ Form::radio('registered', 0, true) }}
                                    {{ Form::label('registered', 'No') }}
                                    {{ Form::radio('registered', 1) }}
                                @endif
                                <hr>
                                <p>Registration Number</p>
                                {{ Form::text('reg_number', $company->reg_number, ['class'=>'form-control', 'id'=>'reg_number', 'placeholder'=>'Registration number...']) }}
                                <hr>
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
                                $company->biz_phase,
                                
                                ['class'=>'form-control']) }}
                                <br>
                                <br>
                                {{ Form::submit('Save', ['class' => 'btn btn-primary std-btn']) }}

                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
                    <h1>Biz Assessment</h1>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
