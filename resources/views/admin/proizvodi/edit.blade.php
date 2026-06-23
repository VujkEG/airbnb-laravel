@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Izmeni smeštaj</h1>
        <a href="{{ route('admin.proizvodi.index') }}" class="btn" style="background:#f1f5f9; color:#1a1a2e; border-radius:8px; font-weight:600;">
            <i class="bi bi-arrow-left me-2"></i>Nazad
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 mb-4" style="background:#fff5f5; color:#e53e3e; border-radius:12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:32px; max-width:700px;">
        <form action="{{ route('admin.proizvodi.update', $proizvodi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Naziv smeštaja / Apartmana</label>
                <input type="text" name="name" value="{{ old('name', $proizvodi->name) }}" required
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Grad</label>
                    <input type="text" name="city" value="{{ old('city', $proizvodi->city) }}" placeholder="npr. Zlatibor" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Tačna adresa / Lokacija</label>
                    <input type="text" name="location" value="{{ old('location', $proizvodi->location) }}" placeholder="npr. Miladina Pećinarca 12" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Detaljan opis smeštaja</label>
                <textarea name="desc" rows="4" required
                          style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; resize:vertical;"
                          onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">{{ old('desc', $proizvodi->description ?? $proizvodi->desc) }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Cena po noćenju (RSD)</label>
                    <input type="number" name="price" value="{{ old('price', $proizvodi->price) }}" step="0.01" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Regija / Lokacija</label>
                    <select name="category_id" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; background:white;"
                            onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="">-- Izaberi regiju --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $proizvodi->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Maksimalno gostiju</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests', $proizvodi->max_guests ?? 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Broj spavaćih soba</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $proizvodi->bedrooms ?? 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Broj kupatila</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $proizvodi->bathrooms ?? 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <div class="mb-4">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:10px; display:block;">Sadržaj objekta (Amenities)</label>
                <div class="row g-2">
                    @php
                        $dostupniSadrzaji = ['Wi-Fi', 'Klima uređaj', 'Besplatan Parking', 'Bazen', 'Dozvoljeni ljubimci', 'Kuhinja', 'TV', 'Dvorište'];
                        $trenutniSadrzaji = is_string($proizvodi->amenities) ? json_decode($proizvodi->amenities, true) : $proizvodi->amenities;
                        $trenutniSadrzaji = $trenutniSadrzaji ?? [];
                    @endphp
                    @foreach($dostupniSadrzaji as $sadrzaj)
                        <div class="col-6 col-md-4">
                            <label class="d-flex align-items-center p-2" style="border:1.5px solid #e2e8f0; border-radius:8px; cursor:pointer; font-size:13px; font-weight:500;">
                                <input type="checkbox" name="amenities[]" value="{{ $sadrzaj }}" class="me-2" style="accent-color:#e53e3e;"
                                    {{ in_array($sadrzaj, $trenutniSadrzaji) ? 'checked' : '' }}>
                                {{ $sadrzaj }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- GLAVNA SLIKA --}}
            <div class="mb-4">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Glavna fotografija smeštaja</label>
                @if($proizvodi->image)
                    <div class="mb-2">
                        <img src="{{ asset($proizvodi->image) }}" alt="Glavna slika" style="height:80px; border-radius:8px; object-fit:cover; border:1px solid #e2e8f0;">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                <small style="color:#94a3b8; font-size:12px;">Ostavite prazno ako ne želite da menjate glavnu sliku</small>
            </div>

            {{-- SPOREDNE SLIKE (GALERIJA) --}}
            @php
                $galerijaSlika = is_string($proizvodi->gallery_images) ? json_decode($proizvodi->gallery_images, true) : $proizvodi->gallery_images;
                $galerijaSlika = $galerijaSlika ?? [];
            @endphp
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Sporedna fotografija 1</label>
                    @if(isset($galerijaSlika[0]))
                        <div class="mb-2">
                            <img src="{{ asset($galerijaSlika[0]) }}" style="height:60px; border-radius:6px; object-fit:cover; border:1px solid #e2e8f0;">
                        </div>
                    @endif
                    <input type="file" name="gallery_image_1" accept="image/*"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                </div>
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Sporedna fotografija 2</label>
                    @if(isset($galerijaSlika[1]))
                        <div class="mb-2">
                            <img src="{{ asset($galerijaSlika[1]) }}" style="height:60px; border-radius:6px; object-fit:cover; border:1px solid #e2e8f0;">
                        </div>
                    @endif
                    <input type="file" name="gallery_image_2" accept="image/*"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                </div>
            </div>

            <button type="submit" class="btn w-100" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600; padding:12px;">
                <i class="bi bi-arrow-repeat me-2"></i>Ažuriraj smeštaj
            </button>
        </form>
    </div>
</div>
@endsection