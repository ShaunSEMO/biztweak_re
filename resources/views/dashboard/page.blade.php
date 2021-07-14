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
                <br>
                <div class="card user-container">
                    <div class="card-header">Admin Users</div>
                    <div class="card-body" style="text-align:center;">
                        <ol class="list-group list-group-numbered">
                            @foreach ($admins as $admin)
                                <li class="list-group-item">{{ $admin->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary">
                           {{ $completed_assess }} <br> <span class="badge bg-secondary"> Completed assessments</span>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary">
                           {{ $incompl_assess }} <br><span class="badge bg-secondary"> Incomplete assessments</span>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary">
                            {{ $total_assess }} <br><span class="badge bg-secondary"> Totall assessments</span>
                        </button>
                    </div>
                </div>

                <br>
                <br>

                <div class="accordion" id="accordionExample">

                    @foreach ($users as $each)
                        <div class="accordion-item" style="background-color: #a9f2f500 !important">
                            <h1 class="accordion-header" id="heading1">
                                <button style="color: white; background-color: #2a8f92;" class="accordion-button h3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1{{ $each->id }}" aria-expanded="true" aria-controls="collapse1{{ $each->id }}">
                                    {{ $each->name }} - {{ $each->email }}
                                </button>
                            </h1>
                            
                            <div id="collapse1{{ $each->id }}" class="accordion-collapse collapse show" aria-labelledby="heading1" >
                                <div class="accordion-body" >
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
                                            @foreach ($each->biz_profiles as $biz)
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

                            
                                </div>
                            </div>
                        </div>    
                    @endforeach
                    
                </div>

                <br>
                <br>

            </div>
        </div>
    </div>

@endsection
