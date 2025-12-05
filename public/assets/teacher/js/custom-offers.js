/**
 * Custom Offer Management - Unified Modal Version
 * Handles the multi-step custom offer creation wizard for sellers
 */

(function($) {
    'use strict';

    // Current step tracking
    let currentStep = 1;
    const totalSteps = 4;

    // State management
    const offerState = {
        buyer_id: null,
        gig_id: null,
        offer_type: 'Class',
        payment_type: 'Single',
        service_mode: 'Online',
        description: '',
        milestones: [],
        expire_days: null,
        request_requirements: false
    };

    // Initialize when document is ready
    $(document).ready(function() {
        initCustomOfferWizard();
    });

    function initCustomOfferWizard() {
        // Set buyer_id from active chat when modal opens
        $('#customOfferModal').on('show.bs.modal', function() {
            const $activeChat = $('.list-group-item.active');
            const buyerId = $activeChat.data('teacher-id');

            if (buyerId && buyerId !== 'A') {
                offerState.buyer_id = buyerId;
                resetWizard();
            } else {
                alert('Please select a conversation first');
                return false;
            }
        });

        // Reset when modal closes
        $('#customOfferModal').on('hidden.bs.modal', function() {
            resetWizard();
        });

        // Navigation buttons
        $('#offer-back-btn').on('click', goToPreviousStep);
        $('#offer-next-btn').on('click', goToNextStep);
        $('#offer-submit-btn').on('click', submitOffer);

        // Option card selections
        $('input[name="offer_type"]').on('change', function() {
            offerState.offer_type = $(this).val();
        });

        $('input[name="service_mode"]').on('change', function() {
            offerState.service_mode = $(this).val();
        });

        $('input[name="payment_type"]').on('change', function() {
            offerState.payment_type = $(this).val();
            togglePaymentFields();
        });

        // Service card selection
        $(document).on('click', '.service-card', function() {
            $('.service-card').removeClass('selected');
            $(this).addClass('selected');
            offerState.gig_id = $(this).data('gig-id');
            const gigTitle = $(this).data('gig-title');
            $('.selected-service-title').text(gigTitle);
        });

        // Milestone handlers
        $('#add-milestone-btn').on('click', addMilestone);
        $(document).on('click', '.remove-milestone-btn', removeMilestone);
        $(document).on('input', '.milestone-field', function() {
            const index = $(this).data('index');
            const field = $(this).data('field');
            offerState.milestones[index][field] = $(this).val();
            calculateTotalAmount();
        });

        // Single payment price
        $('#single-payment-price').on('input', calculateTotalAmount);

        // Expire checkbox
        $('#offer-expire-checkbox').on('change', function() {
            $('#expire-days-select').prop('disabled', !this.checked);
        });

        // Request requirements
        $('#request-requirements-checkbox').on('change', function() {
            offerState.request_requirements = this.checked;
        });
    }

    /**
     * Reset wizard to initial state
     */
    function resetWizard() {
        currentStep = 1;
        offerState.gig_id = null;
        offerState.offer_type = 'Class';
        offerState.payment_type = 'Single';
        offerState.service_mode = 'Online';
        offerState.description = '';
        offerState.milestones = [];
        offerState.expire_days = null;
        offerState.request_requirements = false;

        // Reset form fields
        $('input[name="offer_type"][value="Class"]').prop('checked', true);
        $('input[name="service_mode"][value="Online"]').prop('checked', true);
        $('input[name="payment_type"][value="Single"]').prop('checked', true);
        $('#offer-description').val('');
        $('#single-payment-price').val('');
        $('#offer-expire-checkbox').prop('checked', false);
        $('#expire-days-select').prop('disabled', true);
        $('#request-requirements-checkbox').prop('checked', false);
        $('#milestones-container').empty();
        $('.total-amount-display').text('$0.00');
        $('.selected-service-title').text('Selected Service');
        $('.service-card').removeClass('selected');

        updateStepDisplay();
    }

    /**
     * Update step display and progress indicator
     */
    function updateStepDisplay() {
        // Hide all steps
        $('.offer-step').addClass('d-none');

        // Show current step
        $(`#step-${currentStep}`).removeClass('d-none');

        // Update progress indicator
        $('.step-item').removeClass('active completed');
        $('.step-line').removeClass('completed');

        for (let i = 1; i <= totalSteps; i++) {
            const $step = $(`.step-item[data-step="${i}"]`);
            if (i < currentStep) {
                $step.addClass('completed');
            } else if (i === currentStep) {
                $step.addClass('active');
            }
        }

        // Update step lines
        $('.step-line').each(function(index) {
            if (index < currentStep - 1) {
                $(this).addClass('completed');
            }
        });

        // Update button visibility
        if (currentStep === 1) {
            $('#offer-back-btn').addClass('d-none');
        } else {
            $('#offer-back-btn').removeClass('d-none');
        }

        if (currentStep === totalSteps) {
            $('#offer-next-btn').addClass('d-none');
            $('#offer-submit-btn').removeClass('d-none');
        } else {
            $('#offer-next-btn').removeClass('d-none');
            $('#offer-submit-btn').addClass('d-none');
        }
    }

    /**
     * Go to previous step
     */
    function goToPreviousStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    }

    /**
     * Go to next step
     */
    function goToNextStep() {
        if (!validateCurrentStep()) {
            return;
        }

        if (currentStep < totalSteps) {
            currentStep++;
            updateStepDisplay();

            // Load services when entering step 3
            if (currentStep === 3) {
                loadSellerServices();
            }

            // Toggle payment fields when entering step 4
            if (currentStep === 4) {
                togglePaymentFields();
            }
        }
    }

    /**
     * Validate current step before proceeding
     */
    function validateCurrentStep() {
        if (currentStep === 3) {
            if (!offerState.gig_id) {
                alert('Please select a service to continue');
                return false;
            }
        }
        return true;
    }

    /**
     * Load seller's services based on offer type AND service mode
     */
    function loadSellerServices() {
        const $container = $('#unified-service-list');
        const typeLabel = offerState.offer_type === 'Class' ? 'class' : 'freelance';
        $('#service-type-label').text(typeLabel + ' services');

        // Show loading
        $container.html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading services...</p>
            </div>
        `);

        $.ajax({
            url: '/get-services-for-custom',
            type: 'POST',
            data: {
                offer_type: offerState.offer_type,
                service_mode: offerState.service_mode,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.services && response.services.length > 0) {
                    renderServiceList(response.services, $container);
                } else {
                    const modeText = offerState.service_mode === 'In-person' ? 'in-person' : 'online';
                    const typeText = offerState.offer_type === 'Class' ? 'class' : 'freelance';
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fa-solid fa-folder-open text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-3 mb-0">No ${modeText} ${typeText} services available.</p>
                            <p class="text-muted small">Create a service first or try a different mode.</p>
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error('Failed to load services:', xhr);
                $container.html(`
                    <div class="text-center p-4">
                        <i class="fa-solid fa-exclamation-triangle text-danger" style="font-size: 48px;"></i>
                        <p class="text-danger mt-3">Failed to load services. Please try again.</p>
                    </div>
                `);
            }
        });
    }

    /**
     * Render service list with enhanced information
     */
    function renderServiceList(services, $container) {
        let html = '';

        services.forEach(function(service) {
            const price = parseFloat(service.price || 0);
            const currencySymbol = getCurrencySymbol();
            const displayPrice = (price * getCurrencyRate()).toFixed(2);

            // Service type badge
            let serviceTypeBadge = '';
            if (service.service_type === 'Online') {
                serviceTypeBadge = '<span class="badge bg-info text-white"><i class="fa-solid fa-globe me-1"></i>Online</span>';
            } else if (service.service_type === 'Inperson') {
                serviceTypeBadge = '<span class="badge bg-warning text-dark"><i class="fa-solid fa-location-dot me-1"></i>In-person</span>';
            } else if (service.service_type === 'Both') {
                serviceTypeBadge = '<span class="badge bg-success text-white"><i class="fa-solid fa-arrows-left-right me-1"></i>Both</span>';
            }

            // Rating stars - calculate average rating (cap at 5 stars)
            const reviewsCount = parseInt(service.reviews || 0);
            const orders = parseInt(service.orders || 0);
            let ratingHtml = '';

            // Calculate average rating - rate might be total sum, so divide by reviews
            let rawRating = parseFloat(service.rate || service.ratings || 0);
            let avgRating = 0;

            if (reviewsCount > 0 && rawRating > 0) {
                // If rating seems like a sum (> 5), calculate average
                avgRating = rawRating > 5 ? (rawRating / reviewsCount) : rawRating;
                // Cap at 5 stars max
                avgRating = Math.min(avgRating, 5);
            } else if (rawRating > 0 && rawRating <= 5) {
                avgRating = rawRating;
            }

            if (avgRating > 0) {
                const fullStars = Math.floor(avgRating);
                const hasHalfStar = (avgRating % 1) >= 0.5;
                for (let i = 0; i < fullStars && i < 5; i++) {
                    ratingHtml += '<i class="fa-solid fa-star text-warning"></i>';
                }
                if (hasHalfStar && fullStars < 5) {
                    ratingHtml += '<i class="fa-solid fa-star-half-stroke text-warning"></i>';
                }
                ratingHtml += ` <span class="text-muted">(${avgRating.toFixed(1)})</span>`;
            } else if (reviewsCount > 0) {
                ratingHtml = `<span class="text-muted"><i class="fa-solid fa-comment me-1"></i>${reviewsCount} review${reviewsCount > 1 ? 's' : ''}</span>`;
            } else {
                ratingHtml = '<span class="text-muted"><i class="fa-regular fa-star me-1"></i>New</span>';
            }

            // Orders count
            const ordersText = orders > 0 ? `${orders} order${orders > 1 ? 's' : ''}` : 'No orders yet';

            // Description preview - use 'description' field from teacher_gig_data
            const description = service.description || service.short_description || '';
            // Strip HTML tags and get first 50 characters
            const cleanDesc = description.replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
            const shortDesc = cleanDesc.length > 50 ? cleanDesc.substring(0, 50) + '...' : cleanDesc;

            // Gig ID - handle both 'id' and 'gig_id'
            const gigId = service.id || service.gig_id;

            html += `
                <div class="service-card enhanced" data-gig-id="${gigId}" data-gig-title="${escapeHtml(service.title)}">
                    <div class="service-card-left">
                        <div class="service-icon-box">
                            <i class="fa-solid fa-${service.service_role === 'Class' ? 'chalkboard-user' : 'briefcase'}"></i>
                        </div>
                    </div>
                    <div class="service-card-center">
                        <div class="service-header">
                            <h6 class="service-title mb-1">${escapeHtml(service.title)}</h6>
                            ${serviceTypeBadge}
                        </div>
                        <div class="service-category text-muted mb-1">
                            <i class="fa-solid fa-folder-open me-1" style="font-size: 11px;"></i>
                            <span style="font-size: 12px;">${escapeHtml(service.category_name || service.category || 'General')}</span>
                        </div>
                        ${shortDesc ? `<p class="service-desc text-muted mb-1" style="font-size: 12px; line-height: 1.4;">${escapeHtml(shortDesc)}</p>` : ''}
                        <div class="service-stats d-flex align-items-center gap-3" style="font-size: 11px;">
                            <span class="rating-stars">${ratingHtml}</span>
                            <span class="orders-count text-muted"><i class="fa-solid fa-shopping-bag me-1"></i>${ordersText}</span>
                        </div>
                    </div>
                    <div class="service-card-right">
                        <div class="service-price-box">
                            <span class="price-label text-muted" style="font-size: 10px;">Starting at</span>
                            <span class="price-value text-primary fw-bold">${currencySymbol}${displayPrice}</span>
                        </div>
                        <div class="select-check">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            `;
        });

        $container.html(html);
    }

    /**
     * Toggle payment fields based on payment type
     */
    function togglePaymentFields() {
        if (offerState.payment_type === 'Milestone') {
            $('#single-payment-fields').addClass('d-none');
            $('#milestone-payment-fields').removeClass('d-none');
            if (offerState.milestones.length === 0) {
                addMilestone();
            }
        } else {
            $('#single-payment-fields').removeClass('d-none');
            $('#milestone-payment-fields').addClass('d-none');
        }
        calculateTotalAmount();
    }

    /**
     * Add a new milestone
     */
    function addMilestone() {
        const milestoneIndex = offerState.milestones.length;

        const milestone = {
            title: '',
            description: '',
            date: null,
            start_time: null,
            end_time: null,
            price: 0,
            revisions: 0,
            delivery_days: null,
            order: milestoneIndex
        };

        offerState.milestones.push(milestone);
        renderMilestones();
    }

    /**
     * Remove a milestone
     */
    function removeMilestone() {
        const index = $(this).data('index');
        offerState.milestones.splice(index, 1);
        offerState.milestones.forEach((m, i) => m.order = i);
        renderMilestones();
        calculateTotalAmount();
    }

    /**
     * Render milestones
     */
    function renderMilestones() {
        const $container = $('#milestones-container');
        let html = '';

        offerState.milestones.forEach(function(milestone, index) {
            const isInPerson = offerState.service_mode === 'In-person';
            const isFreelance = offerState.offer_type === 'Freelance';

            html += `
                <div class="milestone-item" data-index="${index}">
                    <div class="milestone-header">
                        <span class="milestone-number">Milestone ${index + 1}</span>
                        ${index > 0 ? `<button type="button" class="btn btn-sm btn-outline-danger remove-milestone-btn" data-index="${index}"><i class="fa-solid fa-times"></i></button>` : ''}
                    </div>
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" class="form-control form-control-sm milestone-field" data-index="${index}" data-field="title" placeholder="Milestone name" value="${milestone.title}" required>
                        </div>
                        ${isFreelance ? `
                        <div class="col-md-4">
                            <select class="form-select form-select-sm milestone-field" data-index="${index}" data-field="revisions">
                                <option value="0" ${milestone.revisions == 0 ? 'selected' : ''}>0 revisions</option>
                                <option value="1" ${milestone.revisions == 1 ? 'selected' : ''}>1 revision</option>
                                <option value="2" ${milestone.revisions == 2 ? 'selected' : ''}>2 revisions</option>
                                <option value="3" ${milestone.revisions == 3 ? 'selected' : ''}>3 revisions</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control form-control-sm milestone-field" data-index="${index}" data-field="delivery_days" placeholder="Delivery days" value="${milestone.delivery_days || ''}" min="1">
                        </div>
                        ` : ''}
                        <div class="col-md-${isFreelance ? '4' : '12'}">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control milestone-field" data-index="${index}" data-field="price" placeholder="Price" value="${milestone.price || ''}" min="10" step="0.01">
                            </div>
                        </div>
                        ${isInPerson ? `
                        <div class="col-md-4">
                            <input type="date" class="form-control form-control-sm milestone-field" data-index="${index}" data-field="date" value="${milestone.date || ''}" min="${new Date().toISOString().split('T')[0]}">
                        </div>
                        <div class="col-md-4">
                            <input type="time" class="form-control form-control-sm milestone-field" data-index="${index}" data-field="start_time" value="${milestone.start_time || ''}" placeholder="Start time">
                        </div>
                        <div class="col-md-4">
                            <input type="time" class="form-control form-control-sm milestone-field" data-index="${index}" data-field="end_time" value="${milestone.end_time || ''}" placeholder="End time">
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
        });

        $container.html(html);
    }

    /**
     * Calculate and display total amount
     */
    function calculateTotalAmount() {
        let total = 0;

        if (offerState.payment_type === 'Milestone') {
            offerState.milestones.forEach(function(milestone) {
                total += parseFloat(milestone.price) || 0;
            });
        } else {
            total = parseFloat($('#single-payment-price').val()) || 0;
        }

        const displayTotal = getCurrencySymbol() + (total * getCurrencyRate()).toFixed(2);
        $('.total-amount-display').text(displayTotal);

        return total;
    }

    /**
     * Get currency symbol
     */
    function getCurrencySymbol() {
        return (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
    }

    /**
     * Get currency rate
     */
    function getCurrencyRate() {
        return (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
    }

    /**
     * Submit custom offer
     */
    function submitOffer() {
        offerState.description = $('#offer-description').val();
        offerState.expire_days = $('#offer-expire-checkbox').is(':checked')
            ? parseInt($('#expire-days-select').val())
            : null;

        if (!validateOffer()) {
            return;
        }

        const $btn = $('#offer-submit-btn');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');

        const data = {
            buyer_id: offerState.buyer_id,
            gig_id: offerState.gig_id,
            offer_type: offerState.offer_type,
            payment_type: offerState.payment_type,
            service_mode: offerState.service_mode,
            description: offerState.description,
            milestones: offerState.payment_type === 'Milestone'
                ? offerState.milestones
                : [{
                    title: 'Complete Service',
                    price: parseFloat($('#single-payment-price').val()),
                    revisions: parseInt($('#single-payment-revisions').val()) || 0,
                    delivery_days: parseInt($('#single-payment-delivery').val()) || null,
                    description: offerState.description,
                    order: 0
                }],
            expire_days: offerState.expire_days,
            request_requirements: offerState.request_requirements,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: '/custom-offers',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                $('#customOfferModal').modal('hide');
                alert('Custom offer sent successfully!');
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = 'Failed to send offer. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                alert(errorMsg);
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    /**
     * Validate offer before submission
     */
    function validateOffer() {
        if (!offerState.buyer_id) {
            alert('Buyer not selected');
            return false;
        }

        if (!offerState.gig_id) {
            alert('Please select a service');
            return false;
        }

        if (offerState.payment_type === 'Milestone') {
            if (offerState.milestones.length === 0) {
                alert('Please add at least one milestone');
                return false;
            }

            for (let i = 0; i < offerState.milestones.length; i++) {
                const m = offerState.milestones[i];

                if (!m.title || m.title.trim() === '') {
                    alert(`Milestone ${i + 1}: Title is required`);
                    return false;
                }

                if (!m.price || parseFloat(m.price) < 10) {
                    alert(`Milestone ${i + 1}: Price must be at least $10`);
                    return false;
                }

                if (offerState.service_mode === 'In-person') {
                    if (!m.date) {
                        alert(`Milestone ${i + 1}: Date is required for in-person services`);
                        return false;
                    }
                    if (!m.start_time || !m.end_time) {
                        alert(`Milestone ${i + 1}: Start and end times are required`);
                        return false;
                    }
                }

                if (offerState.offer_type === 'Freelance' && !m.delivery_days) {
                    alert(`Milestone ${i + 1}: Delivery days required for freelance`);
                    return false;
                }
            }
        } else {
            const price = parseFloat($('#single-payment-price').val());
            if (!price || price < 10) {
                alert('Price must be at least $10');
                return false;
            }
        }

        return true;
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
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // ============ COUNTER OFFER HANDLING FOR SELLER ============

    let currentCounterOffer = null;

    // Initialize counter offer handlers
    $(document).ready(function() {
        initSellerCounterOfferHandlers();
    });

    function initSellerCounterOfferHandlers() {
        // View counter offer button clicks (from chat messages)
        $(document).on('click', '.view-counter-offer-btn, .custom-offer-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const offerId = $(this).data('offer-id');
            viewOfferForSeller(offerId);
        });

        // Accept counter offer
        $(document).on('click', '#seller-accept-counter-btn', function() {
            if (currentCounterOffer) {
                acceptCounterOffer(currentCounterOffer.id);
            }
        });

        // Reject counter offer - show modal
        $(document).on('click', '#seller-reject-counter-btn', function() {
            if (currentCounterOffer) {
                $('#sellerCounterOfferModal').modal('hide');
                setTimeout(function() {
                    $('#sellerRejectCounterModal').modal('show');
                }, 300);
            }
        });

        // Confirm reject counter offer
        $(document).on('click', '#seller-confirm-reject-counter-btn', function() {
            if (currentCounterOffer) {
                rejectCounterOffer(currentCounterOffer.id, $('#seller-reject-reason').val());
            }
        });
    }

    /**
     * View offer details for seller
     * Determines if it's a counter offer or regular offer
     */
    function viewOfferForSeller(offerId) {
        $.ajax({
            url: `/custom-offers/${offerId}`,
            type: 'GET',
            success: function(response) {
                const offer = response.offer;
                currentCounterOffer = offer;

                if (offer.is_counter_offer) {
                    // Show counter offer modal
                    renderCounterOfferForSeller(offer);
                    $('#sellerCounterOfferModal').modal('show');
                } else {
                    // It's a regular offer - just show info (seller can't do much)
                    alert('This is your original offer. Status: ' + offer.status);
                }
            },
            error: function(xhr) {
                console.error('Failed to load offer details:', xhr);
                alert('Failed to load offer details');
            }
        });
    }

    /**
     * Render counter offer details in seller modal
     */
    function renderCounterOfferForSeller(counterOffer) {
        const symbol = getCurrencySymbol();
        const rate = getCurrencyRate();

        // Counter offer details
        $('.seller-counter-buyer').text(counterOffer.buyer ? counterOffer.buyer.first_name + ' ' + counterOffer.buyer.last_name : 'Buyer');
        $('.seller-counter-amount').text(symbol + (parseFloat(counterOffer.total_amount) * rate).toFixed(2));

        // Get original offer from parent
        if (counterOffer.parent_offer) {
            const original = counterOffer.parent_offer;
            $('.seller-original-service').text(original.gig ? original.gig.title : (counterOffer.gig ? counterOffer.gig.title : 'Service'));
            $('.seller-original-type').text(original.offer_type);
            $('.seller-original-amount').text(symbol + (parseFloat(original.total_amount) * rate).toFixed(2));

            // Calculate price difference
            const originalAmount = parseFloat(original.total_amount);
            const counterAmount = parseFloat(counterOffer.total_amount);
            const diff = counterAmount - originalAmount;
            const diffPercent = ((diff / originalAmount) * 100).toFixed(1);

            const $diffEl = $('.seller-price-diff');
            if (diff < 0) {
                $diffEl.removeClass('increase').addClass('savings bg-danger text-white');
                $diffEl.text('-' + symbol + Math.abs(diff * rate).toFixed(2) + ' (' + Math.abs(diffPercent) + '% less)');
            } else if (diff > 0) {
                $diffEl.removeClass('savings').addClass('increase bg-success text-white');
                $diffEl.text('+' + symbol + (diff * rate).toFixed(2) + ' (' + diffPercent + '% more)');
            } else {
                $diffEl.removeClass('savings increase bg-danger bg-success text-white').addClass('bg-secondary text-white');
                $diffEl.text('Same price');
            }

            // Show milestones comparison if applicable
            if (counterOffer.payment_type === 'Milestone' && counterOffer.milestones && counterOffer.milestones.length > 0) {
                renderMilestonesComparison(original.milestones || [], counterOffer.milestones, rate, symbol);
                $('#seller-counter-milestones-section').show();
            } else {
                $('#seller-counter-milestones-section').hide();
            }
        } else {
            // Fallback if no parent offer data
            $('.seller-original-service').text(counterOffer.gig ? counterOffer.gig.title : 'Service');
            $('.seller-original-type').text(counterOffer.offer_type);
            $('.seller-original-amount').text('N/A');
            $('.seller-price-diff').text('');
            $('#seller-counter-milestones-section').hide();
        }

        // Counter message
        if (counterOffer.counter_message) {
            $('.seller-counter-message').text(counterOffer.counter_message);
            $('#seller-counter-message-section').show();
        } else {
            $('#seller-counter-message-section').hide();
        }

        // Store counter offer ID
        $('#seller-counter-offer-id').val(counterOffer.id);

        // Show/hide action buttons and status message based on status and seller_accepted_at
        const $statusArea = $('.seller-counter-status-message');
        let statusHtml = '';

        // Check if seller has already accepted this counter offer
        if (counterOffer.seller_accepted_at) {
            // Seller already accepted - hide buttons, show waiting message
            $('#seller-accept-counter-btn, #seller-reject-counter-btn').hide();
            statusHtml = '<div class="alert alert-success mt-3"><i class="fa-solid fa-check-circle me-2"></i>You have accepted this counter offer. Waiting for buyer to complete payment.</div>';
        } else if (counterOffer.status === 'pending') {
            // Pending and not accepted yet - show buttons
            $('#seller-accept-counter-btn, #seller-reject-counter-btn').show();
            statusHtml = '';
        } else if (counterOffer.status === 'rejected') {
            // Rejected - hide buttons
            $('#seller-accept-counter-btn, #seller-reject-counter-btn').hide();
            statusHtml = '<div class="alert alert-secondary mt-3"><i class="fa-solid fa-times-circle me-2"></i>You declined this counter offer.</div>';
        } else if (counterOffer.status === 'accepted') {
            // Fully accepted (payment completed) - hide buttons
            $('#seller-accept-counter-btn, #seller-reject-counter-btn').hide();
            statusHtml = '<div class="alert alert-success mt-3"><i class="fa-solid fa-check-circle me-2"></i>This counter offer has been completed.</div>';
        } else {
            // Other statuses - hide buttons
            $('#seller-accept-counter-btn, #seller-reject-counter-btn').hide();
        }

        // Update status area
        if ($statusArea.length) {
            $statusArea.html(statusHtml);
        } else if (statusHtml) {
            // Append to modal body if status area doesn't exist
            $('#sellerCounterOfferModal .modal-body').append('<div class="seller-counter-status-message">' + statusHtml + '</div>');
        }
    }

    /**
     * Render milestones comparison table
     */
    function renderMilestonesComparison(originalMilestones, counterMilestones, rate, symbol) {
        let html = '';

        counterMilestones.forEach(function(counterMilestone, index) {
            const originalMilestone = originalMilestones[index] || {};
            const originalPrice = parseFloat(originalMilestone.price || 0) * rate;
            const counterPrice = parseFloat(counterMilestone.price) * rate;
            const diff = counterPrice - originalPrice;

            let diffClass = '';
            let diffText = '';
            if (diff < 0) {
                diffClass = 'text-danger';
                diffText = '-' + symbol + Math.abs(diff).toFixed(2);
            } else if (diff > 0) {
                diffClass = 'text-success';
                diffText = '+' + symbol + diff.toFixed(2);
            } else {
                diffClass = 'text-muted';
                diffText = 'No change';
            }

            html += `
                <tr>
                    <td>${escapeHtml(counterMilestone.title)}</td>
                    <td>${originalMilestone.price ? symbol + originalPrice.toFixed(2) : 'N/A'}</td>
                    <td><strong>${symbol}${counterPrice.toFixed(2)}</strong></td>
                    <td class="${diffClass}">${diffText}</td>
                </tr>
            `;
        });

        $('#seller-counter-milestones-body').html(html);
    }

    /**
     * Accept counter offer
     */
    function acceptCounterOffer(offerId) {
        const $btn = $('#seller-accept-counter-btn');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Accepting...');

        $.ajax({
            url: `/custom-offers/${offerId}/counter/accept`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Counter offer accepted! The buyer can now proceed to payment.');
                    $('#sellerCounterOfferModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.error || 'Failed to accept counter offer');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to accept counter offer';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                alert(errorMsg);
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    /**
     * Reject counter offer
     */
    function rejectCounterOffer(offerId, reason) {
        const $btn = $('#seller-confirm-reject-counter-btn');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Rejecting...');

        $.ajax({
            url: `/custom-offers/${offerId}/counter/reject`,
            type: 'POST',
            data: {
                reason: reason,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Counter offer rejected. You can send a new offer if you wish.');
                    $('#sellerRejectCounterModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.error || 'Failed to reject counter offer');
                    $btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to reject counter offer';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                alert(errorMsg);
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    }

})(jQuery);
