<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from bootstrapget.com/demos/cube-admin-template/create-invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Sep 2025 22:02:02 GMT -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>

    <!-- Meta -->
    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrapget.com/">
    <meta property="og:url" content="https://www.bootstrapget.com/">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="{{ asset('kourekama/assets/images/favicon.ico') }}" />

    <!-- *************
   ************ CSS Files *************
  ************* -->
    <link rel="stylesheet" href="{{ asset('kourekama/assets/fonts/bootstrap/bootstrap-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kourekama/assets/css/main.min.css') }}" />

    <!-- *************
   ************ Vendor Css Files *************
  ************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{ asset('kourekama/assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
</head>

<body>

    <!-- Page wrapper starts -->
    <div class="page-wrapper">

        <!-- Main container starts -->
        <div class="main-container">

            <!-- Sidebar wrapper starts -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand p-3 my-2">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('kourekama/assets/images/logo-sm.svg') }}" class="logo"
                            alt="Admin Dashboards" />
                    </a>
                </div>
                <!-- App brand ends -->

                <!-- Sidebar menu starts -->
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="">
                            <a href="{{ route('dashboard') }}">
                                <i class="bi bi-bar-chart-line"></i>
                                <span class="menu-text">Tableau de bord</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}">
                                <i class="bi bi-shop-window"></i>
                                <span class="menu-text">Ventes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.stocks.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Stocks</span>
                            </a>
                        </li>

                        <li class="active current-page">
                            <a href="{{ route('admin.settings') }}">
                                <i class="bi bi-gear"></i>
                                <span class="menu-text">Paramètre</span>
                            </a>
                        </li>


                    </ul>
                </div>
                <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper ends -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <div class="app-header d-flex align-items-center">

                    <!-- Toggle buttons starts -->
                    <div class="d-flex">
                        <button type="button" class="toggle-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                        <button type="button" class="pin-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                    </div>
                    <!-- Toggle buttons ends -->

                    <!-- App brand sm starts -->
                    <div class="app-brand-sm d-lg-none d-flex">

                        <!-- Logo sm starts -->
                        <a href="index.html">
                            <img src="assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery">
                        </a>
                        <!-- Logo sm end -->

                    </div>
                    <!-- App brand sm ends -->

                    <!-- Page title starts -->
                    <h5 class="m-0 ms-2 fw-semibold">@yield('text')</h5>
                    <!-- Page title ends -->

                    <!-- App header actions starts -->
                    <div class="header-actions">



                        <!-- Header action bar starts -->
                        <div class="header-actions-container rounded-4 d-flex align-items-center">

                            <!-- Header actions start -->
                             <div class="me-2 text-truncate d-lg-block d-none">
                                <span>Montant du magasin :</span>
                                <span id="storeAmount" class="fw-bold">●●●●●</span>
                                <button id="toggleAmount" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                           <script>
const toggleBtn = document.getElementById('toggleAmount');
const amountSpan = document.getElementById('storeAmount');
const actualAmount = "{{ number_format(app(\App\Http\Controllers\Admin\StocksController::class)->totalStockValue(), 0, ',', ' ') }} FCFA";

let visible = false;

toggleBtn.addEventListener('click', () => {
    if (!visible) {
        // Ouvre la modale pour entrer le PIN
        const modal = new bootstrap.Modal(document.getElementById('pinModal'));
        modal.show();

        document.getElementById('validatePin').onclick = function () {
            const pin = document.getElementById('pinInput').value;

            fetch("{{ route('check.pin') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ pin })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    document.getElementById('pinError').textContent = data.message;
                } else {
                    visible = true;
                    amountSpan.textContent = actualAmount;
                    toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                    modal.hide();
                }
            });
        };
    } 
    else {
        visible = false;
        amountSpan.textContent = '●●●●●';
        toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
    }
});
</script>



<!-- Modal pour entrer le PIN -->
<div class="modal fade" id="pinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entrer votre code PIN</h5>
            </div>
            <div class="modal-body">
                <input type="password" id="pinInput" class="form-control" placeholder="****">
                <div id="pinError" class="text-danger small mt-2"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="validatePin">Valider</button>
            </div>
        </div>
    </div>
</div>




                            <!-- Header actions end -->

                            <!-- User settings start -->
                            <div class="dropdown">
                                <a id="userSettings" class="dropdown-toggle user-settings" href="#!" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{-- <span class="me-2 text-truncate d-lg-block d-none">{{ Auth::user()->name }}</span> --}}
                                    <div class="header-actions-avatar fw-bold bg-primary-subtle text-primary">
                                        KO
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('admin.settings') }}"><i class="bi bi-person fs-5 me-2"></i>Mon
                                        profil</a>

                                    <div class="mx-3 my-2 d-grid">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Déconnexion</button>
                                        </form>
                                    </div>


                                </div>
                            </div>
                            <!-- User settings end -->

                        </div>
                        <!-- Header action bar ends -->

                    </div>
                    <!-- App header actions ends -->

                </div>
                <!-- App header ends -->

                <!-- App body starts -->
                @yield('suite')
                <!-- App body ends -->

                <!-- App footer starts -->
                <div class="app-footer">
                    <span class="big text-dark">Développé par Ndiaye Seydou +223 79 57 86 36 |
                        ndiayeseydouyongui@gmail.com
                    </span>
                </div>
                <!-- App footer ends -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container ends -->

    </div>
    <!-- Page wrapper ends -->

    <!-- *************
   ************ JavaScript Files *************
  ************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ asset('kourekama/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('kourekama/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- *************
   ************ Vendor Js Files *************
  ************* -->

    <!-- Overlay Scroll JS -->
    <script src="{{ asset('kourekama/assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('kourekama/assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

    <!-- Custom JS files -->
    <script src="{{ asset('kourekama/assets/js/custom.js') }}"></script>
</body>


<!-- Mirrored from bootstrapget.com/demos/cube-admin-template/create-invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Sep 2025 22:02:02 GMT -->

</html>
