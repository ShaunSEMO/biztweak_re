@extends('layouts.app')

@section('content')
<div class="container" >
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
            <div class="card" style="background-color: #5bd5d900; border: none;">
                <div class="card-header" style="border-radius: 25px; background-color: #2a8f92; color: white;">Your Companies</div>
                <br>
                <div class="card-body">
                    <a class='btn btn-primary std-btn' href="{{ url($user->id.'/add-company') }}"><i class="fas fa-plus-circle"></i>Add Company</a>
                    <br>
                    <br>
                    @if (count($user->biz_profiles)>0)
                        <div class="row">
                            @foreach ($user->biz_profiles as $biz)
                                <div class="col-md-4" style="text-align: center">
                                    <a href="{{ url($biz->id.'/manage-company') }}" style="text-decoration: none;">
                                        <div class="card text-dark mb-3" style="max-width: 18rem; padding: 5px; border-radius: 25px;">
                                            <div class="card-header" style="border-radius: 25px; background-color: #2a8f92; color: white;">{{ $biz->name }}</div>
                                            <div class="card-body">
                                                <img class="img-fluid thumbnail" src="{{ asset($biz->logo) }}" alt="Business logo">
                                                <br>
                                                <br>
                                                @if (isset($biz->reg_number))
                                                    <p>{{ $biz->reg_number }}</p>
                                                @endif
                                                <p>{{ $biz->industry }}</p>
                                                <small>{{ $biz->phase->phase }}</small>
                                            </div>
                                        </div>
                                    </a>
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
