@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<div class="container py-5" style="max-width: 1200px;">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold h2 mb-1">{{ $product->name }}</h1>
            <p class="text-muted mb-0 d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                {{ $product->city ?? 'Srbija' }}{{ $product->location ? ', ' . $product->location : '' }}
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark border p-2 fs-6 d-inline-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#ffc107" stroke="#ffc107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                {{ $product->reviews_count > 0 ? number_format($product->reviews_avg_rating, 1) : 'Nema ocena' }} ({{ $product->reviews_count }} recenzija)
            </span>
        </div>
    </div>

    {{-- POPRAVLJENO: Sigurna obrada galerije slika bez rizika od TypeError rušenja --}}
    @php
        $galerijaSlika = is_string($product->gallery_images) ? json_decode($product->gallery_images, true) : $product->gallery_images;
        $galerijaSlika = is_array($galerijaSlika) ? array_values($galerijaSlika) : [];
        $glavnaSlika = $product->image ? asset($product->image) : 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80';
    @endphp

    <div class="row g-2 mb-4">
        {{-- Velika glavna slika --}}
        <div class="col-md-8">
            <a href="{{ $glavnaSlika }}" data-fancybox="apartman-galerija" data-caption="Glavna fotografija smeštaja">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm bg-light image-hover-zoom" style="cursor: pointer;">
                    <img src="{{ $glavnaSlika }}" class="img-fluid object-fit-cover" alt="{{ $product->name }}">
                </div>
            </a>
        </div>
        {{-- Desna kolona sa sporednim slikama ako postoje u bazi --}}
        <div class="col-md-4 d-none d-md-flex flex-column justify-content-between">
            @php
                $sporedna1 = isset($galerijaSlika[0]) ? asset($galerijaSlika[0]) : 'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600';
                $sporedna2 = isset($galerijaSlika[1]) ? asset($galerijaSlika[1]) : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=600';
            @endphp
            <a href="{{ $sporedna1 }}" data-fancybox="apartman-galerija" data-caption="Unutrašnjost / Detalji smeštaja">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm bg-light mb-2 image-hover-zoom" style="cursor: pointer;">
                    <img src="{{ $sporedna1 }}" class="img-fluid object-fit-cover" alt="Sporedna slika 1">
                </div>
            </a>
            <a href="{{ $sporedna2 }}" data-fancybox="apartman-galerija" data-caption="Pogled / Sadržaj objekta">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm bg-light image-hover-zoom" style="cursor: pointer;">
                    <img src="{{ $sporedna2 }}" class="img-fluid object-fit-cover" alt="Sporedna slika 2">
                </div>
            </a>
        </div>
    </div>

    {{-- Sakriveni linkovi za Fancybox ako ima više od 2 sporedne slike da mogu sve da se listaju levo-desno --}}
    @if(count($galerijaSlika) > 2)
        <div class="d-none">
            @foreach($galerijaSlika as $index => $slika)
                @if($index >= 2)
                    <a href="{{ asset($slika) }}" data-fancybox="apartman-galerija" data-caption="Galerija fotografija - Slika {{ $index + 1 }}"></a>
                @endif
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="d-flex flex-wrap gap-4 mb-4 p-3 bg-light rounded-3 shadow-sm border text-secondary" style="font-size: 14px; font-weight: 500;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-users text-dark fs-5"></i>
                    <span>Maksimalno: <strong class="text-dark">{{ $product->max_guests ?? 1 }} gosta</strong></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bed text-dark fs-5"></i>
                    <span>Spavaće sobe: <strong class="text-dark">{{ $product->bedrooms ?? 1 }}</strong></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bath text-dark fs-5"></i>
                    <span>Kupatila: <strong class="text-dark">{{ $product->bathrooms ?? 1 }}</strong></span>
                </div>
            </div>

            <h3 class="fw-bold mb-3">O ovom smeštaju</h3>
            <p class="text-secondary lh-lg mb-4">
                {{ $product->description ?? 'Opis smeštaja trenutno nije dostupan.' }}
            </p>
            
            <hr class="my-4 text-muted">

            <h4 class="fw-bold mb-3">Šta ovaj smeštaj nudi</h4>
            <div class="row g-3 mb-5">
                @if($product->amenities)
                    @php
                        $allAmenities = [
                            'Wi-Fi' => ['icon' => 'fa-wifi', 'name' => 'Wi-Fi internet'],
                            'Klima uređaj' => ['icon' => 'fa-snowflake', 'name' => 'Klima uređaj'],
                            'Besplatan Parking' => ['icon' => 'fa-car', 'name' => 'Besplatan parking'],
                            'Bazen' => ['icon' => 'fa-swimming-pool', 'name' => 'Bazen'],
                            'Dozvoljeni ljubimci' => ['icon' => 'fa-paw', 'name' => 'Dozvoljeni ljubimci'],
                            'Kuhinja' => ['icon' => 'fa-utensils', 'name' => 'Kuhinja sa posuđem'],
                            'TV' => ['icon' => 'fa-tv', 'name' => 'Kablovska TV'],
                            'Dvorište' => ['icon' => 'fa-tree', 'name' => 'Uređeno dvorište']
                        ];
                        $decodedAmenities = is_string($product->amenities) ? json_decode($product->amenities, true) : $product->amenities;
                    @endphp

                    @if(is_array($decodedAmenities))
                        @foreach($decodedAmenities as $amenityName)
                            @if(isset($allAmenities[$amenityName]))
                                <div class="col-sm-6 d-flex align-items-center">
                                    <div class="bg-light text-center rounded-3 p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas {{ $allAmenities[$amenityName]['icon'] }} text-dark fs-5"></i>
                                    </div>
                                    <span class="text-dark fw-medium">{{ $allAmenities[$amenityName]['name'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted small">Nema unetih pogodnosti za ovaj objekat.</p>
                    @endif
                @else
                    <p class="text-muted small">Nema unetih pogodnosti za ovaj objekat.</p>
                @endif
            </div>

            <hr class="my-4 text-muted">
            <h3 class="fw-bold mb-4">Utisci gostiju</h3>

            @if($product->reviews && $product->reviews->count() > 0)
                <div class="row g-4 mb-5">
                    @foreach($product->reviews as $review)
                        <div class="col-md-6">
                            <div class="card h-100 p-3 border rounded-3 shadow-sm bg-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">{{ $review->user->name ?? 'Korisnik' }}</h6>
                                    <div class="text-warning small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted d-block mb-2">Boravio: {{ $review->created_at->format('d.m.Y.') }}</small>
                                <p class="text-secondary small mb-0">{{ $review->comment ?? 'Nema komentara.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted italic mb-5">Još uvek nema recenzija za ovaj smeštaj.</p>
            @endif

            @auth
                @php
                    $canLeaveReview = \DB::table('bookings')
                        ->where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->whereIn('status', ['approved', 'confirmed', 'Potvrđeno'])
                        ->where('end_date', '<', \Carbon\Carbon::now()->toDateString())
                        ->exists() && !\App\Models\Review::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                @endphp

                @if($canLeaveReview)
                    <div class="card p-4 border rounded-3 shadow-sm bg-light">
                        <h4 class="fw-bold mb-3">Napišite recenziju</h4>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Vaša ocena</label>
                                <select name="rating" class="form-select" required style="max-width: 150px;">
                                    <option value="5">5 - Odlično</option>
                                    <option value="4">4 - Vrlo dobro</option>
                                    <option value="3">3 - Dobro</option>
                                    <option value="2">2 - Loše</option>
                                    <option value="1">1 - Veoma loše</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Komentar i utisci</label>
                                <textarea name="comment" class="form-control" rows="3" placeholder="Podelite Vaše iskustvo sa drugim gostima..." maxlength="1000"></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark fw-bold px-4 py-2" style="border-radius: 8px;">
                                Objavi recenziju
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        <div class="col-lg-5 ps-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border rounded-3 p-4 sticky-top" style="top: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="fs-3 fw-bold text-danger">{{ number_format($product->price, 0, ',', '.') }} RSD</span>
                        <span class="text-muted"> / noć</span>
                    </div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dostupnost i izbor termina</label>
                        <div id="inline-calendar" class="d-flex justify-content-center"></div>
                        <div id="selected-dates-preview" class="alert alert-light border text-center small mt-2 d-none fw-semibold"></div>
                    </div>

                    <button type="submit" class="btn w-100 text-white fw-bold py-2 shadow-sm" style="background-color: #ff385c; border-radius: 8px;">
                        Rezerviši odmah
                    </button>
                </form>
                
                <p class="text-center text-muted small mt-2 mb-0">Nećemo vam odmah naplatiti</p>
            </div>
        </div>
    </div>
</div>

<link class="df" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<style>
    .image-hover-zoom img {
        transition: transform 0.3s ease;
    }
    .image-hover-zoom:hover img {
        transform: scale(1.03);
    }
    @media (min-width: 576px) {
        .border-end-sm { border-right: 1px solid #ededed !important; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind("[data-fancybox='apartman-galerija']", {
            Infinite: true,
            Thumbs: { autoStart: true }
        });

        const disableDates = @json($bookedDates ?? []);

        flatpickr("#inline-calendar", {
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: disableDates,
            mode: "range",
            locale: { firstDayOfWeek: 1 },
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const start = instance.formatDate(selectedDates[0], "Y-m-d");
                    const end = instance.formatDate(selectedDates[1], "Y-m-d");

                    let hasBlockedDate = false;
                    let currentDate = new Date(selectedDates[0]);
                    const endDate = new Date(selectedDates[1]);

                    while (currentDate <= endDate) {
                        const formattedCurrent = instance.formatDate(currentDate, "Y-m-d");
                        if (disableDates.includes(formattedCurrent)) {
                            hasBlockedDate = true;
                            break;
                        }
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    if (hasBlockedDate) {
                        alert('Izabrani period sadrži datume koji su već zauzeti. Molimo izaberite drugi opseg.');
                        instance.clear();
                        return;
                    }

                    document.getElementById('start_date').value = start;
                    document.getElementById('end_date').value = end;

                    const preview = document.getElementById('selected-dates-preview');
                    preview.textContent = `Izabrano: ${instance.formatDate(selectedDates[0], "d.m.Y.")} do ${instance.formatDate(selectedDates[1], "d.m.Y.")}`;
                    preview.classList.remove('d-none');
                } else {
                    document.getElementById('start_date').value = '';
                    document.getElementById('end_date').value = '';
                    document.getElementById('selected-dates-preview').classList.add('d-none');
                }
            }
        });

        document.getElementById('booking-form').addEventListener('submit', function(e) {
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;

            if (!start || !end) {
                e.preventDefault();
                alert('Molimo vas da izaberete datum dolaska i odlaska na kalendaru pre nego što kliknete na dugme Rezerviši.');
            }
        });
    });
</script>
@endsection