@extends('layouts.app')

@section('content')
<div class="container py-5" style="font-family: 'Nunito', sans-serif;">
    
    {{-- Naslov i gornji bar --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #222222; letter-spacing: -0.5px;">Moje Rezervacije</h2>
            <p class="text-muted mb-0" style="font-size: 15px;">Upravljajte vašim predstojećim putovanjima i istorijom boravka.</p>
        </div>
        <a href="{{ route('shop', ['all' => 1]) }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 py-2 fw-bold" style="font-size: 13px; transition: 0.2s;">
            <i class="bi bi-search me-2"></i>Istraži još smeštaja
        </a>
    </div>

    {{-- Prikaz poruka --}}
    @if(session('success') || session('status'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #e6f4ea; color: #137333;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') ?? session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #fff5f5; color: #c1351d;">
            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="text-center py-5 my-5">
            <div class="mb-4">
                <i class="bi bi-suitcase-lg" style="font-size: 80px; color: #b0b0b0;"></i>
            </div>
            <h4 class="fw-bold" style="color: #222222;">Još uvek nema rezervisanih smeštaja</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 420px; font-size: 15px; line-height: 1.6;">
                Vreme je da obrišete prašinu sa kofera! Počnite sa pretragom i isplanirajte svoje sledeće savršeno putovanje na našoj platformi.
            </p>
            <a href="{{ route('shop', ['all' => 1]) }}" class="btn text-white btn-lg rounded-pill px-5 py-2 fw-bold shadow-sm" style="background-color: #FF385C; border: none; font-size: 15px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#E61E4D'" onmouseout="this.style.backgroundColor='#FF385C'">
                Pronađi smeštaj
            </a>
        </div>
    @else
        {{-- Lista rezervacija --}}
        <div class="row g-4">
            @foreach($bookings as $booking)
                <div class="col-12">
                    @php
                        $smeštaj = $booking->product;
                        $linkObjekta = $smeštaj ? route('smestaj.show', $smeštaj->id) : '#';
                    @endphp
                    
                    <div class="card h-100 border rounded-4 overflow-hidden shadow-sm clickable-booking-card" 
                         onclick="if(!event.target.closest('.no-card-click')){ window.location='{{ $linkObjekta }}'; }"
                         style="border-color: #ededed !important; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;">
                        <div class="row g-0">
                            
                            {{-- Sekcija sa slikom --}}
                            <div class="col-md-3 position-relative bg-light" style="min-height: 220px;">
                                @php
                                    $imeSmeštaja = $smeštaj ? Str::lower($smeštaj->name) : '';
                                    
                                    if ($smeštaj && $smeštaj->image && Str::startsWith($smeštaj->image, ['http://', 'https://'])) {
                                        $slikaUrl = $smeštaj->image;
                                    } elseif ($smeštaj && $smeštaj->image) {
                                        $slikaUrl = asset($smeštaj->image);
                                    } else {
                                        if (Str::contains($imeSmeštaja, ['brvnara', 'brvnari', 'drvena'])) {
                                            $slikaUrl = 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?q=80&w=600';
                                        } elseif (Str::contains($imeSmeštaja, ['ski', 'kopaonik', 'zlatibor', 'sneg'])) {
                                            $slikaUrl = 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=600';
                                        } elseif (Str::contains($imeSmeštaja, ['more', 'plaža', 'okean'])) {
                                            $slikaUrl = 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?q=80&w=600';
                                        } else {
                                            $slikaUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=600';
                                        }
                                    }
                                    
                                    $status = trim(Str::lower($booking->status ?? 'na čekanju'));
                                    $isPastBooking = $booking->end_date && \Carbon\Carbon::parse($booking->end_date)->isPast();
                                @endphp

                                <img src="{{ $slikaUrl }}" alt="Smeštaj" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0;">
                                
                                <div class="position-absolute top-0 start-0 m-3 z-index-2">
                                    @if(in_array($status, ['approved', 'confirmed', 'potvrđeno', 'potvrdjeno', 'plaćeno']))
                                        @if($isPastBooking)
                                            <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm" style="background-color: #6c757d; font-size: 12px;">⚫ Završen boravak</span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm" style="background-color: #00875a; font-size: 12px;">🟢 Potvrđeno</span>
                                        @endif
                                    @elseif(in_array($status, ['pending', 'na cekanju', 'na čekanju']))
                                        <span class="badge rounded-pill px-3 py-2 fw-bold text-dark shadow-sm" style="background-color: #febb02; font-size: 12px;">🟡 Na čekanju</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 fw-bold text-white shadow-sm" style="background-color: #c1351d; font-size: 12px;">🔴 Otkazano</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Informacije --}}
                            <div class="col-md-9 d-flex flex-column justify-content-between p-4">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                        <div style="flex: 1; min-width: 200px;">
                                            <h4 class="fw-bold mb-1 target-title" style="font-size: 20px; letter-spacing: -0.3px; color: #222222; transition: color 0.2s;">
                                                {{ $smeštaj ? $smeštaj->name : 'Naziv objekta nedostupan' }}
                                            </h4>
                                            <p class="text-muted small mb-0 fw-semibold" style="font-size: 13px;">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ $smeštaj && ($smeštaj->city || $smeštaj->location) ? ($smeštaj->city ?? $smeštaj->location) : 'Srbija' }}
                                            </p>
                                        </div>
                                        
                                        <div class="text-md-end">
                                            <span class="text-muted d-block small fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Ukupna cena</span>
                                            <span class="fs-4 text-dark font-monospace" style="font-weight: 800; color: #222222;">
                                                {{ number_format(($booking->total_price ?? 0), 0, ',', '.') }} RSD
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-3" style="color: #ededed; opacity: 1;">

                                    {{-- Datumi i informacije --}}
                                    <div class="row text-center text-sm-start g-3 info-row">
                                        <div class="col-sm-4 border-section">
                                            <span class="text-muted d-block small text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Prijava</span>
                                            <strong style="color: #222; font-size: 14px;"><i class="bi bi-calendar2-check-fill text-muted me-2"></i>{{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('d. m. Y.') : '/' }}</strong>
                                        </div>
                                        <div class="col-sm-4 border-section">
                                            <span class="text-muted d-block small text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Odjava</span>
                                            <strong style="color: #222; font-size: 14px;"><i class="bi bi-calendar2-x-fill text-muted me-2"></i>{{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d. m. Y.') : '/' }}</strong>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="text-muted d-block small text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Gosti</span>
                                            <strong style="color: #222; font-size: 14px;"><i class="bi bi-people-fill text-muted me-2"></i>Dodatne informacije na profilu</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Dugmad --}}
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-4 pt-2 flex-wrap" style="border-top: 1px dashed #f0f0f0;">
                                    <button class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold no-card-click" style="font-size: 13px;" onclick="window.print()">
                                        <i class="bi bi-printer me-2"></i>Odštampaj potvrdu
                                    </button>

                                    @if(!in_array($status, ['cancelled', 'otkazano', 'rejected']) && !$isPastBooking)
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite da otkažete ovu rezervaciju?');" class="m-0 no-card-click">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold" style="background-color: #FF385C; border: none; font-size: 13px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#E61E4D'" onmouseout="this.style.backgroundColor='#FF385C'">
                                                <i class="bi bi-x-circle me-2"></i>Otkaži rezervaciju
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .clickable-booking-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
        border-color: #cbd5e1 !important;
    }
    .clickable-booking-card:hover .target-title {
        color: #FF385C !important;
    }
    @media (min-width: 576px) {
        .border-section { 
            border-right: 1px solid #ededed !important; 
        }
    }
    @media (max-width: 575.98px) {
        .border-section { 
            border-bottom: 1px solid #ededed !important; 
            padding-bottom: 10px;
        }
    }
    .z-index-2 {
        z-index: 2;
    }
</style>
@endsection