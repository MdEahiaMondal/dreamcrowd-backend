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
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/admin/asset/css/bootstrap.min.css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
    <!-- Fontawesome CDN -->
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- file upload link -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- js -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
        <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

   {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Dynamic Management-Category</title>
  </head>
  <style>
    .button{
      color:#0072B1!important;
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
                    <h1 class="dash-title">Dynamic Management</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Categories</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Dynamic Management</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ============ -->
              {{-- <div class="col-md-12 manage-profile-faq-sec">
                <h5>Categories & Sub Categories (General)</h5>
                <a href="/add-category-dynamic"
                  ><button
                    class="btn float-end add-faq-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal2"
                  >
                    Add New Category
                  </button>
                </a>
              </div> --}}
              <!-- =============== -->
              {{-- <div class="col-md-12 faq-sec">
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->
                  <div class="input-group mb-3 category">
                    <input
                      type="text"
                      type="text"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    />
                    <button
                      class="btn view-button"
                      type="button"
                      id="button-addon2"
                      onclick="changeStructure(this)"
                    >
                      View
                    </button>
                  </div>
                </div>
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->
                  <div class="input-group mb-3 category">
                    <input
                      type="text"
                      type="text"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    />
                    <button
                      class="btn view-button"
                      type="button"
                      id="button-addon2"
                      onclick="changeStructure(this)"
                    >
                      View
                    </button>
                  </div>
                </div>
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->
                  <div class="input-group mb-3 category">
                    <input
                      type="text"
                      type="text"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    />
                    <button
                      class="btn view-button"
                      type="button"
                      id="button-addon2"
                      onclick="changeStructure(this)"
                    >
                      View
                    </button>
                  </div>
                </div>
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->
                  <div class="input-group mb-3 category">
                    <input
                      type="text"
                      type="text"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    />
                    <button
                      class="btn view-button"
                      type="button"
                      id="button-addon2"
                      onclick="changeStructure(this)"
                    >
                      View
                    </button>
                  </div>
                </div>               
                </div> --}}
              </div>
              <div class="col-md-12 manage-profile-faq-sec">
                <h5>Categories & Sub Categories (Online Only)</h5>
                <a href="/add-category-dynamic"
                  ><button
                    class="btn float-end add-faq-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal4"
                  >
                    Add New Category
                  </button>
                </a>
              </div>
              <div class="col-md-12 faq-sec">

                @if ($online)
                @foreach ($online as $item)
                  {{-- @php $result = preg_replace('/\(.*?\)/', '', $item->category);  @endphp --}}
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->

                  <div class="input-group mb-3 category">
                    <input
                      type="text" readonly
                      type="text" value="{{$item->category}} ({{$item->service_role}})"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    />
                    <button
                      class="btn view-button"
                      type="button" data-id="{{$item->id}}" data-status="{{$item->status}}" data-category="{{$item->category}}" data-sub_category="{{$item->sub_category}}" data-type="{{$item->service_type}}" data-role="{{$item->service_role}}"
                      id="button-addon_{{$item->id}}"
                      onclick="ViewCategory(this.id)"
                    >View</button>
                  </div>
                  <div id="category-{{$item->id}}"  style="margin-bottom: 10px;"></div>
                </div>
                    
                @endforeach
                    
                @endif
                
   
              </div>
              <div class="col-md-12 manage-profile-faq-sec">
                <h5>Categories & Sub Categories (Inperson Only)</h5>
                <a href="/add-category-dynamic"
                  ><button
                    class="btn float-end add-faq-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal4"
                  >
                    Add New Category
                  </button>
                </a>
              </div>
              <div class="col-md-12 faq-sec">

                @if ($inperson)
                @foreach ($inperson as $item)
                {{-- @php $result = preg_replace('/\(.*?\)/', '', $item->category);  @endphp --}}
                <div id="categoryContainer" class="profile-form">
                  <!-- Initial category structure -->
                  <div class="input-group mb-3 category">
                    <input
                      type="text" 
                      type="text" value="{{$item->category}} ({{$item->service_role}})"
                      class="form-control"
                      placeholder="Front End Developer"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                      readonly
                    /> 
                    <button
                      class="btn view-button"
                      type="button" data-id="{{$item->id}}" data-status="{{$item->status}}" data-category="{{$item->category}}" data-sub_category="{{$item->sub_category}}" data-type="{{$item->service_type}}" data-role="{{$item->service_role}}"
                      id="button-addon_{{$item->id}}"
                      onclick="ViewCategory(this.id)"
                    >View</button>
                  </div>

                  <div id="category-{{$item->id}}" style="margin-bottom: 10px;"> 
                   
                  </div>

                </div>
                    
                @endforeach
                    
                @endif
                 
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
    </section>

    <script src="assets/admin/libs/jquery/jquery.js"></script>
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
  </body>
</html>

{{-- View Category Update Script Start=========== --}}
<script>
  function ViewCategory(Clicked) {

   

   var id = $('#'+Clicked).data('id');
   var status = $('#'+Clicked).data('status');
   var category = $('#'+Clicked).data('category');
   var sub_category = $('#'+Clicked).data('sub_category');
    sub_category = sub_category;
   var type = $('#'+Clicked).data('type');
   var role = $('#'+Clicked).data('role');
    
   var html_get = $('#category-'+id).html();
   if (html_get != '') {
    $('#category-'+id).empty();

    return false;
  }


  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/admin-get-sub-categories',
                data:{ id:id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  let sub_cates = response['sub_cate'];
                   
                  SetHtml(sub_cates,id,status,category,type,role) ;
                    
                },
              
            });
 

            function SetHtml(sub_cates,id,status,category,type,role) { 
              
              
              $('#category-'+id).empty();
    var new_div = '';

      new_div +=  '<form action="/admin-category-update" method="POST"  >'+
                    ' @csrf '+ 
                    '<label for="inputEmail4" class="form-label">Category</label>'+
                    '<div class="input-group mb-3 category">'+
                    '<input type="hidden" value="'+id+'" name="id" class="form-control" id="id_upd"   />'+
                    '<input type="hidden" value="'+status+'" name="status" class="form-control" id="status_upd_'+id+'"   />'+
                    '<input type="text" value="'+category+'" name="category" class="form-control" id="category_upd" required placeholder="Front End Developer" />'+
                    '<a href="/admin-category-delete/'+id+'"  style="text-decoration:none;"> <button class="btn view-button " style="background:#fc5757;" type="button"   id="button-addon" >  Remove  </button> </a>'+
                    '<button class="btn view-button" type="button"   id="status_'+id+'" onclick="StatusChange(this.id)" >';
                      if (status == 1) {
                        new_div +=    'Hide';
                      } else {
                        new_div +=    'Show';
                        
                      } 
       new_div +=    '</button>'+
                    '</div>'+
                    '<label for="inputEmail4" class="form-label">Service Type</label>'+
                    '  <select class="form-control" name="type" id="inputAddress">';
                      if (type+','+role == 'Online,Class') {

                    new_div += '<option value="Online,Class" selected>Online Classes</option>'+
                          '<option value="Inperson,Class">In Person Classes</option>'+
                          '<option value="Online,Freelance">Online Freelance</option>'+
                          '<option value="Inperson,Freelance">In Person Freelance</option>';
                        
                      } else if(type+','+role == 'Inperson,Class') {

                        new_div += '<option value="Online,Class" >Online Classes</option>'+
                          '<option value="Inperson,Class" selected>In Person Classes</option>'+
                          '<option value="Online,Freelance">Online Freelance</option>'+
                          '<option value="Inperson,Freelance">In Person Freelance</option>';
                        
                      }  else if(type+','+role == 'Online,Freelance') {

                          new_div += '<option value="Online,Class" >Online Classes</option>'+
                            '<option value="Inperson,Class" >In Person Classes</option>'+
                            '<option value="Online,Freelance" selected>Online Freelance</option>'+
                            '<option value="Inperson,Freelance">In Person Freelance</option>';

                          } else if(type+','+role == 'Inperson,Freelance') {

                          new_div += '<option value="Online,Class" >Online Classes</option>'+
                            '<option value="Inperson,Class" >In Person Classes</option>'+
                            '<option value="Online,Freelance" >Online Freelance</option>'+
                            '<option value="Inperson,Freelance" selected>In Person Freelance</option>';

                          }
                          
                new_div += '</select>'+
                              '<label for="inputEmail4" class="form-label">Add Sub Category</label>'+
                          '<div id="div-sub_cates_add" class="input-group mb-3 category">'+
                            '<input type="text" value="" class="form-control" id="sub_cates_add"  placeholder=" Sub Category" />'+
                            '<button class="btn view-button" type="button"   onclick="SubCateUpd(this.id)" id="add-sub_cates_add" data-action="Add"  data-cate_id="'+id+'"    >Add</button>'+
                            '</div>';

                if (sub_cates.length > 0) {
                  new_div += '<div id="sub_cate_main_div"> <label for="inputEmail4" class="form-label">Sub Categories</label>';

                    for (let i = 0; i < sub_cates.length; i++) {
                      const sub_id = sub_cates[i].id;
                      const sub_category = sub_cates[i].sub_category;
                      
               new_div += '<div id="div-sub_cates_'+sub_id+'" class="input-group mb-3 category">'+
                  '<input type="text" value="'+sub_category+'" class="form-control" id="sub_cates_'+sub_id+'"  placeholder=" Developer" />'+
                  '<a   onclick="SubCateUpd(this.id)" id="remove-sub_cates_'+sub_id+'" data-action="Remove" data-sub_id="'+sub_id+'"  data-cate_id="'+id+'" style="text-decoration:none;"> <button class="btn view-button " style="background:#fc5757;" type="button"   id="button-addon" >  Remove  </button> </a>'+
                  '<button class="btn view-button" type="button"   onclick="SubCateUpd(this.id)" id="update-sub_cates_'+sub_id+'" data-action="Update"  data-cate_id="'+id+'" data-sub_id="'+sub_id+'"  >Update</button>'+
                  '</div></div>';

                    }
                
                }
                        

 
                new_div +='<button class="btn view-button " style="float:right;margin-bottom:25px;" type="submit"  >  Update  </button></form> <hr style="margin-bottom:90px;position:relative;top:60px;"/>';
       
    $('#category-'+id).html(new_div);

             }
  
 
 

    }

    function SubCateUpd(Clicked) {
        var id = Clicked.split('-');
        var action = $('#'+Clicked).data('action');
        var cate_id = $('#'+Clicked).data('cate_id');
        var sub_id = $('#'+Clicked).data('sub_id');
        var sub_category = $('#'+id[1]).val();

        if (action == 'Update') {
          if (sub_category.trim() === '') {
            event.preventDefault(); // Prevent form submission
            alert('Sub Category Input Text Required!');
          }
        }

        if (!confirm("Are You Sure, You Want to do This ?")){
      return false;
    }

        
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/action-sub-categories',
                data:{ sub_id:sub_id,cate_id:cate_id,sub_category:sub_category,action:action, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {  
                
                 if (response.success) {
                  toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.success(response.success);

                    if (response.action == 'Add') {
                      new_div = '<div id="div-sub_cates_'+response.sub_cate.id+'" class="input-group mb-3 category">'+
                  '<input type="text" value="'+response.sub_cate.sub_category+'" class="form-control" id="sub_cates_'+response.sub_cate.id+'"  placeholder=" Developer" />'+
                  '<a   onclick="SubCateUpd(this.id)" id="remove-sub_cates_'+response.sub_cate.id+'" data-action="Remove" data-sub_id="'+response.sub_cate.id+'"  data-cate_id="'+response.sub_cate.cate_id+'" style="text-decoration:none;"> <button class="btn view-button " style="background:#fc5757;" type="button"   id="button-addon" >  Remove  </button> </a>'+
                  '<button class="btn view-button" type="button"   onclick="SubCateUpd(this.id)" id="update-sub_cates_'+response.sub_cate.id+'" data-action="Update"  data-cate_id="'+response.sub_cate.cate_id+'" data-sub_id="'+response.sub_cate.id+'"  >Update</button>'+
                  '</div>';
                  $('#sub_cate_main_div').append(new_div);
                  $('#'+id[1]).val('');
                    }

                 } else { 
                  
                  $('#div-'+id[1]).remove();
                  
                  toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.info(response.info);
                 }
                   
                },
              
            });
         
      
    }


    function StatusChange(Clicked) { 
      $('#'+Clicked).html();
     var id = Clicked.split('_');
     var status = $('#status_upd_'+id[1]).val();
     if (status == 0) {
        $('#status_upd_'+id[1]).val(1);
        $('#'+Clicked).html('Hide');
      } else {
        $('#status_upd_'+id[1]).val(0);
        $('#'+Clicked).html('Show');
     }

     }
