<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

{{-- =======Toastr CDN ======== --}}
<link rel="stylesheet" type="text/css" 
href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{-- =======Toastr CDN ======== --}}

<link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
<style>
    .nav-profile{
        width: fit-content !important;
        position: relative;
    bottom: 4px;
    }
     .loading-spinner {
        position: relative;
        left: 260px;
        bottom: 33px;
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

        /* Keyword Style Suggesions */
        .suggestions {
            width: 29%;
            position: absolute;
            top: 100%;
            left: auto;
            right: auto;
            background: #fff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            max-height: 250px;
            overflow-y: auto;
            display: none;
            z-index: 10;
        }
        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }
        .suggestions div:hover {
            /* background-color: #f0f0f0; */
            color: #0072B1 ;
        }
</style>
<style> #toast-container > .toast-error { background-color: #BD362F; } </style>
<style> #toast-container > .toast-success { background-color: #39ac39; } </style>
<style> #toast-container > .toast-info { background-color: #3984ac; } </style>
 

<nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="/">
        @php
            $home = \App\Models\HomeDynamic::first();
             
        @endphp
        @if ($home)
            
        <img src="assets/public-site/asset/img/{{$home->site_logo}}"  width="100%">
        @endif
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <!-- <span class="navbar-toggler-icon"></span> -->
        <i class="fi fi-br-menu-burger"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown dropdown-mega position-static">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Explore &nbsp;<i
                        class="fa-solid fa-angle-down"></i></a>
                <div class="dropdown-menu mega-dropdown">
                    <div class="mega-content px-4">
                        <div class="container">
                            <!-- FIRST ROW START HERE -->
                            <div class="row mega-menu-top">
                                <div class="col-md-12">
                                    <h2>Online Services</h2>
                                </div>
                            </div>
                            <!--  -->
                            <div class="row service-links">
                                @php
                                $categories = \App\Models\Category::where(['service_type'=>'online','status'=>1 , 'service_role'=>'Class'])->get();
                                @endphp
 
                            @if ($categories)
                            @foreach ($categories as $item)
                            @php  $category = \App\Models\Category::where(['category'=>$item->category,  'service_role'=>'Freelance'])->first();
                            //  $result = preg_replace('/\(.*?\)/', '', $item->category); 
                              @endphp
                            @if ($category)
                               <div class="col-12 col-md-6 col-lg-3">
                                <ul>
                                    <li><a href="/seller-listing/online-services/{{$item->category}}">{{$item->category}}</a></li>
                                </ul>
                            </div>
                            @endif
                                
                            @endforeach
                                
                            @endif
                                {{-- <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Art & Design</a></li>
                                        <li><a href="">Food & Drink</a></li>
                                        <li><a href="">Music & Podcast</a></li>
                                        <li><a href="">Fitness & Wellbeing</a></li>
                                        <li><a href="">Dance</a></li>
                                        <li><a href="">Video & Photography</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Acting & Theatre</a></li>
                                        <li><a href="">Creative & Writing</a></li>
                                        <li><a href="">Sports</a></li>
                                        <li><a href="">Animal Care & Training</a></li>
                                        <li><a href="">Gardening</a></li>
                                        <li><a href="">Comedy</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Mobility & Transformation</a></li>
                                        <li><a href="">Marketing & Advertising</a></li>
                                        <li><a href="">Business & Enterpreneurship</a></li>
                                        <li><a href="">Tech & Programming</a></li>
                                        <li><a href="">DIY & Repairs</a></li>
                                        <li><a href="">Career & Development</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Language & Culture</a></li>
                                        <li><a href="">Virtu Games</a></li>
                                        <li><a href="">Style & Beauty</a></li>
                                        <li><a href="">Dating & Relantionship</a></li>
                                        <li><a href="">Acadmic Courses</a></li>
                                        <li><a href="">Magic & Illusion</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                            <div class="row mega-menu-top">
                                <h1></h1>
                                <div class="col-md-12">
                                    <a href="/seller-listing/online-services">view all >></a>
                                </div>
                            </div>
                            <!-- FIRST ROW END HERE -->
                            <!-- SECOND ROW START HERE -->
                            <div class="row mega-menu-top">
                                <div class="col-md-12">
                                    <h2>In-Person Services</h2>
                                </div>
                            </div>
                            <!--  -->
                            <div class="row service-links">
                                @php
                                $categories = \App\Models\Category::where(['service_type'=>'inperson','status'=>1 , 'service_role'=>'Class'])->get();

                                 
                            @endphp

                            @if ($categories)
                            @foreach ($categories as $item)
                            @php $category = \App\Models\Category::where(['category'=>$item->category,  'service_role'=>'Freelance'])->first();
                            // $result = preg_replace('/\(.*?\)/', '', $item->category);  
                            @endphp

                                @if ($category)
                                    
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="/seller-listing/inperson-services/{{$item->category}}">{{$item->category}}</a></li>
                                    </ul>
                                </div>
                                @endif
                                
                            @endforeach
                                
                            @endif
                                {{-- <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Art & Design</a></li>
                                        <li><a href="">Food & Drink</a></li>
                                        <li><a href="">Music & Podcast</a></li>
                                        <li><a href="">Fitness & Wellbeing</a></li>
                                        <li><a href="">Dance</a></li>
                                        <li><a href="">Video & Photography</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Acting & Theatre</a></li>
                                        <li><a href="">Creative & Writing</a></li>
                                        <li><a href="">Sports</a></li>
                                        <li><a href="">Animal Care & Training</a></li>
                                        <li><a href="">Gardening</a></li>
                                        <li><a href="">Comedy</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Mobility & Transformation</a></li>
                                        <li><a href="">Marketing & Advertising</a></li>
                                        <li><a href="">Business & Enterpreneurship</a></li>
                                        <li><a href="">Tech & Programming</a></li>
                                        <li><a href="">DIY & Repairs</a></li>
                                        <li><a href="">Career & Development</a></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <ul>
                                        <li><a href="">Language & Culture</a></li>
                                        <li><a href="">Virtu Games</a></li>
                                        <li><a href="">Style & Beauty</a></li>
                                        <li><a href="">Dating & Relantionship</a></li>
                                        <li><a href="">Acadmic Courses</a></li>
                                        <li><a href="">Magic & Illusion</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                            <div class="row mega-menu-top">
                                <div class="col-md-12">
                                    <a href="/seller-listing/inperson-services">view all >></a>
                                </div>
                            </div>
                            <!-- SECOND ROW END HERE -->
                        </div>
                    </div>
                </div>
            </li>
            <!--  -->
            
        </ul>
        <form action="/seller-listing-service-search" class="d-flex nav-search" style="width: 50%;"> @csrf
            <div class="d-flex justify-content-center search-container search-container-nav" style="width: 100%;"> 
                <div class="search"> 
                    <input type="hidden" name="category_type" value="">
                    <input type="hidden" name="category_service" value="" id="cate_service">
                    <input type="text" class="search-input" autocomplete="off" placeholder="Search for a services" id="keyword_nav" name="keyword">
                    <div class="suggestions" id="suggestions_nav"></div>
                    <button type="submit" class="search-icon" style="border: none;"> <i class="fa fa-search"></i> </button>
                     </div>
                     
                     </div> 
                     
        </form>
       <div class="btn-area">

        @if (Auth::user())
        @if (Auth::user()->role == 0)
        <li class="nav-item">
            <a class="nav-link" href="/become-expert"  >Become an Expert</a>
        </li>
        @endif
        @else
        <li class="nav-item">
            <a class="nav-link" href="/become-expert"  >Become an Expert</a>
        </li>
        @endif
        


            @if (!Auth::user())
            <button type="button" class="btn login-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
            <button type="button" class="btn register-btn" data-bs-toggle="modal" data-bs-target="#exampleModal1">Register</button>
            
            @else


              <!-- BELL SVG START  -->
              <li class="nav-item dropdown dropdown-mega position-static">
                <a class="nav-link dropdown-toggle p-0" style="padding-left:0px !important ;" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <svg class="" width="28" height="32" viewBox="0 0 28 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.7941 30.9716H12.1954C11.9877 31.1215 11.7432 31.2005 11.4948 31.2005C11.2464 31.2005 11.0018 31.1215 10.7941 30.9716Z"
                            stroke="#181818" stroke-width="1.6" />
                        <path
                            d="M22.2 27.4289V28.5315H0.8V27.4289L0.802222 27.4268L0.802275 27.4269L0.810426 27.4192C1.59587 26.6807 2.2818 25.8374 2.8504 24.9121L2.86979 24.8805L2.88618 24.8473C3.5233 23.5564 3.90462 22.1478 4.00867 20.7041L4.01074 20.6754V20.6466L4.01074 16.696L4.01074 16.6944C4.00703 14.7892 4.67005 12.9512 5.8708 11.5203C7.07099 10.0902 8.7256 9.16464 10.5252 8.90693L11.2117 8.80861V8.11501V7.06738C11.2117 6.98741 11.2427 6.91619 11.2892 6.86801C11.3347 6.82079 11.3904 6.79976 11.4421 6.79976C11.4939 6.79976 11.5495 6.82079 11.5951 6.86801C11.6416 6.91619 11.6725 6.98741 11.6725 7.06738V8.09902V8.80009L12.3675 8.8921C14.1832 9.13246 15.8579 10.0523 17.074 11.4872C18.2907 12.9228 18.963 14.7742 18.9584 16.694V16.696V20.6466V20.6754L18.9605 20.7041C19.0645 22.1478 19.4458 23.5564 20.083 24.8473L20.1005 24.8829L20.1215 24.9166C20.7002 25.8444 21.3974 26.688 22.1949 27.4242L22.1978 27.4268L22.2 27.4289Z"
                            stroke="#181818" stroke-width="1.6" />
                        <path
                            d="M28 8.49976C28 13.1942 24.4183 16.9998 20 16.9998C15.5817 16.9998 12 13.1942 12 8.49976C12 3.80534 15.5817 -0.000244141 20 -0.000244141C24.4183 -0.000244141 28 3.80534 28 8.49976Z"
                            fill="#0072B1" />
                        <path
                            d="M18.4844 11.072H18.582C19.0312 11.072 19.4056 11.0134 19.7051 10.8962C20.0078 10.7758 20.2487 10.6098 20.4277 10.3982C20.6068 10.1866 20.7354 9.93758 20.8135 9.65112C20.8916 9.36466 20.9307 9.05379 20.9307 8.71851V7.49292C20.9307 7.20321 20.8997 6.9493 20.8379 6.7312C20.7793 6.50985 20.6947 6.32593 20.584 6.17944C20.4766 6.0297 20.3512 5.9174 20.208 5.84253C20.068 5.76766 19.9167 5.73022 19.7539 5.73022C19.5749 5.73022 19.4137 5.77091 19.2705 5.85229C19.1305 5.93042 19.0117 6.03947 18.9141 6.17944C18.8197 6.31616 18.7464 6.47729 18.6943 6.66284C18.6455 6.84513 18.6211 7.04045 18.6211 7.24878C18.6211 7.44409 18.6439 7.63289 18.6895 7.81519C18.7383 7.99422 18.8099 8.15373 18.9043 8.2937C18.9987 8.43368 19.1175 8.54435 19.2607 8.62573C19.404 8.70711 19.5716 8.7478 19.7637 8.7478C19.946 8.7478 20.1136 8.71362 20.2666 8.64526C20.4196 8.57365 20.5531 8.47762 20.667 8.35718C20.7809 8.23674 20.8704 8.10164 20.9355 7.9519C21.0007 7.80216 21.0365 7.64917 21.043 7.49292L21.4922 7.62964C21.4922 7.87703 21.4401 8.12118 21.3359 8.36206C21.235 8.59969 21.0934 8.81779 20.9111 9.01636C20.7321 9.21167 20.5221 9.36792 20.2812 9.48511C20.0436 9.60229 19.7848 9.66089 19.5049 9.66089C19.1663 9.66089 18.8669 9.59741 18.6064 9.47046C18.3493 9.34025 18.1344 9.16447 17.9619 8.94312C17.7926 8.72176 17.6657 8.46785 17.5811 8.1814C17.4964 7.89494 17.4541 7.59383 17.4541 7.27808C17.4541 6.93628 17.5062 6.61564 17.6104 6.31616C17.7145 6.01668 17.8659 5.75301 18.0645 5.52515C18.263 5.29403 18.5039 5.11499 18.7871 4.98804C19.0736 4.85783 19.3975 4.79272 19.7588 4.79272C20.1429 4.79272 20.4798 4.86759 20.7695 5.01733C21.0592 5.16707 21.3034 5.37378 21.502 5.63745C21.7005 5.90112 21.8503 6.20711 21.9512 6.55542C22.0521 6.90373 22.1025 7.27808 22.1025 7.67847V8.09351C22.1025 8.51343 22.0651 8.9187 21.9902 9.30933C21.9154 9.6967 21.7933 10.0564 21.624 10.3884C21.458 10.7172 21.2383 11.0069 20.9648 11.2576C20.6947 11.505 20.3626 11.6986 19.9688 11.8386C19.5781 11.9753 19.1191 12.0437 18.5918 12.0437H18.4844V11.072Z"
                            fill="white" />
                    </svg>
                </a>
                <div class="dropdown-menu">
                    <div class="navbar-inbox-dropdawon">
                        <div class="dropDawon-head">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25" fill="none">
                                <path
                                    d="M10.9946 24.2006C10.7974 24.2006 10.6023 24.1465 10.4288 24.0422H11.5603C11.3868 24.1465 11.1917 24.2006 10.9946 24.2006Z"
                                    stroke="#181818" stroke-width="1.6" />
                                <path
                                    d="M21.2 20.6166V21.6338H0.8V20.6166L0.800529 20.6161C1.55398 19.904 2.21182 19.0909 2.75707 18.1989L2.77633 18.1674L2.79261 18.1343C3.40369 16.8897 3.76933 15.5318 3.86909 14.1403L3.87114 14.1117V14.0831L3.87114 10.2846L3.87114 10.283C3.86761 8.4571 4.49976 6.69636 5.64351 5.32633C6.78661 3.95706 8.36152 3.07206 10.073 2.82568L10.7591 2.72693V2.03384V1.02653C10.7591 0.95618 10.7862 0.894935 10.8248 0.85472C10.8624 0.81561 10.9062 0.8 10.9446 0.8C10.9831 0.8 11.0269 0.81561 11.0645 0.854718C11.1031 0.894936 11.1302 0.956182 11.1302 1.02653V2.01846V2.71906L11.8247 2.81147C13.5516 3.04127 15.1456 3.92082 16.3038 5.2946C17.4627 6.66917 18.1038 8.44271 18.0993 10.2826V10.2846V14.0831V14.1117L18.1014 14.1403C18.2011 15.5318 18.5668 16.8897 19.1779 18.1343L19.1953 18.1698L19.2162 18.2035C19.7699 19.096 20.437 19.9077 21.2 20.6166Z"
                                    stroke="#181818" stroke-width="1.6" />
                            </svg>
                            <h4>
                                Notification
                            </h4>
                            <span> (5)</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="15.5" fill="#E5F5FF" stroke="#0072B1" />
                                        <mask id="path-2-inside-1_3086_15476" fill="white">
                                            <path
                                                d="M14.7637 22.3359C14.8049 22.6461 14.9524 22.9303 15.1791 23.136C15.4058 23.3416 15.6963 23.455 15.9969 23.455C16.2975 23.455 16.588 23.3416 16.8147 23.136C17.0414 22.9303 17.1889 22.6461 17.2301 22.3359H14.7637Z" />
                                        </mask>
                                        <path
                                            d="M14.7637 22.3359V20.7359H12.9371L13.1776 22.5466L14.7637 22.3359ZM15.9969 23.455V25.055V23.455ZM17.2301 22.3359L18.8162 22.5466L19.0567 20.7359H17.2301V22.3359ZM13.1776 22.5466C13.2674 23.2226 13.5904 23.8549 14.1039 24.3209L16.2543 21.9511C16.3144 22.0056 16.3424 22.0696 16.3497 22.1253L13.1776 22.5466ZM14.1039 24.3209C14.6191 24.7883 15.2908 25.055 15.9969 25.055V21.855C16.1017 21.855 16.1925 21.895 16.2543 21.9511L14.1039 24.3209ZM15.9969 25.055C16.7029 25.055 17.3747 24.7883 17.8899 24.3209L15.7395 21.9511C15.8013 21.895 15.8921 21.855 15.9969 21.855V25.055ZM17.8899 24.3209C18.4034 23.8549 18.7264 23.2226 18.8162 22.5466L15.644 22.1253C15.6514 22.0696 15.6793 22.0056 15.7395 21.9511L17.8899 24.3209ZM17.2301 20.7359H14.7637V23.9359H17.2301V20.7359Z"
                                            fill="#0072B1" mask="url(#path-2-inside-1_3086_15476)" />
                                        <path
                                            d="M22.5 20.6606V21.321H9.5V20.6607L9.50318 20.6576C9.98206 20.205 10.4002 19.6883 10.7467 19.1213L10.7588 19.1016L10.769 19.0809C11.1573 18.2899 11.3897 17.427 11.4531 16.5427L11.4544 16.5248V16.5069L11.4544 14.0896L11.4544 14.0887C11.4521 12.9246 11.8551 11.8021 12.5843 10.9286C13.3132 10.0555 14.3174 9.4912 15.4088 9.33408L15.8376 9.27236V8.83919V8.19817C15.8376 8.1511 15.8557 8.10986 15.882 8.08254L15.5262 7.74094L15.882 8.08254C15.9075 8.05591 15.9378 8.04492 15.9648 8.04492C15.9918 8.04492 16.022 8.05591 16.0476 8.08254C16.0738 8.10986 16.0919 8.15111 16.0919 8.19817V8.8294V9.26727L16.526 9.32503C17.6272 9.47157 18.6436 10.0324 19.3821 10.9084C20.121 11.7848 20.5297 12.9155 20.5268 14.0884V14.0896V16.5069V16.5248L20.5281 16.5427C20.5915 17.427 20.8239 18.2899 21.2123 19.0809L21.2232 19.1031L21.2362 19.1241C21.5888 19.6925 22.0138 20.2094 22.5 20.6606Z"
                                            stroke="#0072B1" />
                                    </svg>
                                </div>
                                <div class="inbox-profile-detail">
                                    <span style="color: rgba(0, 0, 0, 0.90) !important; ">
                                        Learn all the Dos and Don’ts of Dream Crowd at our May 16th
                                        Community Standards webinar. Register Now
                                    </span>
                                </div>
                            </div>
                            <span>1 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="15.5" fill="#E5F5FF" stroke="#0072B1" />
                                        <mask id="path-2-inside-1_3086_15476" fill="white">
                                            <path
                                                d="M14.7637 22.3359C14.8049 22.6461 14.9524 22.9303 15.1791 23.136C15.4058 23.3416 15.6963 23.455 15.9969 23.455C16.2975 23.455 16.588 23.3416 16.8147 23.136C17.0414 22.9303 17.1889 22.6461 17.2301 22.3359H14.7637Z" />
                                        </mask>
                                        <path
                                            d="M14.7637 22.3359V20.7359H12.9371L13.1776 22.5466L14.7637 22.3359ZM15.9969 23.455V25.055V23.455ZM17.2301 22.3359L18.8162 22.5466L19.0567 20.7359H17.2301V22.3359ZM13.1776 22.5466C13.2674 23.2226 13.5904 23.8549 14.1039 24.3209L16.2543 21.9511C16.3144 22.0056 16.3424 22.0696 16.3497 22.1253L13.1776 22.5466ZM14.1039 24.3209C14.6191 24.7883 15.2908 25.055 15.9969 25.055V21.855C16.1017 21.855 16.1925 21.895 16.2543 21.9511L14.1039 24.3209ZM15.9969 25.055C16.7029 25.055 17.3747 24.7883 17.8899 24.3209L15.7395 21.9511C15.8013 21.895 15.8921 21.855 15.9969 21.855V25.055ZM17.8899 24.3209C18.4034 23.8549 18.7264 23.2226 18.8162 22.5466L15.644 22.1253C15.6514 22.0696 15.6793 22.0056 15.7395 21.9511L17.8899 24.3209ZM17.2301 20.7359H14.7637V23.9359H17.2301V20.7359Z"
                                            fill="#0072B1" mask="url(#path-2-inside-1_3086_15476)" />
                                        <path
                                            d="M22.5 20.6606V21.321H9.5V20.6607L9.50318 20.6576C9.98206 20.205 10.4002 19.6883 10.7467 19.1213L10.7588 19.1016L10.769 19.0809C11.1573 18.2899 11.3897 17.427 11.4531 16.5427L11.4544 16.5248V16.5069L11.4544 14.0896L11.4544 14.0887C11.4521 12.9246 11.8551 11.8021 12.5843 10.9286C13.3132 10.0555 14.3174 9.4912 15.4088 9.33408L15.8376 9.27236V8.83919V8.19817C15.8376 8.1511 15.8557 8.10986 15.882 8.08254L15.5262 7.74094L15.882 8.08254C15.9075 8.05591 15.9378 8.04492 15.9648 8.04492C15.9918 8.04492 16.022 8.05591 16.0476 8.08254C16.0738 8.10986 16.0919 8.15111 16.0919 8.19817V8.8294V9.26727L16.526 9.32503C17.6272 9.47157 18.6436 10.0324 19.3821 10.9084C20.121 11.7848 20.5297 12.9155 20.5268 14.0884V14.0896V16.5069V16.5248L20.5281 16.5427C20.5915 17.427 20.8239 18.2899 21.2123 19.0809L21.2232 19.1031L21.2362 19.1241C21.5888 19.6925 22.0138 20.2094 22.5 20.6606Z"
                                            stroke="#0072B1" />
                                    </svg>
                                </div>
                                <div class="inbox-profile-detail">
                                    <span style="color: rgba(0, 0, 0, 0.90) !important; ">
                                        Learn all the Dos and Don’ts of Dream Crowd at our May 16th
                                        Community Standards webinar. Register Now
                                    </span>
                                </div>
                            </div>
                            <span>1 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="15.5" fill="#E5F5FF" stroke="#0072B1" />
                                        <mask id="path-2-inside-1_3086_15476" fill="white">
                                            <path
                                                d="M14.7637 22.3359C14.8049 22.6461 14.9524 22.9303 15.1791 23.136C15.4058 23.3416 15.6963 23.455 15.9969 23.455C16.2975 23.455 16.588 23.3416 16.8147 23.136C17.0414 22.9303 17.1889 22.6461 17.2301 22.3359H14.7637Z" />
                                        </mask>
                                        <path
                                            d="M14.7637 22.3359V20.7359H12.9371L13.1776 22.5466L14.7637 22.3359ZM15.9969 23.455V25.055V23.455ZM17.2301 22.3359L18.8162 22.5466L19.0567 20.7359H17.2301V22.3359ZM13.1776 22.5466C13.2674 23.2226 13.5904 23.8549 14.1039 24.3209L16.2543 21.9511C16.3144 22.0056 16.3424 22.0696 16.3497 22.1253L13.1776 22.5466ZM14.1039 24.3209C14.6191 24.7883 15.2908 25.055 15.9969 25.055V21.855C16.1017 21.855 16.1925 21.895 16.2543 21.9511L14.1039 24.3209ZM15.9969 25.055C16.7029 25.055 17.3747 24.7883 17.8899 24.3209L15.7395 21.9511C15.8013 21.895 15.8921 21.855 15.9969 21.855V25.055ZM17.8899 24.3209C18.4034 23.8549 18.7264 23.2226 18.8162 22.5466L15.644 22.1253C15.6514 22.0696 15.6793 22.0056 15.7395 21.9511L17.8899 24.3209ZM17.2301 20.7359H14.7637V23.9359H17.2301V20.7359Z"
                                            fill="#0072B1" mask="url(#path-2-inside-1_3086_15476)" />
                                        <path
                                            d="M22.5 20.6606V21.321H9.5V20.6607L9.50318 20.6576C9.98206 20.205 10.4002 19.6883 10.7467 19.1213L10.7588 19.1016L10.769 19.0809C11.1573 18.2899 11.3897 17.427 11.4531 16.5427L11.4544 16.5248V16.5069L11.4544 14.0896L11.4544 14.0887C11.4521 12.9246 11.8551 11.8021 12.5843 10.9286C13.3132 10.0555 14.3174 9.4912 15.4088 9.33408L15.8376 9.27236V8.83919V8.19817C15.8376 8.1511 15.8557 8.10986 15.882 8.08254L15.5262 7.74094L15.882 8.08254C15.9075 8.05591 15.9378 8.04492 15.9648 8.04492C15.9918 8.04492 16.022 8.05591 16.0476 8.08254C16.0738 8.10986 16.0919 8.15111 16.0919 8.19817V8.8294V9.26727L16.526 9.32503C17.6272 9.47157 18.6436 10.0324 19.3821 10.9084C20.121 11.7848 20.5297 12.9155 20.5268 14.0884V14.0896V16.5069V16.5248L20.5281 16.5427C20.5915 17.427 20.8239 18.2899 21.2123 19.0809L21.2232 19.1031L21.2362 19.1241C21.5888 19.6925 22.0138 20.2094 22.5 20.6606Z"
                                            stroke="#0072B1" />
                                    </svg>
                                </div>
                                <div class="inbox-profile-detail">
                                    <span style="color: rgba(0, 0, 0, 0.90) !important; ">
                                        Learn all the Dos and Don’ts of Dream Crowd at our May 16th
                                        Community Standards webinar. Register Now
                                    </span>
                                </div>
                            </div>
                            <span>1 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="15.5" fill="#E5F5FF" stroke="#0072B1" />
                                        <mask id="path-2-inside-1_3086_15476" fill="white">
                                            <path
                                                d="M14.7637 22.3359C14.8049 22.6461 14.9524 22.9303 15.1791 23.136C15.4058 23.3416 15.6963 23.455 15.9969 23.455C16.2975 23.455 16.588 23.3416 16.8147 23.136C17.0414 22.9303 17.1889 22.6461 17.2301 22.3359H14.7637Z" />
                                        </mask>
                                        <path
                                            d="M14.7637 22.3359V20.7359H12.9371L13.1776 22.5466L14.7637 22.3359ZM15.9969 23.455V25.055V23.455ZM17.2301 22.3359L18.8162 22.5466L19.0567 20.7359H17.2301V22.3359ZM13.1776 22.5466C13.2674 23.2226 13.5904 23.8549 14.1039 24.3209L16.2543 21.9511C16.3144 22.0056 16.3424 22.0696 16.3497 22.1253L13.1776 22.5466ZM14.1039 24.3209C14.6191 24.7883 15.2908 25.055 15.9969 25.055V21.855C16.1017 21.855 16.1925 21.895 16.2543 21.9511L14.1039 24.3209ZM15.9969 25.055C16.7029 25.055 17.3747 24.7883 17.8899 24.3209L15.7395 21.9511C15.8013 21.895 15.8921 21.855 15.9969 21.855V25.055ZM17.8899 24.3209C18.4034 23.8549 18.7264 23.2226 18.8162 22.5466L15.644 22.1253C15.6514 22.0696 15.6793 22.0056 15.7395 21.9511L17.8899 24.3209ZM17.2301 20.7359H14.7637V23.9359H17.2301V20.7359Z"
                                            fill="#0072B1" mask="url(#path-2-inside-1_3086_15476)" />
                                        <path
                                            d="M22.5 20.6606V21.321H9.5V20.6607L9.50318 20.6576C9.98206 20.205 10.4002 19.6883 10.7467 19.1213L10.7588 19.1016L10.769 19.0809C11.1573 18.2899 11.3897 17.427 11.4531 16.5427L11.4544 16.5248V16.5069L11.4544 14.0896L11.4544 14.0887C11.4521 12.9246 11.8551 11.8021 12.5843 10.9286C13.3132 10.0555 14.3174 9.4912 15.4088 9.33408L15.8376 9.27236V8.83919V8.19817C15.8376 8.1511 15.8557 8.10986 15.882 8.08254L15.5262 7.74094L15.882 8.08254C15.9075 8.05591 15.9378 8.04492 15.9648 8.04492C15.9918 8.04492 16.022 8.05591 16.0476 8.08254C16.0738 8.10986 16.0919 8.15111 16.0919 8.19817V8.8294V9.26727L16.526 9.32503C17.6272 9.47157 18.6436 10.0324 19.3821 10.9084C20.121 11.7848 20.5297 12.9155 20.5268 14.0884V14.0896V16.5069V16.5248L20.5281 16.5427C20.5915 17.427 20.8239 18.2899 21.2123 19.0809L21.2232 19.1031L21.2362 19.1241C21.5888 19.6925 22.0138 20.2094 22.5 20.6606Z"
                                            stroke="#0072B1" />
                                    </svg>
                                </div>
                                <div class="inbox-profile-detail">
                                    <span style="color: rgba(0, 0, 0, 0.90) !important; ">
                                        Learn all the Dos and Don’ts of Dream Crowd at our May 16th
                                        Community Standards webinar. Register Now
                                    </span>
                                </div>
                            </div>
                            <span>1 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                        <circle cx="16" cy="16" r="15.5" fill="#E5F5FF" stroke="#0072B1" />
                                        <mask id="path-2-inside-1_3086_15476" fill="white">
                                            <path
                                                d="M14.7637 22.3359C14.8049 22.6461 14.9524 22.9303 15.1791 23.136C15.4058 23.3416 15.6963 23.455 15.9969 23.455C16.2975 23.455 16.588 23.3416 16.8147 23.136C17.0414 22.9303 17.1889 22.6461 17.2301 22.3359H14.7637Z" />
                                        </mask>
                                        <path
                                            d="M14.7637 22.3359V20.7359H12.9371L13.1776 22.5466L14.7637 22.3359ZM15.9969 23.455V25.055V23.455ZM17.2301 22.3359L18.8162 22.5466L19.0567 20.7359H17.2301V22.3359ZM13.1776 22.5466C13.2674 23.2226 13.5904 23.8549 14.1039 24.3209L16.2543 21.9511C16.3144 22.0056 16.3424 22.0696 16.3497 22.1253L13.1776 22.5466ZM14.1039 24.3209C14.6191 24.7883 15.2908 25.055 15.9969 25.055V21.855C16.1017 21.855 16.1925 21.895 16.2543 21.9511L14.1039 24.3209ZM15.9969 25.055C16.7029 25.055 17.3747 24.7883 17.8899 24.3209L15.7395 21.9511C15.8013 21.895 15.8921 21.855 15.9969 21.855V25.055ZM17.8899 24.3209C18.4034 23.8549 18.7264 23.2226 18.8162 22.5466L15.644 22.1253C15.6514 22.0696 15.6793 22.0056 15.7395 21.9511L17.8899 24.3209ZM17.2301 20.7359H14.7637V23.9359H17.2301V20.7359Z"
                                            fill="#0072B1" mask="url(#path-2-inside-1_3086_15476)" />
                                        <path
                                            d="M22.5 20.6606V21.321H9.5V20.6607L9.50318 20.6576C9.98206 20.205 10.4002 19.6883 10.7467 19.1213L10.7588 19.1016L10.769 19.0809C11.1573 18.2899 11.3897 17.427 11.4531 16.5427L11.4544 16.5248V16.5069L11.4544 14.0896L11.4544 14.0887C11.4521 12.9246 11.8551 11.8021 12.5843 10.9286C13.3132 10.0555 14.3174 9.4912 15.4088 9.33408L15.8376 9.27236V8.83919V8.19817C15.8376 8.1511 15.8557 8.10986 15.882 8.08254L15.5262 7.74094L15.882 8.08254C15.9075 8.05591 15.9378 8.04492 15.9648 8.04492C15.9918 8.04492 16.022 8.05591 16.0476 8.08254C16.0738 8.10986 16.0919 8.15111 16.0919 8.19817V8.8294V9.26727L16.526 9.32503C17.6272 9.47157 18.6436 10.0324 19.3821 10.9084C20.121 11.7848 20.5297 12.9155 20.5268 14.0884V14.0896V16.5069V16.5248L20.5281 16.5427C20.5915 17.427 20.8239 18.2899 21.2123 19.0809L21.2232 19.1031L21.2362 19.1241C21.5888 19.6925 22.0138 20.2094 22.5 20.6606Z"
                                            stroke="#0072B1" />
                                    </svg>
                                </div>
                                <div class="inbox-profile-detail">
                                    <span style="color: rgba(0, 0, 0, 0.90) !important; ">
                                        Learn all the Dos and Don’ts of Dream Crowd at our May 16th
                                        Community Standards webinar. Register Now
                                    </span>
                                </div>
                            </div>
                            <span>1 Weeks</span>
                        </div>
                        <div class="inbox-drop-footer">
                            <span> See All </span>
                        </div>
                    </div>
                </div>
            </li>

            <!--MAIL SVG START  -->
            <li class="nav-item dropdown dropdown-mega position-static">
                <a style="padding-left:10px !important ;" class="nav-link dropdown-toggle p-0" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <svg class="me-2" width="40" height="32" viewBox="0 0 40 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.5 13.9218V13.0474L29.7464 13.4908L16.2548 21.4306C16.2547 21.4306 16.2547 21.4307 16.2546 21.4307C16.1909 21.4681 16.1197 21.4909 16.0461 21.4974C15.978 21.5035 15.9095 21.4955 15.8447 21.4741L15.7244 21.4184L2.2535 13.4948L1.5 13.0516V13.9258V26.9998C1.5 27.928 1.86875 28.8183 2.52513 29.4746C3.1815 30.131 4.07174 30.4998 5 30.4998H27C27.9283 30.4998 28.8185 30.131 29.4749 29.4746C30.1312 28.8183 30.5 27.928 30.5 26.9998V13.9218ZM1.5 11.6038V11.8897L1.74647 12.0347L15.7465 20.2707L16.0001 20.4199L16.2536 20.2707L30.2536 12.0307L30.5 11.8856V11.5998V10.9998C30.5 10.0715 30.1312 9.18126 29.4749 8.52488C28.8185 7.8685 27.9283 7.49976 27 7.49976H5C4.07174 7.49976 3.1815 7.8685 2.52513 8.52488C1.86875 9.18126 1.5 10.0715 1.5 10.9998V11.6038ZM27 6.49976C28.1935 6.49976 29.3381 6.97386 30.182 7.81778C31.0259 8.66169 31.5 9.80628 31.5 10.9998V26.9998C31.5 28.1932 31.0259 29.3378 30.182 30.1817C29.3381 31.0257 28.1935 31.4998 27 31.4998H5C3.80653 31.4998 2.66193 31.0257 1.81802 30.1817C0.974106 29.3378 0.5 28.1932 0.5 26.9998V10.9998C0.5 9.80628 0.974106 8.66169 1.81802 7.81778C2.66193 6.97386 3.80653 6.49976 5 6.49976H27Z"
                            stroke="#181818" />
                        <ellipse cx="32" cy="8.49976" rx="8" ry="8.5" fill="#0072B1" />
                        <path
                            d="M34.1855 10.0613C34.1855 10.504 34.083 10.8767 33.8779 11.1794C33.6729 11.4822 33.3929 11.7117 33.0381 11.8679C32.6865 12.0209 32.2894 12.0974 31.8467 12.0974C31.404 12.0974 31.0052 12.0209 30.6504 11.8679C30.2956 11.7117 30.0156 11.4822 29.8105 11.1794C29.6055 10.8767 29.5029 10.504 29.5029 10.0613C29.5029 9.76831 29.5599 9.50301 29.6738 9.26538C29.7878 9.0245 29.9489 8.81779 30.1572 8.64526C30.3688 8.46948 30.6162 8.33439 30.8994 8.23999C31.1859 8.14559 31.4984 8.09839 31.8369 8.09839C32.2861 8.09839 32.6882 8.1814 33.043 8.34741C33.3978 8.51343 33.6761 8.74292 33.8779 9.03589C34.083 9.32886 34.1855 9.67065 34.1855 10.0613ZM33.0039 10.0027C33.0039 9.76506 32.9551 9.55672 32.8574 9.37769C32.7598 9.19865 32.623 9.0603 32.4473 8.96265C32.2715 8.86499 32.068 8.81616 31.8369 8.81616C31.6025 8.81616 31.3991 8.86499 31.2266 8.96265C31.054 9.0603 30.9189 9.19865 30.8213 9.37769C30.7269 9.55672 30.6797 9.76506 30.6797 10.0027C30.6797 10.2436 30.7269 10.4519 30.8213 10.6277C30.9157 10.8002 31.0508 10.932 31.2266 11.0232C31.4023 11.1143 31.609 11.1599 31.8467 11.1599C32.0843 11.1599 32.2894 11.1143 32.4619 11.0232C32.6344 10.932 32.7679 10.8002 32.8623 10.6277C32.9567 10.4519 33.0039 10.2436 33.0039 10.0027ZM34.0244 6.7605C34.0244 7.11532 33.93 7.43107 33.7412 7.70776C33.5557 7.98446 33.2985 8.20256 32.9697 8.36206C32.641 8.51831 32.2666 8.59644 31.8467 8.59644C31.4235 8.59644 31.0459 8.51831 30.7139 8.36206C30.3851 8.20256 30.1263 7.98446 29.9375 7.70776C29.752 7.43107 29.6592 7.11532 29.6592 6.7605C29.6592 6.33732 29.752 5.98088 29.9375 5.69116C30.1263 5.39819 30.3851 5.17521 30.7139 5.02222C31.0426 4.86922 31.4186 4.79272 31.8418 4.79272C32.265 4.79272 32.641 4.86922 32.9697 5.02222C33.2985 5.17521 33.5557 5.39819 33.7412 5.69116C33.93 5.98088 34.0244 6.33732 34.0244 6.7605ZM32.8477 6.79956C32.8477 6.58797 32.8053 6.40243 32.7207 6.24292C32.6393 6.08016 32.5238 5.95321 32.374 5.86206C32.2243 5.77091 32.0469 5.72534 31.8418 5.72534C31.6367 5.72534 31.4593 5.76929 31.3096 5.85718C31.1598 5.94507 31.0443 6.06877 30.9629 6.22827C30.8815 6.38778 30.8408 6.57821 30.8408 6.79956C30.8408 7.01766 30.8815 7.20809 30.9629 7.37085C31.0443 7.53035 31.1598 7.65568 31.3096 7.74683C31.4626 7.83797 31.6416 7.88354 31.8467 7.88354C32.0518 7.88354 32.2292 7.83797 32.3789 7.74683C32.5286 7.65568 32.6442 7.53035 32.7256 7.37085C32.807 7.20809 32.8477 7.01766 32.8477 6.79956Z"
                            fill="white" />
                    </svg>
                </a>
                <div class="dropdown-menu">
                    <div class="navbar-inbox-dropdawon">
                        <div class="dropDawon-head">
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="25" viewBox="0 0 31 25" fill="none">
                                <path
                                    d="M29.5625 7.61731V6.7462L28.8103 7.18556L15.7404 14.8199C15.7403 14.82 15.7401 14.8201 15.74 14.8201C15.6802 14.8549 15.6131 14.8763 15.5436 14.8824C15.4795 14.8881 15.415 14.8807 15.3541 14.8608L15.2389 14.8078L2.18959 7.18936L1.4375 6.75027V7.62115V20.1923C1.4375 21.0912 1.79729 21.9525 2.43649 22.5869C3.07557 23.2212 3.94156 23.5769 4.84375 23.5769H26.1562C27.0584 23.5769 27.9244 23.2212 28.5635 22.5869C29.2027 21.9525 29.5625 21.0912 29.5625 20.1923V7.61731ZM1.4375 5.38846V5.6755L1.68538 5.82024L15.2479 13.7395L15.5001 13.8867L15.7522 13.7394L29.3147 5.81634L29.5625 5.67159V5.38462V4.80769C29.5625 3.90883 29.2027 3.04753 28.5635 2.41309C27.9244 1.77877 27.0584 1.42308 26.1562 1.42308H4.84375C3.94156 1.42308 3.07557 1.77877 2.43649 2.41309C1.79729 3.04753 1.4375 3.90883 1.4375 4.80769V5.38846ZM26.1562 0.5C27.3095 0.5 28.4147 0.954745 29.2291 1.76301C30.0433 2.57115 30.5 3.66643 30.5 4.80769V20.1923C30.5 21.3336 30.0433 22.4288 29.2291 23.237C28.4147 24.0453 27.3095 24.5 26.1562 24.5H4.84375C3.69052 24.5 2.58526 24.0453 1.77093 23.237C0.956729 22.4288 0.5 21.3336 0.5 20.1923V4.80769C0.5 3.66643 0.956729 2.57115 1.77093 1.76301C2.58526 0.954745 3.69052 0.5 4.84375 0.5H26.1562Z"
                                    stroke="#181818" />
                            </svg>
                            <h4>
                                Inbox
                            </h4>
                            <span> (5)</span>
                        </div>
                        <div class="empty"></div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1>.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1 style="color: #D2D2D2 !important;">.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1>.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1 style="color: #D2D2D2 !important;">.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1>.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="message-section">
                            <div class="dropDawon-profile-section">
                                <div class="inbox-profile-img">
                                    <h1 style="color: #D2D2D2 !important;">.</h1>
                                    <img src="assets/public-site/asset/img/Ellipse 329.png" alt="">
                                </div>
                                <div class="inbox-profile-detail">
                                    <h5>alice_529</h5>
                                    <span>
                                        Me: ?
                                    </span>
                                </div>
                            </div>
                            <span>2 Weeks</span>
                        </div>
                        <div class="inbox-drop-footer">
                            <span> See All in Inbox</span>
                        </div>
                    </div>
                </div>
            </li>
            <!-- PROFILE SECTION START HERE -->


            <div class="nav-profile">
                  
                  
                @if (Auth::user())
                @if (Auth::user()->profile == null)
                @php  $firstLetter = strtoupper(substr(Auth::user()->first_name, 0, 1));  @endphp
                
                <div class="img_profile">
               <img src="assets/profile/avatars/({{$firstLetter}}).jpg"> 
              </div>  
              @else
              <div class="img_profile" style="width: 50px; height: 50px;">
                <img src="assets/profile/img/{{Auth::user()->profile}}" style="width: 100%; height: 100%;"> 
              </div>  
                   
               @endif
               @endif
                  @if (Auth::user()) <h1>{{Auth::user()->first_name}}</h1> @endif
                  <div class="dropdown">
                    <button
                      class="dropdown-toggle dashboard-drop"
                      type="button"
                      id="dropdownMenuButton11"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="35"
                        height="35"
                        viewBox="0 0 35 35"
                        fill="none"
                      >
                        <path
                          d="M5.83333 18.9583H14.5833C14.9701 18.9583 15.341 18.8047 15.6145 18.5312C15.888 18.2577 16.0417 17.8868 16.0417 17.5V5.83333C16.0417 5.44656 15.888 5.07563 15.6145 4.80214C15.341 4.52865 14.9701 4.375 14.5833 4.375H5.83333C5.44656 4.375 5.07563 4.52865 4.80214 4.80214C4.52865 5.07563 4.375 5.44656 4.375 5.83333V17.5C4.375 17.8868 4.52865 18.2577 4.80214 18.5312C5.07563 18.8047 5.44656 18.9583 5.83333 18.9583ZM4.375 29.1667C4.375 29.5534 4.52865 29.9244 4.80214 30.1979C5.07563 30.4714 5.44656 30.625 5.83333 30.625H14.5833C14.9701 30.625 15.341 30.4714 15.6145 30.1979C15.888 29.9244 16.0417 29.5534 16.0417 29.1667V23.3333C16.0417 22.9466 15.888 22.5756 15.6145 22.3021C15.341 22.0286 14.9701 21.875 14.5833 21.875H5.83333C5.44656 21.875 5.07563 22.0286 4.80214 22.3021C4.52865 22.5756 4.375 22.9466 4.375 23.3333V29.1667ZM18.9583 29.1667C18.9583 29.5534 19.112 29.9244 19.3855 30.1979C19.659 30.4714 20.0299 30.625 20.4167 30.625H29.1667C29.5534 30.625 29.9244 30.4714 30.1979 30.1979C30.4714 29.9244 30.625 29.5534 30.625 29.1667V18.9583C30.625 18.5716 30.4714 18.2006 30.1979 17.9271C29.9244 17.6536 29.5534 17.5 29.1667 17.5H20.4167C20.0299 17.5 19.659 17.6536 19.3855 17.9271C19.112 18.2006 18.9583 18.5716 18.9583 18.9583V29.1667ZM20.4167 14.5833H29.1667C29.5534 14.5833 29.9244 14.4297 30.1979 14.1562C30.4714 13.8827 30.625 13.5118 30.625 13.125V5.83333C30.625 5.44656 30.4714 5.07563 30.1979 4.80214C29.9244 4.52865 29.5534 4.375 29.1667 4.375H20.4167C20.0299 4.375 19.659 4.52865 19.3855 4.80214C19.112 5.07563 18.9583 5.44656 18.9583 5.83333V13.125C18.9583 13.5118 19.112 13.8827 19.3855 14.1562C19.659 14.4297 20.0299 14.5833 20.4167 14.5833Z"
                          fill="#181818"
                        />
                      </svg>
                    </button>
                    <ul
                      class="dropdown-menu dropdown-menu-lg-end dropdown-menu-sm-start logout-dropdawon"
                      aria-labelledby="dropdownMicroProcessorTrigger"
                    >
                      <li>

                        @if (Auth::user()->role == 0)
                        <a class="dropdown-item" href="/user-dashboard">
                            <i class="bx bxs-grid-alt"></i> &nbsp;Full Dashboard</a>
                            @elseif(Auth::user()->role == 1)
                            <a class="dropdown-item" href="/teacher-dashboard">
                                <i class="bx bxs-grid-alt"></i> &nbsp;Full Dashboard</a>
                            @elseif(Auth::user()->role == 2)
                            <a class="dropdown-item" href="/admin-dashboard">
                                <i class='bx bxs-grid-alt'></i> &nbsp;Full Dashboard</a>
                        @endif
                        {{-- <a class="dropdown-item" href="#">
                          <i class="bx bxs-grid-alt"></i> &nbsp;&nbsp;Full
                          Dashboard</a > --}}
                      </li>
                          <li>
                  <a class="dropdown-item" href="/profile">
                    <i class="bx bx-user icon"></i> &nbsp;&nbsp;Profile</a
                  >
                </li>
                      @if (Auth::user())
                      @php
                      $expert = \App\Models\ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>1])->first();
                  @endphp
  
                      @if ($expert)
                      
                  @if (Auth::user()->role == 1)
                  <li>
                    <a class="dropdown-item" href="/switch-account">
                      <i class="bx bx-recycle"></i>&nbsp;&nbsp;Switch To Buyer
                      Account
                    </a>
                  </li>
                  @elseif(Auth::user()->role == 0)
                  <li>
                    <a class="dropdown-item" href="/switch-account">
                      <i class="bx bx-recycle"></i>&nbsp;&nbsp;Switch To Saller
                      Account
                    </a>
                  </li>
                  @endif
                  @endif 
                          
                      @endif
                      <li>
                        <a class="dropdown-item" href="#">
                          <i class="fa-brands fa-dribbble"></i>&nbsp;&nbsp;Help &
                          Support</a
                        >
                      </li>
                      <li>
                        <a class="dropdown-item" href="/logout">
                          <i class="bx bx-log-in"></i>&nbsp;&nbsp;Log Out</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>


            <!-- PROFILE SECTION START HERE -->


            {{-- <div class="profile-sec">
                <p class="mb-0">
                    @if (Auth::user())
                     @if (Auth::user()->profile == null)
                    @php  $firstLetter = strtoupper(substr(Auth::user()->first_name, 0, 1));  @endphp
                    
                      <div class="img_profile" style="width: 50px; height: 50px;">
                          <img src="assets/profile/avatars/({{$firstLetter}}).jpg">  
                      </div>
                      @if (Auth::user()) <h1>{{Auth::user()->first_name}}</span> @endif
                    @else
                    <div class="img_profile" style="width: 50px; height: 50px;">
                        <img src="assets/profile/img/{{Auth::user()->profile}}"> 
                    </div>
                    @if (Auth::user()) <h1>{{Auth::user()->first_name}}</span> @endif 
                        
                    @endif
                    @endif
                </p>
            </div>  --}}
            {{-- <img src="assets/public-site/asset/img/dashboard.png" class="btn dropdown-toggle dash-img" type="button" id="dropdownMicroProcessorTrigger" data-bs-toggle="dropdown" aria-expanded="false"> --}}
            
            {{-- <ul class="dropdown-menu dropdown-menu-lg-end dropdown-menu-sm-start logout-dropdawon" aria-labelledby="dropdownMicroProcessorTrigger">
                <li>
                    @if (Auth::user()->role == 0)
                    <a class="dropdown-item" href="/user-dashboard">
                        <i class="bx bxs-grid-alt"></i> &nbsp;Full Dashboard</a>
                        @elseif(Auth::user()->role == 1)
                        <a class="dropdown-item" href="/teacher-dashboard">
                            <i class="bx bxs-grid-alt"></i> &nbsp;Full Dashboard</a>
                        @elseif(Auth::user()->role == 2)
                        <a class="dropdown-item" href="/admin-dashboard">
                            <i class='bx bxs-grid-alt'></i> &nbsp;Full Dashboard</a>
                    @endif
                    
                </li>
                @if (Auth::user())
                
                @php
                    $expert = \App\Models\ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>1])->first();
                @endphp

                    @if ($expert)
                    
                @if (Auth::user()->role == 1)
                <li>
                  <a class="dropdown-item" href="/switch-account">
                    <i class="bx bx-recycle"></i>&nbsp;&nbsp;Switch To Buyer
                    Account
                  </a>
                </li>
                @elseif(Auth::user()->role == 0)
                <li>
                  <a class="dropdown-item" href="/switch-account">
                    <i class="bx bx-recycle"></i>&nbsp;&nbsp;Switch To Saller
                    Account
                  </a>
                </li>
                @endif
                @endif 
                    
                @endif
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fa-brands fa-dribbble"></i>&nbsp;Help & Support</a>
                </li>
                <li>
                    <a class="dropdown-item" href="/logout">
                        <i class='bx bx-log-in'></i>&nbsp;Log Out</a>
                </li>
            </ul> --}}


                
            @endif


      
    
    
    
    
    </div>
      </div>
    </div>
  </nav>








     <!--  Login Modal  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-section">
            <div class="modal-header p-0 border-0">
                <h5 class="modal-title text-center" id="exampleModalLabel">Log In to Your Account
                </h5>
            </div>
            <div class="modal-body p-0 border-0">
                <form class="login-signup-form" method="POST" action="/login">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="control-label login-signup-label">Email</label>
                        <div class="">
                            <input type="email" id="login_email" class="form-control place" name="email" @if (isset($_COOKIE["email"])) value="{{ $_COOKIE["email"] }}"  @endif placeholder="Example@gmail.com" required>
                            <p id="log_error_email" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                            </div>
                    </div>
                    <div class="login/signup-password">
                        <label class="control-label">Password</label>
                        <div class="">
                            <input id="login_password" type="password" class="form-control place" name="password" @if (isset($_COOKIE["password"])) value="{{ $_COOKIE["password"] }}"  @endif placeholder="Password" required>
                            <span toggle="#login_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <p id="log_error_password" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                        </div>
                    </div>
                    <div class="form-check form-checkbox">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember_login">
                        <label class="form-check-pass" for="exampleCheck1">Remember
                            Password</label>
                        <a  id="forgot-password" style="cursor: pointer;" class="forget-password float-end fst-italic text-decoration-none">Forgot
                            Password?</a>
                    </div>
                    <div class="sign-up">
                 <p class="text-danger" id="login-error" style="font-size: 15px;font-weight: 600; margin-top: 5px; display: none;"></p>
                    </div>
                    <button type="button" onclick="LogInUser(this.id)" id="LoginBtn" class="loginbtn">Log In</button>
                    <div id="LoginloadingSpinner" class="loading-spinner"></div>
                </form>
                <div class="separator">OR</div>
            </div>
            <div class="modal-footer border-0">
                <div class="row buttonssignin">
                    <div class="col-md-6 col-6 signin">
                            <form action="/google/redirect" method="GET">
                                <button type="submit"  name="google_action" value="login" >
                                    <img src="assets/public-site/asset/img/google.png" alt=""> &nbsp;&nbsp;Sign in with
                                    google</button>
                                </form>
                            </div>
                            <div class="col-md-6 col-6 signins">
                                <form action="/facebook/redirect" method="GET">
                                    <button type="submit"  name="facebook_action" value="login">
                                        <img src="assets/public-site/asset/img/facebook.png" alt=""> &nbsp;&nbsp;Sign in with
                                        facebook</button>
                                    </form>
                    </div>
                </div>
                <p class="last-section text-center">Didn’t Have an Account? <a style="cursor: pointer;" class="link signup_model" id="signup-link"> Signup</a></p>
            </div>
        </div>
    </div>
