<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $orders = Booking::with(['product', 'user'])->latest()->paginate(10);
        return view('admin.narudzbine.index', compact('orders'));
    }

    public function show($rezervacije)
    {
        $narudzbine = Booking::with(['product', 'user'])->findOrFail($rezervacije);
        return view('admin.narudzbine.show', compact('narudzbine'));
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

        return redirect()->route('admin.narudzbine.index')->with('status', 'Rezervacija uspešno obrisana!');
    }
}