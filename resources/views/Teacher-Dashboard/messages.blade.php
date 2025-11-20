<!DOCTYPE html>
<html lang="en">
<head> 
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}} 
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css">
    <title>User Dashboard | </title>
</head>
<body>

 {{-- ===========Teacher Sidebar Start==================== --}}
 <x-teacher-sidebar/>
 {{-- ===========Teacher Sidebar End==================== --}}
 <section class="home-section">
    {{-- ===========Teacher NavBar Start==================== --}}
    <x-teacher-nav/>
    {{-- ===========Teacher NavBar End==================== --}}
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
                                  <span class="min-title">Messages</span>
                                  </div>
                              </div>
                          </div>
                          <!-- Blue MASSEGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
          <i class='bx bx-message-square-dots icon' title="Messages"></i>
                                  
                                  <h2>Messages</h2>
                              </div>
                          </div>
                      </div>
                  </div>


                  @if($chats->count() > 0)

                  <div class="row">
                        <div class="col-xl-3 col-lg-5 col-md-12 mb-2">
                          <!-- Sidebar -->
                          <div class="card chat-side-bar">
                            <div class="card-body">
                                <div class="box-notif box-input">
                                    <input type="text" placeholder="Search" class="form-control">
                                    <i class="fa-solid fa-magnifying-glass icon"></i>
                                  </div>


                                  <ul class="list-group" id="userList">
                                    @php $i = 1; @endphp
                                     @foreach ($chatList as $chat)
                                     <li class="list-group-item  @if ($i == 1) active  @endif" data-teacher-id="{{ $chat['teacher_id'] }}" onclick="OpenChat(this.id)" id="teacher_list_{{ $chat['teacher_id'] }}" style="cursor: pointer;">
                                         <a   class="box-notif"> 
                                             <img src="{{ $chat['profile_image'] }}" alt="Avatar" />
                                             @if ($chat['unseen_count'] != 0)
                                             <span class="blue-rate" id="teacher_list_{{ $chat['teacher_id'] }}_unseen">{{ $chat['unseen_count'] }}</span>
                                               @endif
                                             <span class="onlion-icon"></span>
                                            
                                             <div>
                                                 <p class="name">{{ $chat['teacher_name'] }}</p>
                                                 <p>{{ $chat['latest_sms'] }}</p>
                                             </div>
                                             <div class="time">
                                                 <span>{{ $chat['time'] }}</span>
                                             </div>
                                         </a>
                                     </li>
                                     @php $i++; @endphp
                                 @endforeach
                                     
                                     <!-- MSG-NOTIF -->
                                     {{-- <li class="list-group-item active" data-user="User 1" data-avatar="https://placekitten.com/40/40">
                                       <a href="#" class="box-notif">
                                         <img src="assets/user/asset/img/Ellipse 348.svg" />
                                         <span class="blue-rate">99+</span>
                                         <span class="onlion-icon"></span>
                                         <div>
                                           <p class="name">Wade Warren</p>
                                           <p>Acme Co.</p>
                                         </div>
                                         <div class="time">
                                           <span>just now</span>
                                         </div>
                                       </a>
                                     </li> --}} 
                                     
                                     
                                     <!-- END MSG-NOTIF -->
                                   </ul>
                                   
                              <ul class="list-group" id="userList">
                                <!-- MSG-NOTIF -->
                                <li class="list-group-item" data-user="User 1" data-avatar="https://placekitten.com/40/40">
                                  <a href="chat.html" class="box-notif">
                                    <img src="assets/teacher/asset/img/22.svg" />
                                        <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                        <span class="onlion-icon"></span>
                                        <div>
                                         <p class="name">Wade Warren</p>
                                         <p>Acme Co.</p>
                                        </div>
                                        <div class="time">
                                          <span>just now</span>
                                        </div>
                                        
                                       </a>
                                    </li>
                                      <!-- MSG-NOTIF -->
                                <li class="list-group-item" data-user="User 2" data-avatar="https://placekitten.com/40/41">
                                  <a href="#" class="box-notif">
                                    <!-- <img src="assets/img/fa_group.svg" alt="" /> -->
                                    <img src="assets/teacher/asset/teacher/asset/img/22.svg" />
                                        <span class="onlion-blue">99+</span>
                                        <div>
                                         <p class="name blue">Private Group</p>
                                         <p class="blue">Biffco Enterprises Ltd.</p>
                                        </div>
                                        <div class="time">
                                          <p class="blue">just now</p>
                                          <img src="assets/teacher/asset/img/fa_group.svg" alt=""><span class="blu-spn blue">group</span>
                                        </div>
                                       </a>
                                </li>
                                  <!-- MSG-NOTIF -->
                                <li class="list-group-item" data-user="User 3" data-avatar="https://placekitten.com/40/42">
                                  <a href="#" class="box-notif active">
                                    <img src="assets/teacher/asset/img/33.png" />
                                        <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                        <span class="onlion-icon"></span>
                                        <div>
                                         <p class="name act">Devon Lane</p>
                                         <p class="act">Biffco Enterprises Ltd.</p>
                                        </div>
                                        <div class="time">
                                          <span class="act">yesterday</span>
                                        </div>
                                      </a>
                                </li>
                                  <!-- MSG-NOTIF -->
                                <li class="list-group-item" data-user="User 4" data-avatar="https://placekitten.com/40/40">
                                  <a href="#" class="box-notif">
                                    <img src="assets/teacher/asset/img/55.svg" />
                                        <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                        <span class="onlion-icon"></span>
                                        <div>
                                         <p class="name">Devon Lane</p>
                                         <p>Biffco Enterprises Ltd.</p>
                                        </div>
                                        <div class="time">
                                          <span>yesterday</span>
                                        </div>
                                      </a>
                                </li>
                                  <!-- MSG-NOTIF -->
                            <li class="list-group-item" data-user="User 5" data-avatar="https://placekitten.com/40/41">
                              <a href="#" class="box-notif">
                                <img src="assets/teacher/asset/img/66.svg" />
                                    <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                    <span class="onlion-icon"></span>
                                    <div>
                                     <p class="name">Devon Lane</p>
                                     <p>Biffco Enterprises Ltd.</p>
                                    </div>
                                    <div class="time">
                                      <span>yesterday</span>
                                    </div>
                                  </a>
                    
                            </li>
                              <!-- MSG-NOTIF -->
                            <li class="list-group-item" data-user="User 6" data-avatar="https://placekitten.com/40/42">
                              <a href="#" class="box-notif">
                          <img src="assets/teacher/asset/img/Ellipse 348.svg" />
                                    <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                    <span class="onlion-icon"></span>
                                    <div>
                                     <p class="name">Devon Lane</p>
                                     <p>Biffco Enterprises Ltd.</p>
                                    </div>
                                    <div class="time">
                                      <span>Just Now</span>
                                    </div>
                                  </a>
                                
                            </li>
                              <!-- MSG-NOTIF -->
                            <li class="list-group-item" data-user="User 7" data-avatar="https://placekitten.com/40/40">
                              <a href="#" class="box-notif">
                                <img src="assets/teacher/asset/teacher/asset/img/22.svg" />
                                    <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                    <span class="onlion-icon"></span>
                                    <div>
                                     <p class="name">Devon Lane</p>
                                     <p>Biffco Enterprises Ltd.</p>
                                    </div>
                                    <div class="time">
                                      <span>yesterday</span>
                                    </div>
                                   </a>
                            </li>
                              <!-- MSG-NOTIF -->
                        <li class="list-group-item" data-user="User 8" data-avatar="https://placekitten.com/40/41">
                          <a href="#" class="box-notif">
                                <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                <img src="assets/teacher/asset/img/55.svg" />
                                <span class="onlion-icon"></span>
                                <div>
                                 <p class="name">Devon Lane</p>
                                 <p>Biffco Enterprises Ltd.</p>
                                </div>
                                <div class="time">
                                  <span>2hr ago</span>
                                </div>
                              </a>
                    
                        </li>
                          <!-- MSG-NOTIF -->
                        <li class="list-group-item" data-user="User 9" data-avatar="https://placekitten.com/40/42">
                          <a href="#" class="box-notif">
                            <img src="assets/teacher/asset/img/66.svg" />
                                <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                <span class="onlion-icon"></span>
                                <div>
                                 <p class="name">Devon Lane</p>
                                 <p>Biffco Enterprises Ltd.</p>
                                </div>
                                <div class="time">
                                  <span>2hr ago</span>
                                </div>
                               </a>
                            
                        </li>
                          <!-- MSG-NOTIF -->
                        <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                          <a href="#" class="box-notif">
                            <img src="assets/teacher/asset/img/Ellipse 348.svg" />
                                <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                                v
                                <div>
                                 <p class="name">Devon Lane</p>
                                 <p>Biffco Enterprises Ltd.</p>
                                </div>
                                <div class="time">
                                  <span>2hr ago</span>
                                </div>
                              </a>
                            
                        </li>
                          <!-- MSG-NOTIF -->
                        <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                          <a href="#" class="box-notif">
                            <img src="assets/teacher/asset/img/22.svg" />

                              <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                              <span class="onlion-icon"></span>
                              <div>
                               <p class="name">Devon Lane</p>
                               <p>Biffco Enterprises Ltd.</p>
                              </div>
                              <div class="time">
                                <span>2hr ago</span>
                              </div>
                            </a>
                          
                      </li>
                        <!-- MSG-NOTIF -->
                      <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                        <a href="#" class="box-notif">
                          <img src="assets/teacher/asset/img/55.svg" />

                            <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                            <span class="onlion-icon"></span>
                            <div>
                             <p class="name">Devon Lane</p>
                             <p>Biffco Enterprises Ltd.</p>
                            </div>
                            <div class="time">
                              <span>2hr ago</span>
                            </div>
                           </a>
                        
                    </li>
                      <!-- MSG-NOTIF -->
                    <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                      <a href="#" class="box-notif">
                        <img src="assets/teacher/asset/img/66.svg" />

                          <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                          <span class="onlion-icon"></span>
                          <div>
                           <p class="name">Devon Lane</p>
                           <p>Biffco Enterprises Ltd.</p>
                          </div>
                          <div class="time">
                            <span>2hr ago</span>
                          </div>
                        </a>
                  </li>
                    <!-- MSG-NOTIF -->
                  <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                    <a href="#" class="box-notif">
                      <img src="assets/teacher/asset/img/Ellipse 348.svg" />

                        <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                        <span class="onlion-icon"></span>
                        <div>
                         <p class="name">Devon Lane</p>
                         <p>Biffco Enterprises Ltd.</p>
                        </div>
                        <div class="time">
                          <span>2hr ago</span>
                        </div>
                      </a>
                    
                </li>
                  <!-- MSG-NOTIF -->
                <li class="list-group-item" data-user="User 10" data-avatar="https://placekitten.com/40/42">
                  <a href="#" class="box-notif">
                    <img src="assets/teacher/asset/img/55.svg" />
                      <!-- <img src="https://picsum.photos/50/50/?random=1"> -->
                      <span class="onlion-icon"></span>
                      <div>
                       <p class="name">Devon Lane</p>
                       <p>Biffco Enterprises Ltd.</p>
                      </div>
                      <div class="time">
                        <span>2hr ago</span>
                      </div>
                     </a>
                  
              </li>
                <!-- END MSG-NOTIF -->
                              </ul>
                            </div>
                          </div>
                        </div>
                        <!-- CHAT-BOX-SEC -->
                        <div class="col-xl-6 col-lg-7 col-md-12 mb-2">
                          <!-- Chat Box -->
                          <div class="card chat-box-right">
                            <div class="card-header" id="chat-header">
                                <img src="assets/teacher/asset/img/profile4.svg" alt="">
                               <!-- <img src="" alt="User Avatar" id="user-avatar"> -->
                               <div class="name">
                                <p>Reynante Labares</p>
                                <p>Active Now</p>
                               </div>
                                <span id="selectedUserName"></span> 
                              <div>
                              </div>
                            </div>
                              <div class="flex-shrink-1 rounded">
                                  <div class="card profile-data p-0"> 
                                      <div class=" image d-flex flex-column justify-content-center align-items-center">
                                           <img class="prof-mg" src="assets/teacher/asset/img/profile Image.svg" height="100" width="100" />
                                            <span class="name">Bessie Cooper</span>
                                             <!-- <span class="text-muted">Active 2m ago</span>  -->
                                             </div>
                                          
                                               <div class="icons gap-3 d-flex flex-row justify-content-center align-items-center"> 
                                                      <a href="#"><div class="link">
                                                        <div class="profile-icon">
                                                          <img src="assets/teacher/asset/img/profileicon (2).svg" alt="">
                                                        </a> </div>
                                                        
                                                        <p class="ofprofile">Profile</p>
                                                      </div>
                                                      <a href="#">
                                                      <div class="link">
                                                        <div class="profile-icon">
                                                          <img src="assets/teacher/asset/img/profileicon (3).svg" alt="">
                                                        </a></div>
                                                        
                                                        <p class="ofprofile">Mute</p>
                                                      </div>
                                                    
                                                      </div>
                                                     </div>

                                                     
                                                @else

                                                <h2 class="text-center">Not Get Any Chat</h2>

                                                @endif
                                          </div>
                                               
                                      
                          @if ($chats->count() > 0)
                                                    
                            <div class="card-footer">
                              <div class="input-group error-msg"> 
                                  <div class="row">
                                    <div class="col-lg-3 col-md-3 col-12 text">
                                        <textarea name="text" id="messages" placeholder="Type your message..."></textarea>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-12">
                                        <div class="d-flex eror main">
                                          <i class="fa-solid fa-triangle-exclamation"></i>
                                            <!-- <img src="assets/teacher/asset/img/ion_warning.svg" alt=""> -->
                                            <a href="#"><p class="mb-0">Terms Of Service Reminder: Sharing email addresses, social
                                              media handles or telephone numbers in most circumstances are not allowed. Your account may
                                              be banned if you are not adhering to our terms.</p></a>
                                          </div>
                                    </div>
                                  </div>    
                                </div>
                                <div class="input-group-append icon2">
                                  
                                    <a href="#">
                                      <i class="fa-regular fa-face-smile"></i>
                                    </a>
                                    <a href="#">
                                      <input type="file" id="imgInput" accept="image/*" style="display: none;">
                                      <i class="fa-solid fa-paperclip" onclick="uploadImage()"></i>
      
                                    </a>
      
                                    <!-- <input type="file" name="upload" id="upload" class="upload-box " placeholder="Upload File" aria-label="Upload File"> -->
      
                                    <!-- <a href="#"><img class="img-fluid"src="assets/img/subway_pin.png" alt="image title" /></a> -->
                                    <a href="#"><input type="file" id="imgInput" accept="image/*" style="display: none;"><i class="fa-regular fa-images" onclick="uploadImage()"></i></a>
                                    <!-- <a href="#"><img src="assets/img/gificon.svg" alt="" /></a> -->
                                    <a href="#"><input type="file" id="imgInput" accept="image/*" style="display: none;"><i class="fa-solid fa-video" onclick="uploadImage()"></i></a>
      
                                    <!-- <button class="btn send-btn" id="reactionBtn">😊</button> -->
                                  
                                  <!-- <a href="#"><img src="assets/img/smileimji.svg" alt=""></a>
                                    
                                  <a href="#"> <img src="assets/img/subway_pin.png" alt=""></a>
                                    <a href="#"> <img src="assets/img/fluentvideo.svg" alt=""></a>
                                      <a href="#"><img src="assets/img/gificon.svg" alt=""></a>
                                        <a href="#"> <img src="assets/img/fluentvideo.svg" alt=""></a> -->
                                         <!-- Button trigger modal -->
                                    <button type="button" class="custom-btn" data-bs-target="#myModal" data-bs-toggle="modal">custom offer</button>
                                    <h5 class="Safety-term" data-bs-toggle="modal" data-bs-target="#safety-rules">Safety rules<br> for messages</h5>
                                     <!-- Modal -->
                                     <div class="modal" id="myModal">
                                      <div class="modal-dialog">
                                        <div class="modal-content date-modal">
                                          
                                          <div class="modal-body p-0">
                                              <div class="head w-100">
                                                  <h1 class="text-center">What service are you interested in?</h1>
                                                 </div>
                                             <div class="model-heading">
                                              <p class="about">Curious about our offerings? Let us know your interests, and we'll tailor our services to meet your specific needs.</p>
                                              <div class="d-flex option-btn">
                                                  <div class="d-flex radio-toolbar">
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                              <input type="radio" id="offerTypeClass" name="offer_type" value="Class" checked data-bs-toggle="modal" data-bs-target="#secondModal" data-bs-dismiss="modal">
                                                      <label for="offerTypeClass">
                                                          <p class="label mb-0">Class Booking</p>
                                                          <p class="name-label mb-0">Effortless class booking for a seamless learning experience.</p>
                                                      </label>

                                                          </div>
                                                          <div class="col-md-6">
                                                              <input type="radio" id="offerTypeFreelance" name="offer_type" value="Freelance" data-bs-toggle="modal" data-bs-target="#thirdModal" data-bs-dismiss="modal">
                                                              <label for="offerTypeFreelance">
                                                                  <p class="label mb-0">Freelance Booking</p>
                                                                  <p class="name-label mb-0">Simplify your freelancing journey with quick and hassle-free bookings.</p>

                                                              </label>
                                                          </div>
                                                        </div>
                                                      
                                                     
                                                  </div>
                                              </div>
                                              <div class="model-footer">
                                                  <button class="back-btn"  data-bs-dismiss="modal" aria-label="Close">Back</button>
                                                  <button class="next-btn">Next</button>
                                              </div>
                                             </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                     <!-- Modal -->
                                     <div class="modal custom-modal" id="secondModal">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <i class="fa-solid fa-arrow-left" data-bs-target="#myModal" data-bs-toggle="modal" data-bs-dismiss="modal" style="cursor: pointer;"></i>
                                                <h5 class="modal-title">Select Any Class Service</h5>
                                            </div>
                                              <div class="modal-body bg-white service-list">
                                                  <!-- Services will be loaded dynamically via AJAX -->
                                                  <div class="text-center p-4">
                                                      <p class="text-muted">Loading services...</p>
                                                  </div>
                                                  </div>
                                              </div>
                                          </div>
                                    </div>
                                      <!-- Modal -->
                                      <div class="modal custom-modal" id="thirdModal">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                    <i class="fa-solid fa-arrow-left" data-bs-target="#myModal" data-bs-toggle="modal" data-bs-dismiss="modal" style="cursor: pointer;"></i>
                                                      <h5 class="modal-title">Select Any Freelance Service</h5>
                                                  </div>
                                                  <div class="modal-body bg-white service-list">
                                                      <!-- Services will be loaded dynamically via AJAX -->
                                                      <div class="text-center p-4">
                                                          <p class="text-muted">Loading services...</p>
                                                      </div>
                                                  </div>
                                              </div>
                                        </div>
                                        <!-- Service Mode Selection Modal -->
                                        <div class="modal custom-modal" id="servicemode-modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content date-modal">
                                                    <div class="modal-body p-0">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Select Service Mode</h5>
                                                        </div>
                                                        <div class="model-heading">
                                                            <p class="about">Choose how the service will be delivered.</p>
                                                            <div class="d-flex option-btn">
                                                                <div class="d-flex radio-toolbar">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="radio" id="serviceModeOnline" name="service_mode" value="Online" checked data-bs-toggle="modal" data-bs-target="#fourmodal" data-bs-dismiss="modal">
                                                                            <label for="serviceModeOnline">
                                                                                <p class="label mb-0">Online</p>
                                                                                <p class="name-label mb-0">Service will be delivered remotely via video call or online platform.</p>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="radio" id="serviceModeInPerson" name="service_mode" value="In-person" data-bs-toggle="modal" data-bs-target="#fourmodal" data-bs-dismiss="modal">
                                                                            <label for="serviceModeInPerson">
                                                                                <p class="label mb-0">In-person</p>
                                                                                <p class="name-label mb-0">Service will be delivered in person at a physical location.</p>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="model-footer">
                                                                <button class="back-btn" data-bs-target="#secondModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
                                                                <button class="next-btn">Next</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Payment Type Selection Modal -->
                                        <div class="modal custom-modal" id="fourmodal">
                                          <div class="modal-dialog">
                                            <div class="modal-content date-modal">

                                              <div class="modal-body p-0">
                                                <div class="modal-header">
                                                  
                                                    <h5 class="modal-title">Choose how you want to get paid</h5>  
                                                </div>
                                                  
                                                 <div class="model-heading">
                                                  <p class="about">Get paid in full once the project is completed, or break it into smaller
                                                      chunks, called milestones, to get paid as you go.</p>
                                                  <div class="d-flex option-btn">
                                                      <div class="d-flex radio-toolbar">
                                                            <div class="row">
                                                              <div class="col-md-6">
                                                                <input type="radio" id="paymentTypeSingle" name="payment_type" value="Single" checked>
                                                                <label for="paymentTypeSingle" data-bs-target="#sixModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                    <p class="label mb-0">Single Payment</p>
                                                                    <p class="name-label mb-0">Get full payment after completed each order at once.</p>

                                                                </label>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <input type="radio" id="paymentTypeMilestone" name="payment_type" value="Milestone">
                                                                  <label for="paymentTypeMilestone" data-bs-target="#fiveModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                      <p class="label mb-0">Milestones</p>
                                                                      <p class="name-label mb-0">Work in gradual steps and get each completed
                                                                          milestone.</p>

                                                                  </label>
                                                              </div>
                                                            </div>


                                                      </div>
                                                  </div>
                                                  <div class="model-footer">
                                                      <button class="back-btn" data-bs-target="#servicemode-modal" data-bs-toggle="modal"
                                                      data-bs-dismiss="modal">Back</button>
                                                      <button class="next-btn">Next</button>
                                                  </div>
                                                 </div>
                                              </div>
                                            </div>
                                          </div>
                                         
                                        </div>
                                        <div class="modal" id="fiveModal">
                                          <div class="modal-dialog">
                                            <div class="modal-content date-modal">
                                              <div class="modal-body p-0">
                                                <div class="modal-header custom-modal">
                                                  
                                                    <h5 class="modal-title">Create a milestone offer</h5>  
                                                </div>
                                                
                                                <div class="model-heading bg-white p-3 freelancing">

                                                 <p class="offer-title"><span class="selected-service-title">Loading...</span></p>
                                                 <textarea class="form-control offer-area" id="offer-description" name="offer" placeholder="Describe your offer...."></textarea>
                                                 <p class="offer-title mt-3">Set up your milestones or <a href="#" data-bs-target="#sixModal" data-bs-toggle="modal" data-bs-dismiss="modal">switch to single payment</a></p>
                                                 <p class="offer-title">Divide your work into pre-defined steps with goals (minimum $10 for each milestone).</p>

                                                  <!-- Milestones Container - will be populated by JavaScript -->
                                                  <div id="milestones-container">
                                                    <!-- Milestones will be rendered dynamically by custom-offers.js -->
                                                  </div>

                                                  <button type="button" id="add-milestone-btn" class="btn btn-primary mt-3">
                                                    <i class="fa-solid fa-plus"></i> Add Milestone
                                                  </button>

                                                  <!-- Total Amount Display -->
                                                  <div class="row mt-4">
                                                    <div class="col-md-12">
                                                      <h4>Total Amount: <span class="total-amount-display text-primary">$0.00</span></h4>
                                                    </div>
                                                  </div>

                                                  <div class="rado mt-3">
                                                    <div class="row">
                                                      <div class="col-md-9">
                                                        <div class="form-check form-1">
                                                          <input class="form-check-input" type="checkbox" id="offer-expire-checkbox">
                                                          <label class="form-check-label" for="offer-expire-checkbox">
                                                            Offer Expire
                                                          </label>
                                                        </div>
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="checkbox" id="request-requirements-checkbox">
                                                          <label class="form-check-label" for="request-requirements-checkbox">
                                                            Request for Requirements
                                                          </label>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                        <div class="rectangle-desc desc-1">
                                                          <select class="form-select" id="expire-days-select" disabled>
                                                            <option value="1">1 day</option>
                                                            <option value="2">2 days</option>
                                                            <option value="3">3 days</option>
                                                            <option value="5" selected>5 days</option>
                                                            <option value="7">7 days</option>
                                                            <option value="14">14 days</option>
                                                          </select>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <div class="model-footer mt-4">
                                                      <button class="bacck-btn" data-bs-target="#fourmodal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
                                                      <button class="neext-btn" id="submit-milestone-offer-btn">Send Offer</button>
                                                  </div>
                                                  
                                                  </div>
                                                
                                                 
                                                 
                                                 
                                                  <div class="model-footer">
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                          </div>
                                          
                                          <!-- six modal -->
                                          <div class="modal" id="sixModal">
                                            <div class="modal-dialog">
                                              <div class="modal-content date-modal">
                                                <div class="modal-body p-0">
                                                  <div class="modal-header custom-modal">
                                                    
                                                      <h5 class="modal-title">Create a single payment offer</h5>  
                                                  </div>
                                                  
                                                  <div class="model-heading bg-white p-3 freelancing">

                                                   <p class="offer-title"><span class="selected-service-title">Loading...</span></p>
                                                   <textarea class="form-control offer-area" id="offer-description" placeholder="Describe your offer...."></textarea>
                                                   <p class="offer-title mt-3">Single payment or <a href="#" data-bs-target="#fiveModal" data-bs-toggle="modal" data-bs-dismiss="modal">switch to milestones</a></p>
                                                   <p class="offer-title">Set your pricing and delivery terms (minimum $10).</p>


                                                      <div class="row mt-3">
                                                      <div class="col-md-4 rectangle-desc">
                                                        <div class="rectangle">
                                                          <h3>Revisions</h3>
                                                              <select class="form-select" id="single-payment-revisions">
                                                                <option value="0">No revisions</option>
                                                                <option value="1" selected>1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                              </select>
                                                            </div>

                                                      </div>
                                                      <div class="col-md-4 rectangle-desc">
                                                        <div class="rectangle">
                                                          <h3>Delivery</h3>
                                                          <select class="form-select" id="single-payment-delivery">
                                                            <option value="1">1 day</option>
                                                            <option value="2">2 days</option>
                                                            <option value="3">3 days</option>
                                                            <option value="5" selected>5 days</option>
                                                            <option value="7">1 week</option>
                                                            <option value="14">2 weeks</option>
                                                            <option value="30">1 month</option>
                                                          </select>

                                                      </div>

                                                      </div>
                                                      <div class="col-md-4 rectangle-desc">
                                                        <div class="rectangle">
                                                          <h3>Price</h3>
                                                         <input type="number" class="form-control" id="single-payment-price" placeholder="Enter price" min="10" step="0.01" required>
                                                      </div>

                                                      </div>
                                                    </div>

                                                    <!-- Total Amount Display -->
                                                    <div class="row mt-4">
                                                      <div class="col-md-12">
                                                        <h4>Total Amount: <span class="total-amount-display text-primary">$0.00</span></h4>
                                                      </div>
                                                    </div>

                                                    <div class="rado mt-3">
                                                      <div class="row">
                                                        <div class="col-md-9">
                                                          <div class="form-check form-1">
                                                            <input class="form-check-input" type="checkbox" id="offer-expire-checkbox">
                                                            <label class="form-check-label" for="offer-expire-checkbox">
                                                              Offer Expire
                                                            </label>
                                                          </div>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="request-requirements-checkbox">
                                                            <label class="form-check-label" for="request-requirements-checkbox">
                                                              Request for Requirements
                                                            </label>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                          <div class="rectangle-desc desc-1">

                                                                <select class="form-select" id="expire-days-select" disabled>
                                                                  <option value="1">1 day</option>
                                                                  <option value="2">2 days</option>
                                                                  <option value="3">3 days</option>
                                                                  <option value="5" selected>5 days</option>
                                                                  <option value="7">7 days</option>
                                                                  <option value="14">14 days</option>
                                                                </select>

                                                          </div>
                                                        </div>
                                                      </div>


                                                      </div>
                                                      <div class="model-footer mt-4">
                                                        <button class="bacck-btn" data-bs-target="#fourmodal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
                                                        <button class="neext-btn" id="submit-single-offer-btn">Send Offer</button>
                                                    </div>
                                                    
                                                    </div>
                                                  
                                                   
                                                   
                                                   
                                                    <div class="model-footer">
                                                      </div>
                                                   </div>
                                                </div>
                                              </div>
                                            </div>
                                    <button class="btn btn send-btn" id="sendMessageBtn">Send</button>
                                  <!-- <button class="btn send-btn" id="reactionBtn">😊</button> -->
                                </div>
                               </div>
                               @endif
                              </div>
                           </div>

                           @if ($chats->count() > 0)
                               
                         
                          <!-- PROFILE-BOX SEC -->
                          <div class="col-xl-3 col-lg-12 col-md-12" id="context">
                            <div class="content" id="profileId">
                              <div class="Profile d-flex" >
                                <div class="card profile-data">
                                  <a href="#">
                                    <div class="image d-flex flex-column justify-content-center align-items-center prof-jhon">
                                      <img src="assets/teacher/asset/img/admin.png" height="80" width="80" />
                                  </a>
                                  <span class="name">Bessie Cooper</span>
                                  <span class="text-muted">Active 2m ago</span>
                                </div>
                                <div class="icons gap-3 d-flex justify-content-center">
                                  <div class="link">
                                    <a href="#"><div class="profile-icon">
                                      <img src="assets/teacher/asset/img/profileicon (2).svg" alt="" /></a></div>
                                    <p>Profile</p>
                                  </div>
                                 
                                  <div class="link">
                                    <a href="#"><div class="profile-icon">
                                      <img src="assets/teacher/asset/img/Vector.svg" alt="" /></a></div>
                                    <p>Search</p>
                                  </div>
                                  <div class="link">
                                    <a href="#"><div class="profile-icon">
                                      <img src="assets/teacher/asset/img/profileicon (3).svg" alt="" /></a></div>
                                    <p>Block</p>
                                  </div>
                                </div>
                                <div class="prof-info">
                                 <div class="accordian-section">
                                  <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Media & Files
                                      </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                      data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <div class="media-section">
                                          <div class="d-grid gap-2">
                                            <a href="#">
                                            <button class="btn btn-primary active" type="button"  id="mediaFileBtn"><img src="assets/teacher/asset/img/carbon_media-library-filled.svg">Media</button>
                                            </a>
                                          </div>
                                          <div class="d-grid gap-2">
                                            <a href="#">
                                            <button class="btn btn-primary select"  type="button" id="FileMediaBtn" ><img src="assets/teacher/asset/img/ph_files-fill.svg">Files</button>
                                          </a></div>
                                          </div>
              
                                      </div>
                                    </div>
                                  </div>
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseThree">
                                            Privacy & Support
                                          </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                          data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                            <a href="#">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#report-sec" id="accordian-select"><img src="assets/teacher/asset/img/ic_round-report.svg">Report</button>
                                          </a></div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-3" >
                                          <button class="note-add"  data-bs-toggle="modal"
                                          data-bs-target="#exampleModal2">
                                            Notes</button>
                                        </div>
                                        <div class="col-md-6 col-sm-3 note-add-plus-button">
                                          <button class="note-adds"  data-bs-toggle="modal"
                                          data-bs-target="#exampleModal2"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                       </div>
                                   
                                      <div id="notes" class="row contaier-fluid">
                                        <!-- <div class="notecard my-2 mx-2" style="width: 18rem;">
                                             <div class="card-body">
                                                 <h5 class="card-title">Note</h5>
                                                 <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                                     card's content.</p>
                                                 <a href="#" class="btn btn-primary">Delete note</a>
                                             </div>
                                         </div>-->
                                     </div>
                                    
                                  
                                </div>
                              </div>

                              @endif
                              </div>
                            </div>
                          </div>
                       


                        <!-- tabs content start here -->
           
                <div class="content" id="tabsMainDiv">
                  <div class="media">
                     <div class="tabs" id="tabs">
                      <a href="#">
                        <div class="icon1">
                          <i class="fa-solid fa-arrow-left-long" id="backBtn"></i></a>
                        <h3>Media & Files</h3>
                        </div>
                        <div class="mainBtn">
                      <button class="tablink active" onclick="openTab('tab1')">Photos</button>
                      <button class="tablink" onclick="openTab('tab2')">Videos</button>
                      <button class="tablink" onclick="openTab('tab3')">Files</button>
                      </div>
                    </div>
                    </div>
                    </div>
  
                    <div id="tab1" class="tab-content" itemid="tab-content" style="margin-top: 20px;">
                      <div class="gallery">
                       <div class="container-fluid p-0">
                         <div class="grid">
                           <div class="grid-item">
                             <div class="grid-item-content card">
                               <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                   data-fancybox="gallery" class="fancybox">
                                   <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       class="card-img">
                                   <div class="overlay"></div>
                               </a>
                           </div>
                           </div>
                           <div class="grid-item">
                             <div class="grid-item-content card">
                                 <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                     data-fancybox="gallery" class="fancybox">
                                     <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                         class="card-img">
                                     <div class="overlay"></div>
                                 </a>
                             </div>
                         </div>
                         <div class="grid-item">
                           <div class="grid-item-content card">
                               <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                   data-fancybox="gallery" class="fancybox">
                                   <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       class="card-img">
                                   <div class="overlay"></div>
                               </a>
                           </div>
                       </div>
                       <div class="grid-item">
                         <div class="grid-item-content card">
                             <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                 data-fancybox="gallery" class="fancybox">
                                 <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                     class="card-img">
                                 <div class="overlay"></div>
                             </a>
                         </div>
                     </div>
                     <div class="grid-item">
                       <div class="grid-item-content card">
                           <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                               data-fancybox="gallery" class="fancybox">
                               <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                   class="card-img">
                               <div class="overlay"></div>
                           </a>
                       </div>
                   </div>
             
               
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
               
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
               
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
               
               
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1453473552141-5eb1510d09e2?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1453473552141-5eb1510d09e2?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
               
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
               
                          
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                               </div>
                           </div>
                           <div class="grid-item">
                               <div class="grid-item-content card">
                                   <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                       <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                           class="card-img">
                                       <div class="overlay"></div>
                                   </a>
                              </div>
                              </div>
                             </div>
                           </div>
                           </div>
                           </div>
                           <div id="tab2" class="tab-content" style="margin-top: 20px;">
                              
                           
                                         </div>
                                         <div id="tab3" class="tab-content" style="margin-top: 20px;">
                                
                                        
  </div>
  </div>
  </div>
   </div>
   </div>
                       <div class="user-footer text-center">
                        <p class="mb-0">Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                      </div>
                  </div>
                  </div>
                  </div>
              </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
  </section>
  
 <!-- =========== ADD NEW FAQ's MODAL START HERE =============== -->
    <!-- Modal -->
    <div
    class="modal fade"
    id="exampleModal2"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog verification-modal">
      <div class="modal-content content-modal">
        <div class="modal-header modal-heading">
          <h5 class="modal-title" id="exampleModalLabel">Add Notes</h5>
        </div>
        
      <div class="container my-3" >
        
          <div class="card">
              
              <div class="card-body" >
                  <div class="form-group">
                      <h5 class="card-titl">Add Title</h5>
                      <input style="resize: none;" type="text" class="form-control" id="addTitle" aria-describedby="title" placeholder="Enter Title">
                      <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                  <h5 class="card-titl">Add a Note</h5>
                  <div class="form-group">
  
                      <textarea style="resize: none;" class="form-control" id="addTxt" rows="3"></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="buttons-sec">
                        <button type="button" class="btn canceled-btn ">
                          Cancel
                        </button>
                        <button type="button" class="btn added-btn" class="btn btn-primary" id="addBtn">
                          Add Notes
                        </button>
                       
                      </div>
                    </div>
                  </div>
                </div>
          </div>
         
      
     <!-- ==================================================== -->
     
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"></script>    
      <!-- jQuery -->
    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"
  ></script>
            <div class="row">
              <div class="col-md-12">
                <div class="add-button">
                
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
 <!-- =========== ADD NEW CATEGORY MODAL START HERE =============== -->
 <!-- report modal here -->
 <div class="modal fade" id="report-sec" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Report</div>
      <div class="model_popup">
        <label for="car" class="form-label">Rating</label>
        <br>
        <svg xmlns="http://www.w3.org/2000/svg" width="88" height="16" viewBox="0 0 88 16" fill="none">
          <path d="M7.723 1.96796C7.82548 1.72157 8.17452 1.72157 8.277 1.96796L9.46671 4.82838C9.65392 5.27849 10.0772 5.58603 10.5631 5.62499L13.6512 5.87256C13.9172 5.89388 14.0251 6.22584 13.8224 6.39944L11.4696 8.41485C11.0994 8.73198 10.9377 9.22959 11.0508 9.70378L11.7696 12.7172C11.8316 12.9768 11.5492 13.1819 11.3215 13.0428L8.67763 11.428C8.26161 11.1739 7.73839 11.1739 7.32237 11.428L4.67855 13.0428C4.45082 13.1819 4.16844 12.9768 4.23036 12.7172L4.94917 9.70378C5.06228 9.2296 4.9006 8.73198 4.53038 8.41485L2.17759 6.39944C1.97493 6.22583 2.08279 5.89388 2.34878 5.87256L5.43685 5.62499C5.92278 5.58603 6.34608 5.27849 6.53329 4.82839L7.723 1.96796Z" fill="#FFAF06" stroke="#FFAF06"/>
          <path d="M25.723 1.96796C25.8255 1.72157 26.1745 1.72157 26.277 1.96796L27.4667 4.82838C27.6539 5.27849 28.0772 5.58603 28.5631 5.62499L31.6512 5.87256C31.9172 5.89388 32.0251 6.22584 31.8224 6.39944L29.4696 8.41485C29.0994 8.73198 28.9377 9.22959 29.0508 9.70378L29.7696 12.7172C29.8316 12.9768 29.5492 13.1819 29.3215 13.0428L26.6776 11.428C26.2616 11.1739 25.7384 11.1739 25.3224 11.428L22.6786 13.0428C22.4508 13.1819 22.1684 12.9768 22.2304 12.7172L22.9492 9.70378C23.0623 9.2296 22.9006 8.73198 22.5304 8.41485L20.1776 6.39944C19.9749 6.22583 20.0828 5.89388 20.3488 5.87256L23.4369 5.62499C23.9228 5.58603 24.3461 5.27849 24.5333 4.82839L25.723 1.96796Z" fill="#FFAF06" stroke="#FFAF06"/>
          <path d="M43.723 1.96796C43.8255 1.72157 44.1745 1.72157 44.277 1.96796L45.4667 4.82838C45.6539 5.27849 46.0772 5.58603 46.5631 5.62499L49.6512 5.87256C49.9172 5.89388 50.0251 6.22584 49.8224 6.39944L47.4696 8.41485C47.0994 8.73198 46.9377 9.22959 47.0508 9.70378L47.7696 12.7172C47.8316 12.9768 47.5492 13.1819 47.3215 13.0428L44.6776 11.428C44.2616 11.1739 43.7384 11.1739 43.3224 11.428L40.6786 13.0428C40.4508 13.1819 40.1684 12.9768 40.2304 12.7172L40.9492 9.70378C41.0623 9.2296 40.9006 8.73198 40.5304 8.41485L38.1776 6.39944C37.9749 6.22583 38.0828 5.89388 38.3488 5.87256L41.4369 5.62499C41.9228 5.58603 42.3461 5.27849 42.5333 4.82839L43.723 1.96796Z" fill="#FFAF06" stroke="#FFAF06"/>
          <path d="M61.723 1.96796C61.8255 1.72157 62.1745 1.72157 62.277 1.96796L63.4667 4.82838C63.6539 5.27849 64.0772 5.58603 64.5631 5.62499L67.6512 5.87256C67.9172 5.89388 68.0251 6.22584 67.8224 6.39944L65.4696 8.41485C65.0994 8.73198 64.9377 9.22959 65.0508 9.70378L65.7696 12.7172C65.8316 12.9768 65.5492 13.1819 65.3215 13.0428L62.6776 11.428C62.2616 11.1739 61.7384 11.1739 61.3224 11.428L58.6786 13.0428C58.4508 13.1819 58.1684 12.9768 58.2304 12.7172L58.9492 9.70378C59.0623 9.2296 58.9006 8.73198 58.5304 8.41485L56.1776 6.39944C55.9749 6.22583 56.0828 5.89388 56.3488 5.87256L59.4369 5.62499C59.9228 5.58603 60.3461 5.27849 60.5333 4.82839L61.723 1.96796Z" stroke="#FFAF06"/>
          <path d="M79.723 1.96796C79.8255 1.72157 80.1745 1.72157 80.277 1.96796L81.4667 4.82838C81.6539 5.27849 82.0772 5.58603 82.5631 5.62499L85.6512 5.87256C85.9172 5.89388 86.0251 6.22584 85.8224 6.39944L83.4696 8.41485C83.0994 8.73198 82.9377 9.22959 83.0508 9.70378L83.7696 12.7172C83.8316 12.9768 83.5492 13.1819 83.3215 13.0428L80.6776 11.428C80.2616 11.1739 79.7384 11.1739 79.3224 11.428L76.6786 13.0428C76.4508 13.1819 76.1684 12.9768 76.2304 12.7172L76.9492 9.70378C77.0623 9.2296 76.9006 8.73198 76.5304 8.41485L74.1776 6.39944C73.9749 6.22583 74.0828 5.89388 74.3488 5.87256L77.4369 5.62499C77.9228 5.58603 78.3461 5.27849 78.5333 4.82839L79.723 1.96796Z" stroke="#FFAF06"/>
        </svg></br>
    <label for="car" class="form-label">Review</label>
    <textarea class="form-control" list="datalistOptions" id="car" 
    placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit.Vitae ut tellus quis a euismod ut nisl, quis.Tristiquebibendum morbi vel vitae ultrices donec accumsan" readonly></textarea>
    <label for="car" class="form-label">Report</label>
    <textarea class="form-control" list="datalistOptions" id="car" 
    placeholder="write something here....."></textarea>
     <button type="button" class="btn1">Cancel</button>
     <button type="button" class="btn2">submit</button>

      </div>
    </div>
  </div>
