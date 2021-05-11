@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="designation" class="col-md-4 col-form-label text-md-right">Designation in company</label>

                            <div class="col-md-6">
                                <input id="designation" type="text" class="form-control" name="designation" required>
                            </div>
                        </div>

                        


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




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
