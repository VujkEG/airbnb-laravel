@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                {{-- POPRAVLJENO: Uklonjeno dugme za dodavanje nove kategorije iz zaglavlja --}}
                <div class="card-header fw-bold text-uppercase" style="color:#1a1a2e; font-size: 15px; letter-spacing: 0.5px;">
                    Kategorije i Lokacije 
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
                                {{-- POPRAVLJENO: Kolona "Opis" je kompletno izbačena --}}
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
                                <td>
                                    {{-- POPRAVLJENO: Rešen problem sa blanko imenom. Proverava sve varijacije polja iz baze ($category->Name, $category->name, $category->naziv) --}}
                                    <a href="{{ route('kategorija.show', $category->id) }}" class="fw-bold text-decoration-none" style="color: #1a1a2e;">
                                        {{ $category->name ?? ($category->Name ?? ($category->naziv ?? ($category->title ?? 'Grad #' . $category->id))) }}
                                    </a>
                                </td>
                                {{-- POPRAVLJENO: Prikaz opisa je izbačen iz tela tabele --}}
                                <td>{{ $category->author->name ?? 'Admin Domaćin' }}</td>
                                <td>{{ $category->editor->name ?? 'Admin Domaćin' }}</td>
                                <td><a href="{{ route('kategorija.edit', $category->id) }}" class="btn btn-warning btn-sm fw-bold">IZMENI</a></td>
                                <td>
                                    <form action="{{ route('kategorija.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Da li ste sigurni?')">
                                        @csrf
                                        @method('DELETE')
                                    
                                        <button type="submit" class="btn btn-danger btn-sm fw-bold">
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