</div>
    <!-- Modal -->
    <div
    class="modal fade"
    id="exampleModal3"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog verification-modal">
      <div class="modal-content content-modal">
        <div class="modal-header modal-heading">
          <h5 class="modal-title" id="exampleModalLabel">Edit Notes</h5>
        </div>
        
      <div class="container my-3" >
        
          <div class="card">
              
              <div class="card-body" >
                  <div class="form-group">
                      <h5 class="card-titl">Title</h5>
                      <input style="resize: none;" type="text" class="form-control" id="addTitle" aria-describedby="title" placeholder="Enter Title">
                      <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                  <h5 class="card-titl">Note</h5>
                  <div class="form-group">
  
                      <textarea style="resize: none;" class="form-control" id="addTxt" rows="3"></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="buttons-sec">
                        <button type="button" class="btn canceled-btn ">
                          Cancel
                        </button>
                        <button type="button" class="btn added-btn" class="btn btn-primary" id="">
                          Add Notes
                        </button>
                       
                      </div>
                    </div>
                  </div>
               
                </div>
          </div>
         
      
     <!-- ==================================================== -->
     
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"></script>    
            <div class="row">
              <div class="col-md-12">
                <div class="add-button">
                
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!--  =============== safty  Modal start here ================= -->
<div class="modal fade" id="safety-rules" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <!-- modal content -->
<!-- </div> -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
  <div class="modal-dialog">
    <div class="modal-content rules-content">
      <div class="modal-header border-0">
        <h5 class="modal-title rules-title" id="exampleModalLabel">Safety Rules for Message</h5>
      </div>
      <div class="modal-body rules-body">
        <ul class="modal-text">
          <li>Do not ask a buyer to transfer money or communicate with you outside of the Dreamcrowd platform.</li>
          <li>Do not share your email address, telephone number or physical address with any buyer. Do not ask them to share theirs with you too.</li>
          <li> Do not promote any website or social media handles to buyers.</li>
       <li> For in-person services, you can ask a buyer to provide nearby areas or landmarks nearby to give you an idea of how far you need to travel to meet them.</li>
       <li>Only ask a buyer for their physical address or email (if absolutely necessary) after
        they have made a payment to you on Dreamcrowd. See more details <a href="#">here</a></li>
       <li> Violation of any of the terms above may lead to a temporary or permanent
        suspension of your account.</li>
       <li>A Zoom video chat should always be carried out to verify a buyer before meeting
        them in person. This is for your safety.</li>
        <li>Please send us a report if a buyer has broken these rules or tried to get you to
          break these safety rules.</li>
          <li class="pb-3">The email address to report your concern is <a href="#">complaints@dreamcrowd.com</a>. Our
            full terms of service can be found <a href="#">here</a>.</li>
      </ul>
      </div>
      
    </div>
  </div>
