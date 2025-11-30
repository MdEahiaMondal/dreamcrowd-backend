<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="assets/user/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel css -->
    <link href="assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link
        rel="stylesheet"
        type="text/css"
        href="assets/user/asset/css/bootstrap.min.css"
    />
    <link
        href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
    <!-- Fontawesome CDN -->
    <script
        src="https://kit.fontawesome.com/be69b59144.js"
        crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/user/asset/css/style.css"/>
    <link rel="stylesheet" href="assets/user/asset/css/table.css"/>
    <title>User Dashboard | Reviews</title>

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
            max-height: 200px;
            overflow-y: auto;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
            height: 25px !important;
        }
    </style>
</head>
<body>
{{-- ===========User Sidebar Start==================== --}}
<x-user-sidebar/>
{{-- ===========User Sidebar End==================== --}}

{{-- ===========User NavBar Start==================== --}}
<x-user-nav/>
{{-- ===========User NavBar End==================== --}}

<section class="home-section">
    <x-user-nav/>

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
                                    <h2>Reviews</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="/reviews" id="filterForm">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Search reviews..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="service_type" class="form-control">
                                            <option value="">All Services</option>
                                            <option
                                                value="gig" {{ request('service_type') == 'gig' ? 'selected' : '' }}>
                                                Freelance Service
                                            </option>
                                            <option
                                                value="order" {{ request('service_type') == 'order' ? 'selected' : '' }}>
                                                Order Service
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="rating" class="form-control">
                                            <option value="">All Ratings</option>
                                            @for($i = 5; $i >= 1; $i--)
                                                <option
                                                    value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                                    {{ $i }} Stars
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_from" class="form-control"
                                               placeholder="From Date" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_to" class="form-control"
                                               placeholder="To Date" value="{{ request('date_to') }}">
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
                                            <table class="table" style="min-height: 300px; margin-bottom: 40px;">
                                                <thead>
                                                <tr class="text-nowrap">
                                                    <th>Service Title</th>
                                                    <th>Service Type</th>
                                                    <th>Review</th>
                                                    <th>Rating</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($reviews as $review)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $image = $review->gig->image ?? ($review->order->image ?? 'table img.jpeg');
                                                                $title = $review->gig->title ?? ($review->order->service_title ?? 'N/A');
                                                                $description = Str::limit($review->gig->description ?? $review->order->description ?? '', 50);
                                                            @endphp
                                                            <img class="table-img"
                                                                 src="{{ asset('assets/user/asset/img/' . $image) }}"
                                                                 alt="Service"/>
                                                            <span class="para-1">{{ Str::limit($title, 30) }}</span>
                                                            <p class="para-2">{{ $description }}</p>
                                                        </td>
                                                        <td>
                                                            @if($review->gig_id)
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
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fa{{ $i <= $review->rating ? '-solid' : '-regular' }} fa-star"
                                                                       style="color: #FFAF06; margin-left:3px !important;"></i>
                                                                @endfor
                                                            </div>
                                                        </td>
                                                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <div class="dropdown mt-4">
                                                                <button
                                                                    class="btn btn-sm btn-secondary dropdown-toggle"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" style=" left: 0 !important; top: 0 !important;">
                                                                    <li>
                                                                        <a class="dropdown-item view-review"
                                                                           href="#"
                                                                           data-review-id="{{ $review->id }}">
                                                                            <i class="fa fa-eye"></i> View
                                                                        </a>
                                                                    </li>
                                                                    @if($review->replies->isEmpty())
                                                                        <li>
                                                                            <a class="dropdown-item edit-review"
                                                                               href="#"
                                                                               data-review-id="{{ $review->id }}">
                                                                                <i class="fa fa-edit"></i> Edit
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item delete-review"
                                                                               href="#"
                                                                               data-review-id="{{ $review->id }}">
                                                                                <i class="fa fa-trash"></i> Delete
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                                <span class="dropdown-item text-muted">
                                                                                    <i class="fa fa-lock"></i> Seller Replied
                                                                                </span>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
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
    @if($reviews->hasPages())
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
</section>

<!-- View/Edit Review Modal -->
<div class="modal fade" id="view-review-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-text">View Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="review-form">
                    @csrf
                    <input type="hidden" id="review_id" name="review_id">
                    <input type="hidden" id="rating_value" name="rating" value="0">

                    <!-- Service Info -->
                    <div class="mb-3">
                        <img id="service-image" src="" class="img-fluid mb-2" style="max-height: 150px;">
                        <h6 id="service-title"></h6>
                        <small class="text-muted" id="service-type"></small>
                    </div>

                    <h5 class="mb-2">Rating <span class="text-danger">*</span></h5>
                    <div class="row mb-3">
                        <div class="col-md-12 review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-regular fa-star star-rating-view"
                                   data-value="{{ $i }}"
                                   style="padding-left: 6px; cursor: pointer; font-size: 24px;"></i>
                            @endfor
                        </div>
                        <span class="text-danger" id="rating-error" style="display: none;">
                            Please select a rating
                        </span>
                    </div>

                    <h5 class="mb-2">Review <span>(optional)</span></h5>
                    <textarea class="form-control add-review mb-3"
                              name="cmnt"
                              id="feedback_comments_view"
                              placeholder="Give your feedback"
                              rows="4"></textarea>

                    <!-- Seller Replies -->
                    <div id="seller-replies" style="display: none;">
                        <h5 class="mb-2">Seller Response</h5>
                        <div id="replies-container" class="bg-light p-3 rounded mb-3"></div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="submit-review-btn">
                            Submit Review
                        </button>
                        {{--                        <button type="button" class="btn btn-danger" id="delete-review-btn" style="display: none;">--}}
                        {{--                            Delete Review--}}
                        {{--                        </button>--}}
                    </div>
                </form>

                <div id="review-locked-message" style="display: none;" class="alert alert-warning">
                    <i class="fa fa-lock"></i> This review cannot be edited or deleted because the seller has
                    already replied.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/user/libs/jquery/jquery.js"></script>
