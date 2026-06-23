<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy($id)
    {
        $booking = Booking::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $danas = Carbon::now();
        $datumPrijave = Carbon::parse($booking->start_date);

        if ($danas->diffInHours($datumPrijave, false) < 48) {
            return redirect()->back()->with('error', 'Otkazivanje nije moguće! Rezervaciju možete otkazati najkasnije 48 sati pre datuma prijave.');
        }

        $booking->delete();

        return redirect()->back()->with('status', 'Rezervacija je uspešno otkazana.');
    }

    public function myBookings()
    {
        $bookings = Booking::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.my_bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Datum dolaska ne može biti u prošlosti.',
            'end_date.after' => 'Datum odlaska mora biti nakon datuma dolaska.',
        ]);

        $productId = $request->input('product_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Double-booking provera (gledamo samo one koje su odobrene ili na čekanju)
        $isBooked = Booking::where('product_id', $productId)
            ->whereIn('status', ['confirmed', 'approved', 'Potvrđeno', 'na čekanju'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $startDate);
            })
            ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Nažalost, ovaj smeštaj je već rezervisan u izabranom periodu. Molimo vas izaberite druge datume.');
        }

        $product = Product::findOrFail($productId);
        
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end);
        $days = $days == 0 ? 1 : $days; 
        $totalPrice = $days * $product->price;

        Booking::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'na čekanju' // Nova rezervacija ide na čekanje admina
        ]);

        return redirect()->back()->with('status', 'Uspešno ste poslali zahtev za rezervaciju! Kada admin odobri, vaši datumi će biti zaključani.');
    }
}