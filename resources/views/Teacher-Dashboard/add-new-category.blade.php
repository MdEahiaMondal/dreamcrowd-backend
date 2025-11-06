<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8"> 
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
  
        {{-- =======Toastr CDN ======== --}}
        <link rel="stylesheet" type="text/css" 
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        {{-- =======Toastr CDN ======== --}}
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- file upload link -->
    <link
       href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
       rel="stylesheet"
       integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
       crossorigin="anonymous"
     />
    <!-- Defualt css -->
    <link rel=" stylesheet " type=" text/css " href="assets/teacher/asset/css/class-management.css" />
    <link rel=" stylesheet " href=" assets/teacher/asset/css/Learn-How.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">
</head>

<style>

 .btn-next {
    border-radius: 4px;
    background: #0072b1;
    padding: 8px 28px;
    color: #fff;
    font-family: Roboto;
    font-size: 20px;
    font-weight: 500;
    line-height: normal;
}
 .btn-back {
    border-radius: 4px;
    background: #fc5757;
    padding: 8px 28px;
    color: #fff;
    font-family: Roboto;
    font-size: 20px;
    font-weight: 500;
    line-height: normal;
}

.row .buttons-sec {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    flex-wrap: wrap;
    margin-top: calc(var(--bs-gutter-y)* -1);
    margin-right: calc(var(--bs-gutter-x)* -.5);
    margin-left: calc(var(--bs-gutter-x)* -.5);
}
</style>

<body>

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

 {{-- ===========Teacher Sidebar Start==================== --}}
 <x-teacher-sidebar/>
 {{-- ===========Teacher Sidebar End==================== --}}
 <section class="home-section">
    {{-- ===========Teacher NavBar Start==================== --}}
    <x-teacher-nav/>
    {{-- ===========Teacher NavBar End==================== --}}
        <!-- =============================== MAIN CONTENT START HERE =========================== -->
        <div class=" container-fluid ">
            <div class=" row dash-notification ">
                <div class=" col-md-12 ">
                    <nav style=" --bs-breadcrumb-divider: '>' ; " aria-label=" breadcrumb ">
                        <ol class=" breadcrumb mt-3 ">
                            <li class=" breadcrumb-item active " aria-current=" page ">Dashboard</li>
                            <li class=" breadcrumb-item ">Add New Category</li>
                        </ol>
                    </nav>

                    {{-- Change Service Type Start ===== --}}
                    
                    @if ($app->service_role != 'Both' || $app->service_type != 'Both')
                        
                   

                    <div class=" class-Menagent-Heading ">
                      <i class="bx bxs-graduation icon" title="Class Management"></i>
                        <span>Update Services</span>
                    </div>

                    <div class="col-md-12 add-category">
                      <form action="/teacher-update-service-type" method="POST" enctype="multipart/form-data"> @csrf
                        <div class="main-tab-sec mb-5">

                          @if ($app->service_role != 'Both')

                          <div class="col-md-12">
                            <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            style="margin-top: 0px !important"
                            >Service Role <span>*</span></label  > 

                          <select class="form-select" name="service_role"  >
                           
                            @if ($app->service_role == 'Class')
                            @if ($app->service_type != 'Both')
                            <option value="Class">Class</option>
                            @endif
                            <option value="Freelance">Freelance</option>
                            
                            @else
                            @if ($app->service_type != 'Both')
                            <option value="Freelance">Freelance</option>
                            @endif
                            <option value="Class">Class</option>
                                
                            @endif 

                          </select>
  
                          </div>
                              
                          @endif



                          @if ($app->service_type != 'Both')

                          <div class="col-md-12">
                            <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            style="margin-top: 0px !important"
                            >Service Type <span>*</span></label  > 

                          <select class="form-select" name="service_type"  >
                           
                            @if ($app->service_type == 'Online')
                            @if ($app->service_role != 'Both')
                            <option value="Online">Online</option>
                            @endif
                            <option value="Inperson">Inperson</option>
                            
                            @else
                            @if ($app->service_type != 'Both')
                            <option value="Inperson">Inperson</option>
                            @endif
                            <option value="Online">Online</option>
                                
                            @endif 

                          </select>
  
                          </div>
                              
                          @endif
                          
                          <button type="submit"    class="btn btn-next float-start mt-3">
                            Update
                          </button>

                       </div>
                      </form>
                    </div>

                    @endif
                    {{-- Change Service Type END ===== --}}

                    

                    <div class=" class-Menagent-Heading ">
                      <i class="bx bxs-graduation icon" title="Class Management"></i>
                        <span>Add New Category</span>
                    </div>
                    <!-- Blue MASSEGES section -->
                    <div class="col-md-12 add-category">
                      <form action="/teacher-add-category-request" method="POST" enctype="multipart/form-data"> @csrf

                      
                       <div class="main-tab-sec">
                        <div class="col-md-12">
                          <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          style="margin-top: 0px !important"
                          >Category Type <span>*</span></label
                        >
                        <input type="hidden" name="app_id" value="{{$app->id}}">
                        <input type="hidden" name="type" value="category">
                        <input type="hidden" name="service_type" id="service_type" value="{{$app->service_type}}">
                        <select class="form-select" name="service_role" onchange="ChangeServiceRole()" id="service_role">
                          @if ($app->service_role == 'Class')
                          <option selected value="Class">Class</option> 
                          
                          @elseif($app->service_role == 'Freelance')
                          <option selected value="Freelance">Freelance</option>
                          
                          @else
                          <option selected value="Class">Class</option>
                          
                          <option  value="Freelance">Freelance</option>
                          @endif
                        </select>

                        </div>


                       
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Category <span>*</span></label
                                >
                                <input type="hidden" name="category" id="FreelanceCateIds" >
                                <input type="hidden" name="cates_length" id="cates_length" >
                                <p class="text-danger" id="freelance_error" style="display: none;"></p>
                                <div class="dropdown">
                                  <button
                                    class="btn dropdown-toggle form-select"
                                    type="button"
                                    id="multiSelectDropdown2"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"  onclick="SelectFreelanceCategory()"
                                    style="text-align: left; overflow: hidden"
                                  >--select category--</button>
                                  <ul style="max-height: 200px; overflow-y: auto;"
                                    class="dropdown-menu multi-drop-select mt-2"
                                    aria-labelledby="multiSelectDropdown2"
                                  >
                                  <div class="row" id="FreelanceCategories">
                                      
                                    <div class="col-md-6" id="freelance_online_main_col"  style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                      <h4 class="form-label">Online</h4>
                                      <div class="row OnlineFreelance" id="freelanceOnlineContainer" >
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>
                                  
                                  

                                    <div class="col-md-6" id="freelance_inperson_main_col">
                                      <h4 class="form-label">Inperson</h4>
                                      <div class="row InpersonFreelance" id="freelanceInpersonContainer" >
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>

                                    {{-- <div class="col-md-3">
                                      <li class="multi-text-li">
                                        <label>
                                          <input
                                            type="checkbox"
                                            value="Website Development"
                                            class="cat1-input"
                                          />
                                          Website Development
                                        </label>
                                      </li>
                                    </div> --}}

                                  </div>
                                  </ul>
                                </div>
                              </div>
                            </div>

 
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category <span>*</span></label
                              >
                              <input type="hidden" name="sub_category" id="sub_category">
                              <p class="text-danger" id="sub_freelance_error" style="display: none;"></p>
                                <div class="dropdown">
                                <button
                                  class="btn dropdown-toggle form-select"
                                  type="button"
                                  id="multiSelectDropdown3"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false" onclick="SelectFreelanceCategorySub()"
                                  style="text-align: left; overflow: hidden"
                                >--select sub-category--</button>
                                <ul style="max-height: 200px; overflow-y: auto;"
                                  class="dropdown-menu multi-drop-select mt-2"
                                  aria-labelledby="multiSelectDropdown3"
                                >
                                <div class="row" id="FreelanceSubCategories">
                                    
                                    
                                  <div class="col-md-6" id="sub_freelance_online_main_col"  style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                    <h4 class="form-label">Online</h4>
                                    <div class="row SubOnlineFreelance" id="SubOnlineFreelance" >
                                      {{-- <div class="col-md-6">
                                        <li class="multi-text-li">
                                          <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                        </li>
                                      </div> --}}
                                    </div>
                                  </div>
                                
                                

                                  <div class="col-md-6" id="sub_freelance_inperson_main_col">
                                    <h4 class="form-label">Inperson</h4>
                                    <div class="row SubInpersonFreelance" id="SubInpersonFreelance">
                                      {{-- <div class="col-md-6">
                                        <li class="multi-text-li">
                                          <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                        </li>
                                      </div> --}}
                                    </div>
                                  </div>

                                  {{-- <div class="col-md-3">
                                    <li class="multi-text-li">
                                      <label>
                                        <input
                                          type="checkbox"
                                          value="Website Development"
                                          class="subcat1-input"
                                        />
                                        Website Development
                                      </label>
                                    </li>
                                  </div> --}}

                                </div>
                                </ul>
                              </div>
                            </div>


                       </div>

                       <div class="col-md-12">
                        <div class="">
                          <label
                          for="exampleFormControlInput1"
                          class="label-sec"
                          >Add Portfolio</label
                        >
                          <p class="desc">
                            Please provide a link to a website where we
                            can find some or all your portfolio samples.Or
                            you could provide a link to a website (Such as
                            LinkedIn or a service website) where we can
                            see some evidence of your work experience
                          </p>
                          <select
                          class="form-select" id="portfolio" name="portfolio"
                          aria-label="Default select example"
                        >
                          <option value="web_link" selected>I have a web link</option>
                          <option value="not_link" >I don't have any link</option>
                           
                        </select> 
                          
                        </div>
                      </div>
                      <div class="main" id="portfolio_url_div">
                        {{-- <div class="col-md-12 field_wrapper date-time" id="imageDiv">
                          <label class="form-label">URL <span>*</span></label>
                          <div class="d-flex">
                           
                            <input class="add-input form-control"
                              type="text"
                              name="field_name[]"
                              value="" id="url"
                              placeholder="https://bravemindstudio.com/" />
                            <a  href="javascript:void(0);"
                              class="ad_button"  onclick="AddPortfolioUrl()"
                              title="Add field" >
                              <img src="assets/expert/asset/img/add-input.svg" />
                            </a>
                          </div>
                          <div id="portfolio_all_links"></div>
                        </div> --}}
                      </div>

             

                          <div class="col-md-12 identity" id="upload-image" style="margin-bottom: 10px;">
                            <label for="inputAddress" class="form-label label-sec">Certification</label>
                            <div class="input-file-wrapper transition-linear-3 position-relative">
                              <span
                                class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                @click="reset('post-thumbnail')"
                                v-if="preview!==null"
                              >
                                Remove
                              </span>
                              <label
                                class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                for="post-thumbnail" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                              >
                                <span v-show="preview===null">
                                  <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px;  "></i>
                                  <span class="d-block" style="color: #0072b1; padding-top:3px;">Upload Image</span>
                                  <p>Drag and drop files here</p>
                                </span>
                                <template v-if="preview" style="height: 250px; width:100%">
                                  <img :src="preview" class="img-fluid mt-2" style="height: 220px" />
                                </template>
                              </label>
                              <input
                                type="file"   name="certificate"
                                accept="image/*" value=""
                                @change="previewImage('post-thumbnail')"
                                class="input-file"
                                id="post-thumbnail"
                              />
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="buttons-sec">
                                <a href="/teacher-profile" class="btn btn-back float-start" onclick="BackTab(this.id)"   data-tab="7" id="tab_back_btn_7">
                                  Back
                                </a>
                                <button type="submit" id="submit_cate_request"    class="btn btn-next float-end">
                                  Next
                                </button>
                              </div>
                            </div>
                          </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>
    </div>
    </div>

    <script src=" assets/teacher/libs/jquery/jquery.js "></script>
    <script src=" assets/teacher/libs/datatable/js/datatable.js "></script>
    <script src=" assets/teacher/libs/datatable/js/datatablebootstrap.js "></script>
    <script src=" assets/teacher/libs/select2/js/select2.min.js "></script>
    <!-- <script src=" assets/teacher/libs/owl-carousel/js/jquery.min.js "></script> -->
    <script src=" assets/teacher/libs/owl-carousel/js/owl.carousel.min.js "></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>

    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 1,
                margin: 30
            });
        })
    </script>
    <!-- ================ side js start here=============== -->

    {{-- Fetch CateGories Script Start =========== --}}
    <script>

        $(document).ready(function () {

          FetchCategory();
          });

          function ChangeServiceRole() { 
            $('#category').val('');
            $('#sub_category').val('');
            var cate_html = '--select category--';
            var sub_cate_html = '--select sub-category--';
            $('#multiSelectDropdown2').html(cate_html);
            $('#multiSelectDropdown3').html(sub_cate_html);
            FetchCategory();
           }

          function FetchCategory() { 

            
          var service_role =  $('#service_role').val();
          var service_type =  $('#service_type').val();
      

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                  });
      
                  $.ajax({
                      type: "post",
                      url: '/get-services-for-teacher',
                      data:{ service_role:service_role, service_type:service_type, _token: '{{csrf_token()}}'},
                      dataType: 'json',
                      success: function (response) {

                        var All_have_cates = response['have_all_cates'];
                      
                        if (All_have_cates != null) {
                          All_have_cates = All_have_cates.split(',');
                        var count_have_cates = All_have_cates.length;
                        } else { 
                        var count_have_cates = 0;
                        }
                        
                       
                      
                      $('#FreelanceCategories .OnlineFreelance').html('');  
                      $('#FreelanceCategories .InpersonFreelance').html('');  



if (response['service_type'] == 'Online') {

var len = 0;
if(response['services'] != null){
len = response['services'].length;
}
if (len > 0 ) {
 
$('#freelance_online_main_col').removeClass('col-md-6');
$('#freelance_online_main_col').addClass('col-md-12');
$('#freelance_online_main_col').css('border-right', '0');
$('#freelance_inperson_main_col').hide();
$('#freelance_online_main_col').show();
 
$('#sub_freelance_online_main_col').removeClass('col-md-6');
$('#sub_freelance_online_main_col').addClass('col-md-12');
$('#sub_freelance_online_main_col').css('border-right', '0');
$('#sub_freelance_inperson_main_col').hide();
$('#sub_freelance_online_main_col').show();




for (let i = 0; i < len; i++) {
var id = response['services'][i].id;
var category = response['services'][i].category;
var sub_category = response['services'][i].sub_category;
var service_role = response['services'][i].service_role;
var service_type = response['services'][i].service_type;
//  var show_cate = category.replace(/\s*\(.*?\)/g, '');
 

 

var content_div = '<div class="col-md-3">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"   data-have_cates= "'+count_have_cates+'" id="freelancecate_'+id+'" data-cate_id="'+id+'"  data-sub_category="'+sub_category+'"  data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .OnlineFreelance").append(content_div); 
 


}
}

} else if(response['service_type'] == 'Inperson'){

var len = 0;
if(response['services'] != null){
len = response['services'].length;
}
if (len > 0 ) {

 
$('#freelance_inperson_main_col').removeClass('col-md-6');
$('#freelance_inperson_main_col').addClass('col-md-12');
$('#freelance_online_main_col').hide();
$('#freelance_inperson_main_col').show();
 
$('#sub_freelance_inperson_main_col').removeClass('col-md-6');
$('#sub_freelance_inperson_main_col').addClass('col-md-12');
$('#sub_freelance_online_main_col').hide();
$('#sub_freelance_inperson_main_col').show();

for (let i = 0; i < len; i++) {
var id = response['services'][i].id;
var category = response['services'][i].category;
var sub_category = response['services'][i].sub_category;
var service_role = response['services'][i].service_role;
var service_type = response['services'][i].service_type; 


 


var content_div = '<div class="col-md-3">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"   data-have_cates= "'+count_have_cates+'" id="freelancecate_'+id+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .InpersonFreelance").append(content_div); 
 

}

}

} else {

 
$('#freelance_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
$('#freelance_online_main_col').removeClass('col-md-12');
$('#freelance_online_main_col').addClass('col-md-6');
$('#freelance_inperson_main_col').removeClass('col-md-12');
$('#freelance_inperson_main_col').addClass('col-md-6');
$('#freelance_inperson_main_col').show();
$('#freelance_online_main_col').show();




$('#sub_freelance_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
$('#sub_freelance_online_main_col').removeClass('col-md-12');
$('#sub_freelance_online_main_col').addClass('col-md-6');
$('#sub_freelance_inperson_main_col').removeClass('col-md-12');
$('#sub_freelance_inperson_main_col').addClass('col-md-6');
$('#sub_freelance_inperson_main_col').show();
$('#sub_freelance_online_main_col').show();

 
const servicesFreelanceOnline = response['services_freelance_online'];
const servicesFreelanceInperson = response['services_freelance_inperson'];

 

//  Get Common Categories in Freelance Start---------
// Freelance Online Common
const FreelancecommonCategoriesOnline = servicesFreelanceOnline.filter(item1 =>
servicesFreelanceInperson.some(item2 => item1.category === item2.category)
);

   // Online Unique
const FreelanceuniqueCategoriesOnline = servicesFreelanceOnline.filter(item1 =>
!FreelancecommonCategoriesOnline.some(item3 => item1.category === item3.category)
);

// Freelance Inperson Common
const FreelancecommonCategoriesInperson = servicesFreelanceInperson.filter(item1 =>
servicesFreelanceOnline.some(item2 => item1.category === item2.category)
);

// Inperson Unique
    // Online Unique
const FreelanceuniqueCategoriesInperson = servicesFreelanceInperson.filter(item1 =>
!FreelancecommonCategoriesInperson.some(item3 => item1.category === item3.category)
);

// Onlince Sort
FreelancecommonCategoriesOnline.sort((a, b) => {
const categoryA = a.category.toLowerCase();
const categoryB = b.category.toLowerCase();
return categoryA.localeCompare(categoryB);
});
// Unique
FreelanceuniqueCategoriesOnline.sort((a, b) => {
const categoryA = a.category.toLowerCase();
const categoryB = b.category.toLowerCase();
return categoryA.localeCompare(categoryB);
});

// Inperson Sort
FreelancecommonCategoriesInperson.sort((a, b) => {
const categoryA = a.category.toLowerCase();
const categoryB = b.category.toLowerCase();
return categoryA.localeCompare(categoryB);
});
// Unique
FreelanceuniqueCategoriesInperson.sort((a, b) => {
const categoryA = a.category.toLowerCase();
const categoryB = b.category.toLowerCase();
return categoryA.localeCompare(categoryB);
});
 
// Freelance Caategories
var FreelanceCommonOnline = FreelancecommonCategoriesOnline;
var FreelanceCommonInperson = FreelancecommonCategoriesInperson;
var FreelanceUniqueOnline = FreelanceuniqueCategoriesOnline;
var FreelanceUniqueInperson = FreelanceuniqueCategoriesInperson;

//  Get Common Categories in Freelacne END---------

 

 


// Freelance Categories Show START=====

// Freelance Online Common Categories Show Start ---

var len_freelanceonline = 0;
if(FreelanceCommonOnline != null){
len_freelanceonline = FreelanceCommonOnline.length;
}
if (len_freelanceonline > 0 ) {


for (let i = 0; i < len_freelanceonline; i++) {
var id = FreelanceCommonOnline[i].id;
var category = FreelanceCommonOnline[i].category;
var sub_category = FreelanceCommonOnline[i].sub_category;
var service_role = FreelanceCommonOnline[i].service_role;
var service_type = FreelanceCommonOnline[i].service_type;
//  var show_cate = category.replace(/\s*\(.*?\)/g, '');



var content_div = '<div class="col-md-12">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"   data-have_cates= "'+count_have_cates+'" id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .OnlineFreelance").append(content_div); 


}

}

// Freelance Online Common Categories Show END ----



// Freelance Online Unique Categories Show Start ---

var len_freelanceonlineunique = 0;
if(FreelanceUniqueOnline != null){
len_freelanceonlineunique = FreelanceUniqueOnline.length;
}
if (len_freelanceonlineunique > 0 ) {


for (let i = 0; i < len_freelanceonlineunique; i++) {
var id = FreelanceUniqueOnline[i].id;
var category = FreelanceUniqueOnline[i].category;
var sub_category = FreelanceUniqueOnline[i].sub_category;
var service_role = FreelanceUniqueOnline[i].service_role;
var service_type = FreelanceUniqueOnline[i].service_type;
//  var show_cate = category.replace(/\s*\(.*?\)/g, '');



var content_div = '<div class="col-md-12">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"   data-have_cates= "'+count_have_cates+'"  id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .OnlineFreelance").append(content_div); 


}

}

// Freelance Online Unique Categories Show END ----


// Freelance Online Common Categories Show Start ---

var len_freelanceinperson = 0;
if(FreelanceCommonInperson != null){
len_freelanceinperson = FreelanceCommonInperson.length;
}
if (len_freelanceinperson > 0 ) {


for (let i = 0; i < len_freelanceinperson; i++) {
var id = FreelanceCommonInperson[i].id;
var category = FreelanceCommonInperson[i].category;
var sub_category = FreelanceCommonInperson[i].sub_category;
var service_role = FreelanceCommonInperson[i].service_role;
var service_type = FreelanceCommonInperson[i].service_type;
//  var show_cate = category.replace(/\s*\(.*?\)/g, '');



var content_div = '<div class="col-md-12">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"   data-have_cates= "'+count_have_cates+'" id="freelancecate_'+id+'" data-class="fls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .InpersonFreelance").append(content_div); 


}

}

// Freelance Inperson Common Categories Show END ----


// Freelance Inperson Unique Categories Show Start ---

var len_freelanceinpersonunique = 0;
if(FreelanceUniqueInperson != null){
len_freelanceinpersonunique = FreelanceUniqueInperson.length;
}
if (len_freelanceinpersonunique > 0 ) {


for (let i = 0; i < len_freelanceinpersonunique; i++) {
var id = FreelanceUniqueInperson[i].id;
var category = FreelanceUniqueInperson[i].category;
var sub_category = FreelanceUniqueInperson[i].sub_category;
var service_role = FreelanceUniqueInperson[i].service_role;
var service_type = FreelanceUniqueInperson[i].service_type;
//  var show_cate = category.replace(/\s*\(.*?\)/g, '');



var content_div = '<div class="col-md-12">'+
                '<li class="multi-text-li">'+
                  '<label onclick="SelectCateFreelance(this.id)"  data-have_cates= "'+count_have_cates+'" id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                '</li> </div>';

$("#FreelanceCategories .InpersonFreelance").append(content_div); 


}

}

// Freelance Inperson Unique Categories Show END ----


// Freelance Categories Show END=====
 
 



}

 
 
      
                      },
                    
                  });
 
           }

 


    </script>
    {{-- Fetch CateGories Script END =========== --}}

    

{{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
{{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
<script>
  let selectedCategoriesFreelance = new Set(); // Global set to track selected categories
  // const maxCategoriesFreelance = 0; // Maximum allowed categories
   
  function SelectCateFreelance(Clicked) {
      var service_role = $('#service_role').val();
      var click_cated = Clicked.split('_');
      if (service_role == "Class") {
        var have_cates = <?php echo $ClassCates ?>; 
      } else {
         var have_cates = <?php echo $FreelanceCates ?>; 
       } 
      
      const maxCategoriesFreelance = 5 - have_cates;
      var id = click_cated[1];
      const clickedCheckbox = document.getElementById("catecheck_" + id);
      const isChecked = clickedCheckbox.checked;
      
      const clickedCategoryLabel = clickedCheckbox.value; // Category without the (Online/Inperson)
      const FreelancecorrespondingCheckbox = FreelancegetCorrespondingCheckbox(clickedCategoryLabel, id); // Get corresponding checkbox from the other section
      var total_cates = $('#multiSelectDropdown2').html();
      // var replace_cates_total = total_cates.replace(/\s*\(.*?\)/g, '');
      //  replace_cates_total = replace_cates_total.replace(/,\s+/g, ',');
       let uniqueString = [...new Set(total_cates.split(','))];
          
          
       let this_val = $(clickedCheckbox).val(); 
          //  this_val = this_val.replace(/\s*\(.*?\)/g, '');
          //  this_val = this_val.replace(/,\s+/g, ','); 
              
           if (uniqueString.includes(this_val.trim())) {
     
        } else {
          if (uniqueString.length > maxCategoriesFreelance && isChecked) {
              clickedCheckbox.checked = false;
                alert(`You Allready Added ${have_cates} categories.`);
                return;
            }
        }
  
  
      
   
    
  
      // Add or remove category from selectedCategories set
       
      if (isChecked) {
        selectedCategoriesFreelance.add(clickedCategoryLabel);
          // If corresponding checkbox exists, select it too
          if (FreelancecorrespondingCheckbox) FreelancecorrespondingCheckbox.checked = true;
      } else { 
        selectedCategoriesFreelance.delete(clickedCategoryLabel);
         
      
          // Only deselect the clicked checkbox, don't uncheck the corresponding one
      }
  
      const checkboxesChecked = document.querySelectorAll('.cat1-input'); // Select all category checkboxes
      let FreelanceAllSelectedCates = [];
      let SelectedCates = [];
  
      checkboxesChecked.forEach((checkbox) => {
          const categoryLabel = checkbox.id;
          FreelancecorrespondingCheckboxID = checkbox; // Get the checkbox from the other section
           if (checkbox.checked) {
            var cate_id =checkbox.id;
            var cate_val =checkbox.value;
            cate_id = cate_id.split('_');
            FreelanceAllSelectedCates.push(cate_id[1]);
            SelectedCates.push(cate_val);
            }
      });
      const FlsAllCates = FreelanceAllSelectedCates.join(",");
      const FlsSelectedCates = SelectedCates.join(",");
      $("#FreelanceCateIds").val(FlsAllCates);
   
      
      var service_type = $('#service_type').val();
      var service_role = $('#service_role').val();
      
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
              });
  
              $.ajax({
                  type: "post",
                  url: '/get-freelance-sub-cates',
                  data:{  FlsAllCates:FlsAllCates, service_role:service_role, service_type:service_type, _token: '{{csrf_token()}}'},
                  dataType: 'json',
                  success: function (response) {
                   
                   
                    ShowSubCatesFls(response);
                 
  
                  },
                
              });
  
  
  
      // Update the count or handle other UI changes if needed



      // Set Portfolio Urls On Category Selection Script Start=======

      function getUniqueString(all_cates) {
    // Split the string by commas, trim the values, and use Set to filter unique values
    let uniqueValues = [...new Set(all_cates.split(',').map(item => item.trim()))];
    
    // Join the unique values back into a string
    return uniqueValues.join(',');
}
      
      var freelance_cate =   FlsSelectedCates;

      var all_cates = getUniqueString(freelance_cate);
      
      let all_cates_array = all_cates.split(','); 
        $('#cates_length').val(all_cates_array.length);
        
      $('#portfolio_url_div').empty();
      var set_html_url = '';

      all_cates_array.forEach((element, index) => {
     

    set_html_url += '<div class="col-md-12 field_wrapper date-time" id="imageDiv"> '+
                    ' <label class="form-label label-sec">'+element+' URL <span>*</span></label> '+
                    ' <input type="hidden" id="array_url_'+index+'" name="url[]" /> '+
                    ' <div class="d-flex"> '+
                    '   <input class="add-input form-control" '+
                    '     type="text" '+
                    '     name="field_nam" '+
                    '     value="" id="url'+index+'" '+
                    '     placeholder="https://bravemindstudio.com/" /> '+
                    '   <a href="javascript:void(0);"  class="ad_button"  onclick="AddPortfolioUrl(this.id)" id="portfolio_links_'+index+'" title="Add field"  >'+
                     '     <img src="assets/expert/asset/img/add-input.svg" />'+
                    '    </a> </div>  <div id="portfolio_links_'+index+'_all"></div> '+
                    '</div>';


          }); 
          $('#portfolio_url_div').append(set_html_url);
  


    

      // Set Portfolio Urls On Category Selection Script END=======




  }


  // Add Portfolio Urls Start==========

  function AddPortfolioUrl(Clicked) { 
    id = Clicked.split('_') ;
    var url = $('#url'+id[2]).val();
    if (url == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Write a Link!");
                    return false;
    }

    var get_portfolio_value = $('#array_url_'+id[2]).val();
    // var get_portfolio_value = $('#portfolio_url').val();
    var link_arry = get_portfolio_value.split(',_,');
    if (link_arry.length >= 5) {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Maximmum 5 Links Allowed!");
                    return false;
    }

    var url_content = '';
    var get_portfolio_vls = $('#array_url_'+id[2]).val();

    if (get_portfolio_value == '') {
      url_content += '<div class="d-flex mt-2" id="div_url_re_'+id[2]+'_1"><input type="text" name="field_name[]" readonly value="'+url+'" class="form-control url_value" style="width:95%" placeholder="https://bravemindstudio.com/"/><a  onclick="RemovePortfolioUrls(this.id)" id="remove_url_'+id[2]+'_1" class="remove_portfolio_url" ><img src="assets/expert/asset/img/remove-icon.svg"/></a></div>';
    }else{
      var last_val = get_portfolio_vls.split(',_,');
      var array_length = last_val.length;
      var set_array_length = array_length + 1;
      url_content += '<div class="d-flex mt-2" id="div_url_re_'+id[2]+'_'+set_array_length+'" ><input type="text" name="field_name[]" readonly value="'+url+'" class="form-control url_value" style="width:95%" placeholder="https://bravemindstudio.com/"/><a  onclick="RemovePortfolioUrls(this.id)" id="remove_url_'+id[2]+'_'+set_array_length+'" class="remove_portfolio_url" ><img src="assets/expert/asset/img/remove-icon.svg"/></a></div>';
    
     }
     
    
    $('#portfolio_links_'+id[2]+'_all').append(url_content);
    var get_portfolio_value = $('#array_url_'+id[2]).val();
    if (get_portfolio_value == '') {
      $('#array_url_'+id[2]).val(url);
    }else{
    
     var last_val = $('#array_url_'+id[2]).val();
     var finel_val = last_val+',_,'+url;
      $('#array_url_'+id[2]).val(finel_val);
     }
    $('#url'+id[2]).val('');
   }

  //  Once remove button is clicked
  function RemovePortfolioUrls(Clicked) {
    // Get the ID and extract relevant parts
    var id = Clicked.split('_');
    var divId = '#div_url_re_' + id[2] + '_' + id[3]; // Div for the clicked URL
    var inputSelector = divId + ' input';  // Selector to find the input inside the div
    
    // Get the current URL in the clicked div
    var val_input = $(inputSelector).val();
    
    // Get the current array of URLs from the input field
    var get_portfolio_value = $('#array_url_' + id[2]).val();
    
    // Split the URL string into an array using ',_,' as the separator
    var link_arry = get_portfolio_value.split(',_,');
    
    

    // Filter the array to remove the clicked URL
    var newArr = link_arry.filter(function(url) {
        return url !== val_input;
    });
     
    
    // If there are still URLs left, join them into a string with ',_'
    if (newArr.length > 0) {
        var newUrlString = newArr.join(',_,');
        $('#array_url_' + id[2]).val(newUrlString);
    } else {
        // If no URLs left, clear the input field
        $('#array_url_' + id[2]).val('');
    }
    
    // Remove the corresponding div for the URL input field
    $(divId).remove();  // Remove field HTML
}


  // Add Portfolio Urls END==========
  
  
  
  // Function to get corresponding checkbox from the other section
  function FreelancegetCorrespondingCheckbox(category, currentId) {
      const checkboxes = document.querySelectorAll('.cat1-input'); // Select all category checkboxes
      let FreelancecorrespondingCheckbox = null;
  
      checkboxes.forEach((checkbox) => {
        const categoryLabel = checkbox.value;
        if (categoryLabel === category && checkbox.id !== `catecheck_${currentId}`) {
           if (categoryLabel.checked) {
             checkbox.checked = true;
           }
           FreelancecorrespondingCheckbox = checkbox; // Get the checkbox from the other section
          }
      });
  
      return FreelancecorrespondingCheckbox;
  }
  
  
  // Show Sub Categories and Selection Script Start  ========
  function ShowSubCatesFls(response) {
      var subcatesonline = response['subcatesonline'];
      var subcatesinperson = response['subcatesinperson'];
      var service_type_val = $('#service_type').val();  // Fetch service type value
   
  
      // Helper function to group subcategories by category
      function findCommonAndUnique(subcatesonline, subcatesinperson) {
          const groupedCommon = {};
          const groupedUnique = { online: {}, inperson: {} };
  
          function groupByCategory(arr) {
              const grouped = {};
              arr.forEach(item => {
                  if (!grouped[item.category]) {
                      grouped[item.category] = new Set();
                  }
                  grouped[item.category].add(item.sub_category);
              });
              return grouped;
          }
  
          const onlineGrouped = groupByCategory(subcatesonline);
          const inpersonGrouped = groupByCategory(subcatesinperson);
  
          // Find common and unique subcategories in each category
          Object.keys(onlineGrouped).forEach(category => {
              if (inpersonGrouped[category]) {
                  const commonSubcategories = [...onlineGrouped[category]].filter(subcat => inpersonGrouped[category].has(subcat));
                  if (commonSubcategories.length > 0) {
                      groupedCommon[category] = commonSubcategories;
                  }
  
                  const uniqueOnline = [...onlineGrouped[category]].filter(subcat => !inpersonGrouped[category].has(subcat));
                  if (uniqueOnline.length > 0) {
                      groupedUnique.online[category] = uniqueOnline;
                  }
  
                  const uniqueInperson = [...inpersonGrouped[category]].filter(subcat => !onlineGrouped[category].has(subcat));
                  if (uniqueInperson.length > 0) {
                      groupedUnique.inperson[category] = uniqueInperson;
                  }
              } else {
                  groupedUnique.online[category] = [...onlineGrouped[category]];
              }
          });
  
          Object.keys(inpersonGrouped).forEach(category => {
              if (!onlineGrouped[category]) {
                  groupedUnique.inperson[category] = [...inpersonGrouped[category]];
              }
          });
  
          return { common: groupedCommon, unique: groupedUnique };
      }
  
      const { common, unique } = findCommonAndUnique(subcatesonline, subcatesinperson);
      var uniqueOnline = unique.online;
      var uniqueInperson = unique.inperson;
  
      $('#SubOnlineFreelance').empty();
      $('#SubInpersonFreelance').empty();
  
      const onlineSection = document.getElementById('SubOnlineFreelance');
      const inpersonSection = document.getElementById('SubInpersonFreelance');
  
      const allCategories = new Set([...Object.keys(common), ...Object.keys(uniqueOnline), ...Object.keys(uniqueInperson)]);
  
    // Update checkbox state with auto-selection for common subcategories
  function updateCheckboxState(category, subcat, type, isCommon, isChecked) {
      const checkboxes = document.querySelectorAll(`input[data-categoryfls="${category}"][data-subcategoryfls="${subcat}"]`);
      
      checkboxes.forEach(checkbox => {
          // Check the other side automatically if it's a common subcategory and checkbox is being selected
          if (isChecked && isCommon && checkbox.getAttribute('data-typefls') !== type) {
              checkbox.checked = true;
          }
          
          // HandleLimitSelection will ensure limits are enforced for each category
          handleLimitSelection(category);
      });
  }
  
     // Function to limit subcategory selection to a max of 10 per category
  function handleLimitSelection(category) {
      const checkboxes = document.querySelectorAll(`input[data-categoryfls="${category}"]`);
      const selectedSubcategories = new Set(); // To track unique selected subcategories
      const commonSelected = new Set();  // To track common subcategories selected in both sections
      const commonStatus = {}; // To track whether common subcategories are selected in any section
  
      // Count selected subcategories and track common subcategories
      checkboxes.forEach(cb => {
          const subcat = cb.getAttribute('data-subcategoryfls');
          const isCommon = cb.getAttribute('data-commonfls') === 'true';
  
          if (cb.checked) {
              if (isCommon) {
                  commonSelected.add(subcat);  // Common subcategories count as one
                  commonStatus[subcat] = true;  // Mark common subcategory as selected
              } else {
                  selectedSubcategories.add(subcat);  // Unique subcategories count as one each
              }
          } else if (isCommon) {
              commonStatus[subcat] = commonStatus[subcat] || false;  // Mark common subcategory as unselected if not checked
          }
      });
  
      const totalSelected = selectedSubcategories.size + commonSelected.size;
  
      // Disable only unchecked checkboxes when the max limit is reached
      checkboxes.forEach(cb => {
          const subcat = cb.getAttribute('data-subcategoryfls');
          const isCommon = cb.getAttribute('data-commonfls') === 'true';
  
          // Disable checkboxes if limit reached, but keep enabled those that are already selected
          if (!cb.checked && totalSelected >= 10) {
              // Disable only if completely unselected in both sections (common or unique)
              if (!(isCommon && commonStatus[subcat])) {
                  cb.disabled = true; // Disable completely unselected subcategories
              }
          } else {
              cb.disabled = false; // Ensure checked checkboxes and common ones selected on one side stay enabled
          }
      });
  }
  
      // Iterate through all categories and render subcategories
      allCategories.forEach(category => {
          const hasCommon = common[category] && common[category].length > 0;
          const hasUniqueOnline = uniqueOnline[category] && uniqueOnline[category].length > 0;
          const hasUniqueInperson = uniqueInperson[category] && uniqueInperson[category].length > 0;
  
          if (hasCommon || hasUniqueOnline || hasUniqueInperson) {
              // ONLINE Section
              if (hasCommon || hasUniqueOnline) {
                  const onlineCategoryContainer = document.createElement('div');
                  const categoryHeadingOnline = document.createElement('div');
                  categoryHeadingOnline.className = 'category-heading';
                  categoryHeadingOnline.innerText = category;
                  $(categoryHeadingOnline).css('color', '#096090d1');
                  onlineCategoryContainer.appendChild(categoryHeadingOnline);
  
                  const subcategoryListOnline = document.createElement('div');
                  subcategoryListOnline.className = 'row';
  
                  if (hasCommon) {
                      common[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Online', true);
                          subcategoryListOnline.appendChild(checkbox);
                      });
                  }
  
                  if (hasUniqueOnline) {
                      uniqueOnline[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Online', false);
                          subcategoryListOnline.appendChild(checkbox);
                      });
                  }
  
                  onlineCategoryContainer.appendChild(subcategoryListOnline);
                  onlineSection.appendChild(onlineCategoryContainer);
              }
  
              // INPERSON Section
              if (hasCommon || hasUniqueInperson) {
                  const inpersonCategoryContainer = document.createElement('div');
                  const categoryHeadingInperson = document.createElement('div');
                  categoryHeadingInperson.className = 'category-heading';
                  categoryHeadingInperson.innerText = category;
                  $(categoryHeadingInperson).css('color', '#096090d1');
                  inpersonCategoryContainer.appendChild(categoryHeadingInperson);
  
                  const subcategoryListInperson = document.createElement('div');
                  subcategoryListInperson.className = 'row';
  
                  if (hasCommon) {
                      common[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Inperson', true);
                          subcategoryListInperson.appendChild(checkbox);
                      });
                  }
  
                  if (hasUniqueInperson) {
                      uniqueInperson[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Inperson', false);
                          subcategoryListInperson.appendChild(checkbox);
                      });
                  }
  
                  inpersonCategoryContainer.appendChild(subcategoryListInperson);
                  inpersonSection.appendChild(inpersonCategoryContainer);
              }
          }
      });
  
      // Helper function to create checkboxes
      function createCheckbox(category, subcat, type, isCommon) {
          const div_main = document.createElement('div');
          div_main.className = (service_type_val == 'Both') ? 'col-md-12 freelance_sub' : 'col-md-3 freelance_sub';
          const li = document.createElement('li');
          li.className = 'multi-text-li';
          const label = document.createElement('label');
          label.sub_category = subcat;
          label.sub_category_type = type;
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.name = 'subcategories[]';
          if (type == 'Inperson') {
          checkbox.className = 'subcat1-input freelancesub flsin';
          } else {
          checkbox.className = 'subcat1-input freelancesub flson';
          }
          checkbox.value = subcat;
          checkbox.setAttribute('data-categoryfls', category);
          checkbox.setAttribute('data-subcategoryfls', subcat);
          checkbox.setAttribute('data-typefls', type);
          checkbox.setAttribute('data-commonfls', isCommon);  // Flag for common subcategories
  
          checkbox.addEventListener('change', function() {
              updateCheckboxState(category, subcat, type, isCommon, checkbox.checked);
          });
  
          label.appendChild(checkbox);
          label.append(subcat);
          li.appendChild(label);
          div_main.appendChild(li);
  
          return div_main;
      }
  }
  
   // Show Sub Categories and Selection Script END  ========
  
  
  
  
     function SelectFreelanceCategorySub() {
      const chBoxes3 = document.querySelectorAll(".dropdown-menu .subcat1-input");
      const chBoxes3on = document.querySelectorAll(".dropdown-menu .subcat1-input.flson");
      const chBoxes3in = document.querySelectorAll(".dropdown-menu .subcat1-input.flsin");
     const dpBtn3 = document.getElementById("multiSelectDropdown3");
     let mySelectedListItems3 = [];
       
      
    function handleCB() {
      mySelectedListItems3 = [];
      let mySelectedListItemsText3 = "";
      let FlsIn = [];
      let FlsOn = [];
      
      chBoxes3.forEach((checkbox) => {
        if (checkbox.checked) {
             
          mySelectedListItems3.push(checkbox.value);
          mySelectedListItemsText3 += checkbox.value + ", ";
        }
      });

         // Sub Category Online Get Selected
    chBoxes3on.forEach((checkbox) => {
      if (checkbox.checked) {
         FlsOn.push(checkbox.value);
          
      }
    });
    // SubCategory Inperson Get Selected
    chBoxes3in.forEach((checkbox) => {
      if (checkbox.checked) {
         FlsIn.push(checkbox.value);
         
        
      }
    });

    let resultSubOn = FlsOn.join(',');
    let resultSubIn = FlsIn.join(',');
    let sub_vals = resultSubOn + '|*|' + resultSubIn ;
    $('#sub_category').val(sub_vals);
     
    


      
    dpBtn3.innerText =
        mySelectedListItems3.length > 0
          ? mySelectedListItemsText3.slice(0, -2)
          : "--select sub-category--";
    }
  
    chBoxes3.forEach((checkbox) => {
      checkbox.addEventListener("change", handleCB);
    });
       }
    
  
       
       
      </script>
  
  {{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}
  {{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}
  

    {{-- On Change Portfolio for Link Start ======= --}}
<script>
  $('#portfolio').change(function () { 
     
 var portfolio =   $('#portfolio').val();

 if (portfolio == 'not_link') {
  $('.all_urls').removeAttr('required');
    $('#portfolio_url_div').hide();
 }else{
  $('.all_urls').attr('required', 1);
  $('#portfolio_url_div').show();
 }
    
  });
  
 
</script>

{{-- Portfolio Url Script End ===== --}}

{{-- Image Upload with priview Script END ======== --}}
<script>


  // 1
  new Vue({
  el: "#upload-image",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      if (!confirm("Are You Sure, You Want to Remove ?")){
          return false;
       }
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});



</script>
{{-- Image Upload with priview Script Start ======== --}}

    
<script>
  function SelectFreelanceCategory() { 
   
    const chBoxes2 = document.querySelectorAll(".dropdown-menu .cat1-input");
  const dpBtn2 = document.getElementById("multiSelectDropdown2");
  let mySelectedListItems2 = [];

  function handleCB() {
    mySelectedListItems2 = [];
    let mySelectedListItemsText2 = "";

    chBoxes2.forEach((checkbox) => {
      if (checkbox.checked) {
        mySelectedListItems2.push(checkbox.value);
        mySelectedListItemsText2 += checkbox.value + ", ";
      }
    });
    
      

    dpBtn2.innerText =
      mySelectedListItems2.length > 0
        ? mySelectedListItemsText2.slice(0, -2)
        : "--select category--";
        if (mySelectedListItems2 == '--select category--') {
         $('#category').val('');
        } else {
          category = mySelectedListItemsText2.replace(/,\s+/g, ',');
          $('#category').val(category);
        }
       

        var category = $('#multiSelectDropdown2').html();
        var category = category.replace(/\s*\(.*?\)/g, '');
        let string = category.replace(/,\s+/g, ',');
        let array = string.split(',');
        let uniqueArray = [...new Set(array)];
          category = uniqueArray.join(',');
        var cate_html = '';
        $('#portfolio_urls_main_div').empty();
 uniqueArray.forEach(element => {
           cate_html += ' <div class="col-md-12 field_wrapper date-time" id="imageDiv"> '+
                           '  <label class="label-sec">'+element+' URL <span>*</span></label> '+
                          '   <div class="d-flex"> '+
                          '     <input  class="add-input all_urls form-control" '+
                          '       type="text"  name="url[]" '+
                          '       value="" id="url"  placeholder="https://bravemindstudio.com/" required/> '+
                          '      </div> '+
                          ' </div>';
        });
        
        $('#portfolio_urls_main_div').append(cate_html);

        
  }

  chBoxes2.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
   }

 

    
  
</script>
  <!-- ================ side js start End=============== -->

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
<!-- add experience radio -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radio1 = document.getElementById('radio1');
        const radio3 = document.getElementById('radio3');
        const imageDiv = document.getElementById('imageDiv');
    
        function toggleImage() {
            if (radio3.checked) {
                imageDiv.style.display = 'none';
            } else {
                imageDiv.style.display = 'block';
            }
        }
    
        // Add event listeners to radio buttons
        radio1.addEventListener('change', toggleImage);
        radio3.addEventListener('change', toggleImage);
    
        // Initial check
        toggleImage();
    });
    
    </script>
    <!-- multiple input js -->
    <script>
        $(document).ready(function () {
          var maxField = 10; //Input fields increment limitation
          var addButton = $(".add_button"); //Add button selector
          var wrapper = $(".field_wrapper"); //Input field wrapper
          var fieldHTML =
            '<div class="d-flex mt-2"><input type="text" name="field_name[]" value="" class="form-control remove-inp-field" style="width:95%" placeholder="https://bravemindstudio.com/"/><a href="javascript:void(0);" class="remove_button"><img src="assets/teacher/asset/img/remove-icon.svg"/></a></div>'; //New input field html
          var x = 1; //Initial field counter is 1
          // Once add button is clicked
          $(addButton).click(function () {
            //Check maximum number of input fields
            if (x < maxField) {
              x++; //Increase field counter
              $(wrapper).append(fieldHTML); //Add field html
            } else {
              alert("A maximum of " + maxField + " fields are allowed to be added. ");
            }
          });
          // Once remove button is clicked
          $(wrapper).on("click", ".remove_button", function (e) {
            e.preventDefault();
            $(this).parent("div").remove(); //Remove field html
            x--; //Decrease field counter
          });
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
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        new DataTable('#example', {
            scrollX: true
        });
    </script>

    <script src="assets/expert/libs/aos/js/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/teacher/asset/js/bootstrap.min.js "></script>
<!-- upload image js -->
<script>
  jQuery(document).ready(function () {
    ImgUpload();
  });

  function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $(".upload__inputfile").each(function () {
      $(this).on("change", function (e) {
        imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
        var maxLength = $(this).attr("data-max_length");

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        var iterator = 0;
        filesArr.forEach(function (f, index) {
          if (!f.type.match("image.*")) {
            return;
          }

          if (imgArray.length > maxLength) {
            return false;
          } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i] !== undefined) {
                len++;
              }
            }
            if (len > maxLength) {
              return false;
            } else {
              imgArray.push(f);

              var reader = new FileReader();
              reader.onload = function (e) {
                var html =
                  "<div class='upload__img-box'><div style='background-image: url(" +
                  e.target.result +
                  ")' data-number='" +
                  $(".upload__img-close").length +
                  "' data-file='" +
                  f.name +
                  "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                imgWrap.append(html);
                iterator++;
              };
              reader.readAsDataURL(f);
            }
          }
        });
      });
    });

    $("body").on("click", ".upload__img-close", function (e) {
      var file = $(this).parent().data("file");
      for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
          imgArray.splice(i, 1);
          break;
        }
      }
      $(this).parent().parent().remove();
    });
  }
