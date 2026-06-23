@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="width: 18rem;">
                <img src="{{ asset($post->image) }}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{ $post->name }}</h5>
                  <p class="card-text">{{ $post->desc }}</p>
                  <a href="{{ route('post.edit',$post->slug) }}" class="btn btn-primary">Izmeni</a>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