<script src="assets/user/libs/datatable/js/datatable.js"></script>
<script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/user/libs/select2/js/select2.min.js"></script>
<script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/user/libs/aos/js/aos.js"></script>
<script src="assets/user/asset/js/bootstrap.min.js"></script>
<script src="assets/user/asset/js/script.js"></script>
<!-- jQuery -->
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"
></script>

<script>
    $(document).ready(function () {
        let currentRating = 0;
        let isEditMode = false;
        let canModify = true;

        // Star rating hover and click
        $('.star-rating-view').hover(
            function () {
                if (canModify) {
                    let value = $(this).data('value');
                    highlightStars(value);
                }
            },
            function () {
                if (canModify) {
                    highlightStars(currentRating);
                }
            }
        ).click(function () {
            if (canModify) {
                currentRating = $(this).data('value');
                $('#rating_value').val(currentRating);
                highlightStars(currentRating);
                $('#rating-error').hide();
            }
        });

        function highlightStars(rating) {
            $('.star-rating-view').each(function () {
                if ($(this).data('value') <= rating) {
                    $(this).removeClass('fa-regular').addClass('fa-solid');
                } else {
                    $(this).removeClass('fa-solid').addClass('fa-regular');
                }
            });
        }

        // View review
        $('.view-review').click(function (e) {
            e.preventDefault();
            let reviewId = $(this).data('review-id');
            loadReview(reviewId, 'view');
        });

        // Edit review
        $('.edit-review').click(function (e) {
            e.preventDefault();
            let reviewId = $(this).data('review-id');
            loadReview(reviewId, 'edit');
        });

        // Delete review
        $('.delete-review').click(function (e) {
            e.preventDefault();
            let reviewId = $(this).data('review-id');

            if (confirm('Are you sure you want to delete this review?')) {
                $.ajax({
                    url: `/delete-review/${reviewId}`,
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        });

        function loadReview(reviewId, mode) {
            $.ajax({
                url: `/get-single-reviews/${reviewId}`,
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        isEditMode = (mode === 'edit');
                        canModify = response.can_edit;

                        $('#modal-title-text').text(mode === 'edit' ? 'Edit Review' : 'View Review');
                        $('#review_id').val(response.review.id);
                        $('#rating_value').val(response.review.rating);
                        $('#feedback_comments_view').val(response.review.cmnt);
                        $('#service-title').text(response.service_title);
                        $('#service-type').text(response.service_type);
                        $('#service-image').attr('src', response.service_image);

                        currentRating = response.review.rating;
                        highlightStars(currentRating);

                        // Show/hide seller replies
                        if (response.review.replies && response.review.replies.length > 0) {
                            let repliesHtml = '';
                            response.review.replies.forEach(function (reply) {
                                repliesHtml += `
                                <div class="mb-2">
                                    <strong>${reply.teacher.name}:</strong>
                                    <p class="mb-1">${reply.cmnt}</p>
                                    <small class="text-muted">${new Date(reply.created_at).toLocaleDateString()}</small>
                                </div>
                            `;
                            });
                            $('#replies-container').html(repliesHtml);
                            $('#seller-replies').show();
                        } else {
                            $('#seller-replies').hide();
                        }

                        if (canModify && mode === 'edit') {
                            $('#submit-review-btn').text('Update Review').show();
                            $('#delete-review-btn').show();
                            $('#review-locked-message').hide();
                            $('#review-form :input').prop('disabled', false);
                        } else {
                            $('#submit-review-btn').hide();
                            $('#delete-review-btn').hide();
                            if (!canModify) {
                                $('#review-locked-message').show();
                                $('#review-form :input').prop('disabled', true);
                            }
                        }

                        $('#view-review-modal').modal('show');
                    }
                },
                error: function (xhr) {
                    alert('Error loading review');
                }
            });
        }

        // Submit review form
        $('#review-form').submit(function (e) {
            e.preventDefault();

            if (currentRating === 0) {
                $('#rating-error').show();
                return;
            }

            let reviewId = $('#review_id').val();
            let url = `/reviews/${reviewId}`;
            let method = 'PUT';

            let formData = {
                _token: '{{ csrf_token() }}',
                _method: method,
                rating: currentRating,
                cmnt: $('#feedback_comments_view').val()
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#view-review-modal').modal('hide');
                        location.reload();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = Object.values(errors).join('\n');
                        alert(errorMessage);
                    } else {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                }
            });
        });

        // Delete from modal
        $('#delete-review-btn').click(function () {
            if (confirm('Are you sure you want to delete this review?')) {
                let reviewId = $('#review_id').val();

                $.ajax({
                    url: `/delete-review/${reviewId}`,
                    method: 'get',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            $('#view-review-modal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        });

        // Clear modal on close
        $('#view-review-modal').on('hidden.bs.modal', function () {
            $('#review-form')[0].reset();
            $('#review_id').val('');
            currentRating = 0;
            highlightStars(0);
            $('#rating-error').hide();
            $('#review-form :input').prop('disabled', false);
            $('#seller-replies').hide();
        });
    });
</script>
</body>
</html>
