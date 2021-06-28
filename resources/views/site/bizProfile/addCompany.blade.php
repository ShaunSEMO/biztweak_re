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
                    <p>Company Name</p>
                    {{ Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Company name...']) }}
                    <hr>
                    <p>Company Logo</p>
                    {{ Form::file('image') }}
                    <hr>
                    <p>Is your company registered?</p>
                        {{ Form::label('registered', 'Yes') }}
                        {{ Form::radio('registered', 0, '', ['class'=>'radio']) }}
                        {{ Form::label('registered', 'No') }}
                        {{ Form::radio('registered', 1, '', ['class'=>'radio']) }}
                    <hr>
                    <p>Registration Number</p>
                    {{ Form::text('reg_number', '', ['class'=>'form-control', 'id'=>'reg_number', 'placeholder'=>'Registration number...']) }}
                    <hr>
                    <p>Registration Date</p>
                    {{ Form::text('reg_date', '', ['class'=>'form-control', 'id'=>'reg_date', 'placeholder'=>'Registration date...']) }}
                    <hr>
                    <p>Company Location</p>
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
                        '', 
                        
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
                    '',
                    
                    ['class'=>'form-control']) }}
                    <hr>
                    <p>Number of employees</p>
                    {{ Form::number('num_employees', '', ['class'=>'form-control', 'id'=>'num_employees', 'placeholder'=>'Number of employees at your company...']) }}
                    <hr>
                    <p>Annual Turnover</p>
                    {{ Form::number('annual_turnover', '', ['class'=>'form-control', 'id'=>'annual_turnover', 'placeholder'=>'What is your yearly turnover...']) }}
                    <hr>
                    <p>Monthly Turnover (Over 6 months)</p>
                    {{ Form::number('6mo_turnover', '', ['class'=>'form-control', 'id'=>'monthly_turnover', 'placeholder'=>'What was your monthly turnover in the past 6 months...']) }}
                    <hr>
                    <p>Products/Services</p>
                    {{ Form::textarea('offering', '', ['class'=>'form-control', 'id'=>'offering', 'placeholder'=>'What products or services is your company offering?']) }}
                    <hr>
                    <p>Since when has your business been in operation?</p>
                    {{ Form::date('start_date', '', ['class'=>'form-control', 'id'=>'start_date', 'placeholder'=>'Select date']) }}
                    <hr>
                    <p>Since when has your business been operating on the premise?</p>
                    {{ Form::date('premise_start_date', '', ['class'=>'form-control', 'id'=>'premise_start_date', 'placeholder'=>'Select date']) }}
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
                            {{ Form::number('card_to_perc', '', ['class'=>'form-control', 'id'=>'card_to_perc']) }}
                        </div>
                        <div class="col-md-4">
                            <p>Cash</p>
                            {{ Form::number('cash_to_perc', '', ['class'=>'form-control', 'id'=>'cash_to_perc']) }}
                        </div>
                        <div class="col-md-4">
                            <p>EFT</p>
                            {{ Form::number('eft_to_perc', '', ['class'=>'form-control', 'id'=>'eft_to_perc']) }}
                        </div>
                    </div>
                    <br>
                    <br>
                    {{ Form::submit('Save', ['class' => 'btn btn-primary std-btn']) }}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        $('.radio').on('change', function() {
            $('#reg_bin').toggle(+this.value === 1 && this.checked);
        }).change();
    });
</script>
@endsection
