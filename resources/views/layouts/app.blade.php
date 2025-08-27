<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hotel Reservation System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            :root {
                --imperial-red: #e63946;
                --honeydew: #f1faee;
                --powder-blue: #a8dadc;
                --celadon-blue: #457b9d;
                --prussian-blue: #1d3557;
            }

            body {
                background-color: #f8f9fa;
                color: #333;
            }

            .navbar {
                background-color: var(--imperial-red);
            }

            .navbar-brand,
            .navbar-nav .nav-link {
                color: white !important;
            }

            .btn-primary {
                background-color: var(--imperial-red);
                border-color: var(--imperial-red);
            }

            .btn-primary:hover {
                background-color: #d90429;
                border-color: #d90429;
            }

            .card-header {
                background-color: var(--imperial-red);
                color: white;
            }

            .sidebar {
                background-color: var(--prussian-blue);
                color: white;
                min-height: calc(100vh - 56px);
            }

            .sidebar .nav-link {
                color: white;
            }

            .sidebar .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            .table thead {
                background-color: var(--imperial-red);
                color: white;
            }

            .alert-success {
                background-color: #d1e7dd;
                border-color: #badbcc;
                color: #0f5132;
            }

            .alert-danger {
                background-color: #f8d7da;
                border-color: #f5c2c7;
                color: #842029;
            }

            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
                background-size: cover;
                background-position: center;
                color: white;
                padding: 100px 0;
                text-align: center;
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
