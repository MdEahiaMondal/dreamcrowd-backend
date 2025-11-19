@include('components.JSAndMetaTag')
<div class="sidebar">
    <div class="logo-details">
        <i class="">
            @php
                $home = \App\Models\HomeDynamic::first();

            @endphp
            @if ($home)

                <img src="/assets/public-site/asset/img/{{$home->site_logo}}" width="100%">
            @endif
        </i>
        <span class="logo_name">DREAMCROWD</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/admin-dashboard">
                <i class='bx bx-grid-alt' title="Dashboard"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/admin-dashboard">Dashboard</a></li>
            </ul>
        </li>
        <!-- <li> -->

        @if (Auth::user()->admin_role >= 2)

            <li>
                <div class="iocn-link">
                    <a href="javascript:void(0)">
                        <i class='bx bx-user icon' title="Seller Management"></i>
                        <span class="link_name">Seller Management</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Seller Management</a></li>
                    <li><a href="{{ route('admin.all-sellers') }}">All Sellers</a></li>
                    <li><a href="/all-application">All Applications</a></li>
                    <li><a href="/seller-request">Seller Requests</a></li>
                    <li><a href="{{ route('admin.all-services') }}">All Services</a></li>
                </ul>
            </li>
            <!-- <li> -->
            <li>
                <a href="{{ route('admin.buyer-management') }}">
                    <i class='bx bx-user icon' title="Buyer Management"></i>
                    <span class="link_name">Buyer Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('admin.buyer-management') }}">Buyer Management</a></li>
                </ul>
            </li>
            <li>
                <a href="/admin-management">
                    <i class='bx bx-user icon' title="Admin Management"></i>
                    <span class="link_name">Admin Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/admin-management">Admin Management</a></li>
                </ul>
            </li>

            @if (Auth::user()->admin_role >= 4)

                <li>
                    <div class="iocn-link">
                        <a href="javascript:void(0)">
                            <i class='bx bx-cog icon' title="Dynamic Management"></i>
                            <span class="link_name">Dynamic Management</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Dynamic Management</a></li>
                        <li><a href="/admin-home-dynamic">Home Page</a></li>
                        <li><a href="/admin-category-dynamic">Categories</a></li>
                        <li><a href="/admin-about-us-dynamic">About us</a></li>
                        <li><a href="/admin-term-condition-dynamic">T&C and Privacy Policy</a></li>
                        <li><a href="/admin-faq-dynamic">FAQ’s</a></li>
                        <li><a href="/admin-social-media-dynamic">Social Media</a></li>
                        <li><a href="/admin-become-expert-dynamic">Become an expert</a></li>
                        <li><a href="/admin-site-banner-dynamic">Sellers Banner</a></li>
                        {{-- <li><a href="/admin-contact-us-dynamic">Contact Us</a></li> --}}
                        <li><a href="/admin-verification-center-dynamic">Verification Center</a></li>
                        <li>
                            <a href="/admin-languages-dynamic">Add Languages</a>
                        </li>
                        <li>
                            <a href="/admin-keyword-suggessions">Keyword Suggessions</a>
                        </li>
                        <li>
                            <a href="/admin-booking-duration">Booking Duration</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <div class="iocn-link">
                        <a href="javascript:void(0)">
                            <i class='bx bx-cog icon' title="Seller Setting"></i>
                            <span class="link_name">Seller Setting</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li>
                            <a href="/admin-top-seller">Top Seller Tag</a>
                        </li>
                        <li>
                            <a href="/admin-services-sorting">Services Sorting</a>
                        </li>
                        <li>
                            <a href="/admin/commission-settings">Commission</a>
                        </li>
                        <li>
                            <a href="/admin/commission-report">Commission Report</a>
                        </li>
                    </ul>
                </li>

            @endif
            <!-- <li> -->
            <li>
                <a href="/admin-host-guidline">
                    <i class='bx bx-list-ul icon' title="Host Guideline"></i>
                    <span class="link_name">Host Guideline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/admin-host-guidline">Host Guideline</a></li>
                </ul>
            </li>
            <li>
                <a href="/admin-messages">
                    <i class='bx bx-chat icon' title="Messages"></i>
                    <span class="link_name">Messages</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/admin-messages">Messages</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.notifications') }}">
                    <i class='bx bx-bell-minus' title="Notifications"></i>
                    <span class="link_name">Notifications</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('admin.notifications') }}">Notifications</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="javascript:void(0)">
                        <i class='bx bx-credit-card-front icon' title="Payment Management"></i>
                        <span class="link_name">Payment Management</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Payment Management</a></li>
                    <li><a href="{{ route('admin.all-orders') }}">All Orders</a></li>
                    <li><a href="{{ route('admin.payout-details') }}">Payout Detail</a></li>
                    <li><a href="{{ route('admin.refund-details') }}">Refund Detail</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.invoice') }}">
                    <i class='bx bx-file' title="Invoice & Statement"></i>
                    <span class="link_name">Invoice & Statement</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('admin.invoice') }}">Invoice & Statement</a></li>
                </ul>
            </li>



            <li>
                <div class="iocn-link">
                    <a href="javascript:void(0)">
                        <i class='bx bx-credit-card-front icon' title="Discount Codes"></i>
                        <span class="link_name">Discount Codes</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a  href="/admin/coupons">Discount Codes</a></li>
                    <li><a href="/admin/coupons/analytics">Coupons Analytics</a></li>
                </ul>
            </li>


            <li>
                <a href="/admin-notes-calender">
                    <i class='bx bx-notepad icon' title="Notes & Calendar"></i>
                    <span class="link_name">Notes & Calendar</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/admin-notes-calender">Notes & Calendar</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.reviews-ratings') }}">
                    <i class='bx bx-star icon' title="Reviews & Ratings"></i>
                    <span class="link_name">Reviews & Ratings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('admin.reviews-ratings') }}">Reviews & Ratings</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="javascript:void(0)">
                        <i
                            class="bx bxs-user-x icon icon"
                            title="Analytics & Reports"
                        ></i>
                        <span class="link_name">Reports</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Reports</a></li>
                    <li>
                        <a href="{{ route('admin.seller-reports') }}">Seller Reports</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.buyer-reports') }}">Buyer Reports</a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="javascript:void(0)">
                        <i class='bx bx-video icon' title="Zoom Integration"></i>
                        <span class="link_name">Zoom Integration</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Zoom Integration</a></li>
                    <li><a href="/admin/zoom/settings">Zoom Settings</a></li>
                    <li><a href="/admin/zoom/live-classes">Live Classes</a></li>
                    <li><a href="/admin/zoom/audit-logs">Audit Logs</a></li>
                    <li><a href="/admin/zoom/security-logs">Security Logs</a></li>
                </ul>
            </li>
        @endif

        <li>
            <a href="/admin-profile">
                <i class='bx bx-cog icon' title="Account Settings"></i>
                <span class="link_name">Account Settings</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/admin-profile">Account Settings</a></li>
            </ul>
        </li>


        <li class="bottom-content" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
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
                        <button type="button" class="btn btn-yes"><a style="color: white;text-decoration: none;"
                                                                     href="/logout">Yes</a></button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->

<!-- Common Sidebar Script -->
<script src="/assets/admin/asset/js/sidebar.js"></script>
<!-- Active Menu Script -->
<script src="/assets/admin/asset/js/active-menu.js"></script>
