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
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary std-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Recommendations
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Report Recommendations</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>The following are the topics and learning content you need to read and implement in order to improve the processes, systems in your business, as well as business performance</p>
                            <br>
                            @foreach ($biz_scores as $biz_score)
                                <h4>{{ $biz_score->category_title }}</h4>
                                @php
                                  $recom_list = [];
                                  foreach ($biz_score->answers as $answer) {
                                    if (in_array($answer->recom, $recom_list) == False){
                                      array_push($recom_list, $answer->recom);
                                    }
                                  } 
                                @endphp
                                @foreach ($recom_list as $item)
                                    <p>-{{ $item }}</p>
                                @endforeach  
                            @endforeach
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
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

                            <div class="accordion-item">
                                <h1 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Business Concept
                                </button>
                                </h1>
                                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" >
                                    <div class="accordion-body">
                                        <div id="concept_chart" style="max-width: 900px; max-height: 500px;"></div>
                                        <hr>
                                        <h4>Business Diagnosis</h4>
                                        <br>
                                        <br>
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                              <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  Priority Elements
                                                </button>
                                              </h2>
                                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        @foreach ($concept_priority_scores as $score)
                                                          <li class="list-group-item">
                                                            <h5>{{ $score->category_title }}</h5>
                                                            <p>Score: {{ $score->score }}%</p>
                                                            <hr>
                                                            @foreach ($score->answers as $answer)
                                                              <p>--{{ $answer->outcome }}</p>
                                                            @endforeach
                                                          </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="accordion-item">
                                              <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  Best Performing Areas
                                                </button>
                                              </h2>
                                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" >
                                                <div class="accordion-body">
                                                  <ul class="list-group list-group-numbered">
                                                    @foreach ($concept_best_performing as $performing)
                                                      <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-success">
                                                        <div class="ms-2 me-auto">
                                                          <div class="fw-bold">{{ $performing->category_title }}</div>
                                                          <hr>
                                                          @foreach ($performing->answers as $answer)
                                                            <p>--{{ $answer->outcome }}</p>
                                                          @endforeach
                                                        </div>
                                                        <span class="badge bg-primary rounded-pill">{{ $performing->score }}%</span>
                                                      </li>
                                                    @endforeach
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            <div class="accordion-item">
                                              <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                  Major Gaps
                                                </button>
                                              </h2>
                                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" >
                                                <div class="accordion-body">
                                                  <ul class="list-group list-group-numbered">
                                                    @foreach ($concept_major_gaps as $gap)
                                                      <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-danger">
                                                        <div class="ms-2 me-auto">
                                                          <div class="fw-bold">{{ $gap->category_title }}</div>
                                                          <hr>
                                                          @foreach ($gap->answers as $answer)
                                                            <p>--{{ $answer->outcome }}</p>
                                                          @endforeach
                                                        </div>
                                                        <span class="badge bg-primary rounded-pill">{{ $gap->score }}%</span>
                                                      </li>
                                                    @endforeach
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h1 class="accordion-header" id="heading2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapseTwo">
                                    Business Structure
                                </button>
                                </h1>
                                <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" >
                                    <div class="accordion-body">
                                        <div id="structure_chart" style="max-width: 900px; max-height: 500px;"></div>
                                        <hr>
                                        <h4>Business Diagnosis</h4>
                                        <br>
                                        <br>
                                        <div class="accordion" id="accordionExample">
                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Priority Elements
                                              </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                              <div class="accordion-body">
                                                  <ul class="list-group">
                                                      @foreach ($structure_priority_scores as $score)
                                                        <li class="list-group-item">
                                                          <h5>{{ $score->category_title }}</h5>
                                                          <p>{{ $score->score }}</p>
                                                          <hr>
                                                          @foreach ($score->answers as $answer)
                                                            <p>--{{ $answer->outcome }}</p>
                                                        @endforeach
                                                        </li>
                                                      @endforeach
                                                  </ul>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Best Performing Areas
                                              </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" >
                                              <div class="accordion-body">
                                                <ul class="list-group list-group-numbered">
                                                  @foreach ($structure_best_performing as $performing)
                                                    <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-success">
                                                      <div class="ms-2 me-auto">
                                                        <div class="fw-bold">{{ $performing->category_title }}</div>
                                                        <hr>
                                                        @foreach ($performing->answers as $answer)
                                                          <p>--{{ $answer->outcome }}</p>
                                                        @endforeach
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $performing->score }}%</span>
                                                    </li>
                                                  @endforeach
                                                </ul>
                                              </div>
                                            </div>
                                          </div>
                                          
                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Major Gaps
                                              </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" >
                                              <div class="accordion-body">
                                                <ul class="list-group list-group-numbered">
                                                  @foreach ($structure_major_gaps as $gap)
                                                    <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-danger">
                                                      <div class="ms-2 me-auto">
                                                        <div class="fw-bold">{{ $gap->category_title }}</div>
                                                        <hr>
                                                        @foreach ($gap->answers as $answer)
                                                            <p>--{{ $answer->outcome }}</p>
                                                        @endforeach
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $gap->score }}%</span>
                                                    </li>
                                                  @endforeach
                                                </ul>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      </div>     
                </div>
            </div>

        </div>
    </div>
</div>


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
        }
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
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('structure_chart'));

      chart.draw(data, options);
    }
</script>
  
@endsection
