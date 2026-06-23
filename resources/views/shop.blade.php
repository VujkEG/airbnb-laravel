@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- HEADER --}}
<div style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); color: white; padding: 45px 0; box-shadow: inset 0 -10px 20px rgba(0,0,0,0.1);">
    <div class="container">
        <h1 style="font-size: 2.2rem; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.5px;">Smeštaj</h1>
        <p style="color: #94a3b8; font-size: 15px; margin: 0; font-weight: 400;">Pronađi idealan kutak za svoj sledeći odmor</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        
        {{-- SIDEBAR --}}
        <div class="col-md-3">
            {{-- PRETRAGA PO GRADU/LOKACIJI --}}
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); position: relative;">
                <h2 style="font-size: 14px; font-weight: 700; color: #1a1a2e; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="bi bi-geo-alt-fill me-2" style="color: #ff385c;"></i>Izaberi Grad
                </h2>
                <form id="shopSearchForm" action="{{ route('shop') }}" method="GET" autocomplete="off">
                    @if($selectedCategory) 
                        <input type="hidden" name="category" value="{{ $selectedCategory }}"> 
                    @endif
                    @if(request('guests'))
                        <input type="hidden" name="guests" value="{{ request('guests') }}">
                    @endif
                    
                    <input type="hidden" id="shopSearchHidden" name="search" value="{{ request('search') ?? request('location') }}">

                    <div id="shopLocationGroup" style="display: flex; gap: 8px; position: relative;">
                        <input type="text" id="shopLocationInput" name="location" value="{{ request('location') ?? request('search') }}" placeholder="Gde putuješ?" 
                               style="flex: 1; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 13px; outline: none; transition: all 0.2s; cursor: pointer;"
                               onfocus="this.style.borderColor='#ff385c'; this.style.boxShadow='0 0 0 3px rgba(255,56,92,0.1)';" 
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        
                        <button type="submit" style="background: #ff385c; color: white; border: none; border-radius: 10px; padding: 0 16px; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.background='#e02447'" onmouseout="this.style.background='#ff385c'">
                            <i class="bi bi-search"></i>
                        </button>

                        <div class="shop-location-popup d-none" id="shopLocationPopup">
                            <div class="popup-title">Popularne destinacije</div>
                            <div class="popup-item" data-value="Beograd"><i class="fas fa-map-marker-alt"></i> Beograd</div>
                            <div class="popup-item" data-value="Novi Sad"><i class="fas fa-map-marker-alt"></i> Novi Sad</div>
                            <div class="popup-item" data-value="Zlatibor"><i class="fas fa-map-marker-alt"></i> Zlatibor</div>
                            <div class="popup-item" data-value="Kopaonik"><i class="fas fa-map-marker-alt"></i> Kopaonik</div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- KATEGORIJE --}}
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                <h2 style="font-size: 14px; font-weight: 700; color: #1a1a2e; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="bi bi-grid me-2" style="color: #ff385c;"></i>Kategorije
                </h2>
                
                <a href="{{ route('shop', request()->except(['category', 'page'])) }}" 
                   style="display: flex; justify-content: space-between; align-items: center; padding: 11px 14px; border-radius: 10px; text-decoration: none; margin-bottom: 8px; font-size: 14px; font-weight: 600; transition: all 0.2s;
                   background: {{ !$selectedCategory ? '#fff5f5' : 'transparent' }}; 
                   color: {{ !$selectedCategory ? '#ff385c' : '#475569' }};"
                   class="category-sidebar-link">
                    <span style="display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-grid-fill" style="font-size: 16px;"></i> Sve kategorije
                    </span>
                    <span style="background: {{ !$selectedCategory ? '#ff385c' : '#f1f5f9' }}; color: {{ !$selectedCategory ? 'white' : '#64748b' }}; font-size: 11px; padding: 3px 9px; border-radius: 20px; font-weight: 700;">
                        {{ $categories->sum('products_count') }}
                    </span>
                </a>

                @foreach($categories as $category)
                    @php
                        $categoryName = trim($category->name);
                        if (empty($categoryName)) {
                            $categoryName = match($category->id) {
                                1 => 'Apartmani',
                                2 => 'Hoteli',
                                3 => 'Vikendice',
                                4 => 'Brvnare',
                                5 => 'Sobe',
                                default => 'Kategorija ' . $category->id
                            };
                        }

                        $sidebarIcon = match(Str::slug($categoryName)) {
                            'apartmani', 'apartman' => 'bi-building',
                            'hoteli', 'hotel'       => 'bi-backpack',
                            'vikendice', 'vikendica' => 'bi-tree',
                            'brvnare', 'brvnara'     => 'bi-house-heart',
                            'sobe', 'soba'           => 'bi-door-closed',
                            default                  => 'bi-house'
                        };
                    @endphp
                <a href="{{ route('shop', array_merge(request()->except(['page']), ['category' => $category->id])) }}" 
                   style="display: flex; justify-content: space-between; align-items: center; padding: 11px 14px; border-radius: 10px; text-decoration: none; margin-bottom: 6px; font-size: 14px; font-weight: 600; transition: all 0.2s;
                   background: {{ $selectedCategory == $category->id ? '#fff5f5' : 'transparent' }}; 
                   color: {{ $selectedCategory == $category->id ? '#ff385c' : '#475569' }};"
                   class="category-sidebar-link">
                    <span style="display: flex; align-items: center; gap: 10px; color: {{ $selectedCategory == $category->id ? '#ff385c' : '#222222' }};">
                        <i class="bi {{ $sidebarIcon }}" style="font-size: 16px; color: {{ $selectedCategory == $category->id ? '#ff385c' : '#717171' }};"></i> {{ $categoryName }}
                    </span>
                    <span style="background: {{ $selectedCategory == $category->id ? '#ff385c' : '#f1f5f9' }}; color: {{ $selectedCategory == $category->id ? 'white' : '#64748b' }}; font-size: 11px; padding: 3px 9px; border-radius: 20px; font-weight: 700;">
                        {{ $category->products_count ?? 0 }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- SMEŠTAJI --}}
        <div class="col-md-9">
            
            {{-- INFO BAR --}}
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div style="font-size: 14px; color: #64748b; font-weight: 500;">
                    @if(request('location') || request('search')) 
                        Rezultati za lokaciju <strong>"{{ request('location') ?? request('search') }}"</strong> — 
                    @endif
                    Prisutno: <strong style="color: #1a1a2e; font-weight: 700;">{{ $products->total() }}</strong> smeštaja
                </div>
                @if($selectedCategory || request('search') || request('location'))
                <a href="{{ route('shop') }}" style="font-size: 13px; color: #ff385c; text-decoration: none; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#e02447'" onmouseout="this.style.color='#ff385c'">
                    <i class="bi bi-x-circle-fill me-1"></i> Poništi filtere
                </a>
                @endif
            </div>

            {{-- SKELETON LOADER --}}
            <div id="skeletonLoader" class="row g-4 d-none">
                @for ($i = 0; $i < 6; $i++)
                <div class="col-sm-6 col-lg-4">
                    <div class="skeleton-card">
                        <div class="skeleton-img pulse"></div>
                        <div class="skeleton-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="skeleton-text skeleton-title pulse"></div>
                                <div class="skeleton-text skeleton-star pulse"></div>
                            </div>
                            <div class="skeleton-text skeleton-location pulse mb-3"></div>
                            <div class="skeleton-text skeleton-desc pulse mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="skeleton-text skeleton-price pulse"></div>
                                <div class="skeleton-text skeleton-btn pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- GLAVNI GRID SA KARTICAMA --}}
            <div id="productsGrid">
                @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; display: flex; flex-direction: column; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);"
                             onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)'; this.style.transform='translateY(-6px)'; this.style.borderColor='#cbd5e1';"
                             onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.02)'; this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                            
                            {{-- Slika kontejner --}}
                            <div style="width: 100%; overflow: hidden; background: #f1f5f9; position: relative;">
                                
                                @php
                                    $naslovSmeštaja = Str::lower($product->name);
                                    // POPRAVLJENO: Provera da li slika postoji lokalno u storage-u
                                    if ($product->image) {
                                        if (Str::startsWith($product->image, ['http://', 'https://'])) {
                                            $finalUrl = $product->image;
                                        } else {
                                            $finalUrl = asset($product->image);
                                        }
                                    } else {
                                        if (Str::contains($naslovSmeštaja, ['brvnara', 'brvnari', 'drvena'])) {
                                            $finalUrl = 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?q=80&w=600&auto=format&fit=crop';
                                        } elseif (Str::contains($naslovSmeštaja, ['ski', 'kopaonik', 'zlatibor', 'sneg', 'staza', 'apartman'])) {
                                            if (Str::contains($naslovSmeštaja, ['ski-in'])) {
                                                $finalUrl = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop';
                                            } else {
                                                $finalUrl = 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=600&auto=format&fit=crop';
                                            }
                                        } elseif (Str::contains($naslovSmeštaja, ['more', 'obala', 'plaža', 'okean'])) {
                                            $finalUrl = 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?q=80&w=600&auto=format&fit=crop';
                                        } else {
                                            $finalUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=600&auto=format&fit=crop';
                                        }
                                    }
                                    
                                    $cardCategoryName = trim($product->category->name ?? '');
                                    if (empty($cardCategoryName)) {
                                        $cardCategoryName = match($product->category_id ?? 0) {
                                            1 => 'Apartman',
                                            2 => 'Hotel',
                                            3 => 'Vikendica',
                                            4 => 'Brvnara',
                                            5 => 'Soba',
                                            default => 'Smeštaj'
                                        };
                                    }
                                    
                                    $cenaTekst = number_format($product->price, 0, ',', '.') . ' RSD';
                                    $dinamickiGrad = $product->city ?? $product->location ?? 'Srbija';
                                @endphp

                                {{-- DUGME ZA WISH LISTU --}}
                                <button class="btn position-absolute fav-btn rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                        data-id="{{ $product->id }}"
                                        data-naslov="{{ $product->name }}"
                                        data-lokacija="{{ $dinamickiGrad }}"
                                        data-cena="{{ $cenaTekst }} / noć"
                                        data-slika="{{ $finalUrl }}"
                                        style="top: 12px; right: 12px; background: white; border: none; width: 34px; height: 34px; transition: transform 0.2s ease; z-index: 20; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                                    <i class="bi bi-heart text-secondary fs-6" style="transition: color 0.2s, transform 0.2s;"></i>
                                </button>

                                <a href="{{ route('smestaj.show', $product->id) }}" style="text-decoration: none; display: block;">
                                    <img src="{{ $finalUrl }}" alt="{{ $product->name }}" 
                                         style="width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block; transition: transform 0.5s;" 
                                         onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                </a>
                                
                                <div style="position: absolute; top: 12px; left: 12px; background: rgba(26, 26, 46, 0.85); backdrop-filter: blur(4px); color: white; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px; z-index: 10;">
                                    {{ $cardCategoryName }}
                                </div>
                            </div>

                            {{-- Sadržaj kartice --}}
                            <div style="padding: 18px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start gap-2" style="margin-bottom: 4px;">
                                        <div style="font-size: 16px; font-weight: 700; color: #1a1a2e; line-height: 1.4; min-height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1;">
                                            <a href="{{ route('smestaj.show', $product->id) }}" style="color: #1a1a2e; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#ff385c'" onmouseout="this.style.color='#1a1a2e'">
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                        <div style="font-size: 13px; font-weight: 600; white-space: nowrap; margin-top: 2px;">
                                            <i class="bi bi-star-fill" style="color: #ffb400;"></i>
                                            @if($product->reviews_avg_rating)
                                                {{ number_format($product->reviews_avg_rating, 1) }}
                                            @else
                                                <span class="text-muted" style="font-size: 11px; font-weight: normal;">Novo</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="font-size: 13px; color: #717171; margin-bottom: 10px; font-weight: 500;">
                                        <i class="bi bi-geo-alt-fill" style="color: #ff385c;"></i> {{ $dinamickiGrad }}
                                    </div>
                                    
                                    <div style="font-size: 13px; color: #64748b; margin-bottom: 12px; line-height: 1.5; min-height: 38px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ Str::limit($product->desc ?? $product->description, 65) }}
                                    </div>

                                    <div class="d-flex gap-3 mb-3 text-muted" style="font-size: 12px; font-weight: 500; border-top: 1px dashed #e2e8f0; padding-top: 10px;">
                                        <div><i class="fa-solid fa-user-friends me-1" style="color: #717171;"></i>{{ $product->max_guests ?? 2 }} gostiju</div>
                                        <div><i class="fa-solid fa-bed me-1" style="color: #717171;"></i>{{ $product->bedrooms ?? 1 }} soba</div>
                                        <div><i class="fa-solid fa-bath me-1" style="color: #717171;"></i>{{ $product->bathrooms ?? 1 }} kup.</div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div style="margin-bottom: 16px; display: flex; align-items: baseline; gap: 4px;">
                                        <span style="font-size: 1.3rem; font-weight: 800; color: #ff385c;">{{ number_format($product->price, 0, ',', '.') }} RSD</span>
                                        <span style="font-size: 13px; color: #64748b; font-weight: 500;"> / noć</span>
                                    </div>

                                    <a href="{{ route('smestaj.show', $product->id) }}" 
                                       style="display: block; width: 100%; background: #1a1a2e; color: white; font-size: 13px; padding: 11px; border-radius: 10px; font-weight: 600; text-decoration: none; text-align: center; border: none; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(26,26,46,0.1);"
                                       onmouseover="this.style.background='#ff385c'; this.style.boxShadow='0 4px 12px rgba(255,56,92,0.25)';"
                                       onmouseout="this.style.background='#1a1a2e'; this.style.boxShadow='0 4px 6px -1px rgba(26,26,46,0.1)';">
                                        Pogledaj smeštaj
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5" style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px;">
                    <i class="bi bi-building-x" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h3 style="color: #475569; margin-top: 16px; font-weight: 700; font-size: 1.2rem;">Nema slobodnih smeštaja</h3>
                    <p style="color: #94a3b8; font-size: 14px; max-width: 300px; margin: 8px auto 16px;">Pokušaj sa promenom ključne reči ili izaberi drugu kategoriju.</p>
                    <a href="{{ route('shop') }}" style="display: inline-block; background: #ff385c; color: white; border-radius: 10px; padding: 10px 20px; font-size: 14px; font-weight: 600; text-decoration: none;">Prikaži sve</a>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('shopLocationInput');
        const hiddenSearch = document.getElementById('shopSearchHidden');
        const popup = document.getElementById('shopLocationPopup');
        const items = document.querySelectorAll('.popup-item');
        const searchForm = document.getElementById('shopSearchForm');
        
        const productsGrid = document.getElementById('productsGrid');
        const skeletonLoader = document.getElementById('skeletonLoader');
        const categoryLinks = document.querySelectorAll('.category-sidebar-link');

        function showSkeleton() {
            if(productsGrid && skeletonLoader) {
                productsGrid.classList.add('d-none');
                skeletonLoader.classList.remove('d-none');
            }
        }

        if (input && hiddenSearch) {
            input.addEventListener('input', function() {
                hiddenSearch.value = this.value;
            });
        }

        if(input && popup) {
            input.addEventListener('click', function(e) {
                e.stopPropagation();
                popup.classList.toggle('d-none');
            });

            items.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const grad = this.getAttribute('data-value').trim();
                    
                    input.value = grad;
                    if(hiddenSearch) hiddenSearch.value = grad;
                    
                    popup.classList.add('d-none');
                    showSkeleton();
                    
                    setTimeout(() => {
                        if(searchForm) searchForm.submit();
                    }, 80);
                });
            });

            document.addEventListener('click', function(e) {
                const group = document.getElementById('shopLocationGroup');
                if (group && !group.contains(e.target)) {
                    popup.classList.add('d-none');
                }
            });
        }

        if(searchForm) {
            searchForm.addEventListener('submit', function(e) {
                showSkeleton();
            });
        }

        categoryLinks.forEach(link => {
            link.addEventListener('click', function() {
                showSkeleton();
            });
        });

        let favoriti = JSON.parse(localStorage.getItem('smestaj_favoriti')) || [];

        document.querySelectorAll('.fav-btn').forEach(btn => {
            let id = btn.getAttribute('data-id');
            let ikonica = btn.querySelector('i');
            
            let postoji = favoriti.some(x => x.id == id);
            if(postoji) {
                ikonica.classList.remove('bi-heart', 'text-secondary');
                ikonica.classList.add('bi-heart-fill', 'text-danger');
            }
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                this.style.transform = 'scale(1.15)';
                setTimeout(() => this.style.transform = 'scale(1)', 150);

                let currentId = this.getAttribute('data-id');
                let naslov = this.getAttribute('data-naslov');
                let lokacija = this.getAttribute('data-lokacija');
                let cena = this.getAttribute('data-cena');
                let slika = this.getAttribute('data-slika');
                
                favoriti = JSON.parse(localStorage.getItem('smestaj_favoriti')) || [];
                let indeks = favoriti.findIndex(x => x.id == currentId);
                
                if(indeks === -1) {
                    favoriti.push({ id: currentId, naslov, lokacija, cena, slika });
                    ikonica.classList.remove('bi-heart', 'text-secondary');
                    ikonica.classList.add('bi-heart-fill', 'text-danger');
                } else {
                    favoriti.splice(indeks, 1);
                    ikonica.classList.remove('bi-heart-fill', 'text-danger');
                    ikonica.classList.add('bi-heart', 'text-secondary');
                }
                
                localStorage.setItem('smestaj_favorites', JSON.stringify(favoriti));
                localStorage.setItem('smestaj_favoriti', JSON.stringify(favoriti));
                
                if(typeof osveziMeniFavorita === 'function') {
                    osveziMeniFavorita();
                }
            });
        });
    });
