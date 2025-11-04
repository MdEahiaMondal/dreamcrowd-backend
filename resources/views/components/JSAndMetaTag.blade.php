<meta name="csrf-token" content="{{ csrf_token() }}">
<span class="authUserId" data-user-id="{{ auth()->id() }}"></span>
<!-- Include Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<!-- Include your notification script -->
<script src="{{ asset('js/notifications.js') }}"></script>
