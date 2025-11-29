@extends('layout.app')
@section('title', 'Teacher Dashboard | Customer Reviews')
@push('styles')

@endpush
@section('content')
      <div class="container-fluid control">
        <div class="row">
          <div class="col-md-12">
         
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('teacher.dashboard')],
                ['label' => 'Host Guidelines']
            ]" />
            
            <div class="Guidelines">
              <i class="bx bx-list-ul icon" title="Host Guidelines"></i>
              <span class="row__title">Host Guidelines</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="Page-Account">
              <h2>Host Guidelines</h2>

              <div class="main">
                <div class="row">

                  @if ($host)
                  @foreach ($host as $item)
                      
                  <div class="col-lg-4 col-md-6">
                    <a href="/host-heading/{{$item->id}}">
                      <div class="card">
                        <div class="card-body" >
                          <h5 class="card-title" >
                            {{$item->heading}}
                          </h5>
                          <div class="card-text" style="min-height: 50px;max-height: 50px; overflow: hidden;" >
                             {!! Str::limit($item->detail, 155) !!}
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>

                  @endforeach
                      
                  @endif
                  

                </div>
              </div>
            </div>
            <div class="para">
              <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </div>
 @endsection

