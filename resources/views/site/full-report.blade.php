@extends('layouts.app')

@section('content')
<div class="container" style='color:white'>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card user-container">
                <div class="card-body" style="text-align:center; color: black;">
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
                      <div class="modal-dialog" >
                        <div class="modal-content" style="background-color: #5bd5d900; border: none;">

                          <div class="modal-header" style="border-radius: 25px; background-color: #2a8f92; color: white; border: none;">
                            <h5 class="modal-title" id="exampleModalLabel">Report Recommendations</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <div class="modal-body" style="background-color: white; border-radius: 25px; margin-top: 20px;">
                            <p>The following are the topics and learning content you need to read and implement in order to improve the processes, systems in your business, as well as business performance</p>
                            <br>
                            @if (count($mi_recs)!=0)
                              <h4>Market Intelligence</h4>
    
                              @foreach ($mi_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif
                            
                            <br>

                            @if (count($sp_recs)!=0)
                              <h4>Stategic Planning</h4>
    
                              @foreach ($sp_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($fm_recs)!=0)
                              <h4>Financial Management</h4>
    
                              @foreach ($fm_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($mas_recs)!=0)
                              <h4>Marketing and Sales</h4>
    
                              @foreach ($mas_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($pd_recs)!=0)
                              <h4>Product Development</h4>
    
                              @foreach ($pd_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($tm_recs)!=0)
                              <h4>Talent Management</h4>
    
                              @foreach ($tm_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($pm_recs)!=0)
                              <h4>Business Process Management</h4>
    
                              @foreach ($pm_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif

                            <br>

                            @if (count($le_recs)!=0)
                              <h4>Legal</h4>
    
                              @foreach ($le_recs as $rec)
                                <p>-{{ $rec }}</p>
                              @endforeach 
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Current company details --}}
            <div class="container">
                <div class="user-container row">
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
            </div>
          </div>
    </div>

    <br>
    <br>
    
    <h3><span style="color: #2a8f92">Full</span> Report</h3>
    <hr class="std-hr">
    <br>
    <br>
      <div class="card-body">
          <div class="accordion" id="accordionExample">
                  <div class="accordion-item" style="background-color: #a9f2f500 !important">
                      <h1 class="accordion-header" id="heading1">
                      <button style="color: white; background-color: #2a8f92;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                          Business Concept
                      </button>
                      </h1>
                      
                      <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" >
                          <div class="accordion-body" >
                              <div id="concept_chart" class="rounded-charts" style="max-width: 1100px; max-height: 800px;"></div>
                              <hr>
                              <h4><span style="color: #2a8f92">Business</span> Diagnosis</h4>
                              <hr class="std-hr">
                              <br>
                              <br>
                              <div class="accordion" id="accordionExample">
                                  <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                    <h2 class="accordion-header" id="headingOne">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Priority Elements
                                      </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                      <div class="accordion-body">
                                          <ul class="list-group">
                                                @if (isset($conc_vp_score))
                                                  <li class="list-group-item">
                                                    <h5>{{ $conc_vp_score->category_title }}</h5>
                                                    <span class="badge rounded-pill bg-primary">{{ $conc_vp_score->score }}%</span>
                                                    <hr>
                                                    <ul class="list-group list-group-numbered">

  
                                                    @foreach ($conc_vp_score->answers as $answer)

                                                      <div class="list-group-item d-flex justify-content-between align-items-start">
                                                            
                                                        <p class="color-code">{{ $answer->outcome }}</p>
                                                      </div>
                                                    @endforeach
                                                    </ul>
                                                  </li>
                                                @endif

                                                <br>

                                                @if (isset($conc_cs_score))
                                                  <li class="list-group-item">
                                                    <h5>{{ $conc_cs_score->category_title }}</h5>
                                                    <span class="badge rounded-pill bg-primary">{{ $conc_cs_score->score }}%</span>
                                                    <hr>
                                                    <ul class="list-group list-group-numbered">

  
                                                    @foreach ($conc_cs_score->answers as $answer)

                                                      <div class="list-group-item d-flex justify-content-between align-items-start">
                                                            
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                      </div>
                                                    @endforeach
                                                    </ul>
                                                  </li>
                                                @endif

                                                <br>

                                                @if (isset($conc_poc_score))
                                                  <li class="list-group-item">
                                                    <h5>{{ $conc_poc_score->category_title }}</h5>
                                                    <span class="badge rounded-pill bg-primary">{{ $conc_poc_score->score }}%</span>
                                                    <hr>
                                                    <ul class="list-group list-group-numbered">

  
                                                    @foreach ($conc_poc_score->answers as $answer)

                                                      <div class="list-group-item d-flex justify-content-between align-items-start">
                                                            
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                      </div>
                                                    @endforeach
                                                    </ul>
                                                  </li>
                                                @endif
                                          </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                    <h2 class="accordion-header" id="headingTwo">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Best Performing Areas
                                      </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" >
                                      <div class="accordion-body">
                                        <ul class="list-group">
                                          @foreach ($concept_best_performing as $performing)
                                            <li class="list-group-item">
                                              <h5>{{ $performing->category_title }}</h5>
                                              <span class="badge rounded-pill bg-primary">{{ $performing->score }}%</span>
                                              <hr>
                                              <ul class="list-group list-group-numbered">
                                                @foreach ($performing->answers as $answer)
                                                  <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                  </div>
                                                @endforeach
                                              </ul>
                                            </li>
                                            <br>
                                          @endforeach
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                    <h2 class="accordion-header" id="headingThree">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Major Gaps
                                      </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" >
                                      <div class="accordion-body">
                                        <ul class="list-group">
                                          @foreach ($concept_major_gaps as $gap)
                                            <li class="list-group-item">
                                              <h5>{{ $gap->category_title }}</h5>
                                              <span class="badge rounded-pill bg-primary">{{ $gap->score }}%</span>
                                              <hr>
                                              <ul class="list-group list-group-numbered">
                                                @foreach ($gap->answers as $answer)
                                                  <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                  </div>
                                                @endforeach
                                              </ul>
                                            </li>
                                            <br>
                                          @endforeach
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <br>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="accordion-item" style="background-color: #a9f2f500 !important">
                      <h1 class="accordion-header" id="heading2">
                      <button style="color: white; background-color: #2a8f92;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapseTwo">
                          Business Structure
                      </button>
                      </h1>
                      <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" >
                          <div class="accordion-body">
                              <div id="structure_chart" style="max-width: 1100px; max-height: 800px;"></div>
                              <hr>
                              <h4><span style="color: #2a8f92">Business</span> Diagnosis</h4>
                              <hr class="std-hr">
                              <br>
                              <br>
                              <div class="accordion" id="accordionExample">
                                <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Priority Elements
                                    </button>
                                  </h2>
                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                          @if (isset($struct_talent_score))
                                            <li class="list-group-item">
                                              <h5>{{ $struct_talent_score->category_title }}</h5>
                                              <span class="badge rounded-pill bg-primary">{{ $struct_talent_score->score }}%</span>
                                              <hr>
                                              <ul class="list-group list-group-numbered">
                                                @foreach ($struct_talent_score->answers as $answer)
                                                  <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                  </div>
                                                @endforeach
                                              </ul>
                                            </li>
                                          @endif

                                          @if (isset($struct_bpm_score))
                                            <li class="list-group-item">
                                              <h5>{{ $struct_bpm_score->category_title }}</h5>
                                              <span class="badge rounded-pill bg-primary">{{ $struct_bpm_score->score }}%</span>
                                              <hr>
                                              <ul class="list-group list-group-numbered">
                                                @foreach ($struct_bpm_score->answers as $answer)
                                                  <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                  </div>
                                                @endforeach
                                              </ul>
                                            </li>
                                          @endif

                                          @if (isset($struct_fm_score))
                                            <li class="list-group-item">
                                              <h5>{{ $struct_fm_score->category_title }}</h5>
                                              <span class="badge rounded-pill bg-primary">{{ $struct_fm_score->score }}%</span>
                                              <hr>
                                              <ul class="list-group list-group-numbered">
                                                @foreach ($struct_fm_score->answers as $answer)
                                                  <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                    <p class="color-code">{{ $answer->outcome }}</p>
                                                  </div>
                                                @endforeach
                                              </ul>
                                            </li>
                                          @endif
                                          
                                        </ul>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                  <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                      Best Performing Areas
                                    </button>
                                  </h2>
                                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" >
                                    <div class="accordion-body">
                                      <ul class="list-group">
                                        @foreach ($structure_best_performing as $performing)
                                          <li class="list-group-item">
                                            <h5>{{ $performing->category_title }}</h5>
                                            <span class="badge rounded-pill bg-primary">{{ $performing->score }}%</span>
                                            <hr>
                                            <ul class="list-group list-group-numbered">
                                              @foreach ($performing->answers as $answer)
                                                <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                  <p class="color-code">{{ $answer->outcome }}</p>
                                                </div>
                                              @endforeach
                                            </ul>
                                          </li>
                                        @endforeach
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="accordion-item cust-accordion" style="background-color: #a9f2f500 !important">
                                  <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                      Major Gaps
                                    </button>
                                  </h2>
                                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" >
                                    <div class="accordion-body">
                                      <ul class="list-group list-group-numbered">
                                        @foreach ($structure_major_gaps as $gap)
                                          <li class="list-group-item">
                                            <h5>{{ $gap->category_title }}</h5>
                                            <span class="badge rounded-pill bg-primary">{{ $gap->score }}%</span>
                                            <hr>
                                            <ul class="list-group list-group-numbered">
                                              @foreach ($gap->answers as $answer)
                                                <div class="list-group-item d-flex justify-content-between align-items-start">   
                                                  <p class="color-code">{{ $answer->outcome }}</p>
                                                </div>
                                              @endforeach
                                            </ul>
                                          </li>
                                        @endforeach
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <br>
                              </div>
                          </div>
                      </div>
                  </div>

            </div>     
      </div>
</div>

<script>
  var item_par = document.getElementsByClassName('color-code');

  for (let i = 0; i < item_par.length; i++) {
    if (item_par[i].innerText.includes('not') || item_par[i].innerText.includes('No') || item_par[i].innerText.includes('needs')) {
      item_par[i].parentNode.classList.add("list-group-item-danger");
    } else {
      item_par[i].parentNode.classList.add("list-group-item-success");
    }
  }

</script>

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