</script>
{{-- View Category Update Script END=========== --}}
<!-- Hidden form on view button js -->
<script>
  function changeStructure(button) {
    var categoryDiv = button.parentElement;
    var categoryContainer = categoryDiv.parentElement;

    // Create the main div
    var mainDiv = document.createElement("div");
    mainDiv.classList.add("main");
    mainDiv.style.display = "none";

    // Create the form inside the main div
  //   var form = document.createElement("form");
  //   form.classList.add("profile-form");
  //   form.id = "form";
  //  form.action = "{{route('admin.addCategory')}}";
  //   form.method = "POST";

    // Create the input fields inside the form
    var rowDiv = document.createElement("div");
    rowDiv.classList.add("row", "input_fields_wrap");

    var colDiv = document.createElement("div");
    colDiv.classList.add("col-md-12");

    var categoryLabel = document.createElement("label");
    categoryLabel.htmlFor = "inputEmail4";
    categoryLabel.classList.add("form-label");
    categoryLabel.textContent = "Category";

    var inputGroupDiv = document.createElement("div");
    inputGroupDiv.classList.add("input-group", "mb-3", "category-input-group");
    inputGroupDiv.id = "input-group-1";

    var inputField = document.createElement("input");
    inputField.type = "text";
    inputField.classList.add("form-control", "form-control-lg");
    inputField.name = "category_name[]";
    inputField.placeholder = "Graphic Design";
    inputField.ariaLabel = "category Name";
    inputField.ariaDescribedBy = "button-addon";

    var removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.classList.add("btn", "btn-outline-secondary", "remove-button");
    removeButton.id = "button-addon";
    removeButton.textContent = "Remove";
    removeButton.onclick = function () {
      mainDiv.remove();
      categoryDiv.remove();
    };

    var hideButton = document.createElement("button");
    hideButton.type = "button";
    hideButton.classList.add("btn", "btn-outline-secondary", "hide-button");
    hideButton.id = "hide-button";
    hideButton.textContent = "Hide";
    hideButton.onclick = function () {
      mainDiv.style.display = "none";
      categoryDiv.style.display = "flex";
      // Reset the width of the input group
      inputGroupDiv.classList.remove("wide-input-group");
    };

    // Append elements to their respective parents
    inputGroupDiv.appendChild(inputField);
    inputGroupDiv.appendChild(removeButton);
    inputGroupDiv.appendChild(hideButton);

    colDiv.appendChild(categoryLabel);
    colDiv.appendChild(inputGroupDiv);

    rowDiv.appendChild(colDiv);

    // Add textarea for subcategories
    var subcategoriesLabel = document.createElement("label");
    subcategoriesLabel.htmlFor = "inputEmail4";
    subcategoriesLabel.classList.add("form-label");
    subcategoriesLabel.textContent = "Sub Categories";

    var subcategoriesTextarea = document.createElement("textarea");
    subcategoriesTextarea.name = "";
    subcategoriesTextarea.id = "";
    subcategoriesTextarea.cols = "30";
    subcategoriesTextarea.rows = "3";
    subcategoriesTextarea.placeholder = "Product Design, Social Design, ...";

    // Append subcategory elements to the form
    form.appendChild(rowDiv);
    form.appendChild(subcategoriesLabel);
    form.appendChild(subcategoriesTextarea);

    // Append form to the main div
    mainDiv.appendChild(form);

    // Append main div after the category container
    categoryContainer.parentNode.insertBefore(
      mainDiv,
      categoryContainer.nextSibling
    );

    // Show the main div and hide the category div
    mainDiv.style.display = "block";
    categoryDiv.style.display = "none";

    // Set the width of the input group
    inputGroupDiv.classList.add("wide-input-group");
  }
