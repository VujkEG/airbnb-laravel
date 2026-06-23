@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Objave iz kat: {{ $kategorija->Name }}
                    <a href="{{ route('post.create') }}" class="btn btn-success float-end" >Dodaj novu objavu</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                            
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ime</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Kreirao</th>
                                    <th>IZMENIO</th>
                                    <th>EDIT</th>
                                    <th>OBRIŠI</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($kategorija->posts as $post)
                                  <tr>
                                    <th scope="row">{{ $post->id }}</th>
                                    <td>{{ $post->name }}</td>
                                    <td>{{ $post->desc }}</td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>{{ $post->editor->name }}</td>
                                    <td><a href="{{ route('post.edit',$post->slug) }}" class="btn btn-warning">IZMENI</a></td>
                                    <td>
                                        <form action="{{ route('post.destroy', $post->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                    
                                            <button type="submit" class="btn btn-danger">
                                                DELETE
                                            </button>
                                        </form>
                                    </td>
                                    <td></td>
                                  </tr>
                                    @endforeach
                                </tbody>
                              </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
