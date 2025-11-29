/**
 * Custom Offer Management - Buyer Side
 * Handles viewing, accepting, and rejecting custom offers
 */

(function($) {
    'use strict';

    let currentOffer = null;

    $(document).ready(function() {
        initBuyerCustomOffers();
    });

    function initBuyerCustomOffers() {
        // Handle custom offer card clicks
        $(document).on('click', '.custom-offer-card', function() {
            const offerId = $(this).data('offer-id');
            viewOfferDetails(offerId);
        });

        // Handle accept button
        $(document).on('click', '#accept-offer-btn', function() {
            if (currentOffer) {
                acceptOffer(currentOffer.id);
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

        // Total amount
        const totalAmount = parseFloat(offer.total_amount);
        $modal.find('.offer-total-amount').text('$' + totalAmount.toFixed(2));

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
        if (offer.status === 'pending' && !offer.is_expired) {
            $modal.find('.offer-actions').show();
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

            html += `<td>$${parseFloat(milestone.price).toFixed(2)}</td>`;
            html += '</tr>';
        });

        html += '</tbody></table>';
        $container.html(html);
    }

    /**
     * Accept offer and redirect to Stripe checkout
     */
    function acceptOffer(offerId) {
        const $btn = $('#accept-offer-btn');
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: `/custom-offers/${offerId}/accept`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success && response.checkout_url) {
                    // Redirect to Stripe checkout
                    window.location.href = response.checkout_url;
                } else {
                    alert('Failed to process acceptance');
                    $btn.prop('disabled', false).text(originalText);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to accept offer';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                alert(errorMsg);
                $btn.prop('disabled', false).text(originalText);
            }
        });
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
