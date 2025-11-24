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
    <title>Create Admin - DreamCrowd</title>
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
                              <span class="min-title">Create Admin</span>
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
                          <form action="{{ route('admin.admins.store') }}" method="POST">
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
                                                 value="{{ old('first_name') }}" required placeholder="Enter first name">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control" id="last_name" name="last_name"
                                                 value="{{ old('last_name') }}" required placeholder="Enter last name">
                                      </div>
                                      <div class="col-md-12 mb-3">
                                          <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                          <input type="email" class="form-control" id="email" name="email"
                                                 value="{{ old('email') }}" required placeholder="admin@example.com">
                                          <small class="text-muted">This will be used for login credentials</small>
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
                                          <select class="form-select" id="role" name="role" required>
                                              <option value="">-- Select Role --</option>
                                              @foreach($roles as $role)
                                                  <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                                      {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                      (Level {{ $role->hierarchy_level }})
                                                  </option>
                                              @endforeach
                                          </select>
                                          <small class="text-muted">You can only assign roles below your current hierarchy level</small>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="alert alert-info">
                                              <strong><i class="fas fa-info-circle me-2"></i>Role Hierarchy:</strong>
                                              <ul class="mb-0 mt-2">
                                                  <li><strong>Super Admin (Level 1):</strong> Full access to all features</li>
                                                  <li><strong>Moderator (Level 2):</strong> Manage users, orders, and content</li>
                                                  <li><strong>Support (Level 3):</strong> Handle user support and disputes</li>
                                                  <li><strong>Finance (Level 4):</strong> Manage financial operations</li>
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- Password Setup -->
                              <div class="form-section">
                                  <h3 class="section-title">
                                      <i class="fas fa-lock me-2"></i>Password Setup
                                  </h3>
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                          <input type="password" class="form-control" id="password" name="password"
                                                 required placeholder="Enter password">
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
                                          <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                                 required placeholder="Re-enter password">
                                      </div>
                                  </div>
                              </div>

                              <!-- Form Actions -->
                              <div class="form-section">
                                  <div class="d-flex justify-content-between">
                                      <a href="{{ route('admin.admin-management') }}" class="btn btn-secondary">
                                          <i class="fas fa-arrow-left me-2"></i>Cancel
                                      </a>
                                      <button type="submit" class="btn btn-success">
                                          <i class="fas fa-user-plus me-2"></i>Create Admin
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

            // Show/hide password requirements
            passwordInput.on('focus', function() {
                passwordRequirements.slideDown(200);
            });

            passwordInput.on('blur', function() {
                setTimeout(function() {
                    passwordRequirements.slideUp(200);
                }, 200);
            });

            // Validate password in real-time
            passwordInput.on('input', function() {
                const password = $(this).val();

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

            // Auto-dismiss alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
