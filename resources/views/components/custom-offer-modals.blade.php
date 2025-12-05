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
                <button type="button" class="btn btn-warning" id="counter-offer-btn">
                    <i class="fa-solid fa-exchange-alt"></i> Counter Offer
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

<!-- Counter Offer Modal -->
<div class="modal fade" id="counterOfferModal" tabindex="-1" aria-labelledby="counterOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="counterOfferModalLabel">
                    <i class="fa-solid fa-exchange-alt me-2"></i>Send Counter Offer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Original Offer Summary -->
                <div class="card mb-4 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fa-solid fa-file-invoice me-2"></i>Original Offer</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Service:</strong> <span class="counter-original-service"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Type:</strong> <span class="counter-original-type"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Payment Type:</strong> <span class="counter-original-payment-type"></span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Original Amount:</strong> <span class="counter-original-amount text-primary fw-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter Offer Form -->
                <form id="counter-offer-form">
                    <input type="hidden" id="counter-original-offer-id">

                    <!-- Message -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fa-solid fa-comment me-2"></i>Your Message</h6>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" id="counter-message" rows="3"
                                      placeholder="Explain your counter offer to the seller (e.g., 'I'd like to propose a lower price...')"></textarea>
                        </div>
                    </div>

                    <!-- Price Adjustment -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fa-solid fa-dollar-sign me-2"></i>Your Proposed Price</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label for="counter-total-amount" class="form-label">Total Amount *</label>
                                    <div class="input-group">
                                        <span class="input-group-text counter-currency-symbol">$</span>
                                        <input type="number" class="form-control form-control-lg" id="counter-total-amount"
                                               min="1" step="0.01" required placeholder="Enter your proposed price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="counter-price-comparison mt-3 mt-md-4">
                                        <span class="text-muted">Original: </span>
                                        <span class="counter-original-price-display fw-bold"></span>
                                        <span class="counter-price-diff ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Milestones Section (shown for Milestone payment type) -->
                    <div class="card mb-4" id="counter-milestones-section" style="display: none;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fa-solid fa-list-check me-2"></i>Adjust Milestones</h6>
                            <small class="text-muted">Modify individual milestone prices</small>
                        </div>
                        <div class="card-body">
                            <div id="counter-milestones-list">
                                <!-- Milestones will be populated dynamically -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-warning" id="submit-counter-btn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="counter-spinner"></span>
                    <i class="fa-solid fa-paper-plane me-1" id="counter-send-icon"></i>
                    <span class="btn-text">Send Counter Offer</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal for Custom Offer -->
<div class="modal fade" id="customOfferPaymentModal" tabindex="-1" aria-labelledby="customOfferPaymentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="customOfferPaymentModalLabel">
                    <i class="fa-solid fa-credit-card me-2"></i>Complete Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Order Summary -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fa-solid fa-receipt me-2"></i>Order Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service:</span>
                            <span class="payment-service-name fw-bold"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="payment-subtotal"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 payment-fee-row">
                            <span>Service Fee:</span>
                            <span class="payment-fee"></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="payment-total text-primary fs-5"></strong>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="custom-offer-payment-form">
                    <input type="hidden" id="payment-offer-id" name="offer_id">
                    <input type="hidden" id="payment-intent-id" name="payment_intent_id">
                    <input type="hidden" id="payment-client-secret" name="client_secret">

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fa-solid fa-lock me-2"></i>Card Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="payment-holder-name" class="form-label">Cardholder Name *</label>
                                <input type="text" class="form-control" id="payment-holder-name" name="holder_name"
                                       placeholder="Name on card" required>
                            </div>

                            <!-- Stripe Card Element Container -->
                            <div class="mb-3">
                                <label class="form-label">Card Details *</label>
                                <div id="stripe-card-element" class="form-control" style="padding: 12px; height: auto;"></div>
                                <div id="stripe-card-errors" class="text-danger small mt-1"></div>
                            </div>

                            <div class="alert alert-info small mb-0">
                                <i class="fa-solid fa-shield-halved me-1"></i>
                                Your payment is secured with Stripe. We never store your card details.
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Error Display -->
                <div class="alert alert-danger mt-3 d-none" id="payment-error-message">
                    <i class="fa-solid fa-exclamation-circle me-1"></i>
                    <span class="error-text"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel-payment-btn">
                    <i class="fa-solid fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirm-payment-btn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="payment-spinner"></span>
                    <i class="fa-solid fa-lock me-1" id="payment-lock-icon"></i>
                    <span class="btn-text">Pay Now</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Success Modal -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="mb-4">
                    <i class="fa-solid fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="mb-3">Payment Successful!</h4>
                <p class="text-muted mb-4">Your order has been placed successfully. The seller has been notified.</p>
                <button type="button" class="btn btn-primary" id="view-order-btn">
                    <i class="fa-solid fa-eye me-1"></i>View Order
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

    #custom-offer-payment-form .form-control {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }

    #custom-offer-payment-form .form-label {
        font-weight: 500;
    }

    #customOfferPaymentModal .card {
        border: 1px solid #e0e0e0;
    }

    #customOfferPaymentModal .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    /* Counter Offer Modal Styles */
    #counterOfferModal .card {
        border: 1px solid #e0e0e0;
    }

    #counterOfferModal .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .counter-price-diff {
        font-size: 0.9rem;
        padding: 2px 8px;
        border-radius: 4px;
    }

    .counter-price-diff.savings {
        background-color: #d4edda;
        color: #155724;
    }

    .counter-price-diff.increase {
        background-color: #f8d7da;
        color: #721c24;
    }

    .counter-milestone-item {
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        background-color: #fafafa;
    }

    .counter-milestone-item .milestone-title {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .counter-milestone-item .milestone-price-input {
        max-width: 150px;
    }
</style>
