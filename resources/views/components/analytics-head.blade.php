{{-- Google Analytics 4 Tracking --}}
@if(config('services.google_analytics.enabled') && config('services.google_analytics.measurement_id'))
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  // Base configuration
  gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
    'send_page_view': true,
    @if(config('services.google_analytics.debug_mode'))
    'debug_mode': true,
    @endif
    @auth
    'user_id': '{{ auth()->id() }}',
    @endauth
    'custom_map': {
      'dimension1': 'user_role',
      'dimension2': 'user_id',
      'dimension3': 'service_type',
      'dimension4': 'service_delivery',
      'dimension5': 'category_id',
      'dimension6': 'payment_method',
      'dimension7': 'transaction_status',
      'dimension8': 'order_frequency',
      'dimension9': 'coupon_code',
      'metric1': 'commission_amount',
      'metric2': 'seller_earnings',
      'metric3': 'buyer_commission',
      'metric4': 'discount_amount'
    }
  });

  // Set user properties
  @auth
  gtag('set', 'user_properties', {
    'user_role': '{{ ["buyer", "seller", "admin"][auth()->user()->role] ?? "guest" }}',
    'user_id': '{{ auth()->id() }}'
  });
  @endauth
</script>
@endif