</div>
    <!-- ============== safty model end here ================= -->
   
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal7").modal("show");
      $("#delete-teacher-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-teacher-account").modal("show");
      $("#exampleModal7").modal("hide");
    });
  });
</script>
 <!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
  // Wait for the document to load
  document.addEventListener('DOMContentLoaded', function() {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener('click', function() {
      // Find the modal by its ID
      var modal = document.getElementById('exampleModal6');
      
      // Use Bootstrap's modal method to hide the modal
      $(modal).modal('hide');
    });
  });
</script>
    <!-- =========== ADD NEW CATEGORY MODAL ENDED HERE =============== -->
 

  <script src="assets/teacher/libs/jquery/jquery.js"></script>
  <script src="assets/teacher/libs/datatable/js/datatable.js"></script>
  <script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
  <script src="assets/teacher/libs/select2/js/select2.min.js"></script>
  <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>  
  <script src="assets/teacher/libs/aos/js/aos.js"></script>
  <script src="assets/teacher/asset/js/bootstrap.min.js"></script>
  <script src="assets/teacher/asset/js/script.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script src="assets/teacher/js/gallery.js"></script>
  <script src="assets/teacher/js/custom-offers.js"></script>
  <script src="https://cdn.rawgit.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css"></script>
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
<!-- js for tabs  -->
<script>
  function toggleTabs() {
    var content = document.querySelector('.content');
    var tabs = document.querySelector('.tabs');
    var tabContents = document.querySelectorAll('.tab-content');

    if (tabs.style.display === 'none') {
      tabs.style.display = 'block';
      content.style.display = 'none';
      for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = 'none';
      }
    } else {
      tabs.style.display = 'none';
      content.style.display = 'block';
      for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = 'none';
      }
    }
  }

  function openTab(tabName) {
    var i, tabContent, tablinks;
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
      tabContent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.classList.add("active");
  }