</div>



                        <!-- Register Modal -->
                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-signup">
                                <div class="modal-content modal-section">
                                    <div class="modal-header p-0 border-0">
                                        <h5 class="modal-title text-center" id="exampleModalLabel1">Create New Account
                                        </h5>
                                    </div>
                                    <div class="modal-body p-0 border-0">
                                        <form class="login-signup-form" method="POST" action="/create-account">
                                            @csrf
                                            <div class="mb-3">
                                                <div class="row">
                                                 <div class="col-md-6">
                                                     <label class="control-label login-signup-label mt-4">First Name</label>
                                                         <input type="text" id="add_first_name" class="form-control place" name="first_name" value="" placeholder="Usama" required>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <label class="control-label login-signup-label mt-4">Last Name</label>
                                                             <input type="text" id="add_last_name" class="form-control place" name="last_name" value="" placeholder="Aslam" required>
                                                         </div>
                                                </div>
                                             </div>
                                            <div class="">
                                                <label class="control-label login-signup-label">Email</label>
                                                <div class="">
                                                    <input type="email" id="add_email" class="form-control place mb-3" name="email" value="" placeholder="Example@gmail.com" required>
                                                    <p id="add_error_email" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                    
                                                </div>
                                            </div>
                                            <div class="mb-3 login-signup-password">
                                                <label class="control-label">Password</label>
                                                <div class="">
                                                    <input id="add_password" type="password" class="form-control place" name="password" value="" placeholder="Password" required>
                                                    <span toggle="#add_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                    <p id="add_error_password" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                    <div id="passwordPopup" class="password-popup">
                                                        <ul>
                                                            <li id="length">At least 8 characters</li>
                                                            <li id="capital">At least one uppercase letter</li>
                                                            <li id="number">At least one number</li>
                                                            <li id="special">At least one special character</li>
                                                        </ul>
                                                    </div>
                                                    <style>
                                                          .password-popup {
                                                            display: none;
                                                            position: absolute;
                                                            top: 130px;
                                                            left: 100px;
                                                            background-color: #f9f9f9;
                                                            border: 1px solid #ccc;
                                                            border-radius: 10px ;
                                                            padding: 10px;
                                                            width: max-content;
                                                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                                                        }
                                                        .password-popup ul {
                                                            list-style: none;
                                                            padding: 0;
                                                            margin: 0;
                                                        }
                                                        .password-popup ul li {
                                                            font-size: 10px ;
                                                            margin-bottom: 5px;
                                                            color: #ff0000; /* Red color for unfulfilled criteria */
                                                        }
                                                        .password-popup ul li.valid {
                                                            color: #00cc00; /* Green color for fulfilled criteria */
                                                        }
                                                    </style>
                                                </div>
                                            </div>
                                            <div class="mb-3 login-signup-password">
                                                <label class="control-label">Confirm Password</label>
                                                <div class="">
                                                    <input id="add_c_password" type="password" class="form-control place" name="c_password" value="" placeholder="Password" required>
                                                    <span toggle="#add_c_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                    <p id="add_error_c_password" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                    
                                                </div>
                                            </div>
                                            <div class="sign-up">
                                                <p>Signing up you agree <a href="/term-condition"><span>Terms &
                                                            Condition </span></a>and <a href="/privacy"><span>
                                                            Privacy Policy</span></a></p>
                                         <p class="text-danger" id="signup-error" style="font-size: 15px;font-weight: 600; margin-top: 5px; display: none;"></p>
                                            </div>
                                            <button type="button" onclick="RegisterUser(this.id)" id="SignUpBtn" class="loginbtn">Register</button>
                                            <div id="SignuploadingSpinner" class="loading-spinner"></div>
                                        </form>
                                        <div class="separator">OR</div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <div class="row">
                                            <div class="col-md-6 col-6 signin">
                                                <form action="/google/redirect" method="GET">
                                                    <button type="submit"  name="google_action" value="signup" >
                                                        <img src="assets/public-site/asset/img/google.png" alt=""> &nbsp;&nbsp;Sign in with
                                                        google</button>
                                                    </form>
                                                </div>
                                                <div class="col-md-6 col-6 signins">
                                                    <form action="/facebook/redirect" method="GET">
                                                        <button type="submit"  name="facebook_action" value="signup">
                                                            <img src="assets/public-site/asset/img/facebook.png" alt=""> &nbsp;&nbsp;Sign in with
                                                            facebook</button>
                                                        </form>
                                            </div>
                                        </div>
                                        <p class="last-section text-center">Already Have an Account? <a style="cursor: pointer;"  class="link login_model" id="login-link"> Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Forget Password Modal -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-signup">
                                <div class="modal-content modal-section">
                                    <div class="modal-header p-0 border-0">
                                        <h5 class="modal-title text-center" id="exampleModalLabel1">Forgot Password
                                        </h5>
                                    </div>
                                    <div class="modal-body p-0 border-0">
                                        <form class="login-signup-form" method="POST" action="/forgot-password">
                                            @csrf
                                             
                                            <div class="">
                                                <label class="control-label login-signup-label">Email</label>
                                                <div class="">
                                                    <input type="email" id="forgot_email" class="form-control place mb-3" name="email" value="" placeholder="Example@gmail.com" required>
                                                    <p id="forgot_error_email" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                    
                                                </div>
                                            </div>
                                            <div class="sign-up">
                                         <p class="text-danger" id="forgot-error" style="font-size: 15px;font-weight: 600; margin-top: 5px; display: none;"></p>
                                            </div>
                                          
                                            <button type="button" onclick="ForgotPassword(this.id)" id="ForgotBtn" class="loginbtn">Forgot Password</button>
                                            <div id="ForgotloadingSpinner" class="loading-spinner"></div>
                                        </form>
                                        
                                    </div>
                                    <div class="modal-footer border-0">
                                      <p class="last-section text-center">Goto LogIn? <a style="cursor: pointer;"  class="link login_model" id="login-link"> Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                             <!-- Forget Password Modal -->
                             <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-signup">
                                    <div class="modal-content modal-section">
                                        <div class="modal-header p-0 border-0">
                                            <h5 class="modal-title text-center" id="exampleModalLabel1">Update Password
                                            </h5>
                                        </div>
                                        <div class="modal-body p-0 border-0">
                                            <form class="login-signup-form" method="POST" action="/new-forgot-password">
                                                @csrf
                                                 
                                                <div class="">
                                                    <label class="control-label login-signup-label">New Password</label>
                                                    <div class="">
                                                        <input type="hidden" class="form-control place mb-3" id="new_password_id" name="id" value="{{ session('newPass') }}" placeholder="xxxxxxxx" required>
                                                        <input id="new_password" type="password"  class="form-control place mb-3" name="password" value="" placeholder="xxxxxxxx" required>
                                                        <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"  style="margin-top: -43px;"></span>
                                                        <p id="new_error_password" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                        <div id="new_passwordPopup" class="password-popup" style="top: 73px; left: 140px;">
                                                            <ul>
                                                                <li id="new_length">At least 8 characters</li>
                                                                <li id="new_capital">At least one uppercase letter</li>
                                                                <li id="new_number">At least one number</li>
                                                                <li id="new_special">At least one special character</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                 
                                                <div class="">
                                                    <label class="control-label login-signup-label">Confirm Password</label>
                                                    <div class="">
                                                        <input id="new_c_password" type="password"  class="form-control place mb-3" name="password" value="" placeholder="xxxxxxxx" required>
                                                        <span toggle="#new_c_password" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-top: -43px;"></span>
                                                        <p id="new_error_c_password" class="text-danger" style="font-size: 13px; margin-top: 3px; margin-left: 3px; font-weight: 600;"></p>
                                                   </div>
                                                </div>
                                       
                                                <div class="sign-up">
                                                    <p class="text-danger" id="new-password-error" style="font-size: 15px;font-weight: 600; margin-top: 5px; display: none;"></p>
                                                       </div>
                                               
                                                <button type="button" onclick="NewPassword(this.id)" id="NewPassBtn" class="loginbtn">Update Password</button>
                                                <div id="NewPassloadingSpinner" class="loading-spinner"></div>
                                            </form>
                                            
                                        </div>
                                        <div class="modal-footer border-0">
                                          <p class="last-section text-center">Goto LogIn? <a style="cursor: pointer;"  class="link login_model" id="login-link"> Login</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


    {{-- On Focus Password Requirement Script Start --}}
    <script>
        // Select elements
        const passwordInput = document.getElementById('add_password');
        const passwordPopup = document.getElementById('passwordPopup');
    
        const lengthCriteria = document.getElementById('length');
        const capitalCriteria = document.getElementById('capital');
        const numberCriteria = document.getElementById('number');
        const specialCriteria = document.getElementById('special');
    
        // Show popup on focus
        passwordInput.addEventListener('focus', () => {
            passwordPopup.style.display = 'block';
        });
    
        // Hide popup on blur
        passwordInput.addEventListener('blur', () => {
            passwordPopup.style.display = 'none';
        });
    
        // Validate password on input
        passwordInput.addEventListener('input', () => {
            const passwordValue = passwordInput.value;
    
            // Validate length (at least 8 characters)
            if (passwordValue.length >= 8) {
                lengthCriteria.classList.add('valid');
            } else {
                lengthCriteria.classList.remove('valid');
            }
    
            // Validate capital letter
            if (/[A-Z]/.test(passwordValue)) {
                capitalCriteria.classList.add('valid');
            } else {
                capitalCriteria.classList.remove('valid');
            }
    
            // Validate number
            if (/[0-9]/.test(passwordValue)) {
                numberCriteria.classList.add('valid');
            } else {
                numberCriteria.classList.remove('valid');
            }
    
            // Validate special character
            if (/[\W_]/.test(passwordValue)) { // \W matches any non-word character
                specialCriteria.classList.add('valid');
            } else {
                specialCriteria.classList.remove('valid');
            }
        });


        // Select elements
        const new_passwordInput = document.getElementById('new_password');
        const new_passwordPopup = document.getElementById('new_passwordPopup');
    
        const new_lengthCriteria = document.getElementById('new_length');
        const new_capitalCriteria = document.getElementById('new_capital');
        const new_numberCriteria = document.getElementById('new_number');
        const new_specialCriteria = document.getElementById('new_special');
    
        // Show popup on focus
        new_passwordInput.addEventListener('focus', () => {
            new_passwordPopup.style.display = 'block';
        });
    
        // Hide popup on blur
        new_passwordInput.addEventListener('blur', () => {
            new_passwordPopup.style.display = 'none';
        });
    
        // Validate password on input
        new_passwordInput.addEventListener('input', () => {
            const new_passwordValue = new_passwordInput.value;
    
            // Validate length (at least 8 characters)
            if (new_passwordValue.length >= 8) {
                new_lengthCriteria.classList.add('valid');
            } else {
                new_lengthCriteria.classList.remove('valid');
            }
    
            // Validate capital letter
            if (/[A-Z]/.test(new_passwordValue)) {
                new_capitalCriteria.classList.add('valid');
            } else {
                new_capitalCriteria.classList.remove('valid');
            }
    
            // Validate number
            if (/[0-9]/.test(new_passwordValue)) {
                new_numberCriteria.classList.add('valid');
            } else {
                new_numberCriteria.classList.remove('valid');
            }
    
            // Validate special character
            if (/[\W_]/.test(new_passwordValue)) { // \W matches any non-word character
                new_specialCriteria.classList.add('valid');
            } else {
                new_specialCriteria.classList.remove('valid');
            }
        });
    </script>
    {{-- On Focus Password Requirement Script END --}}

