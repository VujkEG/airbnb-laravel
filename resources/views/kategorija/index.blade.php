@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Kategorije 
                    <a href="{{ route('kategorija.create') }}" class="btn btn-success float-end" >Dodaj novu kategoriju</a>
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
                                  @foreach ($categories as $category)
                                  <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td><a href="{{ route('kategorija.show',$category->id) }}">{{ $category->Name }}</a></td>
                                    <td>{{ $category->desc }}</td>
                                    <td>{{ $category->author->name }}</td>
                                    <td>{{ $category->editor->name }}</td>
                                    <td><a href="{{ route('kategorija.edit',$category->id) }}" class="btn btn-warning">IZMENI</a></td>
                                    <td>
                                        <form action="{{ route('kategorija.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                    
                                            <button type="submit" class="btn btn-danger">
                                                DELETE
                                            </button>
                                        </form>
                                    </td>
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
