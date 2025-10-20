<div class="sidebar">
    <div class="logo-details">
        <i class="">
            @php
                $home = \App\Models\HomeDynamic::first();

            @endphp
            @if ($home)

                <img src="assets/public-site/asset/img/{{$home->site_logo}}" width="100%">
            @endif
        </i>
        <span class="logo_name">DREAMCROWD</span>
    </div>
    <ul class="nav-links">
        <li class="active">
            <a href="/user-dashboard">
                <i class="bx bx-user icon" title="My Profile"></i>
                <span class="link_name">My Profile</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/user-dashboard">My Profile</a></li>
            </ul>
        </li>
        <li>
            <a href="/user-messages">
                <i class="bx bx-message-square-dots icon" title="Messages"></i>
                <span class="link_name">Messages</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/user-messages">Messages</a></li>
            </ul>
        </li>
        <li>
            <a href="notification.html">
                <i class="bx bx-bell icon" title="Notifications"></i>
                <span class="link_name">Notifications</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="notification.html">Notifications</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="/order-management">
                <i class="bx bxs-graduation icon" title="Class Management"></i>
                <span class="link_name">Order Management</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="/order-management">Class Management</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="my-learning.html">
                <i class="bx bx-book-reader" title="Video Orders"></i>
                <span class="link_name">Video Orders</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="my-learning.html">Video Orders</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="purchase-history.html">
                <i class="bx bx-history" title="Purchase History"></i>
                <span class="link_name">Purchase History</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="purchase-history.html">Purchase History</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/wish-list">
                <i class="bx bx-list-ul icon" title="Wishlist"></i>
                <span class="link_name">Wishlist</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/wish-list">Wishlist</a></li>
            </ul>
        </li>
        <li>
            <a href="/reviews">
                <i class="bx bx-message-alt-minus icon" title="Reviews"></i>
                <span class="link_name">Reviews</span>
            </a>
{{--            <ul class="sub-menu blank">--}}
{{--                <li><a class="link_name" href="reviews.html">Reviews</a></li>--}}
{{--            </ul>--}}
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class="bx bx-cog icon" title="Account Settings"></i>
                    <span class="link_name">Account Settings</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Account Settings</a></li>
                <li><a href="/change-password">Change Password</a></li>
                <li><a href="/change-email">Change Email</a></li>
                <li><a href="/change-card-detail">Update Card Detail</a></li>
                <li><a href="#" data-bs-target="#exampleModal7"
                       data-bs-toggle="modal">Delete Account</a></li>
            </ul>
        </li>
        <li>
            <a href="/user-faqs">
                <i class="bx bx-chat icon" title="FAQ's"></i>
                <span class="link_name">FAQ’s</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/user-faqs">FAQ’s</a></li>
            </ul>
        </li>
        <li>
            <a href="/user-contact-us">
                <i class="bx bx-id-card icon" title="Contact us"></i>
                <span class="link_name">Contact us</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/user-contact-us">Contact us</a></li>
            </ul>
        </li>
        <li class="bottom-content" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            <a href="#">
                <i class="bx bx-log-out icon" title="Logout"></i>
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
                        <button type="button" class="btn btn-yes"><a style="color: white;text-decoration: none;"
                                                                     href="/logout">Yes</a></button>
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
                        > Yes
                        </button>
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
                        <input type="radio" id="option1" name="mainOptions" value="option1"
                               onclick="showAdditionalOptions1()" checked>
                        <label for="option1">I completed a job and don't need Dreamcrowd anymore</label>
                    </div>
                    <div>
                        <input type="radio" id="option2" name="mainOptions" value="option2"
                               onclick="showAdditionalOptions2()">
                        <label for="option2">I find it hard to use Dreamcrowd</label>
                    </div>
                    <div>
                        <input type="radio" id="option3" name="mainOptions" value="option3"
                               onclick="showAdditionalOptions3()">
                        <label for="option3">I am struggling to find jobs</label>
                    </div>
                    <div>
                        <input type="radio" id="option4" name="mainOptions" value="option4"
                               onclick="showAdditionalOptions4()">
                        <label for="option4">Other reasons</label>
                    </div>

                    <div class="additional-options" id="additionalOptions2">
                        <label for="additionalOption2" class="delete-label">Please tell us why you find it hard to use
                            Dreamcrowd</label>
                        <textarea class="form-control" cols="3" rows="3" id="additionalOption2" name="additionalOption2"
                                  placeholder="Type your reason..."></textarea>
                    </div>

                    <div class="additional-options" id="additionalOptions4">
                        <label for="additionalOption4" class="delete-label">Please tell us the reason as to why you’re
                            leaving</label>
                        <textarea class="form-control" cols="3" rows="3" id="additionalOption4" name="additionalOption4"
                                  placeholder="Type your reason..."></textarea>
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
