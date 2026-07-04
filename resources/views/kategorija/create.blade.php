@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-uppercase" style="color:#1a1a2e; font-size: 15px;">
                    Dodaj novu kategoriju
                </div>

                <div class="card-body">
                    <form action="{{ route('kategorija.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upisi naziv kategorije</label>
                            <input type="text" name="name" class="form-control" placeholder="Npr. Beograd, Zlatibor..." required>
                        </div>

                        {{-- POPRAVLJENO: Tekstualna zona za unos opisa je kompletno izbačena i odavde --}}

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