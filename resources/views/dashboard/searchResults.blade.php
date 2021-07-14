@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
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
            <div class="col-md-9">

                <h3>Search Results</h3>
                <hr>
                <br>
                <br>
                @if (count($business_results)>0)
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">Company name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Phase</th>
                            <th scope="col">Industry</th>
                            <th scope="col">Employees</th>
                            <th scope="col">Turnover</th>
                            <th scope="col">Biz rating</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($business_results as $biz)
                                <tr>
                                    <th scope="row">{{$biz->id}}</th>
                                    <td>{{ $biz->name }}</td>
                                    <td>{{ $biz->location }}</td>
                                    <td>{{ $biz->phase_id }}</td>
                                    <td>{{ $biz->industry }}</td>
                                    <td>{{ $biz->num_employees }}</td>
                                    <td>{{ $biz->annual_turnover }}</td>
                                    <td>NULL</td>
                                    <td><button class="btn btn-primary">View Report</button></td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <br><br>

                @if (isset($users_results))
                    <ol class="list-group list-group-numbered">
                        @foreach ($users_results as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    {{$user->email}}
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ count($user->biz_profiles).' Biz Profile(s)' }}</span>
                            </li>
                        @endforeach
                    </ol>
                @endif

            </div>
        </div>
    </div>

@endsection
