<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <!-- View Point scale to 1.0 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Animate css -->
  <link rel="stylesheet" href="assets/admin/libs/animate/css/animate.css" />
  <!-- AOS Animation css-->
  <link rel="stylesheet" href="assets/admin/libs/aos/css/aos.css" />
  <!-- Datatable css  -->
  <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css" />
   {{-- Fav Icon --}}
   @php  $home = \App\Models\HomeDynamic::first(); @endphp
   @if ($home)
       <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
   @endif
   <!-- Select2 css -->
  <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
  <!-- Owl carousel css -->
  <link href="assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
  <link href="assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/admin/asset/css/msg.css">
 
  <!-- tabs css link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
  <link rel="stylesheet" href="https://cdn.rawgit.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
  <!-- tabs css link --> 

  <!-- Bootstrap css -->

  <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css"
    integrity="sha512-d0olNN35C6VLiulAobxYHZiXJmq+vl+BGIgAxQtD5+kqudro/xNMvv2yIHAciGHpExsIbKX3iLg+0B6d0k4+ZA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
  <!-- Fontawesome CDN -->
  <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css" 
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
  <!-- Defualt css -->
  <link rel="stylesheet" href="assets/admin/asset/css/new.css">
  <link rel="stylesheet" href="assets/admin/asset/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
  <link rel="stylesheet" href="assets/user/asset/css/style.css" />
  <link rel="stylesheet" href="assets/emoji/css/emoji.css" />
  <title>User Dashboard | Messages</title>
</head>
<style>
  button#send_sms_button {
  color: #fff;
  font-family: Roboto;
  font-size: 12px;
  margin-left: auto;
  float: right;
  font-weight: 500;
  border-radius: 4px;
  background: #0072b1;
  position: relative;
  bottom: 2px;
}

