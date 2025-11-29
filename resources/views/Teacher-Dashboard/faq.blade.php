@extends('layout.app')
@section('title', 'Teacher Dashboard | FAQ')

@section('content')
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
                    <span class="min-title">FAQ's</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-chat icon" title="FAQ’s"></i>

                      <h2>FAQ</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!--  -->
              <div class="faq-sec">
                <div class="row">
                  <h1>Frequently Asked Questions</h1>

                  @if ($faqs)

                  @foreach ($faqs as $item)

                  <div class="col-md-6 mb-3">
                    <div class="accordion">
                      <div class="accordion-item">
                        <input type="checkbox" id="accordion{{$item->id}}" />
                        <label for="accordion{{$item->id}}" class="accordion-item-title"
                          ><span class="icon"></span>{{$item->question}}</label
                        >
                        <div class="accordion-item-desc">
                          {!! $item->answer !!}
                        </div>
                      </div>

                      {{-- <div class="accordion-item">
                        <input type="checkbox" id="accordion2" />
                        <label for="accordion2" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          The timeline for seeing results from SEO can vary
                          based on several factors, such as the competitiveness
                          of keywords, the current state of the website, and the
                          effectiveness of the SEO strategy. Generally, it may
                          take several weeks to months before noticeable
                          improvements occur. However, long-term commitment to
                          SEO is essential for sustained success.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion3" />
                        <label for="accordion3" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          A successful SEO strategy involves various components,
                          including keyword research, on-page optimization,
                          quality content creation, link building, technical
                          SEO, and user experience optimization. These elements
                          work together to improve a website's relevance and
                          authority in the eyes of search engines.
                        </div>
                      </div> --}}
                    </div>
                  </div>
                      
                  @endforeach
                      
                  @endif
                
                  {{-- <div class="col-md-6">
                    <div class="accordion">
                      <div class="accordion-item">
                        <input type="checkbox" id="accordion4" />
                        <label for="accordion4" class="accordion-item-title"
                          ><span class="icon"></span>How This Work?</label
                        >
                        <div class="accordion-item-desc">
                          Mobile optimization is crucial for SEO because search
                          engines prioritize mobile-friendly websites. With the
                          increasing use of smartphones, search engines like
                          Google consider mobile responsiveness as a ranking
                          factor. Websites that provide a seamless experience on
                          mobile devices are more likely to rank higher in
                          search results.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion5" />
                        <label for="accordion5" class="accordion-item-title"
                          ><span class="icon"></span>How can I reset my
                          password?</label
                        >
                        <div class="accordion-item-desc">
                          Backlinks, or inbound links from other websites to
                          yours, play a significant role in SEO. They are
                          considered a vote of confidence and can improve a
                          site's authority. Quality over quantity is crucial
                          when acquiring backlinks. Strategies for obtaining
                          backlinks include creating high-quality content, guest
                          posting, reaching out to industry influencers, and
                          participating in community activities. It's important
                          to focus on natural and ethical link-building
                          practices.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion6" />
                        <label for="accordion6" class="accordion-item-title"
                          ><span class="icon"></span>How can I reset my
                          password?</label
                        >
                        <div class="accordion-item-desc">
                          Backlinks, or inbound links from other websites to
                          yours, play a significant role in SEO. They are
                          considered a vote of confidence and can improve a
                          site's authority. Quality over quantity is crucial
                          when acquiring backlinks. Strategies for obtaining
                          backlinks include creating high-quality content, guest
                          posting, reaching out to industry influencers, and
                          participating in community activities. It's important
                          to focus on natural and ethical link-building
                          practices.
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>
              </div>
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
    </section>
    
@endsection
    