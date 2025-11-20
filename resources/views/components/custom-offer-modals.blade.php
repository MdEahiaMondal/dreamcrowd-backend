{{-- Custom Offer Modals for Buyer Side --}}
{{-- Usage: Include this in the User-Dashboard/messages.blade.php --}}
{{-- @include('components.custom-offer-modals') --}}

<!-- Offer Detail Modal -->
<div class="modal fade" id="offerDetailModal" tabindex="-1" aria-labelledby="offerDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="offerDetailModalLabel">Custom Offer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Status Message -->
                <div class="offer-status-message"></div>

                <!-- Service Information -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Service Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Service:</strong> <span class="offer-service-name"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Seller:</strong> <span class="offer-seller-name"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Type:</strong> <span class="offer-type"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Payment Type:</strong> <span class="payment-type"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Service Mode:</strong> <span class="service-mode"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Expires:</strong> <span class="offer-expiry"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Description</h6>
                    </div>
                    <div class="card-body">
                        <p class="offer-description"></p>
                    </div>
                </div>

                <!-- Milestones -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Milestones / Deliverables</h6>
                    </div>
                    <div class="card-body milestones-list">
                        <!-- Milestones table will be inserted here -->
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Total Amount:</h5>
                            <h4 class="mb-0 text-primary offer-total-amount"></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer offer-actions">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="reject-offer-btn">
                    <i class="fa-solid fa-times"></i> Reject
                </button>
                <button type="button" class="btn btn-success" id="accept-offer-btn">
                    <i class="fa-solid fa-check"></i> Accept & Pay
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Offer Modal -->
<div class="modal fade" id="rejectOfferModal" tabindex="-1" aria-labelledby="rejectOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectOfferModalLabel">Reject Custom Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this offer?</p>
                <p class="text-muted small">The seller will be notified of your rejection.</p>

                <div class="mb-3">
                    <label for="rejection-reason" class="form-label">Reason (optional):</label>
                    <textarea class="form-control" id="rejection-reason" rows="3"
                              placeholder="Let the seller know why you're rejecting this offer..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-reject-btn">
                    <i class="fa-solid fa-times"></i> Confirm Rejection
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-offer-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .custom-offer-card .card-body {
        padding: 1.25rem;
    }

    .milestones-list table {
        font-size: 0.9rem;
    }

    .milestones-list table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .offer-status-message {
        margin-bottom: 1rem;
    }
</style>