</script>
<!-- <script>
  var div = document.getElementById("main");
  var display = 0;
  function hideShow() {
    if (display == 1) {
      div.style.display = "block";
      display = 0;
    } else {
      div.style.display = "none";
      display = 1;
    }
  }
</script> -->
<!-- Hidden Input Field -->
<!-- <script>
  function hideShow() {
    var mainDiv = document.querySelector(".main");
    mainDiv.style.display = "block";
  }

  function removeAllDivs() {
    var mainDiv = document.querySelector(".main");
    mainDiv.parentNode.removeChild(mainDiv);
  }

  function hideAllDivs() {
    var mainDiv = document.querySelector(".main");
    mainDiv.style.display = "none";
    var inputField = document.querySelector(".col-12");
    inputField.style.display = "block";
  }
</script> -->

<!-- Radio tab menu js start from here -->
<script>
  $("[name=tab]").each(function (i, d) {
    var p = $(this).prop("checked");
    //   console.log(p);
    if (p) {
      $("article").eq(i).addClass("on");
    }
  });

  $("[name=tab]").on("change", function () {
    var p = $(this).prop("checked");

    // $(type).index(this) == nth-of-type
    var i = $("[name=tab]").index(this);

    $("article").removeClass("on");
    $("article").eq(i).addClass("on");
  });