.box-input-filter .filter-btns.active{
  background: #0072b1;
    color: white;
}
</style>
<body>
    {{-- ===========Admin Sidebar Start==================== --}}
    <x-admin-sidebar/>
    {{-- ===========Admin Sidebar End==================== --}}
    <section class="home-section">
       {{-- ===========Admin NavBar Start==================== --}}
       <x-admin-nav/>
       {{-- ===========Admin NavBar End==================== --}}
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
                    <i class="bx bx-chat icon" title="Messages"></i>

                    <!-- <i class="bx bx-message-square-dots icon" title="Messages"></i> -->
                    <h2>Messages</h2>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3 col-lg-5 col-md-12 mb-2">
                <!-- Sidebar -->
                <div class="card chat-side-bar">
                  <div class="card-body">
                    <div class="box-notif" style="align-items: center;">
                      <input type="text" id="search_name_input" placeholder="Search" class="form-control" />
                      <i class="fa-solid fa-magnifying-glass icon" onclick="SearchName();" ></i>
                    </div>
                    <div class="box-input">
                      {{-- <input type="text" class="form-control border-0" placeholder="Search" />                     --}}
                    </div>
                    <div class="box-input-filter">
                      <button onclick="ChangeUsers(this.id);" id="all" data-users="[0, 1]" class="filter-btns active"> All Users</button>
                      <button onclick="ChangeUsers(this.id);" id="all_users"  data-users="1" class="filter-btns">Sellers</button>
                      <button onclick="ChangeUsers(this.id);"  id="all_teachers"  data-users="0" class="filter-btns">Buyers</button> 
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
                  </div>
                </div>
              </div>
              <!-- CHAT-BOX-SEC -->
              <div class="col-xl-6 col-lg-7 col-md-12 mb-2">
                <!-- Chat Box -->
                <div class="card chat-box-right">
                   
                  <div style="justify-content: left;padding-right: 10px;" class="card-header" id="chat-header">
                    <img id="main_profile" src="{{$profileImageMain}}" alt="" width="50" height="50" style="border-radius: 100%;"/>
                    <!-- <img src="" alt="User Avatar" id="user-avatar"> -->
                    <div class="name">
                      <p id="main_name">{{$fullName}} </p>
                      <p>Active Now</p>
                    </div>
                    <span id="selectedUserName"></span>
                    <div id="search_div" style="margin-left: auto; display: none;">
                      <div class="input-group ">
                        <input type="text" id="search_input" class="form-control" placeholder="Search Message" aria-label="Recipient's username" aria-describedby="search_btn">
                        <span class="input-group-text" onclick="SearchMessage()" id="search_btn" style="background: #0072b1; color: white; cursor: pointer;">search</span>
                      </div>
                    </div>
                  </div>

                  <div id="chat-container" class="modal-body flex-shrink-1 rounded py-2 px-3 mr-3  " style="height: 460px;overflow-y: auto; display: flex; flex-direction: column-reverse;">
                    <div class="msg-body">
                      <ul id="full_chat">
          
                        @if ($completeChat)

                        @if ($hasMore)
                        <button class="btn btn-primary" style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;" type="button" onclick="ReadMore();" id="ReadMore">Read More</button>
                        @endif
                        
                        @foreach($completeChat as $message)
                            <li class="{{ $message['sender_id'] == Auth::user()->id ? 'repaly' : 'sender' }}">
                                <p>{{$message['sms']}}</p>
                                
                                @if(!empty($message['files'])) 
                                @php $files = explode(',',$message['files']);   @endphp
                                    <!-- Loop through and display files if there are any -->
                                    <div class="files">
                                        @foreach($files as $file)
                                        @if ($otheruserRole == 0)
                                        <a href="{{ asset('chat_media/' . $otheruserId . '_chat_files_A/' . $file) }}" class="file-link" download download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px;font-size:13px; ">
                                          <span>{{ pathinfo($file, PATHINFO_BASENAME) }}</span>
                                      </a>
                                        @else
                                        <a href="{{ asset('chat_media/A_chat_files_' . $otheruserId . '/' . $file) }}" class="file-link" download download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px;font-size:13px; ">
                                          <span>{{ pathinfo($file, PATHINFO_BASENAME) }}</span>
                                      </a>
                                        @endif
                                       
                                        @endforeach
                                    </div>
                                @endif
                                
                                <span class="time">{{$message['time_ago']}}</span>
                            </li>
                        @endforeach

                        @else
                        <li style="text-align: center;"><small>Start Chat With User</small> </li>
                            
                        @endif
                    
                        {{-- <li class="repaly">
                          <p> posuere eget augue sodales, aliquet posuere eros.</p>
                          <span class="time">5 minutes ago</span>
                        </li>
                        <li class="sender"> 
                          <p> Sit amet risus nullam eget felis eget. Dolor sed viverra ipsum </p>
                          <span class="time">2 minutes ago</span>
                        </li> --}}
                        


                      </ul>

                    </div>
                  </div>



                 
                       
                  <div class="card-footer">
                    <div class="input-group emoji-picker-container">
                      <input type="hidden" id="teacher_reciver_id" value="{{$otheruserId}}">
                      <input type="hidden" id="teacher_reciver_role" value="{{$otheruserRole}}"> 
                      <input type="hidden" id="user_types" value="[0, 1]"> 
                      <input type="hidden" id="search_name" value=""> 
                      <input type="hidden" id="sms_limit" value="50"> 
                     
                    
                      <textarea type="text" class="form-control" id="message-textarea" data-emojiable="true" placeholder="Type your message..." ></textarea>
                   
                    </div>
                    <div id="preview-area" class="mt-1 mb-1 row" 
                    style="border: 1px solid #ccc; position: relative; bottom: 10px;  padding: 10px; height: 80px; overflow-y: scroll; display: none;">
               </div>
                    <div class="send-btns">
                      <div class="attach">
                        <div class="button-wrapper">
                          <span class="label">


                            <div class="input-group-append icon2">
                              <a  id="emoji-button">
                                <i class="fa-regular fa-face-smile"></i>
                              </a>
                              <a  >
                                <input type="file" id="fileInputAll" accept="*/*" style="display: none;">
                                <i class="fa-solid fa-paperclip" onclick="document.getElementById('fileInputAll').click();"></i>

                              </a>

                           <a  ><input type="file" id="fileInputImages" accept="image/*" style="display: none;"><i class="fa-regular fa-images" onclick="document.getElementById('fileInputImages').click();"></i></a>
                              <a  ><input type="file" id="fileInputVideos" accept="video/*" style="display: none;"><i class="fa-solid fa-video" onclick="document.getElementById('fileInputVideos').click();"></i></a>

                              <!-- <button class="btn send-btn" id="reactionBtn">😊</button> -->
                            </div>
                          </span>
                          <button class="btn btn send-btn float-end" id="send_sms_button" onclick="SendSMS();">
                            Send
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- PROFILE-BOX SEC -->
              <div class="col-xl-3 col-lg-12 col-md-12" id="context">
                <div class="content" id="profileId">
                  <div class="Profile d-flex" >
                    <div class="card profile-data">
                      <a href="#">
                        <div class="image d-flex flex-column justify-content-center align-items-center prof-jhon">
                          <img id="main_profile_2" src="{{$profileImageMain}}" height="80" width="80" />
                      </a>
                      <span id="main_name_2" class="name">{{$fullName}}</span>
                      <span class="text-muted">Active 2m ago</span>
                    </div>
                    <div class="icons gap-3 d-flex justify-content-center">
                      <div class="link">
                        <a id="profile_url" target="__"  >
                          <img src="assets/admin/asset/img/profileicon (2).svg" alt="" /></a>
                        <p>Profile</p>
                      </div>
                    
                      <div class="link">
                        <a  onclick="ShowSearchBar();" style="text-decoration: none; cursor: pointer;">
                          <div class="profile-icon">
                          <img src="assets/user/asset/img/Vector.svg" alt="" />
                        </div>
                        <p>Search</p>
                        </a>
                      </div>
                      <div class="link">
                        <a onclick="BlockUser();"  style="text-decoration: none; cursor: pointer;">
                          <div class="profile-icon">
                          <img src="assets/user/asset/img/profileicon (3).svg" alt="" />
                        </div>
                          <p id="block_user" >@if ($block != 0 && 'A' == $block_by)     Unblock @else Block @endif</p>
                        </a>
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
                                <button class="btn btn-primary active" type="button"  id="mediaFileBtn"><img src="assets/admin/asset/img/carbon_media-library-filled.svg">Media</button>
                                </a>
                              </div>
                              <div class="d-grid gap-2">
                                <a href="#">
                                <button class="btn btn-primary select1"  type="button" id="FileMediaBtn" ><img src="assets/admin/asset/img/ph_files-fill.svg">Files</button>
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
                                <a href="homepage.html">
                                <button type="button" class="btn btn-primary" id="accordian-select"><img src="assets/admin/asset/img/ic_round-report.svg">Report</button>
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
                           
                         </div>
                        
                      
                    </div>
                  </div>
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
                        <button class="tablink active" id="htab1" onclick="openTab(this.id)" data-tab="tab1">Photos</button>
                        <button class="tablink" id="htab2" onclick="openTab(this.id)" data-tab="tab2">Videos</button>
                        <button class="tablink" id="htab3" onclick="openTab(this.id)" data-tab="tab3">Files</button>
                      </div>
                    </div>
                    </div>
                  </div>

                  
                  <div id="tab1" class="tab-content" itemid="tab-content" style="margin-top: 20px;display:none;">
                    <div class="gallery">
                     <div class="container-fluid p-0">
                       <div class="grid">
                         
               
                         {{-- <div class="grid-item">
                             <div class="grid-item-content card">
                                 <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                     data-fancybox="gallery" class="fancybox">
                                     <img src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                         class="card-img">
                                     <div class="overlay"></div>
                                 </a>
                            </div>
                            </div> --}}

                           </div>
                         </div>
                         </div>
                         </div>
                         <div id="tab2" class="tab-content" style="margin-top: 20px;display:none;">
                            </div>
                           <div id="tab3" class="tab-content" style="margin-top: 20px; display:none;">
                            </div>
                  </div>
                </div>
 </div>
 </div>

      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
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
                    <input type="text" class="form-control" id="addTitle" aria-describedby="title" placeholder="Enter Title">
                    <small id="emailHelp" class="form-text text-muted"></small>
                  </div>
                <h5 class="card-titl">Add a Note</h5>
                <div class="form-group">

                    <textarea class="form-control" id="addTxt" rows="3"></textarea>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="buttons-sec">
                      <button type="button" class="btn canceled-btn" data-bs-dismiss="modal" aria-label="Close">
                        Cancel
                      </button>
                      <button type="button" class="btn added-btn "  class="btn btn-primary" id="addBtn" onclick="AddNotes();">
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
    <!-- =========== ADD NEW FAQ's MODAL ENDED HERE =============== -->
     <!-- =========== ADD NEW CATEGORY MODAL START HERE =============== -->
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
                    <h5 class="card-titl"> Title</h5>
                    <input type="hidden" id="note_id" >
                    <input type="text" class="form-control" id="showtitle" aria-describedby="title" placeholder="Enter Title">
                    <small id="emailHelp" class="form-text text-muted"></small>
                  </div>
                <h5 class="card-titl"> Note</h5>
                <div class="form-group">

                    <textarea class="form-control" id="showtext" rows="3"></textarea>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="buttons-sec">
                      <button type="button" class="btn canceled-btn " data-bs-dismiss="modal" aria-label="Close">
                        Cancel
                      </button>
                      <button type="button" class="btn added-btn" id="addBtnedit">
                        Update Note
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
    <!-- =========== ADD NEW CATEGORY MODAL ENDED  HERE =============== -->
  <script src="assets/admin/libs/jquery/jquery.js"></script>
  <script src="assets/admin/libs/datatable/js/datatable.js"></script>
  <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
  <script src="assets/admin/libs/select2/js/select2.min.js"></script>
  <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
  <script src="assets/admin/libs/aos/js/aos.js"></script>
  <script src="assets/admin/asset/js/bootstrap.min.js"></script>
  <script src="assets/admin/asset/js/script.js"></script>
 <!-- jQuery -->
 <script
 src="https://code.jquery.com/jquery-3.7.1.min.js"
 integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
 crossorigin="anonymous"
