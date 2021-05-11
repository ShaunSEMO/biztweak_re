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
            <div class="card">
                <div class="card-header">Please complete your company profile</div>

                <div class="card-body container">
                    {!! Form::open(['action' => ['App\Http\Controllers\HomeController@saveCompany', $user->id], 'files' => true, 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                        {{ Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Company name...']) }}
                        <hr>
                        {{ Form::file('image') }}
                        <hr>
                        <p>Is your company registered?</p>
                        {{ Form::label('registered', 'Yes') }}
                        {{ Form::radio('registered', 0) }}
                        {{ Form::label('registered', 'No') }}
                        {{ Form::radio('registered', 1) }}
                        <hr>
                        {{ Form::text('reg_number', '', ['class'=>'form-control', 'id'=>'reg_number', 'placeholder'=>'Registration number...']) }}
                        <hr>
                        {{ Form::text('location', '', ['class'=>'form-control', 'placeholder'=>'Company physical address...']) }}
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
                            
                            ['class'=>'form-control']) }}

                        <hr>
                        <p>Business Phase</p>
                        {{ Form::select('biz_phase', [
                            'phase_i' => 'I have an idea but don’t know what to do next', 
                            'phase_ii' => 'I have a business but am not making money',
                            'phase_iii' => 'I have products/services but I have poor sales',
                            'phase_iv' => 'We are generating revenue, we would like to grow',
                            'phase_v' => 'I would like to be an entrepreneur but don’t know where to start',
                        ],
                        
                        ['class'=>'form-control']) }}
                        <br>
                        <br>
                        {{ Form::submit('Save', ['class' => 'btn btn-primary std-btn']) }}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
