@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="airbnb-container">
    
    <div class="hero-section" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1920');">
        <div class="hero-content">
            <h1>Pronađite savršeno mesto za boravak</h1>
            <p>Istražite neverovatne apartmane, vile i sobe širom sveta.</p>
            
            <div class="search-widget">
                <form action="{{ route('shop') }}" method="GET" class="search-form" autocomplete="off">
                    <div class="search-input-group position-relative" id="locationGroup" style="position: relative;">
                        <label>Lokacija</label>
                        <input type="text" id="locationInput" name="location" value="{{ trim(request('location')) }}" placeholder="Gde putuješ?" style="cursor: pointer;">
                        
                        <div class="location-popup d-none" id="locationPopup">
                            <div class="popup-title">Dostupne destinacije</div>
                            @if(isset($allLocations) && !$allLocations->isEmpty())
                                @foreach($allLocations as $loc)
                                    <div class="popup-item" data-value="{{ $loc }}"><i class="fas fa-map-marker-alt"></i> {{ $loc }}</div>
                                @endforeach
                            @else
                                <div class="popup-item text-muted" style="cursor: default;"><i class="fas fa-info-circle"></i> Beograd</div>
                                <div class="popup-item" data-value="Zlatibor"><i class="fas fa-map-marker-alt"></i> Zlatibor</div>
                                <div class="popup-item" data-value="Kopaonik"><i class="fas fa-map-marker-alt"></i> Kopaonik</div>
                            @endif
                        </div>
                    </div>
                    <div class="search-input-group">
                        <label>Prijava</label>
                        <input type="date" name="check_in" value="{{ request('check_in') }}">
                    </div>
                    <div class="search-input-group">
                        <label>Odjava</label>
                        <input type="date" name="check_out" value="{{ request('check_out') }}">
                    </div>
                    <div class="search-input-group">
                        <label>Gosti</label>
                        <input type="number" name="guests" value="{{ request('guests') }}" placeholder="Dodaj goste" min="1">
                    </div>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Pretraži
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- KATEGORIJE --}}
    <div class="section-container">
        <h2 class="section-title">Istražite po kategorijama</h2>
        <div class="categories-scroll-wrapper">
            @foreach($categories as $category)
                @php
                    $name = trim($category->name);
                    if (empty($name)) {
                        $name = match($category->id) {
                            1 => 'Apartmani',
                            2 => 'Hoteli',
                            3 => 'Vikendice',
                            4 => 'Brvnare',
                            5 => 'Sobe',
                            default => 'Kategorija ' . $category->id
                        };
                    }

                    $iconClass = match(Str::slug($name)) {
                        'apartmani', 'apartman' => 'fa-building',
                        'hoteli', 'hotel'       => 'fa-hotel',
                        'vikendice', 'vikendica' => 'fa-tree',
                        'brvnare', 'brvnara'     => 'fa-campground',
                        'sobe', 'soba'           => 'fa-bed',
                        default                  => 'fa-home'
                    };
                @endphp
                <a href="{{ route('shop', ['category' => $category->id]) }}" class="category-card-custom">
                    <div class="category-icon">
                        <i class="fas {{ $iconClass }}"></i>
                    </div>
                    <div class="category-info">
                        <h3>{{ $name }}</h3>
                        <p>{{ $category->products_count ?? 0 }} smeštaja</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- SMEŠTAJI (PROPERTIES) --}}
    <div class="section-container">
        <h2 class="section-title">Inspiracija za vaše sledeće putovanje</h2>
        <p class="section-subtitle">Najbolje ocenjeni smeštaji iz naše ponude</p>

        <div class="properties-grid">
            @foreach($featuredProducts as $product)
                <div class="property-card">
                    <div class="property-image-wrapper">
                        @php
                            $naslovSmeštaja = Str::lower($product->name);
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
                        @endphp

                        <img src="{{ $finalUrl }}" alt="{{ $product->name }}">
                        <span class="badge-category">{{ $product->category->name ?? 'Smeštaj' }}</span>
                    </div>
                    <div class="property-details">
                        <div class="property-header">
                            <h3 class="property-title">{{ $product->name }}</h3>
                            <span class="property-rating">
                                <i class="fas fa-star" style="color: #ffb400;"></i> 
                                @if($product->reviews_avg_rating)
                                    {{ number_format($product->reviews_avg_rating, 1) }} ({{ $product->reviews_count }})
                                @else
                                    <span class="text-muted" style="font-size: 12px; font-weight: normal;">Novo</span>
                                @endif
                            </span>
                        </div>
                        
                        <p class="property-location"><i class="fas fa-map-marker-alt"></i> {{ $product->city ?? $product->location ?? 'Srbija' }}</p>
                        <p class="property-description">{{ Str::limit($product->description ?? $product->desc, 60) }}</p>
                        
                        <div class="d-flex gap-3 my-2 text-muted" style="font-size: 12px; font-weight: 500;">
                            <div><i class="fa-solid fa-user-friends me-1"></i>{{ $product->max_guests ?? 2 }}g</div>
                            <div><i class="fa-solid fa-bed me-1"></i>{{ $product->bedrooms ?? 1 }}s</div>
                            <div><i class="fa-solid fa-bath me-1"></i>{{ $product->bathrooms ?? 1 }}k</div>
                        </div>

                        <hr class="card-divider">
                        <div class="property-footer">
                            <span class="property-price"><strong>{{ number_format($product->price, 0, ',', '.') }} RSD</strong> / noć</span>
                            <a href="{{ route('smestaj.show', $product->id) }}" class="view-btn">Pogledaj</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- POPRAVLJENO: Sigurni i ručno stilizovani navigacioni blok koji garantuje vidljivost strelica --}}
        <div class="custom-pagination-container">
            @if ($featuredProducts->hasPages())
                <nav class="custom-pagination-nav">
                    {{-- Prethodna stranica --}}
                    @if ($featuredProducts->onFirstPage())
                        <span class="pagination-arrow disabled"><i class="fas fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $featuredProducts->previousPageUrl() }}&home_page={{ $featuredProducts->currentPage() - 1 }}" class="pagination-arrow"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    {{-- Brojevi stranica --}}
                    @foreach ($featuredProducts->getUrlRange(1, $featuredProducts->lastPage()) as $page => $url)
                        @if ($page == $featuredProducts->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}&home_page={{ $page }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Sledeća stranica --}}
                    @if ($featuredProducts->hasMorePages())
                        <a href="{{ $featuredProducts->nextPageUrl() }}&home_page={{ $featuredProducts->currentPage() + 1 }}" class="pagination-arrow"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <span class="pagination-arrow disabled"><i class="fas fa-chevron-right"></i></span>
                    @endif
                </nav>
            @endif
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('locationInput');
        const popup = document.getElementById('locationPopup');
        const items = document.querySelectorAll('.popup-item');

        if(input && popup) {
            input.addEventListener('click', function(e) {
                e.stopPropagation();
                popup.classList.toggle('d-none');
            });

            items.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    input.value = this.getAttribute('data-value').trim();
                    popup.classList.add('d-none');
                });
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('locationGroup').contains(e.target)) {
                    popup.classList.add('d-none');
                }
            });
        }
    });
