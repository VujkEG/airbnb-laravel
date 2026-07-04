@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Dodaj novu regiju</h1>
        {{-- POPRAVLJENO: Dugme nazad sada vodi na tačnu rutu 'kategorija.index' --}}
        <a href="{{ route('kategorija.index') }}" class="btn" style="background:#f1f5f9; color:#1a1a2e; border-radius:8px; font-weight:600;">
            <i class="bi bi-arrow-left me-2"></i>Nazad
        </a>
    </div>

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:32px; max-width:600px;">
        <form action="{{ route('kategorija.store') }}" method="POST">
            @csrf
            {{-- POPRAVLJENO: Ostavljeno samo polje za naziv regije, opis je kompletno uklonjen --}}
            <div class="mb-4">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Naziv regije / lokacije</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'"
                       placeholder="npr. Zlatibor">
            </div>
            <button type="submit" class="btn w-100" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600; padding:12px;">
                <i class="bi bi-check-lg me-2"></i>Sačuvaj regiju
            </button>
        </form>
    </div>
</div>
@endsection