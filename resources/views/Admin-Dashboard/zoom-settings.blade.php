<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"/>
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css"/>
    <link rel="stylesheet" href="/assets/user/asset/css/style.css"/>
    <title>Super Admin Dashboard | Zoom Settings</title>
</head>
<body>
{{-- ===========Admin Sidebar Start==================== --}}
<x-admin-sidebar/>
{{-- ===========Admin Sidebar End==================== --}}
<section class="home-section">
    {{-- ===========Admin NavBar Start==================== --}}
    <x-admin-nav/>
    {{-- ===========Admin NavBar End==================== --}}
    <!-- =============================== MAIN CONTENT START HERE =========================== -->
    <div class="container-fluid">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Zoom Settings</span>
                            </div>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Blue MESSAGES section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="bx bx-video"></i>
                                    <h2>Zoom Integration Settings</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status Card -->
                    @if($settings)
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle"></i>
                            <strong>Status:</strong> Zoom is configured and active
                            @if($settings->updated_by)
                                | <strong>Last Updated
                                    By:</strong> {{ $settings->updatedByUser->first_name ?? 'Admin' }}
                                | <strong>Updated:</strong> {{ $settings->updated_at->diffForHumans() }}
                            @endif
                        </div>
                    @endif

                    <!-- =============== API SETTINGS SECTION START ================ -->
                    <div class="api-section">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-0">Zoom OAuth App Credentials</h5>
                                <p class="text-muted small">Configure your Zoom OAuth app credentials for the
                                    platform</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="testConnectionBtn">
                                    <i class="bx bx-refresh"></i> Test Connection
                                </button>
                                <a href="{{ route('admin.zoom.live') }}" class="btn btn-sm btn-success">
                                    <i class="bx bx-broadcast"></i> Live Classes
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- =============== API FORM SECTION START ================ -->
                    <div class="api-form">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.zoom.settings.update') }}" method="POST"
                                      id="zoomSettingsForm">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="client_id" class="form-label">Client ID <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('client_id') is-invalid @enderror"
                                                   id="client_id" name="client_id"
                                                   value="{{ old('client_id', $settings->client_id ?? '') }}"
                                                   placeholder="Your Zoom OAuth Client ID" required>
                                            @error('client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="client_secret" class="form-label">Client Secret <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       class="form-control @error('client_secret') is-invalid @enderror"
                                                       id="client_secret" name="client_secret"
                                                       value="{{ old('client_secret', $settings->client_secret ?? '') }}"
                                                       placeholder="Your Zoom OAuth Client Secret" required>
                                                <button class="btn btn-outline-secondary" type="button"
                                                        id="toggleSecret">
                                                    <i class="bx bx-show"></i>
                                                </button>
                                            </div>
                                            @error('client_secret')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="redirect_uri" class="form-label">Redirect URI <span
                                                    class="text-danger">*</span></label>
                                            <input type="url"
                                                   class="form-control @error('redirect_uri') is-invalid @enderror"
                                                   id="redirect_uri" name="redirect_uri"
                                                   value="{{ old('redirect_uri', $settings->redirect_uri ?? url('/teacher/zoom/callback')) }}"
                                                   placeholder="https://yourdomain.com/teacher/zoom/callback" required>
                                            @error('redirect_uri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Use:
                                                <code>{{ url('/teacher/zoom/callback') }}</code></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="account_id" class="form-label">Account ID (Optional)</label>
                                            <input type="text"
                                                   class="form-control @error('account_id') is-invalid @enderror"
                                                   id="account_id" name="account_id"
                                                   value="{{ old('account_id', $settings->account_id ?? '') }}"
                                                   placeholder="For Server-to-Server OAuth (optional)">
                                            @error('account_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="base_url" class="form-label">Base URL</label>
                                            <input type="url"
                                                   class="form-control @error('base_url') is-invalid @enderror"
                                                   id="base_url" name="base_url"
                                                   value="{{ old('base_url', $settings->base_url ?? 'https://api.zoom.us/v2') }}"
                                                   placeholder="https://api.zoom.us/v2">
                                            @error('base_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="webhook_secret" class="form-label">Webhook Secret Token</label>
                                            <input type="text"
                                                   class="form-control @error('webhook_secret') is-invalid @enderror"
                                                   id="webhook_secret" name="webhook_secret"
                                                   value="{{ old('webhook_secret', $settings->webhook_secret ?? '') }}"
                                                   placeholder="For webhook signature verification">
                                            @error('webhook_secret')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Webhook URL:
                                                <code>{{ url('/api/zoom/webhook') }}</code></small>
                                        </div>
                                    </div>

                                    <!-- =============== BUTTONS SECTION START ================ -->
                                    <div class="api-buttons mt-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn float-start cancel-btn button-cancel"
                                                        onclick="window.location.href='/admin-dashboard'">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn float-end update-btn">
                                                    <i class="bx bx-save"></i> Update Settings
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- =============== API FORM SECTION ENDED ================ -->

                    <!-- Recent Audit Logs -->
                    @if(isset($auditLogs) && $auditLogs->count() > 0)
                        <div class="api-section mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Recent Activity</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>User</th>
                                                <th>Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($auditLogs as $log)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $log->action }}</span>
                                                    </td>
                                                    <td>{{ $log->user->first_name ?? 'System' }}</td>
                                                    <td>{{ $log->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('admin.zoom.audit') }}" class="btn btn-sm btn-link">View All Logs
                                        →</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- copyright section -->
                    <div class="copyright">
                        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>

<script src="/assets/admin/libs/jquery/jquery.js"></script>
<script src="/assets/admin/libs/datatable/js/datatable.js"></script>
<script src="/assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
<script src="/assets/admin/libs/select2/js/select2.min.js"></script>
<script src="/assets/admin/asset/js/bootstrap.min.js"></script>
<script src="/assets/admin/asset/js/script.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function () {
        // Toggle password visibility
        $('#toggleSecret').click(function () {
            const input = $('#client_secret');
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx-show').addClass('bx-hide');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx-hide').addClass('bx-show');
            }
        });

        // Test Connection
        $('#testConnectionBtn').click(function () {
            const btn = $(this);
            const originalHtml = btn.html();

            btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i> Testing...');

            $.ajax({
                url: '{{ route("admin.zoom.test") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert('✅ ' + response.message);
                    btn.prop('disabled', false).html(originalHtml);
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Connection test failed';
                    alert('❌ ' + message);
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>

<!-- ================ Sidebar JS =============== -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        toggleSidebar();
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
</body>
</html>


