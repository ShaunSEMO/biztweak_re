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
                <div class="card-header">Your Companies</div>

                <div class="card-body">
                    <a class='btn btn-primary' href="{{ url($user->id.'/add-company') }}"><i class="fas fa-plus-circle"></i></a>
                    <br>
                    <br>
                    @if (count($user->biz_profiles)>0)
                        <div class="row">
                            @foreach ($user->biz_profiles as $biz)
                                <div class="col-md-4">
                                    <div class="card text-dark bg-info mb-3" style="max-width: 18rem;">
                                        <div class="card-header">{{ $biz->name }}</div>
                                        <div class="card-body">
                                            <img class="img-fluid thumbnail" src="{{ asset($biz->logo) }}" alt="Business logo">
                                            @if (isset($biz->reg_number))
                                                <p>{{ $biz->reg_number }}</p>
                                            @endif
                                            <p>{{ $biz->industry }}</p>
                                            <small>{{ $biz->biz_phase }}</small>
                                        </div>
                                      </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
