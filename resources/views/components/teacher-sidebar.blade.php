
@include('components.JSAndMetaTag')
<div class="sidebar">
    <div class="logo-details">
        <i class="">
            @php
            $home = \App\Models\HomeDynamic::first();

        @endphp
        @if ($home)

        <img src="/assets/public-site/asset/img/{{$home->site_logo}}"  width="100%">
        @endif
      </i>
        <span class="logo_name">DREAMCROWD</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/teacher-dashboard">
                <i class='bx bx-grid-alt' title="Dashboard"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/teacher-dashboard">Dashboard</a></li>
            </ul>
        </li>
        <li>
            <a href="/teacher-messages">
                <i class='bx bx-message-square-dots icon' title="Messages"></i>
                <span class="link_name">Messages</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/teacher-messages">Messages</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('teacher.notifications') }}">
                <i class='bx bx-bell icon' title="Notifications"></i>
                <span class="link_name">Notifications</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="{{ route('teacher.notifications') }}">Notifications</a></li>
            </ul>
        </li>
        <li>
            <li>
                <a href="/client-management">
                    <i class='bx bx-user icon' title="Client Managements"></i>
                    <span class="link_name">Client Managements</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/client-management">Client Managements</a></li>
                </ul>
            </li>
            <li>
                <a href="/class-management">
                    <i class='bx bxs-graduation icon' title="Class Management"></i>
                    <span class="link_name">Class Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/class-management">Class Management</a></li>
                </ul>
            </li>
            <li>
                <a href="/teacher/zoom">
                    <i class='bx bx-video icon' title="Zoom Integration"></i>
                    <span class="link_name">Zoom Integration</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/teacher/zoom">Zoom Integration</a></li>
                </ul>
            </li>
            <li>
                <a href="/teacher-profile">
                    <i class='bx bx-user' title="Manage Profile"></i>
                    <span class="link_name">Manage Profile</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/teacher-profile">Manage Profile</a></li>
                </ul>
            </li>
            <li>
                <a href="Earning & Payouts.html">
                    <i class='bx bx-dollar-circle' title="Earning and Payouts"></i>
                    <span class="link_name">Earning and Payouts</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="Earning & Payouts.html">Earning and Payouts</a></li>
                </ul>
            </li>
            <li>
                <a href="invoice.html">
                    <i class='bx bx-receipt icon' title="Invoice Statement"></i>
                    <span class="link_name">Invoice Statement</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="invoice.html">Invoice Statement</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-cog icon' title="Account Settings"></i>
                        <span class="link_name">Account Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Account Settings</a></li>
                    <li><a href="/change-password">Change Password</a></li>
                    <li><a href="/change-email">Change Email</a></li>
                    <li><a href="/change-card-detail">Update Card Detail</a></li>
                    <li><a href="#"  data-bs-target="#exampleModal7"
                        data-bs-toggle="modal">Delete Account</a></li>
                </ul>
            </li>
            <li>
                <a href="/teacher-notes-calender">
                    <i class='bx bx-history icon' title="Notes & Calendar"></i>
                    <span class="link_name">Notes & Calendar</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="notes&calander.html">Notes & Calendar</a></li>
                </ul>
            </li>
            <li>
                <a href="/teacher-reviews">
                    <i class='bx bx-message icon' title="Customer Reviews"></i>
                    <span class="link_name">Customer Reviews</span>
                </a>

            </li>
            <li>
                <a href="/host-guidline">
                    <i class='bx bx-list-ul icon' title="Host Guidelines"></i>
                    <span class="link_name">Host Guidelines</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/host-guidline">Host Guidelines</a></li>
                </ul>
            </li>
            <li>
                <a href="/teacher-faqs">
                    <i class='bx bx-chat icon' title="FAQ’s"></i>
                    <span class="link_name">FAQ’s</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/teacher-faqs">FAQ’s</a></li>
                </ul>
            </li>
            <li>
                <a href="/seller/transactions">
                    <i class='bx bx-id-card icon' title="Contact us"></i>
                    <span class="link_name">Transactions</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/seller/transactions">Transactions</a></li>
                </ul>
            </li>
        <li>
                <a href="/teacher-contact-us">
                    <i class='bx bx-id-card icon' title="Contact us"></i>
                    <span class="link_name">Contact us</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/teacher-contact-us">Contact us</a></li>
                </ul>
            </li>
            <li class="bottom-content" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <a href="#">
                    <i class='bx bx-log-out icon' title="Logout"></i>
                    <span class="link_name">Logout</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/logout">Logout</a></li>
                </ul>
            </li>

    </ul>
