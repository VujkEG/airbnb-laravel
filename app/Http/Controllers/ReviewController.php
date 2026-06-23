<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $now = Carbon::now()->toDateString();

        // KLJUČNA PROVERA: Da li postoji odobrena rezervacija kojoj je prošao end_date
        $hasValidStay = DB::table('bookings')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->whereIn('status', ['approved', 'confirmed', 'Potvrđeno'])
            ->where('end_date', '<', $now)
            ->exists();

        if (!$hasValidStay) {
            return redirect()->back()->with('error', 'Recenziju možete ostaviti tek nakon što se završi Vaš boravak u ovom smeštaju.');
        }

        // Provera da li je korisnik već ostavio recenziju za ovaj smeštaj (da ne duplira)
        $alreadyReviewed = Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Već ste ostavili recenziju za ovaj smeštaj.');
        }

        // Čuvanje recenzije
        Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Hvala Vam! Vaša recenzija je uspešno sačuvana.');
    }
}