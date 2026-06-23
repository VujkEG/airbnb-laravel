@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Rezervacija #{{ $narudzbine->id }}</h1>
        <a href="{{ route('admin.narudzbine.index') }}" class="btn" style="background:#f1f5f9; color:#1a1a2e; border-radius:8px; font-weight:600;">
            <i class="bi bi-arrow-left me-2"></i>Nazad
        </a>
    </div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-5">
            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
                <h2 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:16px;">Podaci o gostu</h2>
                <p style="font-size:14px; margin-bottom:8px;"><strong>Ime gosta:</strong> {{ $narudzbine->user->name ?? 'Nepoznat korisnik' }}</p>
                <p style="font-size:14px; margin-bottom:8px;"><strong>Email:</strong> {{ $narudzbine->user->email ?? 'Nema email adrese' }}</p>
                <p style="font-size:14px; margin-bottom:0;"><strong>Kreirano:</strong> {{ $narudzbine->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px; margin-top:16px;">
                <h2 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:16px;">Promeni status</h2>
                
                <form action="{{ route('admin.narudzbine.update', $narudzbine->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status"
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; background:white; margin-bottom:12px;">
                        <option value="na čekanju" {{ $narudzbine->status == 'na čekanju' ? 'selected' : '' }}>Na čekanju</option>
                        <option value="Potvrđeno" {{ $narudzbine->status == 'Potvrđeno' ? 'selected' : '' }}>Potvrđeno</option>
                        <option value="Otkazano" {{ $narudzbine->status == 'Otkazano' ? 'selected' : '' }}>Otkazano</option>
                    </select>
                    <button type="submit" class="btn w-100" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600; padding:10px; margin-bottom:12px;">
                        <i class="bi bi-check-lg me-2"></i>Sačuvaj status
                    </button>
                </form>

                <hr style="border-color:#f1f5f9; margin:16px 0;">

                <form action="{{ route('admin.narudzbine.destroy', $narudzbine->id) }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite trajno obrisati ovu rezervaciju?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:8px; font-weight:600; padding:10px;">
                        <i class="bi bi-trash me-2"></i>Obriši rezervaciju
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
                <h2 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:16px;">Detalji rezervisanog smeštaja</h2>
                <div class="table-responsive">
                    <table class="table" style="font-size:14px;">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th style="color:#64748b; font-weight:600;">Smeštaj</th>
                                <th style="color:#64748b; font-weight:600;">Datum dolaska</th>
                                <th style="color:#64748b; font-weight:600;">Datum odlaska</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight:600;">{{ $narudzbine->product->name ?? 'Obrisan objekat' }}</td>
                                <td><span style="background:#f1f5f9; padding:4px 8px; border-radius:6px;">{{ \Carbon\Carbon::parse($narudzbine->start_date)->format('d.m.Y') }}</span></td>
                                <td><span style="background:#f1f5f9; padding:4px 8px; border-radius:6px;">{{ \Carbon\Carbon::parse($narudzbine->end_date)->format('d.m.Y') }}</span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align:right; font-weight:700; font-size:15px; padding-top:20px;">Ukupna cena:</td>
                                <td style="font-weight:700; color:#e53e3e; font-size:15px; padding-top:20px;">{{ number_format($narudzbine->total_price, 0, ',', '.') }} RSD</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection