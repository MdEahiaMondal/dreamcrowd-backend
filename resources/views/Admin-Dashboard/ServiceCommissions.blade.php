<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Service Commissions</title>

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
                                <span class="min-title">Service Commissions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-box" style="font-size: 40px; color: #28a745;"></i>
                                    <h2>Manage Service/Class Commission Rates</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Banner -->
                    <div class="alert alert-info" role="alert">
                        <i class="fa-solid fa-info-circle"></i>
                        <strong>Default Commission Rate:</strong> {{ $defaultRate }}%
                        <br>
                        <small>This rate applies to all services/classes unless a custom rate is set below.</small>
                    </div>

                    <!-- Add New Service Commission -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                        <h5><i class="fa-solid fa-plus-circle"></i> Add Custom Service/Class Commission</h5>
                    </div>

                    <div class="form-section">
                        <form action="/admin/service-commission/store" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="service_type" class="form-label">Type</label>
                                    <select class="form-control" id="service_type" name="service_type" required>
                                        <option value="Inperson">In Person</option>
                                        <option value="Online">Online</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="service_id" class="form-label">Service/Class ID</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="service_id"
                                        name="service_id"
                                        placeholder="Enter ID"
                                        required
                                    />
                                    <small class="text-muted">Enter the service or class database ID</small>
                                </div>

                                <div class="col-md-2">
                                    <label for="commission_rate" class="form-label">Commission (%)</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="commission_rate"
                                        name="commission_rate"
                                        min="5"
                                        max="30"
                                        step="0.01"
                                        placeholder="15.00"
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
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Existing Service Commissions Table -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs mt-4">
                        <h5><i class="fa-solid fa-list"></i> Existing Custom Service/Class Commissions</h5>
                    </div>

                    <div class="form-section">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background: #f8f9fa;">
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Service/Class ID</th>
                                    <th>Custom Commission</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($serviceCommissions as $index => $commission)
                                    <tr>
                                        <td>{{ $serviceCommissions->firstItem() + $index }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $commission->service_type == 'service' ? 'bg-primary' : 'bg-info' }}">
                                                {{ ucfirst($commission->service_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>#{{ $commission->service_id }} | {{ $commission->service->title }}</strong>
                                        </td>
                                        <td>
                                            <span style="font-size: 18px; font-weight: bold; color: #28a745;">
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
                                                onclick="editServiceCommission({{ $commission->id }}, {{ $commission->commission_rate }}, '{{ $commission->notes }}', {{ $commission->is_active }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editServiceModal"
                                            >
                                                <i class="fa-solid fa-edit"></i> Edit
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteServiceCommission({{ $commission->id }})"
                                            >
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <i class="fa-solid fa-inbox"></i> No custom service commissions found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $serviceCommissions->links() }}
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

<!-- Edit Service Commission Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">
                    <i class="fa-solid fa-edit"></i> Edit Service Commission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_service_commission_rate" class="form-label">Commission Rate (%)</label>
                        <input
                            type="number"
                            class="form-control"
                            id="edit_service_commission_rate"
                            name="commission_rate"
                            min="5"
                            max="30"
                            step="0.01"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label for="edit_service_notes" class="form-label">Notes</label>
                        <input
                            type="text"
                            class="form-control"
                            id="edit_service_notes"
                            name="notes"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="edit_service_is_active" class="form-label">Status</label>
                        <select class="form-control" id="edit_service_is_active" name="is_active" required>
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
<div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteServiceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteServiceModalLabel">
                    <i class="fa-solid fa-trash"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this custom commission rate?</p>
                <p><strong>Note:</strong> The service will revert to the default commission rate.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteServiceForm" method="POST" style="display: inline;">
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
<script>
    // Sidebar script
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        // Function to toggle sidebar based on screen size
        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        // Call the function initially
        toggleSidebar();

        // Listen for resize events to adjust sidebar
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
<script>
    // Edit Service Commission Function
    function editServiceCommission(id, rate, notes, isActive) {
        $('#edit_service_commission_rate').val(rate);
        $('#edit_service_notes').val(notes);
        $('#edit_service_is_active').val(isActive);
        $('#editServiceForm').attr('action', '/admin/service-commission/update/' + id);
    }

    // Delete Service Commission Function
    function deleteServiceCommission(id) {
        $('#deleteServiceForm').attr('action', '/admin/service-commission/delete/' + id);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteServiceModal'));
        deleteModal.show();
    }
</script>
</body>
</html>
