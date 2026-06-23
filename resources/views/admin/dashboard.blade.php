@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Domaćin Panel</h1>
        <span style="background:#f1f5f9; color:#64748b; font-size:13px; padding:6px 14px; border-radius:20px;">
            <i class="bi bi-person-badge-fill me-1"></i>Domaćin: {{ Auth::user()->name }}
        </span>
    </div>

    {{-- STATISTIKE (PUPRAVLJENO: AIRBNB ANALITIKA IZ KONTROLERA) --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:20px; text-align:center; height:100%;">
                <i class="bi bi-house-door" style="font-size:1.8rem; color:#e53e3e;"></i>
                <div style="font-size:1.6rem; font-weight:700; color:#1a1a2e; margin-top:8px;">{{ $propertiesCount }}</div>
                <div style="font-size:13px; color:#94a3b8;">Aktivnih smeštaja</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:20px; text-align:center; height:100%;">
                <i class="bi bi-cash-stack" style="font-size:1.8rem; color:#e53e3e;"></i>
                <div style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin-top:10px;">{{ number_format($totalRevenue, 0, ',', '.') }} RSD</div>
                <div style="font-size:13px; color:#94a3b8;">Ukupan prihod</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:20px; text-align:center; height:100%;">
                <i class="bi bi-percent" style="font-size:1.8rem; color:#e53e3e;"></i>
                <div style="font-size:1.6rem; font-weight:700; color:#1a1a2e; margin-top:8px;">{{ $occupancyRate }}%</div>
                <div style="font-size:13px; color:#94a3b8;">Popunjenost ovog meseca</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div style="background:#fff5f5; border:1.5px solid #fed7d7; border-radius:16px; padding:20px; text-align:center; height:100%;">
                <i class="bi bi-people-fill" style="font-size:1.8rem; color:#e53e3e;"></i>
                <div style="font-size:1.6rem; font-weight:700; color:#e53e3e; margin-top:8px;">{{ $upcomingGuestsCount }}</div>
                <div style="font-size:13px; color:#94a3b8;">Dolazaka ove nedelje</div>
            </div>
        </div>
    </div>

    {{-- BRZI LINKOVI (DODAT KALENDAR KAO 4. OPCIJA) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.proizvodi.create') }}" class="text-decoration-none">
                <div style="background:#1a1a2e; border-radius:16px; padding:20px; color:white; display:flex; align-items:center; gap:14px; transition:opacity 0.2s; height:100%;"
                     onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-house-add-fill" style="font-size:1.5rem; color:#e53e3e;"></i>
                    <div>
                        <div style="font-weight:700; font-size:14px;">Dodaj smeštaj</div>
                        <div style="font-size:12px; color:#94a3b8;">Novi apartman</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.kategorije.create') }}" class="text-decoration-none">
                <div style="background:#1a1a2e; border-radius:16px; padding:20px; color:white; display:flex; align-items:center; gap:14px; transition:opacity 0.2s; height:100%;"
                     onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-map-fill" style="font-size:1.5rem; color:#e53e3e;"></i>
                    <div>
                        <div style="font-weight:700; font-size:14px;">Dodaj regiju</div>
                        <div style="font-size:12px; color:#94a3b8;">Nova destinacija</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.narudzbine.index') }}" class="text-decoration-none">
                <div style="background:#1a1a2e; border-radius:16px; padding:20px; color:white; display:flex; align-items:center; gap:14px; transition:opacity 0.2s; height:100%;"
                     onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-calendar3" style="font-size:1.5rem; color:#e53e3e;"></i>
                    <div>
                        <div style="font-weight:700; font-size:14px;">Rezervacije</div>
                        <div style="font-size:12px; color:#94a3b8;">Upravljaj dolascima</div>
                    </div>
                </div>
            </a>
        </div>
        {{-- NOVO: KARTICA ZA INTERAKTIVNI KALENDAR --}}
        <div class="col-md-3">
            <a href="{{ route('admin.calendar') }}" class="text-decoration-none">
                <div style="background:#e53e3e; border-radius:16px; padding:20px; color:white; display:flex; align-items:center; gap:14px; transition:opacity 0.2s; height:100%; box-shadow: 0 4px 12px rgba(229, 62, 62, 0.2);"
                     onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-calendar-week-fill" style="font-size:1.5rem; color:white;"></i>
                    <div>
                        <div style="font-weight:700; font-size:14px; color:white;">Kalendar zauzetosti</div>
                        <div style="font-size:12px; color:#fee2e2;">Pogledaj slobodne dane</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- POSLEDNJE REZERVACIJE --}}
    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
        <h2 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:16px;">
            <i class="bi bi-clock-history me-2" style="color:#e53e3e;"></i>Poslednji zahtevi za rezervaciju
        </h2>
        @if($recentBookings->count() > 0)
        <div class="table-responsive">
            <table class="table" style="font-size:14px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="color:#64748b; font-weight:600;">ID</th>
                        <th style="color:#64748b; font-weight:600;">Smeštaj</th>
                        <th style="color:#64748b; font-weight:600;">Gost</th>
                        <th style="color:#64748b; font-weight:600;">Period boravka</th>
                        <th style="color:#64748b; font-weight:600;">Ukupan Prihod</th>
                        <th style="color:#64748b; font-weight:600;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr>
                        <td>#{{ $booking->id }}</td>
                        <td style="font-weight:600; color:#1a1a2e;">{{ $booking->product->name ?? 'Obrisan objekat' }}</td>
                        <td>
                            <div>{{ $booking->user->name ?? 'Registrovani Gost' }}</div>
                            <small class="text-muted" style="font-size:11px;">{{ $booking->user->email ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d.m.Y') }}
                            </span>
                        </td>
                        <td style="font-weight:600; color:#166534;">{{ number_format($booking->total_price, 0, ',', '.') }} RSD</td>
                        <td>
                            @php
                                $statusRezervacije = trim(strtolower($booking->status ?? 'na čekanju'));
                            @endphp
                            @if(in_array($statusRezervacije, ['pending', 'na cekanju', 'na čekanju']))
                                <span style="background:#fef3c7; color:#d97706; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Na čekanju</span>
                            @elseif(in_array($statusRezervacije, ['approved', 'confirmed', 'potvrđeno', 'potvrdjeno']))
                                <span style="background:#dcfce7; color:#166534; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Potvrđeno</span>
                            @else
                                <span style="background:#ffeeeb; color:#e53e3e; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Otkazano</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-calendar-x" style="font-size:2.5rem; color:#cbd5e1;"></i>
            <p style="color:#94a3b8; margin-top:10px; font-size:14px;">Trenutno nema novih rezervacija na čekanju.</p>
        </div>
        @endif
    </div>
</div>
@endsection