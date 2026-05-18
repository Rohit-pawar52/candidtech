<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .admin-sidebar { min-height: 100vh; background: #343a40; color: white; }
        .admin-sidebar a { color: rgba(255,255,255,.8); }
        .admin-sidebar a.active, .admin-sidebar a:hover { color: white; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 admin-sidebar p-3">
                <h4 class="text-white">Admin Panel</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.banners.index') }}">Banners</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.services.index') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.abouts.index') }}">About Section</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.features.index') }}">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.faqs.index') }}">FAQ</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.company-details.index') }}">Company Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.contact-messages.index') }}">Messages</a></li>
                </ul>
            </aside>
            <main class="col-md-10 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>@yield('title', 'Admin')</h2>
                    </div>
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Logout</button>
                    </form>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
