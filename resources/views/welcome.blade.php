<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Avenija Smeštaj') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */ @layer properties{@supports (((-webkit-hyphens:none)) and (not (margin-trim:inline))) or ((-moz-orient:inline) and (not (color:rgb(from red r g b)))){*,:before,:after,::backdrop{--tw-translate-x:0;--tw-translate-y:0;--tw-translate-z:0;--tw-rotate-x:initial;--tw-rotate-y:initial;--tw-rotate-z:initial;--tw-skew-x:initial;--tw-skew-y:initial;--tw-space-x-reverse:0;--tw-border-style:solid;--tw-leading:initial;--tw-font-weight:initial;--tw-tracking:initial;--tw-shadow:0 0 #0000;--tw-shadow-color:initial;--tw-shadow-alpha:100%;--tw-inset-shadow:0 0 #0000;--tw-inset-shadow-color:initial;--tw-inset-shadow-alpha:100%;--tw-ring-color:initial;--tw-ring-shadow:0 0 #0000;--tw-inset-ring-color:initial;--tw-inset-ring-shadow:0 0 #0000;--tw-ring-inset:initial;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-offset-shadow:0 0 #0000;--tw-blur:initial;--tw-brightness:initial;--tw-contrast:initial;--tw-grayscale:initial;--tw-hue-rotate:initial;--tw-invert:initial;--tw-opacity:initial;--tw-saturate:initial;--tw-sepia:initial;--tw-drop-shadow:initial;--tw-drop-shadow-color:initial;--tw-drop-shadow-alpha:100%;--tw-drop-shadow-size:initial;--tw-duration:initial;--tw-ease:initial;--tw-content:""}}}@layer theme{:root,:host{--font-sans:"Instrument Sans", ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";--font-serif:ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;--font-mono:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;--color-red-50:oklch(97.1% .013 17.38);--color-red-100:oklch(93.6% .032 17.717);--color-red-200:oklch(88.5% .062 18.334);--color-red-300:oklch(80.8% .114 19.571);--color-red-400:oklch(70.4% .191 22.216);--color-red-500:oklch(63.7% .237 25.331);--color-red-600:oklch(57.7% .245 27.325);--color-red-700:oklch(50.5% .213 27.518);--color-red-800:oklch(44.4% .177 26.899);--color-red-900:oklch(39.6% .141 25.723);--color-red-950:oklch(25.8% .092 26.042);--spacing:.25rem;--radius-md:.375rem;--radius-lg:.5rem;--radius-xl:.75rem;--radius-2xl:1rem;--radius-3xl:1.5rem;}}
                body { font-family: var(--font-sans); background-color: #fdfdfc; color: #1b1b18; -webkit-font-smoothing: antialiased; }
                .main-container { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
                .section-title { font-size: 1.75rem; font-weight: 700; color: #1b1b18; margin-bottom: 0.5rem; }
                .section-subtitle { color: #706f6c; font-size: 1rem; margin-bottom: 2rem; }
                .products-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.5rem; }
                @media(min-width: 640px) { .products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
                @media(min-width: 1024px) { .products-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
                .product-card { background: white; border: 1px solid #e3e3e0; border-radius: 1.25rem; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: all 0.2s ease-in-out; display: flex; flex-direction: column; }
                .product-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
                .image-container { width: 100%; aspect-ratio: 4/3; overflow: hidden; position: relative; background-color: #f3f4f6; }
                .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
                .product-card:hover .product-image { transform: scale(1.03); }
                .location-badge { position: absolute; top: 1rem; left: 1rem; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(4px); color: #1b1b18; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
                .card-content { padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
                .card-header-info { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; }
                .product-title { font-size: 1.125rem; font-weight: 700; color: #1b1b18; line-height: 1.3; }
                .rating-badge { display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; font-weight: 600; color: #1b1b18; }
                .rating-star { color: #f8b803; }
                .geo-location { font-size: 0.875rem; color: #706f6c; display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem; }
                .product-snippet { font-size: 0.875rem; color: #706f6c; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.25rem; line-height: 1.5; }
                .card-footer { display: flex; justify-content: space-between; align-items: center; pt: 0.5rem; border-top: 1px solid #f3f4f6; }
                .price-container { font-size: 0.875rem; color: #706f6c; }
                .price-amount { font-size: 1.125rem; font-weight: 700; color: #1b1b18; }
                .view-button { background: white; border: 1px solid #1b1b18; color: #1b1b18; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; transition: all 0.15s ease; cursor: pointer; }
                .view-button:hover { background: #1b1b18; color: white; }
            </style>
        @endif
    </head>
    <body class="antialiased">
        
        {{-- Uključujemo tvoj postojeći navigacioni meni / navbar sa vrha sajta --}}
        @include('layouts.navigation') 

        <div class="main-container">
            <div class="mb-6">
                <h2 class="section-title">Inspiracija za vaše sledeće putovanje</h2>
                <p class="section-subtitle">Najbolje ocenjeni smeštaji iz naše ponude</p>
            </div>

            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="image-container">
                            {{-- DINAMIČKA SLIKA KARTICE: Ako smeštaj ima sliku, prikazuje nju, u suprotnom vuče fallback sliku --}}
                            <img src="{{ $product->image ? asset($product->image) : 'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600' }}" 
                                 class="product-image" 
                                 alt="{{ $product->name }}"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600';">
                            
                            <div class="location-badge">
                                {{ $product->category->name ?? 'Zlatibor' }}
                            </div>
                        </div>

                        <div class="card-content">
                            <div>
                                <div class="card-header-info">
                                    <h3 class="product-title">{{ $product->name }}</h3>
                                    <div class="rating-badge">
                                        <i class="bi bi-star-fill rating-star"></i>
                                        <span>{{ $product->reviews_count > 0 ? number_format($product->reviews_avg_rating, 1) : 'Novo' }}</span>
                                    </div>
                                </div>

                                <div class="geo-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>Srbija</span>
                                </div>

                                <p class="product-snippet">
                                    {{ Str::limit($product->description, 85, '...') }}
                                </p>
                            </div>

                            <div class="card-footer">
                                <div class="price-container">
                                    <span class="price-amount">{{ number_format($product->price, 0, ',', '.') }} RSD</span> / noć
                                </div>
                                <a href="{{ route('smestaj.show', $product->id) }}" class="view-button">
                                    Pogledaj
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </body>
</html>