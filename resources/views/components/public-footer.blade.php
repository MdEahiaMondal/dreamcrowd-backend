<div class="container-fluid footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="assets/public-site/asset/img/Logo.png" alt="">
                <p>We recruit worldclass experts to help you complete any goals you have. <br />Get the help you need
                    online or in-person.
                <div class="social-icons">
                    @php  $social = \App\Models\SocialMedia::first(); @endphp
                    @if ($social)
                    @if ($social->facebook_link != null)
                    @if ($social->facebook_status == 0)
                    <a href="{{$social->facebook_link}}" target="__"><i class="fa-brands fa-facebook-f"></i></a>
                     @endif
                    @endif
                    @if ($social->insta_link != null)
                    @if ($social->insta_status == 0)
                    <a href="{{$social->insta_link}}" target="__"><i class="fa-brands fa-instagram"></i></a>
                     @endif
                    @endif
                    @if ($social->twitter_link != null)
                    @if ($social->twitter_status == 0)
                    <a href="{{$social->twitter_link}}" target="__"><i class="fa-brands fa-x-twitter"></i></a>
                     @endif
                    @endif
                     
                    @if ($social->tiktok_link != null)
                    @if ($social->tiktok_status == 0)
                    <a href="{{$social->tiktok_link}}" target="__"><i class="fa-brands fa-tiktok"></i></a>
                     @endif
                    @endif
                    @if ($social->youtube_link != null)
                    @if ($social->youtube_status == 0)
                    <a href="{{$social->youtube_link}}" target="__"><i class="fa-brands fa-youtube"></i></a>
                     @endif
                    @endif
                    {{-- <a href=""><i class="fa-brands fa-pinterest"></i></a> --}}
                    @endif
                    
                </div>
                <h3>Subscribe to our newsletter</h3>
                <div class="input-group mb-3 inp">
                    <input type="text" class="form-control fc" placeholder="Enter Your Email...." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Subscribe</button>
                </div>
                <p>By subscribing, you agree to our <a href="/term-condition">terms</a> and <a href="/privacy">privacy policy.</a></p>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-4 footer-links-section">
                        <h6 class="text-center">Company</h6>
                        <ul class="footer-links">
                            <li><a href="/">Home</a></li>
                            <li><a href="/about-us">About us</a></li>
                            <li><a href="/contact-us">Contact us</a></li>
                            <li><a href="/">How it works</a></li>
                            <li><a href="/privacy">Privacy Policy</a></li>
                            <li><a href="/term-condition">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 footer-links-section">
                        <h6 class="text-center">Seller/Expert</h6>
                        <ul class="footer-links">
                            <li><a href="/become-expert">Become a Seller</a></li>
                            @if (!Auth::user())
                            <li><a href="#">Login</a></li>
                            @endif
                            <li><a href="/expert-faqs">FAQ’s</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 footer-links-section">
                        <h6 class="text-center">Buyer/Subscribers</h6>
                        <ul class="footer-links">
                            @if (!Auth::user())
                            <li><a href="#">Register</a></li>
                            <li><a href="#">Login</a></li>
                            @endif
                           
                            <li><a href="/buyer-faqs">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="bordr">
            <!-- ==================== FOOTER COPYRIGHT SECTION START FROM HERE =================== -->
            <div class="row footer-bottom">
                <div class="col-lg-10 col-md-9 col-12">
                    <p>&copy; 2023 DREAMCROWD. All Rights Reserved.</p>
                </div>
                <div class="col-lg-2 col-md-3 col-12 footer-selector">
                    <select class="select2-icon" name="icon">
                        <option value="fa-globe" data-icon="fa-globe">Select Currency</option>
                        <option value="fa-dollar-sign" data-icon="fa-dollar-sign">USD</option>
                        <option value="fa-euro-sign" data-icon="fa-euro-sign">EUR</option>
                        <option value="fa-sterling-sign" data-icon="fa-sterling-sign">GBP</option>
                        <option value="fa-shekel-sign" data-icon="fa-shekel-sign">ILS</option>
                    </select>
                </div>
            </div>
            <!-- ==================== FOOTER COPYRIGHT SECTION ENDED HERE =================== -->
        </div>
    </div>
</div>