</script>
<!-- upload image js ended here -->
</body>
<!--========== Underline tabes JS Start========== -->
<script>
    function feature(e, featureClassName) {
        var element = document.getElementsByClassName('tab-item');
        for (var i = 0; i < element.length; i++) {
            var shouldBeActive = element[i].classList.contains(featureClassName);
            element[i].classList.toggle('active', shouldBeActive);
        }
    }
</script>
<!--========== Underline tabes JS END =========== -->

<!--========== Slider-JS Start =========== -->
<script>
    jQuery(" #carousel ").owlCarousel({
        autoplay: true,
        rewind: true,
        /* use rewind if you don't want loop */
        margin: 20,
        /* animateOut: 'fadeOut' , animateIn: 'fadeIn' , */
        responsiveClass: true,
        autoHeight: true,
        autoplayTimeout: 7000,
        smartSpeed: 800,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1024: {
                items: 1
            },
            1366: {
                items: 1
            }
        }
    });
</script>
<!--========== Slider-JS End =========== -->
<!-- ===================== multiselect script  ====================================== -->
<script>
    const chBoxes = document.querySelectorAll(".dropdown-menu .cat-input");
    const dpBtn = document.getElementById("multiSelectDropdown");
    let mySelectedListItems = [];
  
    function handleCB() {
      mySelectedListItems = [];
      let mySelectedListItemsText = "";
  
      chBoxes.forEach((checkbox) => {
        if (checkbox.checked) {
          mySelectedListItems.push(checkbox.value);
          mySelectedListItemsText += checkbox.value + ", ";
        }
      });
  
      dpBtn.innerText =
        mySelectedListItems.length > 0
          ? mySelectedListItemsText.slice(0, -2)
          : "Select";
    }
  
    chBoxes.forEach((checkbox) => {
      checkbox.addEventListener("change", handleCB);
    });
  </script>
