@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Dodaj novi smeštaj</h1>
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
        <form action="{{ route('admin.proizvodi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Naziv smeštaja / Apartmana</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="npr. Vila Avenija - Lux Apartman sa pogledom" required
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Grad</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="npr. Zlatibor"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Tačna adresa / Lokacija</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="npr. Miladina Pećinarca 12" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Detaljan opis smeštaja</label>
                <textarea name="desc" rows="4" placeholder="Unesite detalje o smeštaju (kvadratura, opremljenost, blizina centra...)" required
                          style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; resize:vertical;"
                          onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">{{ old('desc') }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Cena po noćenju (RSD)</label>
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="npr. 4500" step="0.01" required
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Maksimalno gostiju</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests', 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Broj spavaćih soba</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div class="col-md-4">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Broj kupatila</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', 1) }}" min="1" required
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                           onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <div class="mb-4">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:10px; display:block;">Sadržaj objekta (Amenities)</label>
                <div class="row g-2">
                    @php
                        $dostupniSadrzaji = ['Wi-Fi', 'Klima uređaj', 'Besplatan Parking', 'Bazen', 'Dozvoljeni ljubimci', 'Kuhinja', 'TV', 'Dvorište'];
                    @endphp
                    @foreach($dostupniSadrzaji as $sadrzaj)
                        <div class="col-6 col-md-4">
                            <label class="d-flex align-items-center p-2" style="border:1.5px solid #e2e8f0; border-radius:8px; cursor:pointer; font-size:13px; font-weight:500;">
                                <input type="checkbox" name="amenities[]" value="{{ $sadrzaj }}" class="me-2" style="accent-color:#e53e3e;"
                                    {{ is_array(old('amenities')) && in_array($sadrzaj, old('amenities')) ? 'checked' : '' }}>
                                {{ $sadrzaj }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Glavna fotografija smeštaja</label>
                <input type="file" name="image" accept="image/*"
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                <small style="color:#94a3b8; font-size:12px;">JPG, PNG, WEBP — max 2MB</small>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Sporedna fotografija 1</label>
                    <input type="file" name="gallery_image_1" accept="image/*"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                </div>
                <div class="col-md-6">
                    <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Sporedna fotografija 2</label>
                    <input type="file" name="gallery_image_2" accept="image/*"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;">
                </div>
                <div class="col-12">
                    <small style="color:#94a3b8; font-size:12px; display:block; margin-top:-6px;">Ove slike će se prikazati u desnom delu mreže na detaljnom pregledu apartmana.</small>
                </div>
            </div>

            <button type="submit" class="btn w-100" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600; padding:12px;">
                <i class="bi bi-check-lg me-2"></i>Sačuvaj smeštaj
            </button>
        </form>
    </div>
</div>
@endsection