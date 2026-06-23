@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Izmeni kategoriju</h1>
        <a href="{{ route('admin.kategorije.index') }}" class="btn" style="background:#f1f5f9; color:#1a1a2e; border-radius:8px; font-weight:600;">
            <i class="bi bi-arrow-left me-2"></i>Nazad
        </a>
    </div>

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:32px; max-width:600px;">
        <form action="{{ route('admin.kategorije.update', ['regije' => $kategorije->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Naziv kategorije</label>
                <input type="text" name="name" value="{{ old('name', $kategorije->name) }}"
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none;"
                       onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div class="mb-4">
                <label style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:6px; display:block;">Opis</label>
                <textarea name="desc" rows="4"
                          style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; resize:vertical;"
                          onfocus="this.style.borderColor='#e53e3e'" onblur="this.style.borderColor='#e2e8f0'">{{ old('desc', $kategorije->description ?? $kategorije->desc) }}</textarea>
            </div>
            <button type="submit" class="btn w-100" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600; padding:12px;">
                <i class="bi bi-check-lg me-2"></i>Sačuvaj izmene
            </button>
        </form>
    </div>
</div>
@endsection