{{-- Custom Offer Card Component --}}
{{-- Usage: <x-custom-offer-card :offer="$offer" /> --}}

@props(['offer'])

<div class="custom-offer-card card my-3 shadow-sm" data-offer-id="{{ $offer->id }}" style="cursor: pointer; border-left: 4px solid #4CAF50;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="card-title mb-0">
                <i class="fa-solid fa-file-invoice"></i> Custom Offer
            </h5>
            @if($offer->status === 'pending')
                @if($offer->isExpired())
                    <span class="badge bg-secondary">Expired</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            @elseif($offer->status === 'accepted')
                <span class="badge bg-success">Accepted</span>
            @elseif($offer->status === 'rejected')
                <span class="badge bg-danger">Rejected</span>
            @endif
        </div>

        <h6 class="text-muted mb-3">{{ $offer->gig->title ?? 'Service' }}</h6>

        <div class="row g-2 small">
            <div class="col-md-6">
                <strong>Type:</strong> {{ $offer->offer_type }}
            </div>
            <div class="col-md-6">
                <strong>Payment:</strong> {{ $offer->payment_type }}
            </div>
            <div class="col-md-6">
                <strong>Service Mode:</strong> {{ $offer->service_mode }}
            </div>
            <div class="col-md-6">
                <strong>Milestones:</strong> {{ $offer->milestones->count() }}
            </div>
        </div>

        @if($offer->description)
            <p class="card-text text-muted small mt-2 mb-2">
                {{ Str::limit($offer->description, 100) }}
            </p>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h5 class="mb-0 text-primary">
                @currency($offer->total_amount)
            </h5>

            @if($offer->status === 'pending' && !$offer->isExpired())
                @if($offer->expires_at)
                    <small class="text-warning">
                        <i class="fa-regular fa-clock"></i>
                        Expires {{ $offer->expires_at->diffForHumans() }}
                    </small>
                @endif
            @endif
        </div>

        <div class="mt-3">
            <button class="btn btn-sm btn-primary" data-offer-id="{{ $offer->id }}">
                View Details
            </button>

            @if($offer->status === 'pending' && !$offer->isExpired())
                <button class="btn btn-sm btn-success ms-2" onclick="event.stopPropagation(); acceptOfferQuick({{ $offer->id }})">
                    <i class="fa-solid fa-check"></i> Accept
                </button>
                <button class="btn btn-sm btn-danger ms-1" onclick="event.stopPropagation(); showRejectModal({{ $offer->id }})">
                    <i class="fa-solid fa-times"></i> Reject
                </button>
            @endif
        </div>

        <small class="text-muted d-block mt-2">
            <i class="fa-regular fa-calendar"></i> Sent {{ $offer->created_at->diffForHumans() }}
        </small>
    </div>
</div>

<script>
    function acceptOfferQuick(offerId) {
        if (confirm('Do you want to accept this offer and proceed to payment?')) {
            $('#accept-offer-btn').click();
        }
    }

    function showRejectModal(offerId) {
        $.ajax({
            url: `/custom-offers/${offerId}`,
            type: 'GET',
            success: function(response) {
                window.currentOffer = response.offer;
                $('#rejectOfferModal').modal('show');
            }
        });
    }
</script>