</script>
<!-- hide remove input field js -->
<script>
  window.addEventListener("DOMContentLoaded", () => {
    var counter = 0;
    var newFields = document
      .getElementById("input_fields-wrap-1")
      .cloneNode(true);
    newFields.id = "";
    var newField = newFields.childNodes;

    document
      .getElementById("add_field_button")
      .addEventListener("click", () => {
        for (var i = 0; i < newField.length; i++) {
          var theName = newField[i].name;
          if (theName) newField[i].name = theName + counter;
        }

        var insertHere = document.getElementById("input_fields_write");
        insertHere.parentNode.insertBefore(newFields, insertHere);
      });
  });

  function hideField(element) {
    element.style.display = "none";
  }
</script>
<!-- Upload script start -->
<script>
  // File Upload
  //
  function ekUpload() {
    function Init() {
      console.log("Upload Initialised");

      var fileSelect = document.getElementById("file-upload"),
        fileDrag = document.getElementById("file-drag"),
        submitButton = document.getElementById("submit-button");

      fileSelect.addEventListener("change", fileSelectHandler, false);

      // Is XHR2 available?
      var xhr = new XMLHttpRequest();
      if (xhr.upload) {
        // File Drop
        fileDrag.addEventListener("dragover", fileDragHover, false);
        fileDrag.addEventListener("dragleave", fileDragHover, false);
        fileDrag.addEventListener("drop", fileSelectHandler, false);
      }
    }

    function fileDragHover(e) {
      var fileDrag = document.getElementById("file-drag");

      e.stopPropagation();
      e.preventDefault();

      fileDrag.className =
        e.type === "dragover" ? "hover" : "modal-body file-upload";
    }

    function fileSelectHandler(e) {
      // Fetch FileList object
      var files = e.target.files || e.dataTransfer.files;

      // Cancel event and hover styling
      fileDragHover(e);

      // Process all File objects
      for (var i = 0, f; (f = files[i]); i++) {
        parseFile(f);
        uploadFile(f);
      }
    }

    // Output
    function output(msg) {
      // Response
      var m = document.getElementById("messages");
      m.innerHTML = msg;
    }

    function parseFile(file) {
      console.log(file.name);
      output("<strong>" + encodeURI(file.name) + "</strong>");

      // var fileType = file.type;
      // console.log(fileType);
      var imageName = file.name;

      var isGood = /\.(?=gif|jpg|png|jpeg)/gi.test(imageName);
      if (isGood) {
        document.getElementById("start").classList.add("hidden");
        document.getElementById("response").classList.remove("hidden");
        document.getElementById("notimage").classList.add("hidden");
        // Thumbnail Preview
        document.getElementById("file-image").classList.remove("hidden");
        document.getElementById("file-image").src = URL.createObjectURL(file);
      } else {
        document.getElementById("file-image").classList.add("hidden");
        document.getElementById("notimage").classList.remove("hidden");
        document.getElementById("start").classList.remove("hidden");
        document.getElementById("response").classList.add("hidden");
        document.getElementById("file-upload-form").reset();
      }
    }

    function setProgressMaxValue(e) {
      var pBar = document.getElementById("file-progress");

      if (e.lengthComputable) {
        pBar.max = e.total;
      }
    }

    function updateFileProgress(e) {
      var pBar = document.getElementById("file-progress");

      if (e.lengthComputable) {
        pBar.value = e.loaded;
      }
    }

    function uploadFile(file) {
      var xhr = new XMLHttpRequest(),
        fileInput = document.getElementById("class-roster-file"),
        pBar = document.getElementById("file-progress"),
        fileSizeLimit = 1024; // In MB
      if (xhr.upload) {
        // Check if file is less than x MB
        if (file.size <= fileSizeLimit * 1024 * 1024) {
          // Progress bar
          pBar.style.display = "inline";
          xhr.upload.addEventListener("loadstart", setProgressMaxValue, false);
          xhr.upload.addEventListener("progress", updateFileProgress, false);

          // File received / failed
          xhr.onreadystatechange = function (e) {
            if (xhr.readyState == 4) {
              // Everything is good!
              // progress.className = (xhr.status == 200 ? "success" : "failure");
              // document.location.reload(true);
            }
          };

          // Start upload
          xhr.open(
            "POST",
            document.getElementById("file-upload-form").action,
            true
          );
          xhr.setRequestHeader("X-File-Name", file.name);
          xhr.setRequestHeader("X-File-Size", file.size);
          xhr.setRequestHeader("Content-Type", "multipart/form-data");
          xhr.send(file);
        } else {
          output("Please upload a smaller file (< " + fileSizeLimit + " MB).");
        }
      }
    }

    // Check for the various File API support.
    if (window.File && window.FileList && window.FileReader) {
      Init();
    } else {
      document.getElementById("file-drag").style.display = "none";
    }
  }
  ekUpload();
