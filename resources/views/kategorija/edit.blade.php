@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-uppercase" style="color:#1a1a2e; font-size: 15px;">
                    Izmeni Kategoriju / Lokaciju
                </div>

                <div class="card-body">
                    <form action="{{ route('kategorija.update', $kategorija->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upisi naziv kategorije</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ $kategorija->name ?? ($kategorija->Name ?? ($kategorija->naziv ?? $kategorija->title)) }}" required>
                        </div>

                        {{-- POPRAVLJENO: Tekstualna zona za unos opisa je kompletno izbačena odavde --}}

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success fw-bold">Sacuvaj</button>
                            <a href="{{ route('kategorija.index') }}" class="btn btn-secondary fw-bold">Nazad</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection