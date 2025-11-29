{{-- Google Analytics 4 --}}
<x-analytics-head />

<meta name="csrf-token" content="{{ csrf_token() }}">
@php

    $userRole = Auth::user()->role ?? null;

@endphp

<span class="authUserId" data-user-id="{{ auth()->id() }}" data-user-role="{{ $userRole }}"></span>
<!-- Include Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<!-- Include your notification script -->
<script src="{{ asset('js/notifications.js') }}"></script>

<!-- Include Google Analytics Helper -->
<script src="{{ asset('js/analytics-helper.js') }}"></script>
