/**
 * Custom Offer Management
 * Handles the multi-step custom offer creation wizard for sellers
 */

(function($) {
    'use strict';

    // State management
    const offerState = {
        buyer_id: null,
        gig_id: null,
        offer_type: 'Class',      // 'Class' or 'Freelance'
        payment_type: "Single",    // 'Single' or 'Milestone'
        service_mode: "Online",    // 'Online' or 'In-person'
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
        $('#myModal').on('show.bs.modal', function() {
            // Get buyer_id from the active chat list item
            const $activeChat = $('.list-group-item.active');
            const buyerId = $activeChat.data('teacher-id'); // Note: In teacher dashboard, this is actually the buyer's ID

            if (buyerId && buyerId !== 'A') { // Exclude admin
                offerState.buyer_id = buyerId;
            } else {
                alert('Please select a conversation first');
                $(this).modal('hide');
                return false;
            }
        });

        // Step 1: Offer type selection (Class or Freelance)
        $('input[name="offer_type"]').on('change', function () {
            
            offerState.offer_type = $(this).val();
        });

        // Step 2: Load services when entering service selection modals
        $('#secondModal').on('show.bs.modal', function() {
            loadSellerServices('Class');
        });

        $('#thirdModal').on('show.bs.modal', function() {
            loadSellerServices('Freelance');
        });

        // Service selection
        $(document).on('click', '.service-item', function() {
            offerState.gig_id = $(this).data('gig-id');
            const gigTitle = $(this).data('gig-title');

            // Update service title in subsequent modals
            $('.selected-service-title').text(gigTitle);
        });

        // Step 3: Payment type selection
        $('input[name="payment_type"]').on('change', function() {
            offerState.payment_type = $(this).val();
        });

        // Step 4: Service mode selection (Online/In-person)
        $('input[name="service_mode"]').on('change', function() {
            offerState.service_mode = $(this).val();
            toggleDateTimeFields();
        });

        // Milestone form handlers
        $('#add-milestone-btn').on('click', addMilestone);
        $(document).on('click', '.remove-milestone-btn', removeMilestone);
        $(document).on('input', '.milestone-field', calculateTotalAmount);

        // Single payment form handlers
        $(document).on('input', '#single-payment-price', calculateTotalAmount);

        // Checkbox handlers
        $('#offer-expire-checkbox').on('change', function() {
            $('#expire-days-select').prop('disabled', !this.checked);
        });

        $('#request-requirements-checkbox').on('change', function() {
            offerState.request_requirements = this.checked;
        });

        // Submit handlers
        $('#submit-milestone-offer-btn').on('click', submitOffer);
        $('#submit-single-offer-btn').on('click', submitOffer);

        // Back/Next navigation validation
        $('.next-btn').on('click', validateCurrentStep);
    }

    /**
     * Load seller's services based on offer type
     */
    function loadSellerServices(offerType) {
        const modalId = offerType === 'Class' ? '#secondModal' : '#thirdModal';
        const $modal = $(modalId);
        const $serviceList = $modal.find('.service-list');

        // Show loading state
        $serviceList.html('<div class="text-center p-4"><div class="spinner-border" role="status"></div></div>');

        $.ajax({
            url: '/get-services-for-custom',
            type: 'POST',
            data: {
                offer_type: offerType,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.services && response.services.length > 0) {
                    renderServiceList(response.services, $serviceList);
                } else {
                    $serviceList.html('<div class="text-center p-4"><p class="text-muted">No services available</p></div>');
                }
            },
            error: function(xhr) {
                console.error('Failed to load services:', xhr);
                $serviceList.html('<div class="text-center p-4"><p class="text-danger">Failed to load services</p></div>');
            }
        });
    }

    /**
     * Render service list in modal
     */
    function renderServiceList(services, $container) {
        let html = '';

        services.forEach(function(service) {
            html += `
                <div class="row service service-item"
                     data-gig-id="${service.id}"
                     data-gig-title="${escapeHtml(service.title)}"
                     data-bs-toggle="modal"
                     data-bs-target="#servicemode-modal"
                     data-bs-dismiss="modal">
                    <div class="col-md-6">
                        <h2>${escapeHtml(service.title)}</h2>
                        <a href="#">${escapeHtml(service.category || 'General')}</a>
                    </div>
                    <div class="col-md-6">
                        <a href="#">Starting from ${getCurrencySymbol()}${(parseFloat(service.price || 0) * getCurrencyRate()).toFixed(2)}</a>
                    </div>
                </div>
            `;
        });

        $container.html(html);
    }

    /**
     * Toggle date/time fields based on service mode
     */
    function toggleDateTimeFields() {
        const isInPerson = offerState.service_mode === 'In-person';

        $('.datetime-fields').toggle(isInPerson);
        $('.milestone-datetime').prop('required', isInPerson);
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

        // Reorder remaining milestones
        offerState.milestones.forEach((m, i) => m.order = i);

        renderMilestones();
        calculateTotalAmount();
    }

    /**
     * Render milestones in the form
     */
    function renderMilestones() {
        const $container = $('#milestones-container');
        let html = '';

        offerState.milestones.forEach(function(milestone, index) {
            html += `
                <div class="milestone-item mb-3 p-3 border rounded" data-index="${index}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Milestone ${index + 1}</h5>
                        ${index > 0 ? '<button type="button" class="btn btn-sm btn-danger remove-milestone-btn" data-index="' + index + '">Remove</button>' : ''}
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <input type="text"
                                   class="form-control milestone-field"
                                   data-index="${index}"
                                   data-field="title"
                                   placeholder="Milestone name"
                                   value="${milestone.title}"
                                   required>
                        </div>

                        ${offerState.offer_type === 'Freelance' ? `
                        <div class="col-md-4 mb-2">
                            <select class="form-control milestone-field" data-index="${index}" data-field="revisions" required>
                                <option value="0" ${milestone.revisions === 0 ? 'selected' : ''}>No revisions</option>
                                <option value="1" ${milestone.revisions === 1 ? 'selected' : ''}>1 revision</option>
                                <option value="2" ${milestone.revisions === 2 ? 'selected' : ''}>2 revisions</option>
                                <option value="3" ${milestone.revisions === 3 ? 'selected' : ''}>3 revisions</option>
                                <option value="4" ${milestone.revisions === 4 ? 'selected' : ''}>4 revisions</option>
                                <option value="5" ${milestone.revisions === 5 ? 'selected' : ''}>5 revisions</option>
                            </select>
                            <small class="text-muted">Revisions</small>
                        </div>
                        ` : ''}

                        ${offerState.offer_type === 'Freelance' ? `
                        <div class="col-md-4 mb-2">
                            <input type="number"
                                   class="form-control milestone-field"
                                   data-index="${index}"
                                   data-field="delivery_days"
                                   placeholder="Delivery days"
                                   value="${milestone.delivery_days || ''}"
                                   min="1"
                                   required>
                            <small class="text-muted">Delivery days</small>
                        </div>
                        ` : ''}

                        <div class="col-md-4 mb-2">
                            <input type="number"
                                   class="form-control milestone-field"
                                   data-index="${index}"
                                   data-field="price"
                                   placeholder="Price"
                                   value="${milestone.price}"
                                   min="10"
                                   step="0.01"
                                   required>
                            <small class="text-muted">Price ($)</small>
                        </div>

                        ${offerState.service_mode === 'In-person' ? `
                        <div class="col-md-4 mb-2 datetime-fields">
                            <input type="date"
                                   class="form-control milestone-field milestone-datetime"
                                   data-index="${index}"
                                   data-field="date"
                                   value="${milestone.date || ''}"
                                   min="${new Date().toISOString().split('T')[0]}"
                                   required>
                            <small class="text-muted">Date</small>
                        </div>
                        <div class="col-md-4 mb-2 datetime-fields">
                            <input type="time"
                                   class="form-control milestone-field milestone-datetime"
                                   data-index="${index}"
                                   data-field="start_time"
                                   value="${milestone.start_time || ''}"
                                   required>
                            <small class="text-muted">Start time</small>
                        </div>
                        <div class="col-md-4 mb-2 datetime-fields">
                            <input type="time"
                                   class="form-control milestone-field milestone-datetime"
                                   data-index="${index}"
                                   data-field="end_time"
                                   value="${milestone.end_time || ''}"
                                   required>
                            <small class="text-muted">End time</small>
                        </div>
                        ` : ''}

                        <div class="col-md-12">
                            <textarea class="form-control milestone-field"
                                      data-index="${index}"
                                      data-field="description"
                                      placeholder="Milestone description (optional)"
                                      rows="2">${milestone.description}</textarea>
                        </div>
                    </div>
                </div>
            `;
        });

        $container.html(html);

        // Attach event listeners to new fields
        $('.milestone-field').on('input change', function() {
            const index = $(this).data('index');
            const field = $(this).data('field');
            offerState.milestones[index][field] = $(this).val();
            calculateTotalAmount();
        });
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

        $('.total-amount-display').text(getCurrencySymbol() + (total * getCurrencyRate()).toFixed(2));

        return total;
    }

    /**
     * Get currency symbol from global config
     */
    function getCurrencySymbol() {
        return (typeof currencyConfig !== 'undefined') ? currencyConfig.symbol : '$';
    }

    /**
     * Get currency rate from global config
     */
    function getCurrencyRate() {
        return (typeof currencyConfig !== 'undefined') ? currencyConfig.rate : 1;
    }

    /**
     * Validate current step before proceeding
     */
    function validateCurrentStep(e) {
        const $btn = $(this);
        const $modal = $btn.closest('.modal');

        // Add custom validation logic here based on current modal
        // Return false to prevent next step if validation fails
    }

    /**
     * Submit custom offer
     */
    function submitOffer() {
        // Collect all form data
        offerState.description = $('#offer-description').val();
        offerState.expire_days = $('#offer-expire-checkbox').is(':checked')
            ? parseInt($('#expire-days-select').val())
            : null;

        // Validate
        if (!validateOffer()) {
            return;
        }

        // Show loading state
        const $btn = $(this);
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('Sending...');

        // Prepare data for API
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

        // Submit via AJAX
        $.ajax({
            url: '/custom-offers',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                // Show success message
                alert('Custom offer sent successfully!');

                // Close all modals
                $('.modal').modal('hide');

                // Reset state
                resetOfferState();

                // Reload page to show new offer in chat
                location.reload();
            },
            error: function(xhr) {
                // Show error message
                let errorMsg = 'Failed to send offer. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                alert(errorMsg);

                // Re-enable button
                $btn.prop('disabled', false).text(originalText);
            }
        });
    }

    /**
     * Validate offer data before submission
     */
    function validateOffer() {
        if (!offerState.buyer_id) {
            alert('Buyer not selected');
            return false;
        }

        // if (!offerState.gig_id) {
        //     alert('Please select a service');
        //     return false;
        // }

        // if (!offerState.offer_type) {
        //     alert('Please select offer type');
        //     return false;
        // }

        // if (!offerState.payment_type) {
        //     alert('Please select payment type');
        //     return false;
        // }

        // if (!offerState.service_mode) {
        //     alert('Please select service mode');
        //     return false;
        // }

        if (offerState.payment_type === 'Milestone') {
            if (offerState.milestones.length === 0) {
                alert('Please add at least one milestone');
                return false;
            }

            // Validate each milestone
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
            // Single payment validation
            const price = parseFloat($('#single-payment-price').val());
            if (!price || price < 10) {
                alert('Price must be at least $10');
                return false;
            }
        }

        return true;
    }    

    /**
     * Reset offer state
     */
    function resetOfferState() {
        offerState.buyer_id = null;
        offerState.gig_id = null;
        offerState.offer_type = null;
        offerState.payment_type = null;
        offerState.service_mode = null;
        offerState.description = '';
        offerState.milestones = [];
        offerState.expire_days = null;
        offerState.request_requirements = false;
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

})(jQuery);
