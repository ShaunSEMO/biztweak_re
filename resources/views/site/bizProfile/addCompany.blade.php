@extends('layouts.app')

@section('content')
<div class="container">
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
            <div class="card user-container">
                <div class="card-header" style="border-radius: 25px; background-color: #2a8f92; color: white;">Please complete your company profile</div>

                <div class="card-body container">

                    <form method="POST" action="{{ url($user->id.'/save-company')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    
                        <p>Company Name</p>
                        <input placeholder="Company name..." name="name" type="text" value="" class="form-control"> 
                        <hr>
                        <p>Company Logo</p>
                        <input name="image" type="file"> 
                        <hr>
                        <p>Is your company registered?</p>
                        <label for="registered">Yes</label> <input name="registered" type="radio" value="1" id="registered" class="radio"> <label for="registered">No</label> <input name="registered" type="radio" value="0" id="registered" class="radio"> 
                        <hr>
                        <div id="reg_bin" style="display: none;">
                           <p>Registration Number</p>
                           <input id="reg_number" placeholder="Registration number..." name="reg_number" type="text" value="" class="form-control"> 
                           <hr>
                           <p>Registration Date</p>
                           <input id="reg_date" placeholder="Registration date..." name="reg_date" type="text" value="" class="form-control"> 
                           <hr>
                        </div>
                        <p>Company Location</p>
                        <input id="autocomplete" placeholder="Company physical address..." name="location" type="text" value="" class="form-control pac-target-input" autocomplete="off"> 
                        <hr>
                        <p>Business industry</p>
                        <select name="industry" class="form-control">
                           <option value="Admin/Business support">Admin/Business support</option>
                           <option value="Agriculture, Forestry,Fishing and Hunting">Agriculture, Forestry,Fishing and Hunting</option>
                           <option value="Arts, Entertainment and Recreation">Arts, Entertainment and Recreation</option>
                           <option value="Constrution">Constrution</option>
                           <option value="Education">Education</option>
                           <option value="Finance and Insurance">Finance and Insurance</option>
                           <option value="Healthcare and Social Assistance">Healthcare and Social Assistance</option>
                           <option value="Hospitality">Hospitality</option>
                           <option value="Information Technology">Information Technology</option>
                           <option value="Manufacturing">Manufacturing</option>
                           <option value="Mining and Mineral processing">Mining and Mineral processing</option>
                           <option value="Professional, Scientific and Technical Services">Professional, Scientific and Technical Services</option>
                           <option value="Real Estate">Real Estate</option>
                           <option value="Retail">Retail</option>
                           <option value="Transport and Logistics">Transport and Logistics</option>
                           <option value="Other">Other</option>
                        </select>
                        <hr>
                        <p>Business Phase</p>
                        <select name="biz_phase" class="form-control">
                           <option value="phase_i">I have an idea but don’t know what to do next</option>
                           <option value="phase_ii">I have a business but am not making money</option>
                           <option value="phase_iii">I have products/services but I have poor sales</option>
                           <option value="phase_iv">We are generating revenue, we would like to grow through investment</option>
                           <option value="phase_v">I would like to be an entrepreneur but don’t know where to start</option>
                        </select>
                        <hr>
                        <p>Number of employees</p>
                        <input id="num_employees" placeholder="Number of employees at your company..." name="num_employees" type="number" value="" class="form-control"> 
                        <hr>
                        <p>Annual Turnover</p>
                        <input id="annual_turnover" placeholder="What is your yearly turnover..." name="annual_turnover" type="number" value="" class="form-control"> 
                        <hr>
                        <p>Monthly Turnover (Over 6 months)</p>
                        <input id="monthly_turnover" placeholder="What was your monthly turnover in the past 6 months..." name="6mo_turnover" type="number" value="" class="form-control"> 
                        <hr>
                        <p>Products/Services</p>
                        <textarea id="offering" placeholder="What products or services is your company offering?" name="offering" cols="50" rows="10" class="form-control"></textarea>
                        <hr>
                        <p>Since when has your business been in operation?</p>
                        <input id="start_date" placeholder="Select date" name="start_date" type="date" value="" class="form-control"> 
                        <hr>
                        <p>Since when has your business been operating on the premise?</p>
                        <input id="premise_start_date" placeholder="Select date" name="premise_start_date" type="date" value="" class="form-control"> 
                        <hr>
                        <p>Which bank does your company bank with?</p>
                        <select name="company_bank" class="form-control">
                           <option value="absa">ABSA</option>
                           <option value="nedbank">Nedbank</option>
                           <option value="standard_bank">Standard Bank</option>
                           <option value="fnb">FNB/RNB</option>
                           <option value="tyme_bank">Tyme bank</option>
                        </select>
                        <hr>
                        <p>What % of your turnover is</p>
                        <div class="row">
                           <div class="col-md-4">
                              <p>Card</p>
                              <input id="card_to_perc" name="card_to_perc" type="number" value="" class="form-control">
                           </div>
                           <div class="col-md-4">
                              <p>Cash</p>
                              <input id="cash_to_perc" name="cash_to_perc" type="number" value="" class="form-control">
                           </div>
                           <div class="col-md-4">
                              <p>EFT</p>
                              <input id="eft_to_perc" name="eft_to_perc" type="number" value="" class="form-control">
                           </div>
                        </div>
                        <br> <br> <input type="submit" value="Save" class="btn btn-primary std-btn">
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var placeSearch, autocomplete, geocoder;
    function initAutocomplete() {
        geocoder = new google.maps.Geocoder();
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });
        autocomplete.addListener('place_changed', fillInAddress);
    }
    function codeAddress(address) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == 'OK') {
                // This is the lat and lng results[0].geometry.location
                // alert(results[0].geometry.location);
            } else {
                // alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    
    function fillInAddress() {
        var place = autocomplete.getPlace();
    
        codeAddress(document.getElementById('autocomplete').value);
    }
    $(document).ready(function () {
        if ($('#autocomplete').length > 0) {
            initAutocomplete();
        }
    });
 </script>

 <script>
    $(document).ready(function () {
        var values = [0,0,0];

       $("#card_to_perc").keyup(function() {
            var value = $( this ).val();
            $("#cash_to_perc").val( (100-value) / 2 );
            $("#eft_to_perc").val( (100-value) / 2 );
        }).keyup();

        $("#cash_to_perc").keyup(function() {
            var value = $( this ).val();
            $("#eft_to_perc").val( 100-value-$("#card_to_perc").val() );
        }).keyup();

        // $("#eft_to_perc").keyup(function() {
        //     var value = $( this ).val();
        //     $("#card_to_perc").val( (100-value) / 2 );
        //     $("#cash_to_perc").val( (100-value) / 2 );
        // }).keyup();
    });

    
 </script>
@endsection
