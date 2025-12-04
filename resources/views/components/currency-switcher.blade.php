@php
    $currentCurrency = \App\Services\CurrencyService::getDisplayCurrency();
    $currencies = [
        'USD' => ['symbol' => '$', 'name' => 'US Dollar'],
        'GBP' => ['symbol' => '£', 'name' => 'British Pound'],
        'EUR' => ['symbol' => '€', 'name' => 'Euro'],
    ];
@endphp

<div class="currency-switcher dropdown">
    <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-1"
            type="button"
            id="currencyDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false">
        <span class="currency-symbol">{{ $currencies[$currentCurrency]['symbol'] }}</span>
        <span class="currency-code">{{ $currentCurrency }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
        @foreach($currencies as $code => $info)
            <li>
                <a class="dropdown-item d-flex align-items-center gap-2 {{ $code === $currentCurrency ? 'active' : '' }}"
                   href="#"
                   onclick="switchCurrency('{{ $code }}'); return false;">
                    <span class="currency-option-symbol" style="width: 20px;">{{ $info['symbol'] }}</span>
                    <span>{{ $code }}</span>
                    <span class="text-muted ms-auto small">{{ $info['name'] }}</span>
                    @if($code === $currentCurrency)
                        <i class="bx bx-check text-success"></i>
                    @endif
                </a>
            </li>
        @endforeach
        <li><hr class="dropdown-divider"></li>
        <li class="px-3 py-2">
            <small class="text-muted d-flex align-items-center gap-1">
                <i class="bx bx-info-circle"></i>
                Payments are always processed in USD
            </small>
        </li>
    </ul>
</div>

<style>
.currency-switcher .dropdown-toggle {
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 13px;
    border-color: #dee2e6;
}

.currency-switcher .dropdown-toggle:hover {
    background-color: #f8f9fa;
}

.currency-switcher .dropdown-menu {
    min-width: 220px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.currency-switcher .dropdown-item {
    padding: 8px 16px;
    font-size: 14px;
}

.currency-switcher .dropdown-item.active {
    background-color: #e7f1ff;
    color: #0d6efd;
}

.currency-switcher .dropdown-item:hover:not(.active) {
    background-color: #f8f9fa;
}

.currency-symbol {
    font-weight: 600;
}
</style>

<script>
function switchCurrency(currency) {
    // Show loading state
    const btn = document.getElementById('currencyDropdown');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
    btn.disabled = true;

    fetch('{{ route("currency.set") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ currency: currency })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to reflect new currency
            location.reload();
        } else {
            // Restore button
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Failed to change currency. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Failed to change currency. Please try again.');
    });
}
</script>
