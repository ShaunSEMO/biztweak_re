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
                    <br>
                    <a href="{{ url('/'.$company->id.'/full-report') }}" class="btn btn-primary">Full Report</a>                                       
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
                    Report Summary
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($biz_scores as $score)
                            <div class="col-md-6">
                                <div id="{{'chart_'.$score->id}}" style="max-width: 900px; max-height: 500px;"></div>
                            </div>
                        @endforeach
                    </div>
                    <div id="piechart" style="max-width: 900px; max-height: 500px;"></div>       
                </div>
            </div>

        </div>
    </div>
</div>

@foreach ($charts_js as $chart)
    {!! $chart !!}
@endforeach

<script type="text/javascript">
    // ------ Full report ------

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();

      var data_set = {!! json_encode($scores) !!};


      data.addColumn('string', 'Category');
      data.addColumn('number', 'Score');
      data.addRows(data_set);

      var options = {
        // pieHole: 0.2,
        'title': 'Assessment results',
        animation: {
            "startup": true,
            duration: 1000,
            easing: 'out'
        }
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>

  
@endsection
