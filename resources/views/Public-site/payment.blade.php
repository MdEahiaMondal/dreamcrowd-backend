<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
 
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
     <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
  {{-- =======Toastr CDN ======== --}}
 <link rel="stylesheet" type="text/css" 
 href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 {{-- =======Toastr CDN ======== --}}
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/bootstrap.min.css" />
    <link href="assets/public-site/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <title>DreamCrowd | Payment</title>
</head>

<style>
      .loading-spinner {
        position: relative;
        float: right !important;
        left: 138px !important;
         bottom: -12px !important;
            display: none; /* Initially hidden */
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

</style> 

<body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- page-payment -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <!-- ======================== PAYMENT SECTION START FROM HERE ====================== -->
                <div class="col-lg-8 col-md-12">
                    <div class="payment-sec">
                        <!-- ======================== PAYMENT DETAILS START FROM HERE ====================== -->
                        <div class="payment-detail-title">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Title: </h1>
                                </div>
                                        <div class="col-md-6">
                                            <span class="">{{ \Illuminate\Support\Str::limit($gig->title, 22, '...') }}</span>

                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                    <h1>Seller </h1>
                                    </div>
                                        <div class="col-md-6">
                                        <span class="">{{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">

                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Service Type </h1>
                                 </div> 
                                 <div class="col-md-6">
                                 <span class="">{{$gig->service_type}} {{$gig->service_role}} </span>
                                </div>
                                </div>
                                </div>

                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Booking Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                            
                                        @endphp
                                        <span class=""> 
                                            @if ($gig->service_role == 'Freelance')
                                            {{$gigData->freelance_service}}
                                             @else   {{$formData['group_type']}}
                                        @endif     </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">

                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Payment Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">{{$gig->payment_type}}</span>
                                    </div>
                                </div>
                                </div>

                                @if ($gig->service_role == 'Freelance')

                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Booking At</h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">{{$formData['selected_slots']}}</span>
                                    </div>
                                </div>
                                </div>
                                    
                                @endif

                         

                               
                                {{-- <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Additional Guests </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">  @if ($formData['extra_guests'] == 'Yes')
                                            {{$formData['total_people']}} Guests
                                            @else
                                            0 Guests
                                        @endif  </span>
                                    </div>
                                </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- ======================== PAYMENT DETAILS ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT DESCRIPTION START FROM HERE ====================== -->
                        {{-- <div class="paragraph">
                            <p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut niSl, quis. Tristique bibendum morbi vel vitæ ultrices donec accumsan. Tincidunt eget habitant pellentesque id purus. Hendrerit varius
                                sapien, nunc, turpis augue arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                            </p>
                        </div> --}}
                        <!-- ======================== PAYMENT DESCRIPTION ENDED HERE ====================== -->
                          {{-- Appointment Calender Booking ==== Start --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <!-- Load Moment Timezone -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone-with-data.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
                        <!-- ======================== PAYMENT TIMEZONE START FROM HERE ====================== -->
                        <div class="timezone">
                            <div class="row">
                                <h1>Timezone: {{ $formData['user_time_zone'] }}</h1>
                                @if ($gig->service_role == 'Class')
                                @php
                                    $class_time = array_filter(explode('|*|', $formData['selected_slots'])); // Remove empty values
                                    $max_classes = max(count($class_time), 3); // Show at least 3, or more if needed
                                @endphp
                            
                                @for ($i = 0; $i < $max_classes; $i++)
                                    <div class="col-md-4 rectangle-desc">
                                        <div class="rectangle">
                                            <h3>Class {{ $i + 1 }}</h3>
                                            <span class="timezone-desc">
                                                {{ $class_time[$i] ?? 'Not Available' }}
                                            </span>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                            </div>
                        </div>
                    
                        <!-- ======================== PAYMENT TIMEZONE ENDED HERE ====================== -->
                        <!-- ======================== SUBSCRIBE CARD START FROM HERE ====================== -->
                        <div class="subscription-sec">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card subscribe-card">
                                        <div class="card-body p-0">
                                            <h5 class="card-title subscribe-heading">Order Amount: ${{$formData['finel_price']}}</h5>
                                            @if ($gig->payment_type == 'Subscription')
                                            <p class="card-text subscribe-text">You will be charged ${{$formData['finel_price']}} each month
                                                for your subscription package
                                                </p>
                                            @else
                                            <p class="card-text subscribe-text">You will be charged a One-Off Payment of ${{$formData['finel_price']}} today with no recurring fee 
                                                </p>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card subscribe-card">
                                        <div class="card-body p-0">
                                            <h5 class="card-title subscribe-heading">Booking and Order Information
                                            </h5>
                                            <p class="card-text subscribe-text">After completing your order, you will be
                                                emailed your receipt and booking instructions if applicable’
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================== SUBSCRIBE CARD ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT FORM START FROM HERE ====================== -->
                        <div class="payment-form-sec">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-start">
                                        <h1>Pay With</h1>
                                    </div>
                                    <div class="float-end">
                                        <a href="#"><img src="assets/public-site/asset/img/visacard.png"></a>
                                        <a href="#"> <img src="assets/public-site/asset/img/mastercard.png"></a>
                                        <a href="#"><img src="assets/public-site/asset/img/expresscard.png"></a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                       
                            <div class="payment-form">
                                <div class="row g-3">
                                    <div class="col-md-6 form-input">
                                        <input type="hidden" id="form_data" name="form_data" value='@json($formData)'>
                                        <input type="hidden" id="price" name="price" value="{{ $formData['price'] }}">
                                        <input type="hidden" id="finel_price" name="finel_price" value="{{ $formData['finel_price'] }}">
                                        <input type="text" class="form-control payment-input" id="holder_name" name="holder_name"
                                            placeholder="Card Holder Name" required>
                                    </div>
                                    <div class="col-md-6 form-input">
                                        <input type="number" class="form-control payment-input" id="card_number" name="card_number"
                                            placeholder="Card Number" required>
                                    </div>
                                    <div class="col-md-6 input-start form-input cvv">
                                        <input type="number" class="form-control payment-input" id="cvv" name="cvv"
                                            placeholder="CVV" required>
                                    </div>
                                    <div class="col-md-6 form-input">
                                        <input type="text" class="form-control payment-input" id="date" name="date"
                                            placeholder="MM/YY" required>
                                    </div>
                                    <div class="col-12 form-input">
                                        <label for="coupon" class="form-label enter-coupon">Enter Coupon</label>
                                        <input type="hidden" id="discount" name="discount" value="0">
                                        <input type="text" class="form-control payment-input" id="coupon" name="coupon"
                                            placeholder="OR87262">
                                    </div>
                                    <div class="col-12 form-input">
                                        <div class="form-check form-check-box">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" required>
                                            <label class="form-check-label checkbox-confirmation" for="gridCheck">
                                                By checking this box, you’re confirming that you understand and agree with
                                                our <a href="/term-condition" target="__" class="confirmation-link">terms & conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 form-input-btn">
                                        <button onclick="SubmitPayment()" id="pay_btn" type="button" class="btn submit-payment float-end">
                                            Pay Securely ${{$formData['finel_price']}}
                                        </button>
                                        <div id="BtnSpinner" class="loading-spinner"></div>
                                    </div>
                                </div>
                            </div>
                         

                    </div>

                      <!-- Modal -->
                      <div class="modal fade" id="PaymentModel" tabindex="-1"
                      aria-labelledby="PaymentModelLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content payment-modal">
                              <div class="modal-body payment-body">
                                  <img src="assets/public-site/asset/img/payment-submit-successfully.png" alt=""
                                      class="submit-payment-image">
                                  <h1>Thank You</h1>
                                  <p>Your order has been completed. You will receive a confirmation
                                      email shortly</p>
                                  <a href="/seller-listing" class="btn submit-payment-successfully"
                                       >Go to dashboard</a>
                              </div>
                          </div>
                      </div>
                  </div> 
                    <!-- ======================== PAYMENT FORM ENDED HERE ====================== -->
                </div>
                <!-- ======================== PAYMENT SECTION ENDED HERE ====================== -->
                <!-- ======================== LEARNING SECTION START FROM HERE ====================== -->
                <div class="col-lg-4 col-md-12 col-sm-12 order-first">
                    <div class="learn-sec">
                        <div class="row">

                            <div class="col-md-4 col-s-12 learn-image">

                                @if (Str::endsWith($gig->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                                  <!-- Video Player -->
                                  <video autoplay loop muted   style="height: 100%; width: 100%;" >
                                      <source src="assets/teacher/listing/data_{{ $gig->user_id }}/media/{{$gig->main_file}}" type="video/mp4" >
                                      Your browser does not support the video tag.
                                  </video>
                              @elseif (Str::endsWith($gig->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                  <!-- Image Display -->
                                  <img src="assets/teacher/listing/data_{{ $gig->user_id }}/media/{{$gig->main_file}}"  >
                              @endif
      
      
      
                                 </div>

                            
                            <div class="col-md-8 col-sm-12 learn-style">
                                <h1>{{$gig->title}}</h1>
                                <p>By:&nbsp;<span>{{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.</span></p>
                                    </div>
                                </div>
                                <div class="learning">
                                    <div class="row">
                                        <div class="col-md-12 total-desc">
                                            <h1>Sub-Total<span class="sub-total">${{$formData['price']}}</span></h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 total-desc">
                                            <h1>Coupon Discount<span class="coupon">$0</span></h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 total-desc">
                                            <h1>Service Fee<span class="coupon">{{$formData['buyer_commission']}} %</span></h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 total-desc">
                                            <h1 class="total-payment">Total<span class="">${{$formData['finel_price']}}</span></h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="subscription">You can cancel your subscription at anytime</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================== LEARNING SECTION ENDED HERE ====================== -->
                    </div>
                </div>
            </div>

           <!-- ============================= FOOTER SECTION START HERE ===================================== -->
           <x-public-footer/>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
            <script src="assets/public-site/libs/jquery/jquery.js"></script>
            <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
            <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
            <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
            <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
            <script src="assets/public-site/libs/aos/js/aos.js"></script>
            <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
            <script src="assets/public-site/asset/js/script.js"></script>



        {{-- Card Validations Form ========script Start --}}

<script>


document.getElementById("date").addEventListener("keyup", function (event) {
    let input = this.value.replace(/\D/g, ""); // Remove non-numeric characters
    let formattedValue = "";

    if (input.length > 0) {
        let month = input.substring(0, 2);

        if (parseInt(month, 10) > 12) {
            month = "12"; // Restrict to max 12
        }

        formattedValue = month;
    }

    if (input.length > 2) {
        let day = input.substring(2, 4);
        formattedValue += "/" + day;
    }

    this.value = formattedValue;
});



// Submit Payment By Ajax =============== Script start ==========
function SubmitPayment() { 
    let holderName = document.getElementById("holder_name").value.trim();
    let cardNumber = document.getElementById("card_number").value.trim();
    let cvv = document.getElementById("cvv").value.trim();
    let date = document.getElementById("date").value;
    let coupon = document.getElementById("coupon").value.trim();
    let discount = document.getElementById("discount").value.trim();
    let checkbox = document.getElementById("gridCheck");
    let form_data = document.getElementById("form_data").value;
    let finalPrice = document.getElementById("finel_price").value;
     
    
    // Cardholder Name Validation (Only Letters & Spaces)
    let nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(holderName) || holderName === "") {
        alert("Please enter a valid Card Holder Name (letters only).");
        return;
    }

    // Card Number Validation (16 Digits)
    let cardRegex = /^\d{16}$/;
    if (!cardRegex.test(cardNumber)) {
        alert("Please enter a valid 16-digit Card Number.");
        return;
    }

    // CVV Validation (3 or 4 Digits)
    let cvvRegex = /^\d{3,4}$/;
    if (!cvvRegex.test(cvv)) {
        alert("Please enter a valid CVV (3 or 4 digits).");
        return;
    }

    // Validate Expiry Date (MM/YY format and future date check)
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(date)) {
        alert("Please enter a valid date in MM/YY format.");
        return;
    } else {
        // Split the date into month and year
        var [month, year] = date.split('/');
        var expiry = new Date(`20${year}`, month - 1);
        var now = new Date();
        
        // Check if expiry date is in the future
        if (expiry <= now) {
            alert("Please enter a valid future expiry date.");
            return;
        }
    }

    // Checkbox Validation
    if (!checkbox.checked) {
        alert("You must agree to the terms and conditions.");
        return;
    }

    // Prepare Data for AJAX
    let formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        holder_name: holderName,
        card_number: cardNumber,
        cvv: cvv,
        date: date,
        coupon: coupon,
        discount: discount,
        form_data: form_data,
        finel_price: finalPrice
    };


    var btn_html = $('#pay_btn').text();
    const button = document.getElementById('pay_btn');
            const spinner = document.getElementById('BtnSpinner');
            $(button).html('Waiting');
            button.disabled = true;
            $(spinner).css('display', 'block'); 

     
 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: '/service-payment',
        data: formData,
        dataType: 'json',
        success: function (response) {
 
            
            $(button).html(btn_html);
                button.disabled = false;
                spinner.style.display = 'none';

                if (response.success) {
                    $('#PaymentModel').modal('show'); // Corrected 'model' to 'modal'

                    // Redirect to /seller-listing on any click anywhere on the page
                    $(document).on('click', function () {
                        window.location.href = "/seller-listing";
                    });

                }
               
               
            // You can redirect or update the UI based on the response
        },
        error: function (xhr, status, error) {
            $(button).html(btn_html);
                button.disabled = false;
                spinner.style.display = 'none';
            alert("Payment submission failed. Please try again.");
            console.error(xhr.responseText);
        }
    });
}



    
// Submit Payment By Ajax =============== Script END ==========


    </script>
        {{-- Card Validations Form ========script END --}} 






</body>

</html>