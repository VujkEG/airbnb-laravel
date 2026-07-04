@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-uppercase" style="color:#1a1a2e; font-size: 15px;">
                    Detalji Lokacije / Kategorije
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold text-muted small text-uppercase d-block">ID:</label>
                        <span class="fs-5 text-dark">#{{ $kategorija->id }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small text-uppercase d-block">Ime:</label>
                        <span class="fs-5 fw-bold" style="color: #1a1a2e;">
                            {{ $kategorija->name ?? ($kategorija->Name ?? ($kategorija->naziv ?? ($kategorija->title ?? 'Grad #' . $kategorija->id))) }}
                        </span>
                    </div>

                    {{-- POPRAVLJENO: Kompletan blok za "Opis" je uklonjen jer je prazan (blank) --}}

                    <div class="mb-3">
                        <label class="fw-bold text-muted small text-uppercase d-block">Kreirao:</label>
                        <span class="text-secondary">{{ $kategorija->author->name ?? 'Admin Domaćin' }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted small text-uppercase d-block">Izmenio:</label>
                        <span class="text-secondary">{{ $kategorija->editor->name ?? 'Admin Domaćin' }}</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('kategorija.index') }}" class="btn btn-secondary fw-bold">
                            <i class="bi bi-arrow-left"></i> Nazad na listu
                        </a>
                        <a href="{{ route('kategorija.edit', $kategorija->id) }}" class="btn btn-warning fw-bold">
                            IZMENI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection