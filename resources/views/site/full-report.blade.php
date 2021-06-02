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

            <hr>
            <div class="card">
                <div class="card-header">
                    Full Report
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">

                        @foreach ($cate_groups as $group)
                            <div class="accordion-item">
                                <h1 class="accordion-header" id="{{ 'heading'.$group->id}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{'#collapse'.$group->id}}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $group->cate_group_title }}
                                </button>
                                </h1>
                                <div id="{{'collapse'.$group->id}}" class="accordion-collapse collapse show" aria-labelledby="{{ 'heading'.$group->id}}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div id="chart_div"></div>
                                        <hr>
                                        <h3>Business Diagnosis</h3>
                                        <ul class="list-group">
                                            <li class="list-group-item">Channels</li>
                                            <li class="list-group-item">Value Proposition</li>
                                            <li class="list-group-item">E-commerce</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                      </div>     
                </div>
            </div>

        </div>
    </div>
</div>

<script>

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawAnnotations);

function drawAnnotations() {
      var data = google.visualization.arrayToDataTable([
        ['Category', 'Advantages', 'Dissadvantages'],
        ['Channels', 56, 44],
        ['Functional Capabilities', 87, 13],
        ['Business and Customers', 23, 73],
        ['E-commerce', 45, 55],
      ]);


      var options = {
        title: 'Best Performing Areas',
        annotations: {
          alwaysOutside: true,
          textStyle: {
            fontSize: 12,
            auraColor: 'none',
            color: '#555'
          },
          boxStyle: {
            stroke: '#ccc',
            strokeWidth: 1,
            gradient: {
              color1: '#f3e5f5',
              color2: '#f3e5f5',
              x1: '0%', y1: '0%',
              x2: '100%', y2: '100%'
            }
          }
        },
        hAxis: {
          title: 'Total Population',
          minValue: 0,
        },
        vAxis: {
          title: 'City'
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>
  
@endsection
