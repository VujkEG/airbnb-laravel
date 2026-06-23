@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Dodaj novu kategoriju</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form class="" action="{{ route('kategorija.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="name" class="form-label">Upisi naziv kategorije</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Upisi opis kategorije</label>
                                <textarea name="desc" id="" cols="30" rows="10" class="form-control">{{ old('desc') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Sacuvaj</button>
                            </div>
                        </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