</script>


<!-- /////////////////////////2nd js ///////////////////// -->
<script>
  var div = document.getElementById('main');
  var display = 0;
  function hideShow() {
    if (display == 1) {
      div.style.display = 'block';
      display = 0;

    }
    else {
      div.style.display = 'none';
      display = 1;

    }

  }



  document.addEventListener('DOMContentLoaded', function () {
const button = document.getElementById('mediaFileBtn');



// Add a click event listener to the button
button.addEventListener('click', function () {
  // Get the divs by their IDs
  const tabsDiv = document.getElementById('tabs');
  const tabContentDiv = document.getElementById('tab1');
  const profilDiv = document.getElementById('profileId');
  const tabsMainDiv = document.getElementById('tabsMainDiv');


  // Hide the profileId div
  profilDiv.style.display = 'none';
  // Show the tabs and tabContent divs
  tabsMainDiv.style.display = 'block';
  tabsDiv.style.display = 'block';
  tabContentDiv.style.display = 'block';
});
});

///////// FUNCTION FOR FILE BUTTON //////

document.addEventListener('DOMContentLoaded', function () {
const button = document.getElementById('FileMediaBtn');



// Add a click event listener to the button
button.addEventListener('click', function () {
  // Get the divs by their IDs
  const tabsDiv = document.getElementById('tabs');
  const tabContentDiv = document.getElementById('tab3');
  const profilDiv = document.getElementById('profileId');
  const tabsMainDiv = document.getElementById('tabsMainDiv');


  // Hide the profileId div
  profilDiv.style.display = 'none';
  // Show the tabs and tabContent divs
  tabsMainDiv.style.display = 'block';
  tabsDiv.style.display = 'block';
  tabContentDiv.style.display = 'block';
});
});

            ////// BACK BUTTON FUNCTION ///////

