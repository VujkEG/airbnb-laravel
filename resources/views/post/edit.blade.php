@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Dodaj novu objavu</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form class="form-control" action="{{ route('post.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Upisi naziv objave</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $post->name) }}">
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Upisi opis kategorije</label>
                                <textarea name="desc" id="" cols="30" rows="10" class="form-control">{{ old('desc',$post->desc) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upisi slag</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="from-label">Selektuj kategoriju</label>
                                <select name="category_id" class="form-control" id="">
                                    @foreach ($categories as $kategorija)
                                        <option @if (old('category_id')==$kategorija->id) selected @endif value="{{ $kategorija->id }}">{{ $kategorija->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Dodaj sliku</label>
                                <input type="file" name="image" class="form-control">
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