</script>

<style>
    .shop-location-popup { position: absolute; top: 110%; left: 0; width: 100%; background: white; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); padding: 10px 0; z-index: 999; border: 1px solid #e2e8f0; }
    .popup-title { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #717171; padding: 5px 15px; letter-spacing: 0.5px; }
    .popup-item { padding: 8px 15px; font-size: 13px; color: #222; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 8px; }
    .popup-item i { color: #717171; }
    .popup-item:hover { background: #fff5f5; color: #ff385c; }
    .popup-item:hover i { color: #ff385c; }

    .category-sidebar-link { transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease; }
    .category-sidebar-link:hover { background-color: #fff5f5 !important; color: #ff385c !important; transform: translateX(4px); }

    .skeleton-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; height: 100%; display: flex; flex-direction: column; }
    .skeleton-img { width: 100%; aspect-ratio: 16/9; background: #f1f5f9; }
    .skeleton-body { padding: 18px; display: flex; flex-direction: column; flex-grow: 1; }
    .skeleton-text { background: #f1f5f9; border-radius: 6px; }
    .skeleton-title { height: 20px; width: 65%; }
    .skeleton-star { height: 18px; width: 15%; }
    .skeleton-location { height: 16px; width: 40%; }
    .skeleton-desc { height: 34px; width: 100%; }
    .skeleton-price { height: 24px; width: 45%; }
    .skeleton-btn { height: 38px; width: 40%; background: #f1f5f9; border-radius: 10px; }
    
    .pulse { animation: skeleton-pulse 1.4s infinite ease-in-out; }
    @keyframes skeleton-pulse { 0% { opacity: 0.6; } 50% { opacity: 1; } 100% { opacity: 0.6; } }
    .fav-btn:hover { transform: scale(1.1) !important; }
</style>
@endsection