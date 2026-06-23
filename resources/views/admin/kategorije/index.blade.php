@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e;">Kategorije</h1>
        <a href="{{ route('admin.kategorije.create') }}" class="btn" style="background:#e53e3e; color:white; border-radius:8px; font-weight:600;">
            <i class="bi bi-plus-lg me-2"></i>Dodaj kategoriju
        </a>
    </div>

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table" style="font-size:14px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="color:#64748b; font-weight:600;">#</th>
                        <th style="color:#64748b; font-weight:600;">Naziv</th>
                        <th style="color:#64748b; font-weight:600;">Opis</th>
                        <th style="color:#64748b; font-weight:600;">Proizvoda</th>
                        <th style="color:#64748b; font-weight:600;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td style="font-weight:600; color:#1a1a2e;">{{ $category->name }}</td>
                        <td style="color:#64748b;">{{ Str::limit($category->desc, 50) }}</td>
                        <td>
                            <span style="background:#f1f5f9; color:#1a1a2e; font-size:12px; padding:3px 10px; border-radius:20px; font-weight:600;">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.kategorije.edit', $category) }}" class="btn btn-sm me-1" style="background:#f1f5f9; color:#1a1a2e; border-radius:6px; font-size:12px;">
                                <i class="bi bi-pencil"></i> Izmeni
                            </a>
                            <form action="{{ route('admin.kategorije.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Da li ste sigurni?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:#fff5f5; color:#e53e3e; border-radius:6px; font-size:12px;">
                                    <i class="bi bi-trash"></i> Obriši
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-grid" style="font-size:3rem; color:#cbd5e1;"></i>
            <p style="color:#94a3b8; margin-top:12px;">Nema kategorija još uvek.</p>
        </div>
        @endif
    </div>
</div>
@endsection