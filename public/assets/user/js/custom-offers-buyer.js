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

        // Handle counter offer button
        $(document).on('click', '#counter-offer-btn', function() {
            if (currentOffer) {
                showCounterOfferModal();
            }
        });

        // Handle counter offer submission
        $(document).on('click', '#submit-counter-btn', function() {
            submitCounterOffer();
        });

        // Update price difference when counter amount changes
        $(document).on('input', '#counter-total-amount', function() {
            updatePriceDifference();
        });

        // Update total from milestone prices
        $(document).on('input', '.counter-milestone-price', function() {
            recalculateTotalFromMilestones();
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

        // Show/hide action buttons based on status and offer type
        $modal.find('.offer-status-message').html('');
        $modal.find('.offer-actions').hide();
        $modal.find('#accept-offer-btn, #reject-offer-btn, #counter-offer-btn').hide();

        if (offer.is_counter_offer) {
            // This is a counter offer sent BY the buyer
            if (offer.status === 'pending' && !offer.is_expired) {
                // Check if seller has accepted the counter offer
                if (offer.seller_accepted_at) {
                    // Seller accepted the counter offer - buyer can now pay
                    $modal.find('.offer-status-message').html(
                        '<div class="alert alert-success"><i class="fa-solid fa-check-circle me-2"></i><strong>Counter Offer Accepted!</strong> The seller has accepted your counter offer. You can now proceed to payment.</div>'
                    );
                    $modal.find('.offer-actions').show();
                    $modal.find('#accept-offer-btn').show().html('<i class="fa-solid fa-credit-card"></i> Pay Now');
                } else {
                    // Still waiting for seller response
                    $modal.find('.offer-status-message').html(
                        '<div class="alert alert-info"><i class="fa-solid fa-clock me-2"></i><strong>Counter Offer Sent</strong> - Waiting for seller to respond.</div>'
                    );
                }
            } else if (offer.status === 'rejected') {
                $modal.find('.offer-status-message').html(
                    '<div class="alert alert-danger"><i class="fa-solid fa-times-circle me-2"></i><strong>Counter Offer Declined</strong>' +
                    (offer.rejection_reason ? '<br><small>Reason: ' + escapeHtml(offer.rejection_reason) + '</small>' : '') + '</div>'
                );
            } else if (offer.status === 'accepted') {
                $modal.find('.offer-status-message').html(
                    '<div class="alert alert-success"><i class="fa-solid fa-check-circle me-2"></i>This offer has been completed.</div>'
                );
            } else if (offer.is_expired) {
                $modal.find('.offer-status-message').html(
                    '<div class="alert alert-warning"><i class="fa-solid fa-clock me-2"></i>This counter offer has expired.</div>'
                );
            }
        } else {
            // This is an original offer from the seller
            if (offer.status === 'pending' && !offer.is_expired) {
                $modal.find('.offer-actions').show();
                $modal.find('#accept-offer-btn, #reject-offer-btn, #counter-offer-btn').show();
                $modal.find('#accept-offer-btn').html('<i class="fa-solid fa-check"></i> Accept & Pay');
            } else {
                // Show status message for non-pending offers
                let statusMessage = '';
                if (offer.status === 'accepted') {
                    statusMessage = '<div class="alert alert-success"><i class="fa-solid fa-check-circle me-2"></i>This offer has been accepted</div>';
                } else if (offer.status === 'rejected') {
                    statusMessage = '<div class="alert alert-danger"><i class="fa-solid fa-times-circle me-2"></i>This offer was rejected</div>';
                } else if (offer.status === 'expired' || offer.is_expired) {
                    statusMessage = '<div class="alert alert-warning"><i class="fa-solid fa-clock me-2"></i>This offer has expired</div>';
                }
                $modal.find('.offer-status-message').html(statusMessage);
            }
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
     * Show counter offer modal with original offer data
     */
    function showCounterOfferModal() {
        if (!currentOffer) return;

        const symbol = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
        const totalAmount = parseFloat(currentOffer.total_amount);

        // Populate original offer details
        $('.counter-original-service').text(currentOffer.gig ? currentOffer.gig.title : 'Service');
        $('.counter-original-type').text(currentOffer.offer_type);
        $('.counter-original-payment-type').text(currentOffer.payment_type);
        $('.counter-original-amount').text(symbol + (totalAmount * rate).toFixed(2));
        $('.counter-original-price-display').text(symbol + (totalAmount * rate).toFixed(2));
        $('.counter-currency-symbol').text(symbol);

        // Set original offer ID
        $('#counter-original-offer-id').val(currentOffer.id);

        // Pre-fill with original amount
        $('#counter-total-amount').val((totalAmount * rate).toFixed(2));

        // Reset message
        $('#counter-message').val('');

        // Handle milestones
        if (currentOffer.payment_type === 'Milestone' && currentOffer.milestones && currentOffer.milestones.length > 0) {
            $('#counter-milestones-section').show();
            populateCounterMilestones(currentOffer.milestones, rate, symbol);
        } else {
            $('#counter-milestones-section').hide();
            $('#counter-milestones-list').empty();
        }

        // Reset price difference
        updatePriceDifference();

        // Hide offer detail modal and show counter offer modal
        $('#offerDetailModal').modal('hide');
        setTimeout(function() {
            $('#counterOfferModal').modal('show');
        }, 300);
    }

    /**
     * Populate milestone inputs for counter offer
     */
    function populateCounterMilestones(milestones, rate, symbol) {
        let html = '';
        milestones.forEach(function(milestone, index) {
            const price = parseFloat(milestone.price) * rate;
            html += `
                <div class="counter-milestone-item" data-original-price="${milestone.price}">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="milestone-title">${escapeHtml(milestone.title)}</div>
                            <small class="text-muted">${escapeHtml(milestone.description || 'No description')}</small>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Original: ${symbol}${price.toFixed(2)}</small>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group milestone-price-input">
                                <span class="input-group-text">${symbol}</span>
                                <input type="number" class="form-control counter-milestone-price"
                                       data-index="${index}" value="${price.toFixed(2)}"
                                       min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#counter-milestones-list').html(html);
    }

    /**
     * Update the price difference display
     */
    function updatePriceDifference() {
        const symbol = (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
        const originalAmount = parseFloat(currentOffer.total_amount) * rate;
        const counterAmount = parseFloat($('#counter-total-amount').val()) || 0;

        const diff = counterAmount - originalAmount;
        const $diffEl = $('.counter-price-diff');

        if (diff < 0) {
            $diffEl.removeClass('increase').addClass('savings');
            $diffEl.text('Saving ' + symbol + Math.abs(diff).toFixed(2));
        } else if (diff > 0) {
            $diffEl.removeClass('savings').addClass('increase');
            $diffEl.text('+' + symbol + diff.toFixed(2));
        } else {
            $diffEl.removeClass('savings increase');
            $diffEl.text('Same price');
        }
    }

    /**
     * Recalculate total from milestone prices
     */
    function recalculateTotalFromMilestones() {
        let total = 0;
        $('.counter-milestone-price').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#counter-total-amount').val(total.toFixed(2));
        updatePriceDifference();
    }

    /**
     * Collect milestone data for counter offer
     */
    function collectCounterMilestones() {
        const milestones = [];
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;

        if (currentOffer.milestones && currentOffer.milestones.length > 0) {
            currentOffer.milestones.forEach(function(milestone, index) {
                const $input = $(`.counter-milestone-price[data-index="${index}"]`);
                const newPrice = parseFloat($input.val()) / rate; // Convert back to base currency

                milestones.push({
                    title: milestone.title,
                    description: milestone.description,
                    price: newPrice.toFixed(2),
                    date: milestone.date,
                    start_time: milestone.start_time,
                    end_time: milestone.end_time,
                    delivery_days: milestone.delivery_days,
                    revisions: milestone.revisions
                });
            });
        }

        return milestones;
    }

    /**
     * Submit counter offer
     */
    function submitCounterOffer() {
        const offerId = $('#counter-original-offer-id').val();
        const message = $('#counter-message').val().trim();
        const rate = (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
        const totalAmount = parseFloat($('#counter-total-amount').val()) / rate; // Convert back to base currency

        if (!totalAmount || totalAmount < 1) {
            alert('Please enter a valid amount');
            return;
        }

        const $btn = $('#submit-counter-btn');
        $btn.prop('disabled', true);
        $('#counter-spinner').removeClass('d-none');
        $('#counter-send-icon').addClass('d-none');
        $btn.find('.btn-text').text('Sending...');

        const data = {
            counter_message: message,
            total_amount: totalAmount.toFixed(2),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // Include milestones if it's a milestone payment
        if (currentOffer.payment_type === 'Milestone') {
            data.milestones = collectCounterMilestones();
        }

        $.ajax({
            url: `/custom-offers/${offerId}/counter`,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    alert('Counter offer sent successfully! The seller will be notified.');
                    $('#counterOfferModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.error || 'Failed to send counter offer');
                    resetCounterButton();
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to send counter offer';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                alert(errorMsg);
                resetCounterButton();
            }
        });
    }

    /**
     * Reset counter offer button
     */
    function resetCounterButton() {
        const $btn = $('#submit-counter-btn');
        $btn.prop('disabled', false);
        $('#counter-spinner').addClass('d-none');
        $('#counter-send-icon').removeClass('d-none');
        $btn.find('.btn-text').text('Send Counter Offer');
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
