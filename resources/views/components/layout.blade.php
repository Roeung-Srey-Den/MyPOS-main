<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $header }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/27dad13733.js" crossorigin="anonymous"></script>
    <!-- Chart -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body style="background: rgb(221, 222, 223);">

    <!-- Header -->
    <header class="d-flex align-items-center gap-3" style="padding: 10px;">
        <button id="menu-toggle" class="btn btn-outline-primary d-xl-none" type="button" aria-label="Toggle Menu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo-header">
            <h1>Pos System</h1>
        </div>

        <div class="search-wrapper d-none d-xl-block" style="position: relative; width: 50%;">
            <input type="text" id="search" class="btn-search" placeholder="Search products..." style="border: none; border-bottom: 2px solid #ccc; outline: none; padding: 5px 40px 5px 10px; width: 100%;" />
            <i class="fas fa-search search-icon" style="position: absolute; right: 210px; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none;"></i>
        </div>

        <div class="button-logo">
            <button class="btn btn-warning">{{session()->get('username')}}</button>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container-fluid">
        <div class="row h-100 min-vh-100">

            <!-- Sidebar -->
            <div class="col-auto col-md-1 d-none d-lg-block p-0" id="sidebar-nav">
                <nav class="shadow bg-light h-100">
                    <ul class="nav-ul d-flex flex-column p-3 text-center">
                        <li>
                            <a href="/" class="d-flex flex-column align-items-center {{ Request::is('/') ? 'active' : '' }}">
                                <i class="fa-solid fa-house box-icon"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="/tables" class="d-flex flex-column align-items-center {{ Request::is('tables') ? 'active' : '' }}">
                                <i class="fa-solid fa-table box-icon"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Tables</span>
                                
                            </a>
                        </li>
                        <li>
                            <a href="/products" class="d-flex flex-column align-items-center {{ Request::is('products') ? 'active' : '' }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Products</span>
                            </a>
                        </li>
                
                        @if(session('role')==='Admin')
                        <li>
                            <a href="/cashiers" class="d-flex flex-column align-items-center  nav-link {{ Request::is('cashiers') ? 'active' : '' }}">
                                <i class="fa-solid fa-dollar-sign"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Cashiers</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="/orders" class="d-flex flex-column align-items-center  nav-link {{ Request::is('orders') ? 'active' : '' }} ">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Orders</span>
                            </a>
                        </li>
                        @if(session('role')==='Admin')
                        <li>
                            <a href="/reports" class="d-flex flex-column align-items-center {{ Request::is('reports') ? 'active' : '' }}">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Reports</span>
                            </a>
                        </li>
                        @endif
                        <li class="d-none">
                            <a href="/settings" class="d-flex flex-column align-items-center  nav-link {{ Request::is('settings') ? 'active' : '' }} ">
                                <i class="fa-solid fa-gear"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Setting</span>
                            </a>
                        </li>
                        <li>
                            <a href="/logout" class="d-flex flex-column align-items-center text-danger nav-link ">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span class="d-none d-lg-inline custom-hide-ipad">Log out</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content -->
            <main class="col px-2 overflow-auto" style="max-height: 100vh;">
                <div class="row gx-2">
                    {{ $slot }}
            
                </div>
            </main>

        </div>

    </div>


    <script src="/js/cart.js"></script>
    <script src="/js/event.js"></script>
    <script src="/js/imagePreview.js"></script>
    <script src="/js/jqueryTable.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
