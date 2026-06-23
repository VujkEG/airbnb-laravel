@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin-bottom:24px;">Pregled svih rezervacija</h1>

    <div style="background:white; border:1.5px solid #f1f5f9; border-radius:16px; padding:24px;">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table" style="font-size:14px;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="color:#64748b; font-weight:600;">Kod</th>
                        <th style="color:#64748b; font-weight:600;">Gost</th>
                        <th style="color:#64748b; font-weight:600;">Smeštaj</th>
                        <th style="color:#64748b; font-weight:600;">Ukupni iznos</th>
                        <th style="color:#64748b; font-weight:600;">Status</th>
                        <th style="color:#64748b; font-weight:600;">Datum</th>
                        <th style="color:#64748b; font-weight:600;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td style="font-weight:600;">{{ $order->user->name ?? 'Nepoznat' }}</td>
                        <td>{{ $order->product->name ?? 'Nepoznat smeštaj' }}</td>
                        <td style="font-weight:600; color:#e53e3e;">{{ number_format($order->total_price, 0, ',', '.') }} RSD</td>
                        <td>
                            @if($order->status == 'na čekanju')
                                <span style="background:#dbeafe; color:#1d4ed8; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Na čekanju</span>
                            @elseif($order->status == 'Potvrđeno')
                                <span style="background:#dcfce7; color:#166534; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Potvrđeno</span>
                            @else
                                <span style="background:#fee2e2; color:#991b1b; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;">Otkazano</span>
                            @endif
                        </td>
                        <td style="color:#64748b;">{{ $order->created_at->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.narudzbine.show', $order->id) }}" class="btn btn-sm" style="background:#f1f5f9; color:#1a1a2e; border-radius:6px; font-size:12px;">
                                <i class="bi bi-eye"></i> Detalji
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
        @else
        <div class="text-center py-5">
            <i class="bi bi-calendar-x" style="font-size:3rem; color:#cbd5e1;"></i>
            <p style="color:#94a3b8; margin-top:12px;">Trenutno nema zabeleženih rezervacija.</p>
        </div>
        @endif
    </div>
</div>
@endsection