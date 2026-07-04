<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // POPRAVLJENO: Promenljiva preimenovana u $orders (koju prima index.blade.php kao kolekciju) ali unutar petlje koristi čist $booking
        $orders = Booking::with(['product', 'user'])->latest()->paginate(10);
        return view('admin.rezervacije.index', compact('orders'));
    }

    public function show($rezervacije)
    {
        // POPRAVLJENO: Promenljiva promenjena iz $narudzbine u $rezervacija u skladu sa novim show.blade.php
        $rezervacija = Booking::with(['product', 'user'])->findOrFail($rezervacije);
        return view('admin.rezervacije.show', compact('rezervacija'));
    }

    public function update(Request $request, $rezervacije)
    {
        $booking = Booking::findOrFail($rezervacije);

        $request->validate([
            'status' => 'required|in:na čekanju,Potvrđeno,Otkazano',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('status', 'Status rezervacije uspešno izmenjen u: ' . $request->status);
    }

    public function destroy($rezervacije)
    {
        $booking = Booking::findOrFail($rezervacije);
        $booking->delete();

        return redirect('admin/rezervacije')->with('status', 'Rezervacija uspešno obrisana!');
    }
}