<!--  -->
<script src=" https://kit.fontawesome.com/6dba2ff605.js " crossorigin=" anonymous ">
</script>
<!-- upload file start js -->
<script>
    // Design By
    // - https://dribbble.com/shots/13992184-File-Uploader-Drag-Drop

    // Select Upload-Area
    const uploadArea = document.querySelector('#uploadArea')

    // Select Drop-Zoon Area
    const dropZoon = document.querySelector('#dropZoon');

    // Loading Text
    const loadingText = document.querySelector('#loadingText');

    // Slect File Input 
    const fileInput = document.querySelector('#fileInput');

    // Select Preview Image
    const previewImage = document.querySelector('#previewImage');

    // File-Details Area
    const fileDetails = document.querySelector('#fileDetails');

    // Uploaded File
    const uploadedFile = document.querySelector('#uploadedFile');

    // Uploaded File Info
    const uploadedFileInfo = document.querySelector('#uploadedFileInfo');

    // Uploaded File  Name
    const uploadedFileName = document.querySelector('.uploaded-file__name');

    // Uploaded File Icon
    const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');

    // Uploaded File Counter
    const uploadedFileCounter = document.querySelector('.uploaded-file__counter');

    // ToolTip Data
    const toolTipData = document.querySelector('.upload-area__tooltip-data');

    // Images Types
    const imagesTypes = [
        "jpeg",
        "png",
        "svg",
        "gif"
    ];

    // Append Images Types Array Inisde Tooltip Data
    toolTipData.innerHTML = [...imagesTypes].join(', .');

    // When (drop-zoon) has (dragover) Event 
    dropZoon.addEventListener('dragover', function(event) {
        // Prevent Default Behavior 
        event.preventDefault();

        // Add Class (drop-zoon--over) On (drop-zoon)
        dropZoon.classList.add('drop-zoon--over');
    });

    // When (drop-zoon) has (dragleave) Event 
    dropZoon.addEventListener('dragleave', function(event) {
        // Remove Class (drop-zoon--over) from (drop-zoon)
        dropZoon.classList.remove('drop-zoon--over');
    });

    // When (drop-zoon) has (drop) Event 
    dropZoon.addEventListener('drop', function(event) {
        // Prevent Default Behavior 
        event.preventDefault();

        // Remove Class (drop-zoon--over) from (drop-zoon)
        dropZoon.classList.remove('drop-zoon--over');

        // Select The Dropped File
        const file = event.dataTransfer.files[0];

        // Call Function uploadFile(), And Send To Her The Dropped File :)
        uploadFile(file);
    });

    // When (drop-zoon) has (click) Event 
    dropZoon.addEventListener('click', function(event) {
        // Click The (fileInput)
        fileInput.click();
    });

    // When (fileInput) has (change) Event 
    fileInput.addEventListener('change', function(event) {
        // Select The Chosen File
        const file = event.target.files[0];

        // Call Function uploadFile(), And Send To Her The Chosen File :)
        uploadFile(file);
    });

    // Upload File Function
    function uploadFile(file) {
        // FileReader()
        const fileReader = new FileReader();
        // File Type 
        const fileType = file.type;
        // File Size 
        const fileSize = file.size;

        // If File Is Passed from the (File Validation) Function
        if (fileValidate(fileType, fileSize)) {
            // Add Class (drop-zoon--Uploaded) on (drop-zoon)
            dropZoon.classList.add('drop-zoon--Uploaded');

            // Show Loading-text
            loadingText.style.display = "block";
            // Hide Preview Image
            previewImage.style.display = 'none';

            // Remove Class (uploaded-file--open) From (uploadedFile)
            uploadedFile.classList.remove('uploaded-file--open');
            // Remove Class (uploaded-file__info--active) from (uploadedFileInfo)
            uploadedFileInfo.classList.remove('uploaded-file__info--active');

            // After File Reader Loaded 
            fileReader.addEventListener('load', function() {
                // After Half Second 
                setTimeout(function() {
                    // Add Class (upload-area--open) On (uploadArea)
                    uploadArea.classList.add('upload-area--open');

                    // Hide Loading-text (please-wait) Element
                    loadingText.style.display = "none";
                    // Show Preview Image
                    previewImage.style.display = 'block';

                    // Add Class (file-details--open) On (fileDetails)
                    fileDetails.classList.add('file-details--open');
                    // Add Class (uploaded-file--open) On (uploadedFile)
                    uploadedFile.classList.add('uploaded-file--open');
                    // Add Class (uploaded-file__info--active) On (uploadedFileInfo)
                    uploadedFileInfo.classList.add('uploaded-file__info--active');
                }, 500); // 0.5s

                // Add The (fileReader) Result Inside (previewImage) Source
                previewImage.setAttribute('src', fileReader.result);

                // Add File Name Inside Uploaded File Name
                uploadedFileName.innerHTML = file.name;

                // Call Function progressMove();
                progressMove();
            });

            // Read (file) As Data Url 
            fileReader.readAsDataURL(file);
        } else { // Else

            this; // (this) Represent The fileValidate(fileType, fileSize) Function

        };
    };

    // Progress Counter Increase Function
    function progressMove() {
        // Counter Start
        let counter = 0;

        // After 600ms 
        setTimeout(() => {
            // Every 100ms
            let counterIncrease = setInterval(() => {
                // If (counter) is equle 100 
                if (counter === 100) {
                    // Stop (Counter Increase)
                    clearInterval(counterIncrease);
                } else { // Else
                    // plus 10 on counter
                    counter = counter + 10;
                    // add (counter) vlaue inisde (uploadedFileCounter)
                    uploadedFileCounter.innerHTML = `${counter}%`
                }
            }, 100);
        }, 600);
    };


    // Simple File Validate Function
    function fileValidate(fileType, fileSize) {
        // File Type Validation
        let isImage = imagesTypes.filter((type) => fileType.indexOf(`image/${type}`) !== -1);

        // If The Uploaded File Type Is 'jpeg'
        if (isImage[0] === 'jpeg') {
            // Add Inisde (uploadedFileIconText) The (jpg) Value
            uploadedFileIconText.innerHTML = 'jpg';
        } else { // else
            // Add Inisde (uploadedFileIconText) The Uploaded File Type 
            uploadedFileIconText.innerHTML = isImage[0];
        };

        // If The Uploaded File Is An Image
        if (isImage.length !== 0) {
            // Check, If File Size Is 2MB or Less
            if (fileSize <= 2000000) { // 2MB :)
                return true;
            } else { // Else File Size
                return alert('Please Your File Should be 2 Megabytes or Less');
            };
        } else { // Else File Type 
            return alert('Please make sure to upload An Image File Type');
        };
    };

    // :)
</script>
<!-- upload file end js -->

</html>