</script>

<style>
    .airbnb-container { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #222222; }
    .section-container { max-width: 1200px; margin: 60px auto; padding: 0 20px; }
    .section-title { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .section-subtitle { color: #717171; margin-bottom: 24px; }
    
    /* Hero Style */
    .hero-section { height: 500px; background-size: cover; background-position: center; border-radius: 16px; margin: 20px auto; max-width: 1200px; display: flex; align-items: center; justify-content: center; text-align: center; color: white; padding: 20px; }
    .hero-content h1 { font-size: 42px; font-weight: 800; margin-bottom: 10px; }
    .hero-content p { font-size: 18px; margin-bottom: 30px; opacity: 0.9; }
    
    /* Search Widget */
    .search-widget { background: white; padding: 10px 20px; border-radius: 100px; box-shadow: 0 16px 32px rgba(0,0,0,0.15); max-width: 850px; margin: 0 auto; }
    .search-form { display: flex; align-items: center; justify-content: space-between; }
    .search-input-group { display: flex; flex-direction: column; text-align: left; padding: 5px 15px; border-right: 1px solid #eee; flex: 1; }
    .search-input-group:last-of-type { border-right: none; }
    .search-input-group label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #222; margin-bottom: 2px; }
    .search-input-group input { border: none; background: transparent; outline: none; font-size: 14px; color: #222; width: 100%; }
    .search-btn { background: #FF385C; color: white; border: none; padding: 12px 24px; border-radius: 100px; font-weight: 600; cursor: pointer; transition: 0.2s; white-space: nowrap; }
    .search-btn:hover { background: #E61E4D; }

    /* Pop-up lokacije stil */
    .location-popup { position: absolute; top: 115%; left: 0; width: 260px; background: white; border-radius: 16px; box-shadow: 0 8px 28px rgba(0,0,0,0.15); padding: 15px 0; z-index: 999; border: 1px solid #eaeaea; max-height: 250px; overflow-y: auto; }
    .popup-title { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #717171; padding: 0 20px 10px 20px; letter-spacing: 0.5px; }
    .popup-item { padding: 10px 20px; font-size: 14px; color: #222; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 10px; }
    .popup-item i { color: #717171; font-size: 14px; }
    .popup-item:hover { background: #f7f7f7; color: #FF385C; }
    .popup-item:hover i { color: #FF385C; }
    .d-none { display: none !important; }

    /* Horizontalni scroll za kategorije */
    .categories-scroll-wrapper { display: flex; gap: 20px; overflow-x: auto; padding: 10px 5px 20px 5px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; }
    .categories-scroll-wrapper::-webkit-scrollbar { height: 6px; }
    .categories-scroll-wrapper::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .categories-scroll-wrapper::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
    .categories-scroll-wrapper::-webkit-scrollbar-thumb:hover { background: #FF385C; }
    
    .category-card-custom { display: flex; align-items: center; padding: 15px 25px; border: 1px solid #dddddd; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.2s ease-in-out; background: #fff; min-width: 260px; flex-shrink: 0; }
    .category-card-custom:hover { border-color: #FF385C; box-shadow: 0 10px 20px rgba(255,56,92,0.08); transform: translateY(-3px); }
    .category-icon { font-size: 26px; color: #FF385C; margin-right: 18px; width: 40px; text-align: center; }
    .category-info h3 { font-size: 16px; font-weight: 700; margin: 0 0 2px 0; color: #1a1a2e; }
    .category-info p { font-size: 13px; color: #717171; margin: 0; }

    /* Property Cards Style */
    .properties-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .property-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eef0f2; transition: 0.3s; }
    .property-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px rgba(0,0,0,0.1); }
    .property-image-wrapper { position: relative; height: 200px; overflow: hidden; }
    .property-image-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .badge-category { position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.9); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #222; }
    .property-details { padding: 16px; }
    .property-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
    .property-title { font-size: 17px; font-weight: 600; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .property-rating { font-size: 14px; font-weight: 600; }
    .property-location { font-size: 13px; color: #717171; margin-bottom: 4px; }
    .property-description { font-size: 13px; color: #555; margin-bottom: 6px; line-height: 1.4; }
    .card-divider { border: 0; border-top: 1px solid #eee; margin: 12px 0; }
    .property-footer { display: flex; justify-content: space-between; align-items: center; }
    .property-price { font-size: 15px; color: #222; }
    .view-btn { background: transparent; border: 1px solid #222; padding: 6px 16px; border-radius: 8px; text-decoration: none; color: #222; font-size: 13px; font-weight: 600; }

    /* POPRAVLJENO: Unikatni Airbnb stil za numeraciju stranica */
    .custom-pagination-container { display: flex; justify-content: center; margin-top: 50px; padding-bottom: 20px; }
    .custom-pagination-nav { display: flex; align-items: center; gap: 8px; background: #ffffff; padding: 8px 16px; border-radius: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #ebebeb; }
    .pagination-number { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; font-size: 14px; font-weight: 600; color: #222222; text-decoration: none; transition: 0.2s; }
    .pagination-number:hover { background: #f7f7f7; color: #FF385C; }
    .pagination-number.active { background: #222222; color: #ffffff !important; cursor: default; }
    .pagination-arrow { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; color: #222222; text-decoration: none; transition: 0.2s; font-size: 12px; }
    .pagination-arrow:hover:not(.disabled) { background: #f7f7f7; color: #FF385C; }
    .pagination-arrow.disabled { color: #d5d5d5; cursor: not-allowed; }
</style>
@endsection