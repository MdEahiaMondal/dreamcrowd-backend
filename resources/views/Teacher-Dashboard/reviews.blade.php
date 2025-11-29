@extends('layout.app')
@section('title', 'Teacher Dashboard | Reviews')
@push('styles')
    <link rel="stylesheet" href="assets/user/asset/css/table.css" />

    <style>
        .star-rating i {
            font-size: 18px;
            margin-right: 2px;
        }

        .review-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
        }

        .para-1 {
            font-weight: 600;
            color: #333;
        }

        .para-2 {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        #service-image {
            border-radius: 8px;
            object-fit: cover;
        }

        #replies-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .reply-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 3px solid #007bff;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .reply-actions {
            display: flex;
            gap: 10px;
        }

        .customer-review {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #ffc107;
        }

        .reply-form {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
            height: 25px !important;
        }
    </style>
@endpush
@section('content')


    <div class="container-fluid">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Reviews</span>
                            </div>
                        </div>
                    </div>

                    <!-- Blue MESSAGES section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="bx bx-message-alt-minus icon" title="Reviews"></i>
                                    <h2>Customer Reviews</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="/teacher-reviews" id="filterForm">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search reviews..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="service_type" class="form-control">
                                            <option value="">All Services</option>
                                            <option value="gig" {{ request('service_type') == 'gig' ? 'selected' : '' }}>
                                                Freelance Service
                                            </option>
                                            <option value="order"
                                                {{ request('service_type') == 'order' ? 'selected' : '' }}>
                                                Order Service
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="rating" class="form-control">
                                            <option value="">All Ratings</option>
                                            @for ($i = 5; $i >= 1; $i--)
                                                <option value="{{ $i }}"
                                                    {{ request('rating') == $i ? 'selected' : '' }}>
                                                    {{ $i }} Stars
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_from" class="form-control" placeholder="From Date"
                                            value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_to" class="form-control" placeholder="To Date"
                                            value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Review Table Section -->
                    <div class="rewiew-sec" id="installment-contant">
                        <div class="row" id="main-contant-AI">
                            <div class="col-md-12 installment-table">
                                <div class="table-responsive">
                                    <div class="hack1">
                                        <div class="hack2" style="min-height: 300px">
                                            <table class="table" style="min-height: 300px">
                                                <thead>
                                                    <tr class="text-nowrap">
                                                        <th>Service Title</th>
                                                        <th>Service Type</th>
                                                        <th>Review</th>
                                                        <th>Rating</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($reviews as $review)
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $image =
                                                                        $review->gig->image ??
                                                                        ($review->order->image ?? 'table img.jpeg');
                                                                    $title =
                                                                        $review->gig->title ??
                                                                        ($review->order->service_title ?? 'N/A');
                                                                    $description = Str::limit(
                                                                        $review->gig->description ??
                                                                            ($review->order->description ?? ''),
                                                                        50,
                                                                    );
                                                                @endphp
                                                                <img class="table-img"
                                                                    src="{{ asset('assets/user/asset/img/' . $image) }}"
                                                                    alt="Service" />
                                                                <span class="para-1">{{ Str::limit($title, 30) }}</span>
                                                                <p class="para-2">{{ $description }}</p>
                                                            </td>
                                                            <td>
                                                                @if ($review->gig_id)
                                                                    Freelance Service
                                                                @elseif($review->order_id)
                                                                    Order Service
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p class="review-text">
                                                                    {{ Str::limit($review->cmnt ?? 'No comment', 50) }}
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <div class="star-rating">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fa{{ $i <= $review->rating ? '-solid' : '-regular' }} fa-star"
                                                                            style="color: #FFAF06;"></i>
                                                                    @endfor
                                                                </div>
                                                            </td>
                                                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                                                            <td>
                                                                @if ($review->replies->isNotEmpty())
                                                                    <span class="badge bg-success">
                                                                        <i class="fa fa-check"></i> Replied
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-warning">
                                                                        <i class="fa fa-clock"></i> Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="dropdown mt-4">
                                                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a class="dropdown-item view-review"
                                                                                href="#"
                                                                                data-review-id="{{ $review->id }}">
                                                                                <i class="fa fa-eye"></i> View Review
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item add-reply"
                                                                                href="#"
                                                                                data-review-id="{{ $review->id }}">
                                                                                <i class="fa fa-comment"></i>
                                                                                {{ $review->replies->isNotEmpty() ? 'View/Edit Reply' : 'Add Reply' }}
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center py-4">
                                                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                                <p>No reviews found</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if ($reviews->hasPages())
        <div class="demo">
            <nav class="pagination-outer" aria-label="Page navigation">
                {{ $reviews->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    @endif

    <!-- Copyright -->
    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>


    <!-- View Review Modal -->
    <div class="modal fade" id="view-review-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Service Info -->
                    <div class="mb-3">
                        <img id="service-image" src="" class="img-fluid mb-2" style="max-height: 150px;">
                        <h6 id="service-title"></h6>
                        <small class="text-muted" id="service-type"></small>
                    </div>

                    <!-- Customer Review -->
                    <div class="customer-review">
                        <h6><i class="fa fa-user"></i> Customer Review</h6>
                        <div class="mb-2">
                            <strong>Rating:</strong>
                            <div class="star-rating d-inline-block ms-2" id="customer-rating"></div>
                        </div>
                        <div>
                            <strong>Comment:</strong>
                            <p class="mb-1" id="customer-comment"></p>
                        </div>
                        <small class="text-muted" id="review-date"></small>
                    </div>

                    <!-- Seller Reply Section -->
                    <div id="reply-section">
                        <h6 class="mb-3"><i class="fa fa-comments"></i> Your Reply</h6>
                        <div id="existing-reply" style="display: none;">
                            <div class="reply-item">
                                <div class="reply-header">
                                    <strong><i class="fa fa-user-tie"></i> Your Reply:</strong>
                                    <div class="reply-actions">
                                        <button class="btn btn-sm btn-primary" id="edit-reply-btn">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" id="delete-reply-btn">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                                <p class="mb-1" id="reply-content"></p>
                                <small class="text-muted" id="reply-date"></small>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Reply Modal -->
    <div class="modal fade" id="reply-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reply-modal-title">Add Reply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="reply-form">
                        @csrf
                        <input type="hidden" id="parent_review_id" name="parent_id">
                        <input type="hidden" id="reply_id" name="reply_id">
                        <input type="hidden" id="is_edit_mode" value="0">

                        <!-- Customer Review Summary -->
                        <div class="mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                            <h6>Customer's Review:</h6>
                            <div class="star-rating mb-2" id="reply-customer-rating"></div>
                            <p class="mb-0" id="reply-customer-comment"></p>
                        </div>

                        <h6 class="mb-2">Your Reply <span class="text-danger">*</span></h6>
                        <textarea class="form-control mb-3" name="cmnt" id="reply_comment"
                            placeholder="Write your reply to the customer..." rows="5" required></textarea>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="submit-reply-btn">
                                <i class="fa fa-paper-plane"></i> Submit Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="assets/user/asset/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            let currentReviewData = null;

            // Generate star rating HTML
            function generateStarRating(rating) {
                let html = '';
                for (let i = 1; i <= 5; i++) {
                    html +=
                        `<i class="fa${i <= rating ? '-solid' : '-regular'} fa-star" style="color: #FFAF06;"></i>`;
                }
                return html;
            }

            // View review
            $('.view-review').click(function(e) {
                e.preventDefault();
                let reviewId = $(this).data('review-id');
                loadReviewDetails(reviewId, 'view');
            });

            // Add/Edit reply
            $('.add-reply').click(function(e) {
                e.preventDefault();
                let reviewId = $(this).data('review-id');
                loadReviewDetails(reviewId, 'reply');
            });

            // Load review details
            function loadReviewDetails(reviewId, mode) {
                $.ajax({
                    url: `/teacher-get-single-reviews/${reviewId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            currentReviewData = response;

                            // Populate service info
                            $('#service-title').text(response.service_title);
                            $('#service-type').text(response.service_type);
                            $('#service-image').attr('src', response.service_image);

                            // Populate customer review
                            $('#customer-rating').html(generateStarRating(response.review.rating));
                            $('#customer-comment').text(response.review.cmnt || 'No comment provided');
                            $('#review-date').text(new Date(response.review.created_at)
                                .toLocaleDateString());

                            // Handle replies
                            if (response.review.replies && response.review.replies.length > 0) {
                                let reply = response.review.replies[0]; // Get first reply
                                $('#reply-content').text(reply.cmnt);
                                $('#reply-date').text(new Date(reply.created_at).toLocaleDateString());
                                $('#existing-reply').show();

                                // Store reply ID for edit/delete
                                $('#existing-reply').data('reply-id', reply.id);

                                // Show/hide edit and delete buttons based on 7-day limit
                                if (response.can_edit_reply) {
                                    $('#edit-reply-btn').show();
                                    $('#delete-reply-btn').show();
                                } else {
                                    $('#edit-reply-btn').hide();
                                    $('#delete-reply-btn').hide();
                                }
                            } else {
                                $('#existing-reply').hide();
                            }

                            if (mode === 'view') {
                                $('#view-review-modal').modal('show');
                            } else if (mode === 'reply') {
                                openReplyModal(response);
                            }
                        }
                    },
                    error: function(xhr) {
                        alert('Error loading review details');
                    }
                });
            }

            // Open reply modal
            function openReplyModal(reviewData) {
                $('#parent_review_id').val(reviewData.review.id);
                $('#reply-customer-rating').html(generateStarRating(reviewData.review.rating));
                $('#reply-customer-comment').text(reviewData.review.cmnt || 'No comment provided');

                if (reviewData.review.replies && reviewData.review.replies.length > 0) {
                    // Edit mode - check if reply can be edited (within 7 days)
                    if (!reviewData.can_edit_reply) {
                        alert('You can only edit your reply within 7 days of posting it.');
                        return;
                    }

                    let reply = reviewData.review.replies[0];
                    $('#reply-modal-title').text('Edit Reply');
                    $('#reply_id').val(reply.id);
                    $('#reply_comment').val(reply.cmnt);
                    $('#is_edit_mode').val('1');
                    $('#submit-reply-btn').html('<i class="fa fa-save"></i> Update Reply');
                } else {
                    // Add mode
                    $('#reply-modal-title').text('Add Reply');
                    $('#reply_id').val('');
                    $('#reply_comment').val('');
                    $('#is_edit_mode').val('0');
                    $('#submit-reply-btn').html('<i class="fa fa-paper-plane"></i> Submit Reply');
                }

                $('#view-review-modal').modal('hide');
                $('#reply-modal').modal('show');
            }

            // Edit reply button
            $(document).on('click', '#edit-reply-btn', function() {
                if (currentReviewData) {
                    openReplyModal(currentReviewData);
                }
            });

            // Delete reply button
            $(document).on('click', '#delete-reply-btn', function() {
                if (confirm('Are you sure you want to delete your reply?')) {
                    let replyId = $('#existing-reply').data('reply-id');

                    $.ajax({
                        url: `/teacher-delete-reply/${replyId}`,
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                $('#view-review-modal').modal('hide');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message ||
                                'Failed to delete reply'));
                        }
                    });
                }
            });

            // Submit reply form
            $('#reply-form').submit(function(e) {
                e.preventDefault();

                let isEditMode = $('#is_edit_mode').val() === '1';
                let url = isEditMode ? `/teacher-update-reply/${$('#reply_id').val()}` :
                    '/teacher-store-reply';

                let formData = {
                    _token: '{{ csrf_token() }}',
                    parent_id: $('#parent_review_id').val(),
                    cmnt: $('#reply_comment').val()
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#reply-modal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = Object.values(errors).join('\n');
                            alert(errorMessage);
                        } else {
                            alert('Error: ' + (xhr.responseJSON?.message ||
                                'Failed to submit reply'));
                        }
                    }
                });
            });

            // Clear modal on close
            $('#reply-modal').on('hidden.bs.modal', function() {
                $('#reply-form')[0].reset();
                $('#parent_review_id').val('');
                $('#reply_id').val('');
                $('#is_edit_mode').val('0');
            });
        });
    </script>
@endpush