{{-- Register User Ajax Call Start ======== --}}
<script>

    $(document).ready(function () {

       
        const message = sessionStorage.getItem('showToaster');
        if (message) {
        // Show the toaster
        toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.success(message);

        // Remove the flag from sessionStorage to prevent the toaster from showing again
        sessionStorage.removeItem('showToaster');
        
    }
    
});
    
    // Register User =====
    function RegisterUser(Clicked) { 

        
        const button = document.getElementById(Clicked);
            const spinner = document.getElementById('SignuploadingSpinner');
            $(button).html('Waiting');
            button.disabled = true;
           spinner.style.display = 'inline-block';

        var first_name = $('#add_first_name').val();
        var last_name = $('#add_last_name').val();
        var email = $('#add_email').val();
        var password = $('#add_password').val();
        var c_password = $('#add_c_password').val();

        $('#add_error_email').html('');
        $('#add_error_password').html('');
        $('#add_error_c_password').html('');

        
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/create-account',
                data:{ first_name:first_name, last_name:last_name, email:email, password:password, c_password:c_password, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                    $(button).html('Register');
                button.disabled = false;
                spinner.style.display = 'none';
                
                    if (response.error) {
                        
                        if (response.geterror != '') {
                            $('#add_error_'+response.geterror).css('display', 'block');
                            $('#add_error_'+response.geterror).html(response.message);
                        } else {
                            $('#signup-error').css('display', 'block');
                        $('#signup-error').html(response.message);
                        }
                        
                    }else if(response.success){
                        sessionStorage.setItem('showToaster', response.message);
                        window.location.reload();
                    }
                },
              
            });


     }

     
    
    // Login User =====
    function LogInUser(Clicked) { 

        const button = document.getElementById(Clicked);
            const spinner = document.getElementById('LoginloadingSpinner');
            $(button).html('Waiting');
            button.disabled = true;
           spinner.style.display = 'inline-block';

          
 
        var remember = $('#remember_login').val();
        var email = $('#login_email').val();
        var password = $('#login_password').val();
        var remember = $('input[name="remember"]').is(':checked');
        
        $('#log_error_email').html('');
        $('#log_error_password').html('');


        
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/login',
                data:{ email:email, password:password,  remember:remember, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                    $(button).html('Log In');
                button.disabled = false;
                spinner.style.display = 'none';

                    if (response.error) {
                        if (response.geterror != '') {
                            $('#log_error_'+response.geterror).css('display', 'block');
                            $('#log_error_'+response.geterror).html(response.message);
                        } else {
                        $('#login-error').css('display', 'block');
                        $('#login-error').html(response.message);
                        }
                    }else if(response.success){
                        
                       window.location.reload();
                    }
                },
              
            });


     }

     
    
    // Forgot Password =====
    function ForgotPassword(Clicked) { 

        const button = document.getElementById(Clicked);
            const spinner = document.getElementById('ForgotloadingSpinner');
            $(button).html('Waiting');
            button.disabled = true;
           spinner.style.display = 'inline-block';
 
        var email = $('#forgot_email').val();

        $('#forgot_error_email').html('');
        
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/forgot-password',
                data:{ email:email, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                      
                    $(button).html('Forgot Password');
                button.disabled = false;
                spinner.style.display = 'none';

                    if (response.error) {
                        if (response.geterror != '') {
                            $('#forgot_error_'+response.geterror).css('display', 'block');
                            $('#forgot_error_'+response.geterror).html(response.message);
                        } else {
                        $('#forgot-error').css('display', 'block');
                        $('#forgot-error').html(response.message);
                        }
                    }else if(response.success){
                        sessionStorage.setItem('showToaster', response.message);
                        window.location.reload();
                    }
                },
              
            });


     }

    
    // New Password =====
    function NewPassword(Clicked) { 
 
        const button = document.getElementById(Clicked);
            const spinner = document.getElementById('NewPassloadingSpinner');
            $(button).html('Waiting');
            button.disabled = true;
           spinner.style.display = 'inline-block';

        var id = $('#new_password_id').val();
        var password = $('#new_password').val();
        var c_password = $('#new_c_password').val();
 
        $('#new_error_password').html('');
        $('#new_error_c_password').html('');

        
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/new-forgot-password',
                data:{ id:id, password:password, c_password:c_password, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                    
                    $(button).html('Update Password');
                button.disabled = false;
                spinner.style.display = 'none';


                    if (response.error) {
                        if (response.geterror != '') {
                            $('#new_error_'+response.geterror).css('display', 'block');
                            $('#new_error_'+response.geterror).html(response.message);
                        } else {
                        $('#new-password-error').css('display', 'block');
                        $('#new-password-error').html(response.message);
                        }
                    }else if(response.success){
                        sessionStorage.setItem('showToaster', response.message);
                        window.location.reload();
                    }
                },
              
            });


     }