document.addEventListener('DOMContentLoaded', function () {
const button = document.getElementById('backBtn');

// Add a click event listener to the button
button.addEventListener('click', function () {
  // Get the divs by their IDs
  const tabsDiv = document.getElementById('tabs');
  const tabContentDiv = document.getElementById('tab1');
  const profilDiv = document.getElementById('profileId');
  const tabsMainDiv = document.getElementById('tabsMainDiv');


  // Hide the profileId div
  profilDiv.style.display = 'block';
  // Show the tabs and tabContent divs
  tabsMainDiv.style.display = 'none';
  tabsDiv.style.display = 'none';
  tabContentDiv.style.display = 'none';
});
});

</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const offerArea = document.querySelector('.offer-area');
    const typedContentDisplay = document.querySelector('.typed-content-display');

    offerArea.addEventListener('input', function () {
      typedContentDisplay.textContent = offerArea.value;
    });
  });
</script>

<!-- close js for tabs -->
<script>
  function uploadImage() {
document.getElementById('imgInput').click();
}
document.getElementById('imgInput').addEventListener('change', function() {
var file = this.files[0];
if (file) {
  console.log('Selected image:', file);
  // Yahan par image upload ka logic implement karein
} else {
  console.log('No image selected.');
}
});
</script>
<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
      hideAllAdditionalOptions();
  }

  function showAdditionalOptions2() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions2').style.display = 'block';
  }

  function showAdditionalOptions3() {
      hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions4').style.display = 'block';
  }

  function hideAllAdditionalOptions() {
      var elements = document.getElementsByClassName('additional-options');
      for (var i = 0; i < elements.length; i++) {
          elements[i].style.display = 'none';
      }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function() {
      showAdditionalOptions1();
  };
</script>
</body>
</html>