></script>





<script>
 
// CHange Fetch User Types Script Start ========
$(document).ready(function() {
    GetMessages(); // Run GetMessages when the page loads
  });

  function ChangeUsers(Clicked) {
    var users = $('#' + Clicked).data("users"); // Get data-users attribute value
    $('#user_types').val(users); // Set value in input field
    $('.filter-btns').removeClass('active');
    $('#'+Clicked).addClass('active');
    GetMessages(); // Call GetMessages after changing user_types
  }

  function SearchName() { 
   var search_name =  $('#search_name_input').val();
   $('#search_name').val(search_name);  
   GetMessages(); // Call GetMessages after changing user_types
   }
   
   function ReadMore() { 
    var sms_limit = parseInt($('#sms_limit').val()) || 0; // Get current value, default to 0 if empty
    sms_limit += 50 ; // Increase by 50
    $('#sms_limit').val(sms_limit); // Set updated value back to input
    GetMessages(); // Call GetMessages after changing user_types
    }
// CHange Fetch User Types Script END ========


  var searchCheck = false ;
  // Fetch Records ======= Script Start ====
 
    function GetMessages(){

      
      var sender_id = 'A' ;
    var reciver_id = $('#teacher_reciver_id').val();  
    var sender_role = 2 ;
    var reciver_role = $('#teacher_reciver_role').val(); 
    var type = 2 ;
    var user_types = $('#user_types').val(); 
    var search_name = $('#search_name').val(); 
    var sms_limit = $('#sms_limit').val(); 
    var active_list = $('.list-group-item.active').attr('id');
      
      
 
   
      
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          });

          $.ajax({
              type: "POST",
              url: '/admin-fetch-message',
              data:{ sender_id:sender_id,reciver_id:reciver_id,sender_role:sender_role,reciver_role:reciver_role,type:type, user_types:user_types, search_name:search_name, sms_limit:sms_limit, _token: '{{csrf_token()}}'},
              dataType: 'json',
              success: function (response) { 
                
               ShowDataFetched(response,active_list);


              },
            
          });


    }


    // OnPage Load Show Data Script Start =====
    function ShowDataFetched(response,active_list) { 
       
       
      var authUserId = 'A'; // Get authenticated user ID
        if (response.block == 0 || response.block_by != authUserId) {
          
            
          $('#block_user').html('Block');
        } else {
             $('#block_user').html('Unblock');
        }
      
        if (response['otheruserRole'] == 1) {
            var profile_url  = `/professional-profile/${response.otheruserId}/${response.profileName}`;
        } else{
          var profile_url  = '#' ; 
        } 
        $('#profile_url').attr('href', profile_url);
      
      var img = response.profileImageMain;
        

        $('#main_profile').attr('src', img);
        $('#main_name').html(response.fullName);

        $('#main_profile_2').attr('src', img);
        $('#main_name_2').html(response.fullName);



        
         

          var len = 0 ;
          $('#userList').empty();
         
           len = response['chatList'].length;
           var html_div = '';

          //  Chat List Show ------ Start
           if (len > 0) {
            
            for (let i = 0; i < len; i++) {
               
              
              
              const teacher_id = response['chatList'][i].teacher_id;
              const teacher_name = response['chatList'][i].teacher_name ;
              const profile_image = response['chatList'][i].profile_image ;
              const latest_sms = response['chatList'][i].latest_sms ;
              const time = response['chatList'][i].time ;
              const unseen_count = response['chatList'][i].unseen_count ;
              const active = 'teacher_list_'+teacher_id ;

              if (active == active_list ) {
               var unread = 'active' ;
                 } else {
                  var unread = '' ;
                 }
                  
                 
                 html_div += ' <li class="list-group-item '+unread+'" data-teacher-id="'+teacher_id+'" onclick="OpenChat(this.id)" id="teacher_list_'+teacher_id+'" style="cursor: pointer;"> '+
                              '<a  class="box-notif"> '+
                             ' <img src="'+profile_image+'" alt="Avatar" /> ' ;
                             if (unseen_count != 0 ) {
                   html_div += ' <span class="blue-rate" id="teacher_list_'+teacher_id+'_unseen">'+unseen_count+'</span>';
                                
                             }
                          
                             html_div += '  <span class="onlion-icon"></span>  <div> '+
                                  '<p class="name">'+teacher_name+'</p> '+
                                  '<p>'+latest_sms+'</p> '+
                              '</div> '+
                             ' <div class="time"> '+
                                  '<span>'+time+'</span> '+
                              '</div> '+
                          '</a>  </li>'; 

                              
                              
                          
                          
                        }
                        $("#userList").append(html_div);


           } else{
            $("#userList").html(`<li class="list-group-item text-center mt-2  "    style="cursor: pointer;"> <p class="name"> User's Not Found</p> </li>`);
           }


          //  Chat list Show ----------- END




          if (searchCheck == false) {
            
          // Full Chat Show -------- Start

           
          
          $('#full_chat').empty();
          $('#tab1').empty(); // Images
          $('#tab2').empty(); // Videos
          $('#tab3').empty(); // Other Files
          len_chat = response['completeChat'].length;
          var chat_div = '';


           if (len_chat > 0 ) {

            if (response.hasMore) {
              $("#full_chat").append(`<button class="btn btn-primary" style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;" type="button" onclick="ReadMore();" id="ReadMore">Read More</button>`);
              }
 
            for (let i = 0; i < len_chat; i++) {
             
              
              const user_id = 'A';
              const sender_id = response['completeChat'][i].sender_id;
              const sms = response['completeChat'][i].sms;
              const files = response['completeChat'][i].files;
              const time_ago = response['completeChat'][i].time_ago;

              
              if (sender_id == user_id) {
                chat_type = 'repaly' ;
                justify_content = 'end';
              } else {
                chat_type = 'sender' ;
                justify_content = 'start';
              }

              chat_div += ' <li class="'+chat_type+'">'+
                          '<p>'+sms+'</p>';
        if (files != null) {
        // Split the comma-separated files into an array
        const fileArray = files.split(',');
        chat_div += `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;
        
        // Loop through each file and generate the appropriate anchor tag
        fileArray.forEach(file => {

 

          let filePath; // Declare filePath outside the if-else block

        if (response['otheruserRole'] == 0) {
            filePath = `/assets/chat_media/A_chat_files_${response['otheruserId']}/${file}`;
        } else {
            filePath = `/assets/chat_media/${response['otheruserId']}_chat_files_A/${file}`;
        }
        
          
           
            const fileName = file.split('/').pop(); // Extract the base name of the file
            const fileExtension = file.split('.').pop().toLowerCase(); 

             // Define file types for different categories
    const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const videoTypes = ['mp4', 'webm', 'ogg'];
    const zipTypes = ['zip', 'rar'];

            

            if (imageTypes.includes(fileExtension)) {
        // Display image
        chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
    }else if (videoTypes.includes(fileExtension)) {
    // Display video with a clickable link to open in a new tab
    chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4"> 
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
} else if (zipTypes.includes(fileExtension)) {
        // Display ZIP file link
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>
              
                <span>${fileName}</span>
            </a>
        `;
    } else {
        // Default case for other files (PDF, DOCX, etc.)
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
    }


            

        // Categorize and append file type
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
            // Image files
            $('#tab1').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}">
                        <img src="${filePath}" alt="Image" style="width:100%; height:auto; margin-bottom:10px;">
                    </a>
                </div>
            `);
        } else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'].includes(fileExtension)) {
            // Video files
            $('#tab2').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}">
                        <video style="width:100%; height:auto; margin-bottom:10px;">
                            <source src="${filePath}" type="video/${fileExtension}">
                            Your browser does not support the video tag.
                        </video>
                        
                    </a>
                </div>
            `);
        } else {
          if (fileName != "") {
                // Other file types
                $('#tab3').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}" style="text-decoration:none; color:black; font-weight:500;">
                        <i class="fa fa-file" style="margin-right:5px;"></i> ${fileName}
                    </a>
                </div>
            `);
          }
        
        }
        });
        
        chat_div += '</div>';
        }
               
                   chat_div +=  '<span class="time">'+time_ago+'</span>'+
                        '</li>' ;

                        
                      } 
                      $("#full_chat").append(chat_div);
            
           }  




          //  Full Chat Show  ------- END
        }
      



          //  Show All Notes ------- Start
       
       
           var lennotes = 0;
            $("#notes").empty();
          if(response['notes'] != null){
             lennotes = response['notes'].length;
          }

          var notes = response['notes']; 
          
  if (lennotes > 0 ) {
    
    for (let i = 0; i < lennotes; i++) {
      var id = notes[i].id;
      var title = notes[i].title;
      var text = notes[i].text;
       
      
     var content_div = '<div id="main_div_'+id+'" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> '+
                   ' <div class="card-body" style="background-color:#ffff"> '+
                     ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_'+id+'" data-id="'+id+'" data-title="'+title+'" data-text="'+text+'"   on>'+title+'</h5> '+
                     ' <button id="delete_note_'+id+'" onclick="DeleteNote(this.id)" data-id="'+id+'" data-main_div="main_div_'+id+'" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> '+
                    '</div> '+
        ' </div>';




        $("#notes").append(content_div);
    }

  }

  // Show All Notes ------- END
        
 
      
      


     }
    // OnPage Load Show Data Script end =====


            GetMessages();
              setInterval(() => {
                GetMessages();
              }, 10000);
 
  // Fetch Records ======= Script END ====




  

 </script>
<!-- ======= Script for Send Sms by Ajax END ====== -->







  {{-- Open Chat Script by Ajax Start ============ --}}
  <script>


    // Upload Files ======================

    let uploadedFiles = []; // Store uploaded files

function handleFileUpload(input) {
    const files = input.files;
    const previewArea = document.getElementById("preview-area");

    Array.from(files).forEach((file, index) => {
        uploadedFiles.push(file);

        const fileId = `file-${uploadedFiles.length - 1}`;

        // Create a file preview element
        const filePreview = document.createElement("div");
        filePreview.classList.add("col-6", "file-preview", "position-relative", "p-1");
        filePreview.id = fileId;

        if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.style.width = "100%";
            img.style.borderRadius = "5px";
            img.alt = file.name;
            filePreview.appendChild(img);
        } else if (file.type.startsWith("video/")) {
            const video = document.createElement("video");
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.style.width = "100%";
            video.style.borderRadius = "5px";
            filePreview.appendChild(video);
        } else {
            const fileIcon = document.createElement("div");
            fileIcon.textContent = file.name;
            fileIcon.style.fontSize = "14px";
            fileIcon.style.padding = "5px";
            fileIcon.style.background = "#f5f5f5";
            fileIcon.style.borderRadius = "5px";
            fileIcon.style.textAlign = "center";
            filePreview.appendChild(fileIcon);
        }

        // Add a remove button
        const removeButton = document.createElement("button");
        removeButton.textContent = "×";
        removeButton.classList.add("btn", "btn-danger", "btn-sm", "position-absolute");
        removeButton.style.top = "5px";
        removeButton.style.right = "5px";
        removeButton.style.padding = "2px 6px";
        removeButton.style.borderRadius = "50%";
        removeButton.onclick = () => removeFile(fileId, index);

        filePreview.appendChild(removeButton);
        previewArea.appendChild(filePreview);
    });

    previewArea.style.display = "flex"; // Show preview area if hidden
}

function removeFile(fileId, index) {
    const previewArea = document.getElementById("preview-area");
    const fileElement = document.getElementById(fileId);

    // Remove the file from uploadedFiles array
    uploadedFiles.splice(index, 1);

    // Remove the file preview element
    fileElement.remove();

    // Hide the preview area if no files remain
    if (uploadedFiles.length === 0) {
        previewArea.style.display = "none";
    }else{
      previewArea.style.display = "block";
    }
}

// Attach file handling to inputs
document.getElementById("fileInputAll").addEventListener("change", function () {
    handleFileUpload(this);
});
document.getElementById("fileInputImages").addEventListener("change", function () {
    handleFileUpload(this);
});
document.getElementById("fileInputVideos").addEventListener("change", function () {
    handleFileUpload(this);
});





    function OpenChat(Clicked) {

      $('#search_div').hide(); // Hide if already visible
      $('#search_input').val('');
      $('#sms_limit').val(50);
      searchCheck = false ;

      var id = $('#'+Clicked).data('teacher-id');
      var role = {{Auth::user()->role}};
       
     if ($('#'+Clicked).hasClass('active')) {
        // return false ;
     }


      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/admin-open-chat',
                data:{ id:id,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                   
                   
                  ShowChat(response,Clicked);
                },
              
            });
      
      }




      function ShowChat(response,Clicked) { 
        
        
        var authUserId = 'A'; // Get authenticated user ID
        if (response.block == 0 || response.block_by != authUserId) {
              $('#block_user').html('Block');
        } else {
             $('#block_user').html('Unblock');
        }


        $('.list-group-item').removeClass('active');
        $('#'+Clicked).addClass('active');
        $('#'+Clicked+'_unseen').empty();
        $('#tab1').empty(); // Images
    $('#tab2').empty(); // Videos
    $('#tab3').empty(); // Other Files
        $('#'+Clicked+'_unseen').hide();

        if (response['OtherUserRole'] == 1) {
            var profile_url  = `/professional-profile/${response.OtherUserId}/${response.profileName}`;
        } else{
          var profile_url  = '#' ; 
        } 
        $('#profile_url').attr('href', profile_url);
         
          var img = response.profileImageMain;
         

        $('#main_profile').attr('src', img);
        $('#main_name').html(response.fullName);
        $('#main_profile_2').attr('src', img);
        $('#main_name_2').html(response.fullName);
        $('#teacher_reciver_id').val(response.OtherUserId);  
        $('#teacher_reciver_role').val(response.OtherUserRole);  
        $('.emoji-wysiwyg-editor').empty(); 
        $('#message-textarea').val('');
        document.getElementById("preview-area").innerHTML = '';
        $('#preview-area').css('display', 'none');
        uploadedFiles = [];
 

        var len = 0;
            $("#full_chat").empty();
          if(response['completeChat']){
             len = response['completeChat'].length;
          }
  if (len > 0 ) {

    if (response.hasMore) {
              $("#full_chat").append(`<button class="btn btn-primary" style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;" type="button" onclick="ReadMore();" id="ReadMore">Read More</button>`);
              
            }

      for (let i = 0; i < len; i++) {
        const user_id = 'A';
        const sender_id = response['completeChat'][i].sender_id;
        const receiver_id = response['completeChat'][i].receiver_id;
        const sms = response['completeChat'][i].sms;
        const files = response['completeChat'][i].files;
        const time_ago = response['completeChat'][i].time_ago;

        if (sender_id == user_id) {
        chat_type = 'repaly' ;
        justify_content = 'end';
      } else {
        chat_type = 'sender' ;
        justify_content = 'start';
      }

        var chat_div = ' <li class="'+chat_type+'">'+
                          '<p>'+sms+'</p>';
        if (files != null) {
        // Split the comma-separated files into an array
        const fileArray = files.split(',');
        chat_div += `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;
        
        // Loop through each file and generate the appropriate anchor tag
        fileArray.forEach(file => {
           
          let filePath; // Declare filePath outside the if-else block

        if (response['OtherUserRole'] == 0) {
            filePath = `/assets/chat_media/A_chat_files_${response['OtherUserId']}/${file}`;
        } else {
            filePath = `/assets/chat_media/${response['OtherUserId']}_chat_files_A/${file}`;
        }
            const fileName = file.split('/').pop(); // Extract the base name of the file
            const fileExtension = file.split('.').pop().toLowerCase(); 

             // Define file types for different categories
    const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const videoTypes = ['mp4', 'webm', 'ogg'];
    const zipTypes = ['zip', 'rar'];
 

            if (imageTypes.includes(fileExtension)) {
        // Display image
        chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
    } else if (videoTypes.includes(fileExtension)) {
    // Display video with a clickable link to open in a new tab
    chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4"> 
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
} else if (zipTypes.includes(fileExtension)) {
        // Display ZIP file link
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>
              
                <span>${fileName}</span>
            </a>
        `;
    } else {
        // Default case for other files (PDF, DOCX, etc.)
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
    }

// Categorize and append file type
if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
    // Image files
    $('#tab1').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}">
                <img src="${filePath}" alt="Image" style="width:100%; height:auto; margin-bottom:10px;">
            </a>
        </div>
    `);
} else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'].includes(fileExtension)) {
    // Video files
    $('#tab2').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}">
                <video style="width:100%; height:auto; margin-bottom:10px;">
                    <source src="${filePath}" type="video/${fileExtension}">
                    Your browser does not support the video tag.
                </video>
            </a>
        </div>
    `);
} else {
  if (fileName != "") {
        // Other file types
        $('#tab3').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}" style="text-decoration:none; color:black; font-weight:500;">
                <i class="fa fa-file" style="margin-right:5px;"></i> ${fileName}
            </a>
        </div>
    `);
  }

}





        });
        
        chat_div += '</div>';
        }
               
                   chat_div +='<span class="time">'+time_ago+'</span>'+
                        '</li>' ;

         $("#full_chat").append(chat_div);

        
      }



       }


       var lennotes = 0;
            $("#notes").empty();
          if(response['notes'] != null){
             lennotes = response['notes'].length;
          }

          var notes = response['notes']; 
          
  if (lennotes > 0 ) {
    
    for (let i = 0; i < lennotes; i++) {
      var id = notes[i].id;
      var title = notes[i].title;
      var text = notes[i].text;
       
      
     var content_div = '<div id="main_div_'+id+'" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> '+
                   ' <div class="card-body" style="background-color:#ffff"> '+
                     ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_'+id+'" data-id="'+id+'" data-title="'+title+'" data-text="'+text+'"   on>'+title+'</h5> '+
                     ' <button id="delete_note_'+id+'" onclick="DeleteNote(this.id)" data-id="'+id+'" data-main_div="main_div_'+id+'" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> '+
                    '</div> '+
        ' </div>';




        $("#notes").append(content_div);
    }

  }



  
  var lennotes = 0;
            $("#notes").empty();
          if(response['notes'] != null){
             lennotes = response['notes'].length;
          }

          var notes = response['notes']; 
          
  if (lennotes > 0 ) {
    
    for (let i = 0; i < lennotes; i++) {
      var id = notes[i].id;
      var title = notes[i].title;
      var text = notes[i].text;
       
      
     var content_div = '<div id="main_div_'+id+'" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> '+
                   ' <div class="card-body" style="background-color:#ffff"> '+
                     ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_'+id+'" data-id="'+id+'" data-title="'+title+'" data-text="'+text+'"   on>'+title+'</h5> '+
                     ' <button id="delete_note_'+id+'" onclick="DeleteNote(this.id)" data-id="'+id+'" data-main_div="main_div_'+id+'" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> '+
                    '</div> '+
        ' </div>';




        $("#notes").append(content_div);
    }

  }


      }
  </script>
  {{-- Open Chat Script by Ajax END ============ --}}

   <!-- ======= Script for Send Sms by Ajax Start ====== -->
   <script>
   
    function SendSMS() {  
      
      
        
      var sms = $('#message-textarea').val(); // Get the value of the textarea

        // Check if the textarea is empty or null
        if ((sms === null || sms.trim() === '') && uploadedFiles.length === 0) {
          alert("Please add a message or upload files before sending."); // Show a warning message
          return; // Exit the function
        }

      var sender_id = 'A' ;
      var reciver_id = $('#teacher_reciver_id').val();    
      var sender_role = 2 ;
      var reciver_role = $('#teacher_reciver_role').val() ;
      var type = 2 ;

      // Prepare FormData for file upload
var formData = new FormData();
formData.append('sms', sms);
formData.append('sender_id', sender_id);
formData.append('reciver_id', reciver_id);
formData.append('sender_role', sender_role);
formData.append('reciver_role', reciver_role);
formData.append('type', type);
formData.append('_token', '{{ csrf_token() }}'); // CSRF token for Laravel security

// Add the uploaded files to the FormData object
uploadedFiles.forEach((file, index) => {
    formData.append(`files[${index}]`, file); // Append each file to the FormData object
});
 

     // Setup AJAX request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Make sure CSRF token is passed in headers
    }
});

// Send the AJAX request to the server
$.ajax({
    type: "POST",
    url: '/admin-send-message', // Your route for handling the message
    data: formData, // Pass FormData (including files and other fields)
    processData: false, // Do not process data (important for files)
    contentType: false, // Do not set content type (important for files)
    dataType: 'json',
    success: function (response) {
       
       
        // Clear the input fields and update the chat
        $('.emoji-wysiwyg-editor').empty();
        $('#message-textarea').val('');
        document.getElementById("preview-area").innerHTML = '';
        $('#preview-area').css('display', 'none');
        uploadedFiles = [];
        var files = response['chat'].files ;
        var user_id = {{Auth::user()->id}} ;

        var chat_div = '<li class="repaly">' +
            '<p>' + response['chat'].sms + '</p>' ;
        if (files != null) {
        // Split the comma-separated files into an array
        const fileArray = files.split(',');
        chat_div += '<div class="files">';

 
        // Loop through each file and generate the appropriate anchor tag

        fileArray.forEach(file => {
           
           let filePath; // Declare filePath outside the if-else block
 
         if (response['otheruserRole'] == 0) {
             filePath = `/assets/chat_media/A_chat_files_${response['otheruserId']}/${file}`;
         } else {
             filePath = `/assets/chat_media/${response['otheruserId']}_chat_files_A/${file}`;
         }
             const fileName = file.split('/').pop(); // Extract the base name of the file
             const fileExtension = file.split('.').pop().toLowerCase(); 
 
              // Define file types for different categories
     const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
     const videoTypes = ['mp4', 'webm', 'ogg'];
     const zipTypes = ['zip', 'rar'];
  
 
             if (imageTypes.includes(fileExtension)) {
         // Display image
         chat_div += `
             <a class="p-1" href="${filePath}" target="_blank">
                 <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
             </a>
         `;
     } else if (videoTypes.includes(fileExtension)) {
     // Display video with a clickable link to open in a new tab
     chat_div += `
          <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
             <video width="200" style="pointer-events: none;">
                 <source src="${filePath}" type="video/mp4"> 
             </video>
             <div style="
                 position: absolute;
                 top: 50%;
                 left: 50%;
                 transform: translate(-50%, -50%);
                 background: rgba(0, 0, 0, 0.6);
                 color: white;
                 font-size: 20px;
                 padding: 10px 15px;
                 border-radius: 50%;
                 cursor: pointer;">
                 ▶
             </div>
         </a>
     `;
 } else if (zipTypes.includes(fileExtension)) {
         // Display ZIP file link
         chat_div += `
             <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                 <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>
               
                 <span>${fileName}</span>
             </a>
         `;
     } else {
         // Default case for other files (PDF, DOCX, etc.)
         chat_div += `
             <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                 <span>${fileName}</span>
             </a>
         `;
     }
 
 // Categorize and append file type
 if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
     // Image files
     $('#tab1').append(`
         <div class="col-6">
             <a href="${filePath}" download="${fileName}">
                 <img src="${filePath}" alt="Image" style="width:100%; height:auto; margin-bottom:10px;">
             </a>
         </div>
     `);
 } else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'].includes(fileExtension)) {
     // Video files
     $('#tab2').append(`
         <div class="col-6">
             <a href="${filePath}" download="${fileName}">
                 <video style="width:100%; height:auto; margin-bottom:10px;">
                     <source src="${filePath}" type="video/${fileExtension}">
                     Your browser does not support the video tag.
                 </video>
             </a>
         </div>
     `);
 } else {
   if (fileName != "") {
         // Other file types
         $('#tab3').append(`
         <div class="col-6">
             <a href="${filePath}" download="${fileName}" style="text-decoration:none; color:black; font-weight:500;">
                 <i class="fa fa-file" style="margin-right:5px;"></i> ${fileName}
             </a>
         </div>
     `);
   }
 
 }
 
 
 
 
 
         });
        

 
        
        chat_div += '</div>';
        }
               
                   chat_div += '<span class="time">' + response['chat'].time_ago + '</span>' +
            '</li>';

        $("#full_chat").append(chat_div);

        const chatContainer = document.getElementById('chat-container');
        // chatContainer.insertAdjacentHTML('beforeend', chat_div);
        chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to the bottom of the chat container
    },
    error: function (xhr, status, error) {
        console.log(error); // Log errors if any
    }
});
 


    }


    
   </script>







  <!-- ================ side js start here=============== -->
<script>
  // Sidebar script
  document.addEventListener("DOMContentLoaded", function () {
    let arrow = document.querySelectorAll(".arrow");
    for (let i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", function (e) {
        let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
      });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");

    sidebarBtn.addEventListener("click", function () {
      sidebar.classList.toggle("close");
    });

    // Function to toggle sidebar based on screen size
    function toggleSidebar() {
      let screenWidth = window.innerWidth;
      if (screenWidth < 992) {
        sidebar.classList.add("close");
      } else {
        sidebar.classList.remove("close");
      }
    }

    // Call the function initially
    toggleSidebar();

    // Listen for resize events to adjust sidebar
    window.addEventListener("resize", function () {
      toggleSidebar();
    });
  });
</script>
<!-- ================ side js start End=============== -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script src="js/gallery.js"></script>
  <script src="https://cdn.rawgit.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css"></script>

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

    function openTab(clicked) {
    // Remove active class from all tab links
    $('.tablink').removeClass('active');

    // Add active class to the clicked tab link
    $('#' + clicked).addClass('active');

    // Get the target tab's ID from the data attribute
    var targetTab = $('#' + clicked).data('tab');

    // Hide all tab contents
    $('.tab-content').hide();

    // Show the target tab content
    $('#' + targetTab).show();
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
  $('.tablink').removeClass('active');
  const htab = document.getElementById('htab1');
  $(htab).addClass('active');
  $('.tab-content').css('display', 'none');
  $('#tab1').css('display', 'block');
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
console.log(tabsDiv);



  // Hide the profileId div
  profilDiv.style.display = 'none';
  // Show the tabs and tabContent divs
  tabsMainDiv.style.display = 'block';
  tabsDiv.style.display = 'block';
  tabContentDiv.style.display = 'block';
  $('.tablink').removeClass('active');
  const htab = document.getElementById('htab3');
  $(htab).addClass('active');
  $('.tab-content').css('display', 'none');
  $('#tab3').css('display', 'block');
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
  $('.tab-content').css('display', 'none');
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



 <!-- Emoji SelectorCDNS -->
 <script src="assets/emoji/js/config.min.js"></script>
 <script src="assets/emoji/js/emoji-picker.min.js"></script>
 <script src="assets/emoji/js/jquery.emojiarea.min.js"></script>
 <script src="assets/emoji/js/util.min.js"></script>
 <script>
  $(function() {
  // Initializes and creates emoji set from sprite sheet
  window.emojiPicker = new EmojiPicker({
    emojiable_selector: '[data-emojiable=true]',
    assetsPath: 'assets/emoji/img', 
  }); 
  window.emojiPicker.discover();
});

$('#emoji-button').on('click', function () { 
  console.log('dsdkjfkjsdfkj');
  
  $('.emoji-menu').css('display', 'block');
});

 </script>




{{-- Add Notes Script Start ====== --}}
<script>
  function AddNotes() {
    var title = $('#addTitle').val();
    var text = $('#addTxt').val();
    var other = $('#teacher_reciver_id').val();  

    if ( title === null   && (text === null || text.trim() === '') ) {
        alert("Please write something for add note."); // Show a warning message
        return; // Exit the function
    }

   
    

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/add-notes',
                data:{ title:title,text:text,other:other, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  $('#exampleModal2').modal('hide');
                    ShowNotes(response);
                    
                },
              
            });

         


    }

    // Show Notes Function ===

    function  ShowNotes(response) { 
       
       
  
  var len = 0;
            $("#notes").empty();
          if(response['notes'] != null){
             len = response['notes'].length;
          }

          var notes = response['notes'];
  if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {
      var id = notes[i].id;
      var title = notes[i].title;
      var text = notes[i].text;
  
     var content_div = '<div id="main_div_'+id+'" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> '+
                   ' <div class="card-body" style="background-color:#ffff"> '+
                     ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_'+id+'" data-id="'+id+'" data-title="'+title+'" data-text="'+text+'"   on>'+title+'</h5> '+
                     ' <button id="delete_note_'+id+'" onclick="DeleteNote(this.id)" data-id="'+id+'" data-main_div="main_div_'+id+'" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> '+
                    '</div> '+
        ' </div>';




        $("#notes").append(content_div);
    }

  }




}


function DeleteNote(Clicked) {
    var id = $('#'+Clicked).data('id');
    var main_div = $('#'+Clicked).data('main_div');


    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/delete-notes',
                data:{ id:id,main_div:main_div, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  
                  if (response.success) {
                    $('#'+main_div).remove();
                  }else{
                    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
                "timeOut": "10000", // 10 seconds
                "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error(response.message);
                  }
                    
                    
                },
              
            });

 
  }

  function EditNotes(Clicked) { 
    var id = $('#'+Clicked).data('id');
    var title = $('#'+Clicked).data('title');
    var text = $('#'+Clicked).data('text');
    $('#showtitle').val(title);
    $('#showtext').val(text);
    $('#note_id').val(id);

    $('#exampleModal3').modal('show');
   }


  $('#addBtnedit').click(function () { 
    var id = $('#note_id').val();
    var title = $('#showtitle').val();
    var text = $('#showtext').val();

    if ( title === null   && (text === null || text.trim() === '') ) {
        alert("Please write something for add note."); // Show a warning message
        return; // Exit the function
    }

    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/update-notes',
                data:{ title:title,text:text,id:id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  $('#exampleModal3').modal('hide');
                     

                    
                  if (response.success) {
                    $("#main_div_"+response.notes.id).empty();

                    var content_div =  ` <div class="card-body" style="background-color:#ffff"> 
                      <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_${response.notes.id}" data-id="${response.notes.id}" data-title="${response.notes.title}" data-text="${response.notes.text}"   on>${response.notes.title}</h5> 
                      <button id="delete_note_${response.notes.id}" onclick="DeleteNote(this.id)" data-id="${response.notes.id}" data-main_div="main_div_${response.notes.id}" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> 
                      </div>`;
                      $("#main_div_"+response.notes.id).html(content_div);
                  }else{
                    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
                "timeOut": "10000", // 10 seconds
                "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error(response.message);
                  }

                    
                },
              
            });
   
    
  });


</script>
{{-- Add Notes Script END ====== --}}



{{-- Block User Script Start ====== --}}
<script>
  function BlockUser() { 

    var block_id = $('#teacher_reciver_id').val(); 
    if (block_id == 'A') {
      alert('You are not able to block admin!');
      return false ;
    } 



     
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/block-user',
                data:{ block_id:block_id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) { 
                  
                  if (response.error) {
                    toastr.options =
                  {
                      "closeButton" : true,
                      "progressBar": true,
                  "timeOut": "10000", // 10 seconds
                  "extendedTimeOut": "4410000" // 10 seconds
                  }
                          toastr.error(response.error);
                  } else {

                    if (response.block == 0) { 
                      $('#block_user').html('Block');
                    } else { 
                      $('#block_user').html('UnBlock');
                    }



                    toastr.options =
                  {
                      "closeButton" : true,
                      "progressBar": true,
                  "timeOut": "10000", // 10 seconds
                  "extendedTimeOut": "4410000" // 10 seconds
                  }
                          toastr.success(response.success);
                  }
                  
                },
              
            });

   }
</script>
{{-- Block User Script END ====== --}}




{{-- Search Message Script END ====== --}}
<script>
  // Show Search Bar Function -------
  function ShowSearchBar() {
    // $('#search_div').toggle(); // Toggle display between block and none
   
    if ($('#search_div').is(':visible')) {
        $('#search_div').hide(); // Hide if already visible
        $('#search_input').val('');
        searchCheck = false ;
        // SearchMessage();
    } else {
        $('#search_div').show(); // Show if hidden
    }

  }


    // Search Message Script Start -----------
    function SearchMessage() {
      var id = $('#teacher_reciver_id').val(); 
      var key =  $('#search_input').val();
      searchCheck = true ;


      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/search-message',
                data:{ id:id, key:key, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
  
                  // Show Fetched Messages By sms Start ----

                  var len = 0;
            $("#full_chat").empty();
          if(response['completeChat']){
             len = response['completeChat'].length;
          }
  if (len > 0 ) {

      for (let i = 0; i < len; i++) {
        const user_id = 'A';
        const sender_id = response['completeChat'][i].sender_id;
        const receiver_id = response['completeChat'][i].receiver_id;
        const sms = response['completeChat'][i].sms;
        const files = response['completeChat'][i].files;
        const time_ago = response['completeChat'][i].time_ago;

        if (sender_id == user_id) {
        chat_type = 'repaly' ;
        justify_content = 'end';
      } else {
        chat_type = 'sender' ;
        justify_content = 'start';
      }

        var chat_div = ' <li class="'+chat_type+'">'+
                          '<p>'+sms+'</p>';
        if (files != null) {
        // Split the comma-separated files into an array
        const fileArray = files.split(',');
        chat_div += `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;
        
        // Loop through each file and generate the appropriate anchor tag
        fileArray.forEach(file => {

          let filePath; // Declare filePath outside the if-else block
 
 if (response['OtherUserRole'] == 0) {
     filePath = `/assets/chat_media/A_chat_files_${response['OtherUserId']}/${file}`;
 } else {
     filePath = `/assets/chat_media/${response['OtherUserId']}_chat_files_A/${file}`;
 }

            const fileName = file.split('/').pop(); // Extract the base name of the file
            const fileExtension = file.split('.').pop().toLowerCase(); 

             // Define file types for different categories
    const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const videoTypes = ['mp4', 'webm', 'ogg'];
    const zipTypes = ['zip', 'rar'];
 

            if (imageTypes.includes(fileExtension)) {
        // Display image
        chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
    } else if (videoTypes.includes(fileExtension)) {
    // Display video with a clickable link to open in a new tab
    chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4"> 
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
} else if (zipTypes.includes(fileExtension)) {
        // Display ZIP file link
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>
              
                <span>${fileName}</span>
            </a>
        `;
    } else {
        // Default case for other files (PDF, DOCX, etc.)
        chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
    }

 





        });
        
        chat_div += '</div>';
        }
               
                   chat_div +='<span class="time">'+time_ago+'</span>'+
                        '</li>' ;

         $("#full_chat").append(chat_div);

        
      }



       }else{
        $("#full_chat").append(`<h5  class="Safety-term text-center" >No Record Found</h5>`);
       }

                  // Show Fetched Messages By sms END ----

                  
                  
                  
                },
              
            });


 
      }
    // Search Message Script END -----------


</script>
{{-- Search Message Script Start ====== --}}





</body>

</html>