</script>
    {{-- Register User Ajax Call END ======== --}}


<script>
   $(document).ready(function() {
        // Event delegation for login and signup links within modals
        $(document).on('click', '#login-link', function(e) {
            e.preventDefault();
            $('#exampleModal').modal('show');
            $('#exampleModal1').modal('hide'); // Hide the signup modal if shown
            $('#exampleModal2').modal('hide'); // Hide the signup modal if shown
            $('#exampleModal3').modal('hide'); // Hide the signup modal if shown
        });
        // Event delegation for login and signup links within modals
        $(document).on('click', '#forgot-password', function(e) {
            e.preventDefault();
            $('#exampleModal2').modal('show');
            $('#exampleModal').modal('hide'); // Hide the signup modal if shown
        });

        $(document).on('click', '#signup-link', function(e) {
            e.preventDefault();
            $('#exampleModal1').modal('show');
            $('#exampleModal').modal('hide'); // Hide the login modal if shown
        });
    });
</script>


{{-- Keyword Suggession --}}

<script>
    const searchInput = document.getElementById('keyword_nav');
    const suggestionsBox = document.getElementById('suggestions_nav');

    searchInput.addEventListener('keyup', function() {
        const query = this.value.trim();
        
        
        if (query) {
           
            fetch(`/keywords?keyword=${query}`)
                .then(response => response.json())
                .then(keywords => { 
                    suggestionsBox.innerHTML = '';
                    if (keywords.length > 0) {
                        keywords.forEach(keyword => { 
                           
                            const div = document.createElement('div');
                            div.textContent = keyword;
                            div.onclick = function() {
                                searchInput.value = keyword;
                                suggestionsBox.style.display = 'none';
                            };
                            suggestionsBox.appendChild(div);
                        });
                        suggestionsBox.style.display = 'block';
                    } else {
                        suggestionsBox.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching keywords:', error));
        } else {
            suggestionsBox.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.search-container-nav')) {
            suggestionsBox.style.display = 'none';
        }
    });
</script>