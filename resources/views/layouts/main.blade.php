<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parking Application')</title>

    {{-- CSS Global --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    
    {{-- CSS untuk sidebar --}}
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
        }

        .btn-edit:hover {
            color: var(--primary);
        }
        
        .btn-delete:hover {
            color: red;
            
        }
        
        .main-content {
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            flex: 1;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .card-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 10px;
            box-shadow: var(--box-shadow);
        }
        
        .card-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 10px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            
        }

       

        
       .attendance-table {
            background-color: white;
            width: 100%;
            border-collapse: collapse
            
        }

       
        
        .attendance-table thead {
            background-color: var(--light);
        }
        
        .attendance-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid var(--light-gray);
        }
        
        .attendance-table td {
            padding: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .attendance-table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }

         /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-left: 10px;
        }
        
        .status-admin {
            background-color: rgba(35, 128, 204, 0.374);
            color: var(--primary);
        }
        
        .status-petugas {
            background-color: rgba(47, 223, 71, 0.341);
            color: var(--success);
        }
        
        .status-owner {
            background-color: rgba(80, 77, 73, 0.241);
            color: var(--secondary);
        }

        .status-unknown {
            background-color: rgba(158, 158, 158, 0.15);
            color: var(--danger);
        }

        .status-select, .time-input, .note-input {
            padding: 10px 12px;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
            font-size: 0.95rem;
            width: 100%;
            max-width: 200px;
        }

        .quick-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .input-group{
            display: flex;
            flex-wrap: nowrap;
        }

       .nav-strip {
            position: relative;
            padding-bottom: 6px;
        }

        .nav-strip::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background-color: #f2f3f4; /* warna biru bootstrap */
            transition: width 0.3s ease;
        }

        .nav-strip:hover::after {
            width: 100%;
        }

        .nav-strip.active::after {
            width: 100%;
        }

      

        .nav-link {
            border-radius: 10px;
            padding: 6px 12px;
            transition: all 0.25s ease;
            opacity: 0.85;
            transition: 0.2s;
            padding: 6px 10px;
            white-space: nowrap;
        }
       

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            opacity: 1;
            transform: scale(1.1);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .navbar-nav {
            flex-wrap: nowrap;
           
            gap: 6px;
        }

        .dropdown-menu {
            position: absolute !important;
            right: 0;
            left: auto;
        }

       .nav-sidebar {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 12px;
            margin-bottom: 6px;

            border-radius: 10px;

            color: #374151;
            text-decoration: none;

            transition: all 0.2s ease;
        }

        .nav-sidebar:hover {
            background: #eef2ff;
            color: #1a1a1d;
            transform: translateX(4px);
        }   

        .nav-sidebar.active {
            background: #656568;
            color: #ffffff !important;

            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.25);
        }

        
        /* Responsive */
        @media (max-width: 568px) {
            .sidebar {
                min-height: auto;
                position: static;
            }
            .navbar-nav {
                flex-direction: row;
                gap: 7px !important;;
            }

            .nav-text {
                display: none;
            }

            .nav-link {
                padding: 7px 12px;
            }

            .navbar {
                padding: 8px 7px;
            }
            .navbar-brand {
                font-size: 16px;
                max-width: 150px;
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .navbar .rounded-circle {
                width: 32px !important;
                height: 32px !important;
                font-size: 12px;
            }
            
            .navbar .dropdown-toggle span {
                display: none;
            }
           .dropdown-menu {
                position: absolute !important;
                right: 0;
                left: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="container-fluid px-0">
    <div class="row g-0">
        @php
            $role = auth()->user()->role;
        @endphp

        @if($role === 'anggota')

            {{-- ================= NAVBAR OWNER ================= --}}
            <div class="col-12">
                @include('layouts.navbar.anggota')
            </div>

        @else

            {{-- ================= SIDEBAR ADMIN & PETUGAS ================= --}}
            <div class="col-lg-2 col-md-3 d-md-block">
                <aside class=" p-4 px-5" style="width: 250px;">
                    <div class=" mb-3 pb-2 border-bottom">
                        <div class=" text-dark text-center">
                             <h3 class="fw-bold">
                                <i class="bi bi-book"></i> Perpustakaan
                            </h3>
                        </div>
                        <small class="text-muted">
                            Management System
                        </small>
                    </div>
                    @include('layouts.sidebar.' . $role)
                </aside>
            </div>

        @endif

        {{-- Konten Utama --}}
        <div class="col-lg-10 col-md-9 main-content">
            <div class="p-5">
                <h3 class="mb-4">@yield('page-title')</h3>
                @yield('content')
            </div>
        </div>
    </div>
</div>

{{-- JS Global --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- JS untuk toggle sidebar di mobile --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggler = document.querySelector('[data-bs-toggle="sidebar"]');
        const sidebar = document.querySelector('.sidebar');
        
        if (sidebarToggler && sidebar) {
            sidebarToggler.addEventListener('click', function() {
                sidebar.classList.toggle('d-none');
                sidebar.classList.toggle('d-md-block');
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>