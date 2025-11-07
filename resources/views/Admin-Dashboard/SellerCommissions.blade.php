<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Seller Commissions</title>

    {{-- Include same head assets as main commission page --}}
    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/admin/asset/css/style.css"/>
</head>
<body>

@if (Session::has('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

{{-- Admin Sidebar --}}
<x-admin-sidebar/>

<section class="home-section">
    {{-- Admin NavBar --}}
    <x-admin-nav/>

    <div class="container-fluid">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">

                    <!-- Breadcrumb -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <h1 class="dash-title">Commission Management</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Seller Commissions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-user-tie" style="font-size: 40px; color: #007bff;"></i>
                                    <h2>Manage Seller Commission Rates</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Banner -->
                    <div class="alert alert-info" role="alert">
                        <i class="fa-solid fa-info-circle"></i>
                        <strong>Default Commission Rate:</strong> {{ $defaultRate }}%
                        <br>
                        <small>This rate applies to all sellers unless a custom rate is set below.</small>
                    </div>

                    <!-- Add New Seller Commission -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                        <h5><i class="fa-solid fa-plus-circle"></i> Add Custom Seller Commission</h5>
                    </div>

                    <div class="form-section">
                        <form action="/admin/seller-commission/store" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="seller_id" class="form-label">Select Seller</label>
                                    <select class="form-control select2" id="seller_id" name="seller_id" required>
                                        <option value="">-- Choose Seller --</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{ $seller->id }}">
                                                {{ $seller->name }} ({{ $seller->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="commission_rate"
                                        name="commission_rate"
                                        min="5"
                                        max="30"
                                        step="0.01"
                                        placeholder="e.g., 15.50"
                                        required
                                    />
                                </div>

                                <div class="col-md-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="notes"
                                        name="notes"
                                        placeholder="Admin notes"
                                    />
                                </div>

                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Existing Seller Commissions Table -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs mt-4">
                        <h5><i class="fa-solid fa-list"></i> Existing Custom Seller Commissions</h5>
                    </div>

                    <div class="form-section">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background: #f8f9fa;">
                                <tr>
                                    <th>#</th>
                                    <th>Seller Name</th>
                                    <th>Email</th>
                                    <th>Custom Commission</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($sellerCommissions as $index => $commission)
                                    <tr>
                                        <td>{{ $sellerCommissions->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $commission->seller->first_name ? $commission->seller->first_name .' '. $commission->seller->last_name : 'N/A' }}</strong>
                                        </td>
                                        <td>{{ $commission->seller->email ?? 'N/A' }}</td>
                                        <td>
                                                    <span style="font-size: 18px; font-weight: bold; color: #007bff;">
                                                        {{ $commission->commission_rate }}%
                                                    </span>
                                        </td>
                                        <td>
                                            @if($commission->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $commission->notes ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $commission->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning"
                                                onclick="editCommission({{ $commission->id }}, {{ $commission->commission_rate }}, '{{ $commission->notes }}', {{ $commission->is_active }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                            >
                                                <i class="fa-solid fa-edit"></i> Edit
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteCommission({{ $commission->id }})"
                                            >
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <i class="fa-solid fa-inbox"></i> No custom seller commissions found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $sellerCommissions->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>
</section>

<!-- Edit Commission Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fa-solid fa-edit"></i> Edit Seller Commission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_commission_rate" class="form-label">Commission Rate (%)</label>
                        <input
                            type="number"
                            class="form-control"
                            id="edit_commission_rate"
                            name="commission_rate"
                            min="5"
                            max="30"
                            step="0.01"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <input
                            type="text"
                            class="form-control"
                            id="edit_notes"
                            name="notes"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="edit_is_active" class="form-label">Status</label>
                        <select class="form-control" id="edit_is_active" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fa-solid fa-trash"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this custom commission rate?</p>
                <p><strong>Note:</strong> The seller will revert to the default commission rate.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script src="assets/admin/libs/select2/js/select2.min.js"></script>
<script>
    // Initialize Select2
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Search and select seller",
            allowClear: true
        });
    });

    // Edit Commission Function
    function editCommission(id, rate, notes, isActive) {
        $('#edit_commission_rate').val(rate);
        $('#edit_notes').val(notes);
        $('#edit_is_active').val(isActive);
        $('#editForm').attr('action', '/admin/seller-commission/update/' + id);
    }

    // Delete Commission Function
    function deleteCommission(id) {
        $('#deleteForm').attr('action', '/admin/seller-commission/delete/' + id);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
</body>
</html>
