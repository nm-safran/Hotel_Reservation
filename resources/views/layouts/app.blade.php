<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hotel Reservation System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #6366f1;
                --primary-dark: #4f46e5;
                --accent: #f472b6;
                --bg: #f8fafc;
                --surface: #fff;
                --text: #22223b;
                --muted: #9ca3af;
                --success: #22c55e;
                --danger: #ef4444;
                --warning: #facc15;
                --info: #38bdf8;
            }

            body {
                background-color: var(--bg);
                color: var(--text);
                font-family: 'Inter', Arial, sans-serif;
                letter-spacing: 0.01em;
            }

            .navbar {
                background: linear-gradient(90deg, var(--primary), var(--accent));
                box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
            }

            .navbar-brand,
            .navbar-nav .nav-link {
                color: #fff !important;
                font-weight: 600;
                letter-spacing: 0.03em;
            }

            .navbar-nav .nav-link.active,
            .navbar-nav .nav-link:hover {
                color: var(--accent) !important;
                text-shadow: 0 1px 4px rgba(244, 114, 182, 0.15);
            }

            .btn-primary {
                background: linear-gradient(90deg, var(--primary), var(--accent));
                border: none;
                font-weight: 600;
                border-radius: 1.5rem;
                box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
                transition: background 0.2s, box-shadow 0.2s;
            }

            .btn-primary:hover {
                background: linear-gradient(90deg, var(--primary-dark), var(--accent));
                box-shadow: 0 4px 16px rgba(99, 102, 241, 0.16);
            }

            .btn-secondary {
                border-radius: 1.5rem;
            }

            .card {
                border-radius: 1.25rem;
                box-shadow: 0 4px 24px rgba(99, 102, 241, 0.06);
                border: none;
            }

            .card-header {
                background: linear-gradient(90deg, var(--primary), var(--accent));
                color: #fff;
                border-radius: 1.25rem 1.25rem 0 0;
                font-weight: 600;
                letter-spacing: 0.02em;
            }

            .sidebar {
                background: linear-gradient(180deg, var(--primary-dark), var(--primary));
                color: #fff;
                min-height: calc(100vh - 56px);
                box-shadow: 2px 0 8px rgba(99, 102, 241, 0.08);
            }

            .sidebar .list-group-item {
                background: transparent;
                color: #fff;
                border: none;
                font-weight: 500;
                border-radius: 0.75rem;
                margin-bottom: 0.25rem;
                transition: background 0.2s, color 0.2s;
            }

            .sidebar .list-group-item:hover,
            .sidebar .list-group-item.active {
                background: rgba(244, 114, 182, 0.15);
                color: var(--accent);
            }

            .table thead {
                background: linear-gradient(90deg, var(--primary), var(--accent));
                color: #fff;
            }

            .table {
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(99, 102, 241, 0.04);
            }

            .alert-success {
                background-color: #e0fbea;
                border-color: #bbf7d0;
                color: var(--success);
                border-radius: 1rem;
            }

            .alert-danger {
                background-color: #fee2e2;
                border-color: #fecaca;
                color: var(--danger);
                border-radius: 1rem;
            }

            .alert-info {
                background-color: #e0f2fe;
                border-color: #bae6fd;
                color: var(--info);
                border-radius: 1rem;
            }

            .hero-section {
                background: linear-gradient(rgba(99, 102, 241, 0.7), rgba(244, 114, 182, 0.7)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
                background-size: cover;
                background-position: center;
                color: #fff;
                padding: 120px 0 80px 0;
                text-align: center;
                border-radius: 0 0 2rem 2rem;
                box-shadow: 0 8px 32px rgba(99, 102, 241, 0.12);
            }

            .form-control,
            .form-select {
                border-radius: 1.5rem;
                border: 1px solid #e5e7eb;
                box-shadow: none;
                transition: border 0.2s;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
            }

            .badge {
                border-radius: 1rem;
                font-size: 0.95em;
                padding: 0.5em 1em;
            }

            .dropdown-menu {
                border-radius: 1rem;
                box-shadow: 0 4px 24px rgba(99, 102, 241, 0.08);
            }

            /* Smooth transitions for interactive elements */
            .btn,
            .card,
            .sidebar .list-group-item,
            .form-control,
            .form-select {
                transition: all 0.2s;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Hotel Reservation System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- In the navbar section, update the menu based on user role -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                            </li>
                            @if (auth()->user()->role === 'clerk' || auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reservations.index') }}">Reservations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('billings.index') }}">Billing</a>
                                </li>
                            @endif
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rooms.index') }}">Rooms</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button"
                                        data-bs-toggle="dropdown">
                                        Reports
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reports.occupancy') }}">Occupancy
                                                Report</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reports.financial') }}">Financial
                                                Report</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reports.daily') }}">Daily Report</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @auth
                    @if (auth()->user()->role === 'clerk' || auth()->user()->role === 'admin')
                        <div class="col-md-2 sidebar p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('reservations.index') }}"
                                    class="list-group-item list-group-item-action">Reservations</a>
                                <a href="{{ route('customers.index') }}"
                                    class="list-group-item list-group-item-action">Customers</a>
                                <a href="{{ route('billings.index') }}"
                                    class="list-group-item list-group-item-action">Billing</a>
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('rooms.index') }}"
                                        class="list-group-item list-group-item-action">Room Management</a>
                                    <div class="list-group-item">
                                        <strong>Reports</strong>
                                        <div class="list-group list-group-flush ms-2">
                                            <a href="{{ route('reports.occupancy') }}"
                                                class="list-group-item list-group-item-action">Occupancy Report</a>
                                            <a href="{{ route('reports.financial') }}"
                                                class="list-group-item list-group-item-action">Financial Report</a>
                                            <a href="{{ route('reports.daily') }}"
                                                class="list-group-item list-group-item-action">Daily Report</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-10">
                        @else
                            <div class="col-12">
                    @endif
                @else
                    <div class="col-12">
                    @endauth
                    <main class="py-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>

</html>
