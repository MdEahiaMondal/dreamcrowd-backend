/**
 * Custom Offer Management - Buyer Side
 * Handles viewing, accepting, and rejecting custom offers
 * With inline Stripe payment processing using Stripe Elements
 */

(function($) {
    'use strict';

    let currentOffer = null;
    let currentPaymentData = null;
    let stripe = null;
    let cardElement = null;
    let elements = null;

    $(document).ready(function() {
        initStripe();
        initBuyerCustomOffers();
    });

    /**
     * Initialize Stripe and Card Element
     */
    function initStripe() {
        if (typeof Stripe !== 'undefined' && typeof stripePublicKey !== 'undefined' && stripePublicKey) {
            stripe = Stripe(stripePublicKey);
            elements = stripe.elements();

            // Create card element with styling
            const style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            cardElement = elements.create('card', { style: style });

            // Handle real-time validation errors
            cardElement.on('change', function(event) {
                const displayError = document.getElementById('stripe-card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        } else {
            console.error('Stripe.js not loaded or stripePublicKey not defined');
        }
    }

    function initBuyerCustomOffers() {
        // Handle custom offer card clicks
        $(document).on('click', '.custom-offer-card', function() {
            const offerId = $(this).data('offer-id');
            viewOfferDetails(offerId);
        });

        // Handle custom offer button clicks (from message items)
        $(document).on('click', '.custom-offer-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const offerId = $(this).data('offer-id');
            viewOfferDetails(offerId);
        });

        // Handle accept button - now opens payment modal
        $(document).on('click', '#accept-offer-btn', function() {
            if (currentOffer) {
                initiatePayment(currentOffer.id);
            }
        });

        // Handle reject button
        $(document).on('click', '#reject-offer-btn', function() {
            if (currentOffer) {
                showRejectModal();
            }
        });

        // Handle reject confirmation
        $(document).on('click', '#confirm-reject-btn', function() {
            const reason = $('#rejection-reason').val();
            if (currentOffer) {
                rejectOffer(currentOffer.id, reason);
            }
        });

        // Handle payment confirmation
        $(document).on('click', '#confirm-payment-btn', function() {
            processPayment();
        });

        // Handle view order button after success
        $(document).on('click', '#view-order-btn', function() {
            if (currentPaymentData && currentPaymentData.redirect_url) {
                window.location.href = currentPaymentData.redirect_url;
            } else {
                window.location.href = '/order-management';
            }
        });

        // Handle payment modal close
        $(document).on('click', '#cancel-payment-btn', function() {
            resetPaymentForm();
        });

        // Mount card element when payment modal is shown
        $('#customOfferPaymentModal').on('shown.bs.modal', function() {
            if (cardElement) {
                cardElement.mount('#stripe-card-element');
            }
        });

        // Unmount card element when payment modal is hidden
        $('#customOfferPaymentModal').on('hidden.bs.modal', function() {
            if (cardElement) {
                cardElement.unmount();
            }
            resetPaymentForm();
        });
    }

    /**
     * Fetch and display offer details
     */
    function viewOfferDetails(offerId) {
        $.ajax({
            url: `/custom-offers/${offerId}`,
            type: 'GET',
            success: function(response) {
                currentOffer = response.offer;
                renderOfferDetails(response.offer);
                $('#offerDetailModal').modal('show');
            },
            error: function(xhr) {
                console.error('Failed to load offer details:', xhr);
                alert('Failed to load offer details');
            }
        });
    }

    /**
     * Render offer details in modal
     */
    function renderOfferDetails(offer) {
        const $modal = $('#offerDetailModal');

        // Basic info
        $modal.find('.offer-service-name').text(offer.gig ? offer.gig.title : 'Service');
        $modal.find('.offer-seller-name').text(offer.seller ? offer.seller.first_name + ' ' + offer.seller.last_name : 'Seller');
        $modal.find('.offer-type').text(offer.offer_type);
        $modal.find('.payment-type').text(offer.payment_type);
        $modal.find('.service-mode').text(offer.service_mode);
        $modal.find('.offer-description').text(offer.description || 'No description provided');

        // Total amount - with currency conversion
        const totalAmount = parseFloat(offer.total_amount);
        const symbol = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
        $modal.find('.offer-total-amount').text(symbol + (totalAmount * rate).toFixed(2));

        // Expiration
        if (offer.expires_at) {
            const expiresAt = new Date(offer.expires_at);
            const now = new Date();
            const isExpired = expiresAt < now;

            if (isExpired) {
                $modal.find('.offer-expiry').html('<span class="text-danger">Expired</span>');
            } else {
                const timeRemaining = getTimeRemaining(expiresAt);
                $modal.find('.offer-expiry').html(`<span class="text-warning">Expires in ${timeRemaining}</span>`);
            }
        } else {
            $modal.find('.offer-expiry').text('No expiration');
        }

        // Milestones
        if (offer.milestones && offer.milestones.length > 0) {
            renderMilestones(offer.milestones, $modal.find('.milestones-list'));
        } else {
            $modal.find('.milestones-list').html('<p class="text-muted">No milestones</p>');
        }

        // Show/hide action buttons based on status
        $modal.find('.offer-status-message').html('');
        if (offer.status === 'pending' && !offer.is_expired) {
            $modal.find('.offer-actions').show();
            $modal.find('#accept-offer-btn, #reject-offer-btn').show();
        } else {
            $modal.find('.offer-actions').hide();

            // Show status message
            let statusMessage = '';
            if (offer.status === 'accepted') {
                statusMessage = '<div class="alert alert-success">This offer has been accepted</div>';
            } else if (offer.status === 'rejected') {
                statusMessage = '<div class="alert alert-danger">This offer was rejected</div>';
            } else if (offer.status === 'expired' || offer.is_expired) {
                statusMessage = '<div class="alert alert-warning">This offer has expired</div>';
            }
            $modal.find('.offer-status-message').html(statusMessage);
        }
    }

    /**
     * Render milestones table
     */
    function renderMilestones(milestones, $container) {
        let html = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        ${milestones[0].date ? '<th>Date</th>' : ''}
                        ${milestones[0].start_time ? '<th>Time</th>' : ''}
                        ${milestones[0].revisions !== null ? '<th>Revisions</th>' : ''}
                        ${milestones[0].delivery_days !== null ? '<th>Delivery</th>' : ''}
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
        `;

        milestones.forEach(function(milestone) {
            html += '<tr>';
            html += `<td>${escapeHtml(milestone.title)}</td>`;
            html += `<td>${escapeHtml(milestone.description || '-')}</td>`;

            if (milestone.date) {
                html += `<td>${formatDate(milestone.date)}</td>`;
            }

            if (milestone.start_time && milestone.end_time) {
                html += `<td>${milestone.start_time} - ${milestone.end_time}</td>`;
            }

            if (milestone.revisions !== null) {
                html += `<td>${milestone.revisions}</td>`;
            }

            if (milestone.delivery_days !== null) {
                html += `<td>${milestone.delivery_days} days</td>`;
            }

            const sym = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
            const rt = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
            html += `<td>${sym}${(parseFloat(milestone.price) * rt).toFixed(2)}</td>`;
            html += '</tr>';
        });

        html += '</tbody></table>';
        $container.html(html);
    }

    /**
     * Initiate payment - get payment intent and show payment modal
     */
    function initiatePayment(offerId) {
        if (!stripe || !cardElement) {
            alert('Payment system not initialized. Please refresh the page and try again.');
            return;
        }

        const $btn = $('#accept-offer-btn');
        const originalText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Processing...');

        $.ajax({
            url: `/custom-offers/${offerId}/accept`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $btn.prop('disabled', false).html(originalText);

                if (response.success) {
                    currentPaymentData = response;

                    // Populate payment modal
                    populatePaymentModal(response.offer);

                    // Store payment intent data
                    $('#payment-offer-id').val(response.offer.id);
                    $('#payment-intent-id').val(response.payment_intent_id);
                    $('#payment-client-secret').val(response.client_secret);

                    // Hide offer detail modal and show payment modal
                    $('#offerDetailModal').modal('hide');
                    setTimeout(function() {
                        $('#customOfferPaymentModal').modal('show');
                    }, 300);
                } else {
                    alert('Failed to initiate payment');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalText);
                let errorMsg = 'Failed to initiate payment';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                alert(errorMsg);
            }
        });
    }

    /**
     * Populate payment modal with offer details
     */
    function populatePaymentModal(offer) {
        const symbol = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;

        $('.payment-service-name').text(offer.service_name);
        $('.payment-subtotal').text(symbol + (parseFloat(offer.subtotal) * rate).toFixed(2));

        if (offer.service_fee > 0) {
            $('.payment-fee').text(symbol + (parseFloat(offer.service_fee) * rate).toFixed(2));
            $('.payment-fee-row').show();
        } else {
            $('.payment-fee-row').hide();
        }

        $('.payment-total').text(symbol + (parseFloat(offer.total_amount) * rate).toFixed(2));
        $('#confirm-payment-btn .btn-text').text('Pay ' + symbol + (parseFloat(offer.total_amount) * rate).toFixed(2));
    }

    /**
     * Process the payment using Stripe Elements
     */
    async function processPayment() {
        // Validate cardholder name
        const holderName = $('#payment-holder-name').val().trim();

        if (!holderName) {
            showPaymentError('Please enter the cardholder name.');
            return;
        }

        const clientSecret = $('#payment-client-secret').val();

        if (!clientSecret) {
            showPaymentError('Payment session expired. Please try again.');
            return;
        }

        // Show loading state
        const $btn = $('#confirm-payment-btn');
        $btn.prop('disabled', true);
        $('#payment-spinner').removeClass('d-none');
        $('#payment-lock-icon').addClass('d-none');
        $btn.find('.btn-text').text('Processing...');
        hidePaymentError();

        try {
            // Confirm the card payment with Stripe
            const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: holderName
                    }
                }
            });

            if (error) {
                // Show error to customer
                showPaymentError(error.message);
                resetPaymentButton();
                return;
            }

            // Payment succeeded or requires capture (manual capture mode)
            if (paymentIntent.status === 'succeeded' || paymentIntent.status === 'requires_capture') {
                // Now create the order on the server
                await createOrder(paymentIntent.id, holderName);
            } else {
                showPaymentError('Payment was not completed. Status: ' + paymentIntent.status);
                resetPaymentButton();
            }
        } catch (err) {
            console.error('Payment error:', err);
            showPaymentError('An unexpected error occurred. Please try again.');
            resetPaymentButton();
        }
    }

    /**
     * Create order after successful payment confirmation
     */
    async function createOrder(paymentIntentId, holderName) {
        try {
            const response = await $.ajax({
                url: '/custom-offers/process-payment',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    offer_id: $('#payment-offer-id').val(),
                    payment_intent_id: paymentIntentId,
                    holder_name: holderName
                }
            });

            if (response.success) {
                currentPaymentData = response;

                // Hide payment modal and show success modal
                $('#customOfferPaymentModal').modal('hide');
                setTimeout(function() {
                    $('#paymentSuccessModal').modal('show');
                }, 300);
            } else {
                showPaymentError(response.error || 'Failed to create order. Please contact support.');
                resetPaymentButton();
            }
        } catch (xhr) {
            let errorMsg = 'Failed to create order. Please contact support.';

            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMsg = xhr.responseJSON.error;
            }

            showPaymentError(errorMsg);
            resetPaymentButton();
        }
    }

    /**
     * Show payment error
     */
    function showPaymentError(message) {
        $('#payment-error-message').removeClass('d-none').find('.error-text').text(message);
    }

    /**
     * Hide payment error
     */
    function hidePaymentError() {
        $('#payment-error-message').addClass('d-none');
    }

    /**
     * Reset payment button to default state
     */
    function resetPaymentButton() {
        const $btn = $('#confirm-payment-btn');
        $btn.prop('disabled', false);
        $('#payment-spinner').addClass('d-none');
        $('#payment-lock-icon').removeClass('d-none');

        if (currentPaymentData && currentPaymentData.offer) {
            const symbol = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
            const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
            $btn.find('.btn-text').text('Pay ' + symbol + (parseFloat(currentPaymentData.offer.total_amount) * rate).toFixed(2));
        } else {
            $btn.find('.btn-text').text('Pay Now');
        }
    }

    /**
     * Reset payment form
     */
    function resetPaymentForm() {
        $('#payment-holder-name').val('');
        if (cardElement) {
            cardElement.clear();
        }
        hidePaymentError();
        resetPaymentButton();
        $('#stripe-card-errors').text('');
    }

    /**
     * Show reject confirmation modal
     */
    function showRejectModal() {
        $('#offerDetailModal').modal('hide');
        $('#rejectOfferModal').modal('show');
    }

    /**
     * Reject offer with reason
     */
    function rejectOffer(offerId, reason) {
        const $btn = $('#confirm-reject-btn');
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: `/custom-offers/${offerId}/reject`,
            type: 'POST',
            data: {
                rejection_reason: reason || 'No reason provided',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Offer rejected successfully');
                $('#rejectOfferModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = 'Failed to reject offer';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                alert(errorMsg);
                $btn.prop('disabled', false).text(originalText);
            }
        });
    }

    /**
     * Calculate time remaining until expiration
     */
    function getTimeRemaining(expiresAt) {
        const now = new Date();
        const diff = expiresAt - now;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

        if (days > 0) {
            return `${days} day${days > 1 ? 's' : ''}`;
        } else if (hours > 0) {
            return `${hours} hour${hours > 1 ? 's' : ''}`;
        } else {
            return `${minutes} minute${minutes > 1 ? 's' : ''}`;
        }
    }

    /**
     * Format date
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

})(jQuery);
