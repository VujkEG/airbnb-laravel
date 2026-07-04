@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Smeštajni kapaciteti</h1>
        <a href="{{ url('admin/smestaji/create') }}" class="btn" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600;">
            <i class="bi bi-plus-lg me-2"></i>Dodaj smeštaj
        </a>
    </div>

    @if(session('status'))
        <div class="alert alert-success border-0 mb-4" style="background:#f0fdf4; color:#15803d; border-radius:12px; font-weight:500;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
        </div>
    @endif

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
        {{-- POPRAVLJENO: Promenljiva prilagođena smeštajima --}}
        @if($smestaji->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle" style="font-size:14px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="color:#64748b; font-weight:600; width:50px;">#</th>
                        <th style="color:#64748b; font-weight:600; width:70px;">Slika</th>
                        <th style="color:#64748b; font-weight:600;">Naziv smeštaja</th>
                        <th style="color:#64748b; font-weight:600;">Regija / Lokacija</th>
                        <th style="color:#64748b; font-weight:600;">Kapacitet</th>
                        <th style="color:#64748b; font-weight:600;">Cena po noćenju</th>
                        <th style="color:#64748b; font-weight:600; width:180px;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- POPRAVLJENO: Izbačeni šoping nazivi, petlja koristi $smestaji i $smestaj --}}
                    @foreach($smestaji as $smestaj)
                    <tr>
                        <td>{{ $smestaj->id }}</td>
                        <td>
                            @if($smestaj->image)
                                <img src="{{ asset($smestaj->image) }}" alt="{{ $smestaj->name }}"
                                     style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
                            @else
                                <div style="width:48px; height:48px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-house" style="color:#94a3b8;"></i>
                                </div>
                            @endif
                        </td>
                        <td style="font-weight:600; color:#1a1a2e;">{{ $smestaj->name }}</td>
                        <td>
                            <span style="background:#f1f5f9; color:#1a1a2e; font-size:12px; padding:4px 12px; border-radius:20px; font-weight:500;">
                                {{ $smestaj->category->name ?? 'Nema regije' }}
                            </span>
                        </td>
                        <td style="color:#475569;">
                            <span class="me-2" title="Gostiju"><i class="bi bi-people me-1"></i>{{ $smestaj->max_guests }}</span>
                            <span class="me-2" title="Sobe"><i class="bi bi-door-open me-1"></i>{{ $smestaj->bedrooms }}</span>
                            <span title="Kupatila"><i class="bi bi-droplet me-1"></i>{{ $smestaj->bathrooms }}</span>
                        </td>
                        <td style="font-weight:700; color:#e53e3e;">{{ number_format($smestaj->price, 0, ',', '.') }} RSD</td>
                        <td>
                            <a href="{{ url('admin/smestaji/' . $smestaj->id . '/edit') }}" class="btn btn-sm me-1" style="background:#f1f5f9; color:#1a1a2e; border-radius:6px; font-size:12px; font-weight:500;">
                                <i class="bi bi-pencil"></i> Izmeni
                            </a>
                            <form action="{{ url('admin/smestaji/' . $smestaj->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj smeštaj?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:#fff5f5; color:#e53e3e; border-radius:6px; font-size:12px; font-weight:500;">
                                    <i class="bi bi-trash"></i> Obriši
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $smestaji->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-house-door" style="font-size:3rem; color:#cbd5e1;"></i>
            <p style="color:#94a3b8; margin-top:12px; font-weight:500;">Nema registrovanih smeštaja još uvek.</p>
        </div>
        @endif
    </div>
</div>
@endsection