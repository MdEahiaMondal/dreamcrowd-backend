@extends('layout.app')
@section('title', 'Teacher Dashboard | Contact Us')
@section('content')
    
@if (Session::has('error'))
<script>

      toastr.options =
        {
            "closeButton" : true,
             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
        }
                toastr.error("{{ session('error') }}");

                
</script>
@endif
@if (Session::has('success'))
<script>

      toastr.options =
        {
            "closeButton" : true,
             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
        }
                toastr.success("{{ session('success') }}");

                
</script>
@endif



      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row dash-notification">
          <div class="col-md-12">
            <div class="dash">
              <div class="row">
                <div class="col-md-12">
                  <div class="dash-top">
                    <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Contact Us</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-id-card icon" title="Contact us"></i>

                      <h2>Contact Us</h2>
                    </div>
                  </div>
                </div>
              </div>

              <form action="/contact-mail" method="POST">
                @csrf
             
                <div class="drop-mail-sec">
                  <div class="row">
                    <h1>Drop Us a Mail</h1>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <input
                          type="text" name="first_name" value="{{Auth::user()->first_name}}"
                          class="form-control" readonly
                          id="exampleFormControlInput1"
                          placeholder="First Name" required
                        />
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="mb-3">
                        <input
                          type="text" name="last_name"  value="{{Auth::user()->last_name}}"
                          class="form-control" readonly
                          id="exampleFormControlInput1"
                          placeholder="Last Name" required
                        />
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="mb-3">
                        <input
                          type="email" name="email"  value="{{Auth::user()->email}}"
                          class="form-control" required
                          id="exampleFormControlInput1"
                          placeholder="orhankhan098@gmail.com" required
                        />
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="mb-3">
                        <input
                          type="text" name="subject"
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="Your Subject" required
                        />
                      </div>
                    </div>
  
                    <div class="col-md-12">
                      <div class="mb-3">
                        <textarea
                          class="form-control text-area-sec"
                          id="exampleFormControlTextarea1"
                          rows="3" name="msg"
                          placeholder="Type your message........"
                        ></textarea>
                      </div>
                      <button type="submit" class="btn">SEND</button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="user-footer text-center">
                <p class="mb-0">
                  Copyright Dreamcrowd © 2021. All Rights Reserved.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    @endsection