</div>





  <!-- Modal -->
  <div class="modal fade logout-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body p-0">
        <h1>Are you really sure you want to log out?</h1>
        <div class="btn-sec">
          <center>
            <button type="button" class="btn btn-no" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-yes"><a style="color: white;text-decoration: none;" href="/logout">Yes</a></button>
          </center>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!--  -->



  <!-- Modal Start Here -->
<div
class="modal fade delete-modal"
id="exampleModal7"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <h1>Are you really sure you want to delete this account?</h1>
      <div class="btn-sec">
        <center>
          <button
            type="button"
            class="btn btn-no"
            id="cancelButton"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          <button
            type="button"
            class="btn btn-yes"
            data-bs-toggle="modal"
            data-bs-target="#delete-teacher-account"
            id="delete-account"
          >  Yes  </button>
        </center>
      </div>
    </div>
  </div>
</div>
</div>
<!-- delete user account modal here -->



<div
class="modal fade delete-modal confirm-delete"
id="delete-teacher-account"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog delete-dialog">
  <div class="modal-content delete-content">
    <div class="modal-body p-0">
      <h1>We are sorry that you’re leaving!</h1>
      <form action="/delete-account" method="POST">
        @csrf
          <div>
              <input type="radio" id="option1" name="mainOptions" value="option1" onclick="showAdditionalOptions1()" checked>
              <label for="option1">I completed a job and don't need Dreamcrowd anymore</label>
          </div>
          <div>
              <input type="radio" id="option2" name="mainOptions" value="option2" onclick="showAdditionalOptions2()">
              <label for="option2">I find it hard to use Dreamcrowd</label>
          </div>
          <div>
              <input type="radio" id="option3" name="mainOptions" value="option3" onclick="showAdditionalOptions3()">
              <label for="option3">I am struggling to find jobs</label>
          </div>
          <div>
              <input type="radio" id="option4" name="mainOptions" value="option4" onclick="showAdditionalOptions4()">
              <label for="option4">Other reasons</label>
          </div>

          <div class="additional-options" id="additionalOptions2">
              <label for="additionalOption2" class="delete-label">Please tell us why you find it hard to use Dreamcrowd</label>
              <textarea class="form-control" cols="3" rows="3" id="additionalOption2" name="additionalOption2" placeholder="Type your reason..."></textarea>
          </div>

          <div class="additional-options" id="additionalOptions4">
              <label for="additionalOption4" class="delete-label">Please tell us the reason as to why you’re leaving</label>
              <textarea class="form-control" cols="3" rows="3" id="additionalOption4" name="additionalOption4" placeholder="Type your reason..."></textarea>
          </div>
          <div class="float-end btn-sec">
            <button type="button" class="btn btn-no" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-yes">Delete Account</button>
          </div>
        </form>
    </div>
  </div>
</div>
</div>
<!-- Modal End Here -->


<!-- Common Sidebar Script -->
<script src="/assets/teacher/asset/js/sidebar.js"></script>
<!-- Active Menu Script -->
<script src="/assets/teacher/asset/js/active-menu.js"></script>
<!-- Common Modal Script (requires jQuery) -->
<script src="/assets/teacher/asset/js/modals.js"></script>
