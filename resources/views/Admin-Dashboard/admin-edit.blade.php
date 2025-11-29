<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <title>Edit Admin - DreamCrowd</title>
    <style>
        .password-requirements {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
            display: none;
        }
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        .password-requirements li {
            color: #dc3545;
            margin: 5px 0;
        }
        .password-requirements li.valid {
            color: #28a745;
        }
        .password-requirements li i {
            margin-right: 5px;
        }
        .form-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
        .admin-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>

    <x-admin-sidebar/>

    <section class="home-section">
       <x-admin-nav/>

       <div class="container-fluid">
        <div class="row dash-notification">
          <div class="col-md-12">
              <div class="dash">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="dash-top">
                              <h1 class="dash-title">Dashboard</h1>
                              <i class="fa-solid fa-chevron-right"></i>
                              <a href="{{ route('admin.admin-management') }}" class="text-decoration-none">
                                  <span class="min-title">Admin Management</span>
                              </a>
                              <i class="fa-solid fa-chevron-right"></i>
                              <span class="min-title">Edit Admin</span>
                          </div>
                      </div>
                  </div>

                  @if(session('error'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          {{ session('error') }}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  @endif

                  @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Please fix the following errors:</strong>
                          <ul class="mb-0 mt-2">
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  @endif

                  <div class="row">
                      <div class="col-md-8 offset-md-2">
                          <!-- Admin Information Banner -->
                          <div class="admin-info mb-3">
                              <div class="d-flex align-items-center">
                                  @if($admin->profile)
                                      <img src="/assets/public-site/asset/img/{{ $admin->profile }}" alt="{{ $admin->first_name }}" class="rounded-circle me-3" width="50" height="50">
                                  @else
                                      <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;font-size:20px;">
                                          {{ substr($admin->first_name, 0, 1) }}
                                      </div>
                                  @endif
                                  <div>
                                      <h5 class="mb-0">{{ $admin->first_name }} {{ $admin->last_name }}</h5>
                                      <small class="text-muted">
                                          <i class="fas fa-envelope me-1"></i>{{ $admin->email }}
                                          @if($admin->isTopSuperAdmin())
                                              <span class="badge bg-danger ms-2">TOP SUPER ADMIN</span>
                                          @else
                                              @php $currentRole = $admin->roles()->first(); @endphp
                                              @if($currentRole)
                                                  <span class="badge bg-info ms-2">{{ ucfirst(str_replace('_', ' ', $currentRole->name)) }}</span>
                                              @endif
                                          @endif
                                      </small>
                                  </div>
                              </div>
                          </div>

                          <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                              @csrf

                              <!-- Personal Information -->
                              <div class="form-section">
                                  <h3 class="section-title">
                                      <i class="fas fa-user me-2"></i>Personal Information
                                  </h3>
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control" id="first_name" name="first_name"
                                                 value="{{ old('first_name', $admin->first_name) }}" required placeholder="Enter first name">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control" id="last_name" name="last_name"
                                                 value="{{ old('last_name', $admin->last_name) }}" required placeholder="Enter last name">
                                      </div>
                                      <div class="col-md-12 mb-3">
                                          <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                          <input type="email" class="form-control" id="email" name="email"
                                                 value="{{ old('email', $admin->email) }}" required placeholder="admin@example.com">
                                          <small class="text-muted">This is used for login credentials</small>
                                      </div>
                                  </div>
                              </div>

                              <!-- Role Assignment -->
                              <div class="form-section">
                                  <h3 class="section-title">
                                      <i class="fas fa-user-shield me-2"></i>Role Assignment
                                  </h3>
                                  <div class="row">
                                      <div class="col-md-12 mb-3">
                                          <label for="role" class="form-label">Admin Role <span class="text-danger">*</span></label>
                                          @php $currentRole = $admin->roles()->first(); @endphp
                                          <select class="form-select" id="role" name="role" required>
                                              @foreach($roles as $role)
                                                  <option value="{{ $role->name }}"
                                                      {{ old('role', $currentRole?->name) == $role->name ? 'selected' : '' }}>
                                                      {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                      (Level {{ $role->hierarchy_level }})
                                                  </option>
                                              @endforeach
                                          </select>
                                          <small class="text-muted">You can only assign roles below your current hierarchy level</small>
                                      </div>
                                  </div>
                              </div>

                              <!-- Password Update (Optional) -->
                              <div class="form-section">
                                  <h3 class="section-title">
                                      <i class="fas fa-lock me-2"></i>Change Password (Optional)
                                  </h3>
                                  <div class="alert alert-warning">
                                      <i class="fas fa-info-circle me-2"></i>
                                      <strong>Note:</strong> Leave password fields empty if you don't want to change the password.
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <label for="password" class="form-label">New Password</label>
                                          <input type="password" class="form-control" id="password" name="password"
                                                 placeholder="Enter new password">
                                          <div class="password-requirements" id="passwordRequirements">
                                              <strong>Password must contain:</strong>
                                              <ul>
                                                  <li id="length"><i class="fas fa-times"></i> At least 8 characters</li>
                                                  <li id="uppercase"><i class="fas fa-times"></i> One uppercase letter</li>
                                                  <li id="number"><i class="fas fa-times"></i> One number</li>
                                                  <li id="special"><i class="fas fa-times"></i> One special character</li>
                                              </ul>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                                 placeholder="Re-enter new password">
                                      </div>
                                  </div>
                              </div>

                              <!-- Form Actions -->
                              <div class="form-section">
                                  <div class="d-flex justify-content-between">
                                      <a href="{{ route('admin.admin-management') }}" class="btn btn-secondary">
                                          <i class="fas fa-arrow-left me-2"></i>Cancel
                                      </a>
                                      <button type="submit" class="btn btn-primary">
                                          <i class="fas fa-save me-2"></i>Update Admin
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>
       </div>
    </section>

    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const passwordInput = $('#password');
            const passwordRequirements = $('#passwordRequirements');

            // Show/hide password requirements only if user starts typing
            passwordInput.on('focus', function() {
                if ($(this).val().length > 0) {
                    passwordRequirements.slideDown(200);
                }
            });

            passwordInput.on('input', function() {
                const password = $(this).val();

                if (password.length === 0) {
                    passwordRequirements.slideUp(200);
                    return;
                }

                passwordRequirements.slideDown(200);

                // Check length
                if (password.length >= 8) {
                    $('#length').addClass('valid').find('i').removeClass('fa-times').addClass('fa-check');
                } else {
                    $('#length').removeClass('valid').find('i').removeClass('fa-check').addClass('fa-times');
                }

                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    $('#uppercase').addClass('valid').find('i').removeClass('fa-times').addClass('fa-check');
                } else {
                    $('#uppercase').removeClass('valid').find('i').removeClass('fa-check').addClass('fa-times');
                }

                // Check number
                if (/[0-9]/.test(password)) {
                    $('#number').addClass('valid').find('i').removeClass('fa-times').addClass('fa-check');
                } else {
                    $('#number').removeClass('valid').find('i').removeClass('fa-check').addClass('fa-times');
                }

                // Check special character
                if (/[\W_]/.test(password)) {
                    $('#special').addClass('valid').find('i').removeClass('fa-times').addClass('fa-check');
                } else {
                    $('#special').removeClass('valid').find('i').removeClass('fa-check').addClass('fa-times');
                }
            });

            passwordInput.on('blur', function() {
                setTimeout(function() {
                    passwordRequirements.slideUp(200);
                }, 200);
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
