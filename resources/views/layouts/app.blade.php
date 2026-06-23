<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smeštaj i Apartmani - Pronađite savršen boravak</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22 fill=%22%23FF385C%22><path d=%22M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982Z%22/><path d=%22M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L8.707 1.5ZM13 13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5V13.5Z%22/></svg>">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Nunito', sans-serif; color: #222222; transition: background-color 0.3s, color 0.3s; }
        
        /* Moderni Svetli Airbnb Navbar */
        .navbar-main { background-color: #ffffff !important; border-bottom: 1px solid #ededed; padding: 15px 0; transition: background-color 0.3s, border-color 0.3s; }
        .navbar-main .navbar-brand { color: #FF385C !important; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; }
        .navbar-main .nav-link { color: #484848 !important; font-weight: 600; font-size: 15px; margin: 0 10px; transition: 0.2s; }
        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active { color: #FF385C !important; }
        
        /* Dugme za Rezervacije */
        .btn-cart { background: #FF385C; color: white !important; border: none; border-radius: 24px; padding: 8px 20px; font-size: 14px; font-weight: 600; transition: 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-cart:hover { background: #E61E4D; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.15); }

        /* Elegantan tamno-sivi Footer */
        footer { background-color: #222222; color: #f7f7f7; font-family: system-ui, -apple-system, sans-serif; }
        footer a { color: #b0b0b0; text-decoration: none; transition: 0.2s; }
        footer a:hover { color: #FF385C; }
        .footer-title { color: white; font-size: 15px; font-weight: 700; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .social-icon { width: 36px; height: 36px; border-radius: 50%; border: 1px solid #444; display: inline-flex; align-items: center; justify-content: center; color: #b0b0b0; margin-right: 8px; text-decoration: none; transition: 0.2s; }
        .social-icon:hover { border-color: #FF385C; color: #FF385C; background-color: rgba(255, 56, 92, 0.1); }

        /* STILOVI ZA DARK MODE (Samo unutar Admin/Host Panela) */
        body.admin-dark-mode {
            background-color: #121212 !important;
            color: #f5f5f5 !important;
        }
        body.admin-dark-mode .navbar-main {
            background-color: #1e1e1e !important;
            border-bottom: 1px solid #2d2d2d !important;
        }
        body.admin-dark-mode .navbar-main .nav-link {
            color: #e0e0e0 !important;
        }
        body.admin-dark-mode .navbar-main .nav-link:hover,
        body.admin-dark-mode .navbar-main .nav-link.active {
            color: #FF385C !important;
        }
        body.admin-dark-mode .card {
            background-color: #1e1e1e !important;
            border-color: #2d2d2d !important;
            color: #f5f5f5 !important;
        }
        body.admin-dark-mode .card-header, body.admin-dark-mode .card-footer {
            background-color: #252525 !important;
            border-color: #2d2d2d !important;
            color: #ffffff !important;
        }
        body.admin-dark-mode .table {
            color: #e0e0e0 !important;
            border-color: #2d2d2d !important;
        }
        body.admin-dark-mode .table th, body.admin-dark-mode .table td {
            background-color: #1e1e1e !important;
            border-color: #2d2d2d !important;
        }
        body.admin-dark-mode .dropdown-menu {
            background-color: #1e1e1e !important;
            border-color: #2d2d2d !important;
        }
        body.admin-dark-mode .dropdown-item {
            color: #e0e0e0 !important;
        }
        body.admin-dark-mode .dropdown-item:hover {
            background-color: #2d2d2d !important;
        }
        body.admin-dark-mode .form-control, body.admin-dark-mode .form-select {
            background-color: #252525 !important;
            border-color: #333333 !important;
            color: #ffffff !important;
        }
        body.admin-dark-mode .form-control:focus, body.admin-dark-mode .form-select:focus {
            background-color: #2a2a2a !important;
            color: #ffffff !important;
            border-color: #FF385C !important;
            box-shadow: 0 0 0 0.25px rgba(255, 56, 92, 0.5) !important;
        }
        body.admin-dark-mode .alert {
            background-color: #2d1a1e !important;
            border-color: #4c1d24 !important;
            color: #ff99a8 !important;
        }
        body.admin-dark-mode .alert-success {
            background-color: #14281d !important;
            border-color: #1e462f !important;
            color: #a3cfbb !important;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-main shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-house-heart-fill me-2"></i>Avenija Smeštaj
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop', ['all' => 1]) }}">Istraži Smeštaje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">O nama</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    {{-- DUGME ZA LISTU ŽELJA (FAVORITI) --}}
                    <li class="nav-item me-3">
                        <a href="javascript:void(0)" class="nav-link position-relative p-2" data-bs-toggle="modal" data-bs-target="#wishlistModal" title="Moja Lista Želja">
                            <i class="bi bi-heart-fill text-danger fs-5"></i>
                            <span id="wishlist-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark" style="font-size: 10px; display: none;">0</span>
                        </a>
                    </li>

                    @auth
                        @if(Auth::user()->role === 'host' || Auth::user()->is_admin)
                            <li class="nav-item me-2">
                                <button id="darkModeToggle" class="btn btn-link nav-link p-2" style="border: none; text-decoration: none;" title="Promeni režim svetla">
                                    <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5" style="color: #484848;"></i>
                                </button>
                            </li>
                        @endif
                    @endauth

                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown me-3">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }} 
                                <span class="badge bg-secondary ms-1" style="font-size: 10px;">{{ strtoupper(Auth::user()->role) }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                @if(Auth::user()->role === 'host' || Auth::user()->is_admin)
                                    <a class="dropdown-item py-2" href="{{ Route::has('host.dashboard') ? route('host.dashboard') : (Route::has('admin.dashboard') ? route('admin.dashboard') : '#') }}">
                                        <i class="bi bi-speedometer2 me-2 text-secondary"></i>Domaćin Panel
                                    </a>
                                    <hr class="dropdown-divider">
                                @endif
                                
                                <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Odjavi se
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                    
                    <li class="nav-item">
                        @auth
                            <a href="{{ Route::has('bookings.my') ? route('bookings.my') : '#' }}" class="btn btn-cart">
                                <i class="bi bi-calendar-check me-1"></i>Moje Rezervacije
                                @php
                                    $activeBookingsCount = \App\Models\Booking::where('user_id', Auth::id())->count();
                                @endphp
                                @if($activeBookingsCount > 0)
                                    <span class="badge bg-white text-danger ms-1 rounded-circle">{{ $activeBookingsCount }}</span>
                                @endif
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-cart">
                                <i class="bi bi-calendar-check me-1"></i>Moje Rezervacije
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ELEGANTAN MODAL ZA PRIKAZ LISTE ŽELJA --}}
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-header border-bottom px-4">
                    <h5 class="modal-title fw-bold" id="wishlistModalLabel"><i class="bi bi-heart-fill text-danger me-2"></i>Moja lista želja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: 400px; overflow-y: auto;">
                    <div id="wishlist-items-container">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <main class="py-4">
        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('status'))
            <div class="container">
                <div class="alert alert-success shadow-sm">{{ session('status') }}</div>
            </div>
        @endif
        @if($errors->any())
            <div class="container">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger shadow-sm">{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="pt-5 pb-3 mt-5" style="background-color: #1f1f1f; color: #f7f7f7; font-family: 'Nunito', sans-serif;">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-md-3">
                <div class="footer-title fw-bold mb-3 text-uppercase" style="color: #FF385C; font-size: 15px; letter-spacing: 0.5px;">
                    <i class="bi bi-house-heart-fill me-2"></i>Avenija Smeštaj
                </div>
                <p style="font-size:14px; color:#b0b0b0; line-height:1.7; margin-bottom: 0;">
                    Vaš pouzdan partner za pronalaženje idealnog boravka. Luksuzni apartmani, planinske brvnare i letnji beg na jednom mestu.
                </p>
            </div>
            
            <div class="col-md-3">
                <div class="footer-title fw-bold mb-3 text-uppercase" style="color: #ffffff; font-size: 15px; letter-spacing: 0.5px;">
                    Navigacija
                </div>
                <ul class="list-unstyled mb-0" style="font-size:14px;">
                    <li class="mb-2"><a href="{{ route('home') }}" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">Početna stranica</a></li>
                    <li class="mb-2"><a href="{{ route('shop', ['all' => 1]) }}" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">Svi smeštaji</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">O našoj platformi</a></li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <div class="footer-title fw-bold mb-3 text-uppercase" style="color: #ffffff; font-size: 15px; letter-spacing: 0.5px;">
                    Popularne regije
                </div>
                <ul class="list-unstyled mb-0" style="font-size:14px;">
                    <li class="mb-2">
                        <a href="javascript:void(0)" onclick="filtrirajGrad('Zlatibor')" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">
                            <i class="bi bi-chevron-right small me-1" style="font-size: 10px;"></i> Zlatibor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="javascript:void(0)" onclick="filtrirajGrad('Kopaonik')" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">
                            <i class="bi bi-chevron-right small me-1" style="font-size: 10px;"></i> Kopaonik
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="javascript:void(0)" onclick="filtrirajGrad('Beograd')" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">
                            <i class="bi bi-chevron-right small me-1" style="font-size: 10px;"></i> Beograd
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="javascript:void(0)" onclick="filtrirajGrad('Novi Sad')" style="color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.color='#FF385C'" onmouseout="this.style.color='#b0b0b0'">
                            <i class="bi bi-chevron-right small me-1" style="font-size: 10px;"></i> Novi Sad
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <div class="footer-title fw-bold mb-3 text-uppercase" style="color: #ffffff; font-size: 15px; letter-spacing: 0.5px;">
                    Korisnička podrška
                </div>
                <ul class="list-unstyled mb-0" style="font-size:14px; color: #b0b0b0;">
                    <li class="mb-2"><i class="bi bi-envelope me-2" style="color: #FF385C;"></i>podrska@avenijasmestaj.rs</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2" style="color: #FF385C;"></i>+381 11 123 456</li>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2" style="color: #FF385C;"></i>Beograd, Srbija</li>
                </ul>
            </div>
        </div>
        
        <div class="border-top pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-color:#333 !important;">
            <span style="font-size:13px; color: #717171;">© {{ date('Y') }} Avenija Smeštaj. Sva prava zadržana.</span>
            <div class="d-flex gap-2">
                <a href="#" class="d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; border: 1px solid #444; color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.borderColor='#FF385C'; this.style.color='#FF385C';" onmouseout="this.style.borderColor='#444'; this.style.color='#b0b0b0';"><i class="bi bi-facebook"></i></a>
                <a href="#" class="d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; border: 1px solid #444; color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.borderColor='#FF385C'; this.style.color='#FF385C';" onmouseout="this.style.borderColor='#444'; this.style.color='#b0b0b0';"><i class="bi bi-instagram"></i></a>
                <a href="#" class="d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 50%; border: 1px solid #444; color: #b0b0b0; text-decoration: none; transition: 0.2s;" onmouseover="this.style.borderColor='#FF385C'; this.style.color='#FF385C';" onmouseout="this.style.borderColor='#444'; this.style.color='#b0b0b0';"><i class="bi bi-twitter-x"></i></a>
            </div>
        </div>
    </div>
</footer>

<script>
function filtrirajGrad(imeGrada) {
    if (!window.location.href.includes('/shop')) {
        window.location.href = "{{ route('shop', ['all' => 1]) }}?search=" + encodeURIComponent(imeGrada);
        return;
    }
    let inputPolje = document.querySelector('input[placeholder="Gde putuješ?"]') || 
                     document.querySelector('input[name="search"]') || 
                     document.querySelector('input[type="text"]');
                     
    if (inputPolje) {
        inputPolje.value = imeGrada;
        let forma = inputPolje.closest('form');
        if (forma) { forma.submit(); }
    } else {
        window.location.href = window.location.pathname + "?search=" + encodeURIComponent(imeGrada);
    }
}

// LOGIKA ZA STRUKTURU FAVORITA UNUTAR NAVBAR-A KOJA RADI BILO GDE NA SAJTU
function osveziMeniFavorita() {
    let favoriti = JSON.parse(localStorage.getItem('smestaj_favoriti')) || [];
    let badge = document.getElementById('wishlist-badge');
    let container = document.getElementById('wishlist-items-container');
    
    if(badge) {
        if(favoriti.length > 0) {
            badge.innerText = favoriti.length;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
    
    if(container) {
        if(favoriti.length === 0) {
            container.innerHTML = `<div class="text-center py-4 text-muted">
                <i class="bi bi-heartbreak fs-2 d-block mb-2"></i> Vaša lista želja je prazna.
            </div>`;
            return;
        }
        
        let html = '<div class="list-group list-group-flush">';
        favoriti.forEach(item => {
            html += `
                <div class="list-group-item d-flex align-items-center justify-content-between border-0 py-3 px-0">
                    <div class="d-flex align-items-center">
                        <img src="${item.slika}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-bold text-truncate" style="max-width: 220px;">${item.naslov}</h6>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>${item.lokacija}</small>
                            <div class="fw-bold text-danger mt-1" style="font-size: 13px;">${item.cena}</div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <a href="/smestaj/${item.id}" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size:11px; font-weight:600;">Pogledaj</a>
                        <button onclick="ukloniIzFavoritaDirektno(${item.id})" class="btn btn-sm btn-light text-muted border-0 rounded-circle" style="width:28px; height:28px; padding:0;" title="Ukloni"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;
    }
}

function ukloniIzFavoritaDirektno(id) {
    let favoriti = JSON.parse(localStorage.getItem('smestaj_favoriti')) || [];
    favoriti = favoriti.filter(x => x.id != id);
    localStorage.setItem('smestaj_favoriti', JSON.stringify(favoriti));
    osveziMeniFavorita();
    
    // Ako se nalazimo na shop stranici, ažuriraj i tamošnju ikonicu srca
    let dugmeNaStranici = document.querySelector(`.fav-btn[data-id="${id}"]`);
    if(dugmeNaStranici) {
        let ikonica = dugmeNaStranici.querySelector('i');
        ikonica.classList.remove('bi-heart-fill', 'text-danger');
        ikonica.classList.add('bi-heart', 'text-white');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    osveziMeniFavorita();

    // DARK MODE PANEL LOGIKA
    const toggleBtn = document.getElementById('darkModeToggle');
    const toggleIcon = document.getElementById('darkModeIcon');
    const isPanelPage = window.location.href.includes('/host') || window.location.href.includes('/admin');

    if (isPanelPage) {
        const isDarkMode = localStorage.getItem('admin-dark-mode') === 'true';
        if (isDarkMode) {
            document.body.classList.add('admin-dark-mode');
            if(toggleIcon) {
                toggleIcon.classList.remove('bi-moon-stars-fill');
                toggleIcon.classList.add('bi-sun-fill');
                toggleIcon.style.color = '#ffc107';
            }
        }
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const currentDark = document.body.classList.toggle('admin-dark-mode');
                localStorage.setItem('admin-dark-mode', currentDark);
                if (currentDark) {
                    toggleIcon.classList.remove('bi-moon-stars-fill');
                    toggleIcon.classList.add('bi-sun-fill');
                    toggleIcon.style.color = '#ffc107';
                } else {
                    toggleIcon.classList.remove('bi-sun-fill');
                    toggleIcon.classList.add('bi-moon-stars-fill');
                    toggleIcon.style.color = '#484848';
                }
            });
        }
    } else {
        if (toggleBtn) { toggleBtn.style.display = 'none'; }
    }
});
</script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>