</script>
<!-- Upload script End -->
<!-- FAQs js start -->
<script>
  const accordionItemHeaders = document.querySelectorAll(
    ".accordion-item-header"
  );

  accordionItemHeaders.forEach((accordionItemHeader) => {
    accordionItemHeader.addEventListener("click", (event) => {
      // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

      const currentlyActiveAccordionItemHeader = document.querySelector(
        ".accordion-item-header.active"
      );
      if (
        currentlyActiveAccordionItemHeader &&
        currentlyActiveAccordionItemHeader !== accordionItemHeader
      ) {
        currentlyActiveAccordionItemHeader.classList.toggle("active");
        currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
      }
      accordionItemHeader.classList.toggle("active");
      const accordionItemBody = accordionItemHeader.nextElementSibling;
      if (accordionItemHeader.classList.contains("active")) {
        accordionItemBody.style.maxHeight =
          accordionItemBody.scrollHeight + "px";
      } else {
        accordionItemBody.style.maxHeight = 0;
      }
    });
  });
</script>
<!-- FAQs js end -->
<!-- ================ side js start here=============== -->
<script>
  // Sidebar script
document.addEventListener("DOMContentLoaded", function() {
  let arrow = document.querySelectorAll(".arrow");
  for (let i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", function(e) {
      let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
      arrowParent.classList.toggle("showMenu");
    });
  }

  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");

  sidebarBtn.addEventListener("click", function() {
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
  window.addEventListener("resize", function() {
    toggleSidebar();
  });
});

</script>
<!-- ================ side js start End=============== -->

