{{-- Google Analytics 4 Tracking Script --}}
@if(config('services.google_analytics.enabled') && config('services.google_analytics.measurement_id'))
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
    'send_page_view': true,
    @auth
    'user_id': '{{ auth()->id() }}',
    @endauth
  });

  @if(config('services.google_analytics.debug_mode'))
  // Debug mode enabled
  gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
    'debug_mode': true
  });
  @endif
</script>
@endif
