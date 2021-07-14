@extends('layouts.app')

@section('content')
<div class="container" style="color: white">
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
                    <br>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Current company details --}}
            <div class="container">
                <div class="row user-container">
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
                <br>
                <br>
                <a href="{{ url('/'.$company->id.'/full-report') }}" class="btn btn-primary" style="background-color: white !important; color: black; border-radius: 100px; border:none;">Full Report</a>                                       
            </div>
        </div>
    </div>

    <br><br>

    <h3><span style="color: #2a8f92">Summary</span> Report</h3>
    <hr class="std-hr">
    <br>

    <div class="row">
        <div class="col-md-6 field_score_cont ">
            <div class="row field-root container">
                @foreach ($field_scores as $score)
                    <div class="col-md-12 row field-cont">
                        <div class="col-md-6">
                            <div id="{{'chart_'.$score->id}}" style="max-width: 900px; max-height: 500px;"></div>
                        </div>
                        <div class="col-md-6">
                            <h4>{{ $score->field_name }}</h4>
                            <br>
                            <p>{{ $score->field_desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
        </div>
        <div class="col-md-6 b_rating">
            <div id="biz_rating" style="max-width: 900px; height: 500px;"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 ">
            <div class="rounded-charts" id="concept_chart" style="max-width: 900px; height: 400px;"></div>
        </div>
        <div class="col-md-6">
            <div class="rounded-charts" id="structure_chart" style="max-width: 900px; height: 400px;"></div>
        </div>
    </div>
</div>

@foreach ($charts_js as $chart)
    {!! $chart !!}
@endforeach

<script>
    // Business concept report

    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      var data_set = {!! json_encode($concept_charts_js) !!};

      data.addColumn('string', 'Category');
      data.addColumn('number', 'Score');

      data.addRows(data_set);

      var options = {
        title: 'Business Concept',
        hAxis: {
          title: 'Category',
        },
        vAxis: {
          title: 'Score (scale 0-100)'
        },
        colors: ['#5BD4D9'],

      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('concept_chart'));

      chart.draw(data, options);
    }
</script>

<script>
    // Business structure report

    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      var data_set = {!! json_encode($structure_charts_js) !!};

      data.addColumn('string', 'Category');
      data.addColumn('number', 'Score');

      data.addRows(data_set);

      var options = {
        title: 'Business Structure',
        hAxis: {
          title: 'Category',
        },
        vAxis: {
          title: 'Score (scale 0-100)'
        }, 
        colors: ['#5BD4D9'],
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('structure_chart'));

      chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();

      var data_set = {!! json_encode($biz_score_slices) !!};

      data.addColumn('string', 'Category');
      data.addColumn('number', 'Score');

      data.addRows(data_set);


      var options = {
        title: 'Biz Rating',
        slices: {  1: {offset: 0.2},
                    4: {offset: 0.3},
                    7: {offset: 0.4},
                    10: {offset: 0.5},
          },
        colors: ['#21e9f0', '#21c0f0', '#b7faff', '#188188', '#00cbda'],
      };

      var chart = new google.visualization.PieChart(document.getElementById('biz_rating'));

      chart.draw(data, options);
    }
  </script>

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
