<?php

namespace App\Http\Controllers;

use App\Models\Apartman;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $location = trim($request->input('location'));
        $guests = $request->input('guests');
        $selectedCategory = $request->input('category');
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        $categories = Category::has('apartmani')->withCount('apartmani as products_count')->get();
        $query = Apartman::query()->with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        $aktivnaLokacija = !empty($location) ? $location : (!empty($search) ? $search : null);

        if (!empty($aktivnaLokacija)) {
            $query->where('location', 'LIKE', '%' . $aktivnaLokacija . '%');
        }

        if (!empty($checkIn) && !empty($checkOut)) {
            $query->whereNotExists(function ($subquery) use ($checkIn, $checkOut) {
                $subquery->select(DB::raw(1))
                    ->from('bookings')
                    ->whereColumn('bookings.product_id', 'apartmani.id')
                    ->whereIn('bookings.status', ['confirmed', 'approved', 'Potvrđeno'])
                    ->where(function ($q) use ($checkIn, $checkOut) {
                        $q->where('bookings.start_date', '<', $checkOut)
                          ->where('bookings.end_date', '>', $checkIn);
                    });
            });
        }

        if ($guests) {
            $query->where('max_guests', '>=', $guests);
        }

        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        $products = $query->latest()->paginate(9);

        return view('shop', compact('products', 'categories', 'selectedCategory', 'search', 'location', 'guests'));
    }

    // POPRAVLJENO: Pametna pretraga koja prihvata i ID i tekstualni Slug, sprečavajući 404 grešku
    public function show($idOrSlug)
    {
        $query = Apartman::withAvg('reviews', 'rating')->withCount('reviews')->with('category');

        if (is_numeric($idOrSlug)) {
            $product = $query->where('id', $idOrSlug)->firstOrFail();
        } else {
            $product = $query->where('slug', $idOrSlug)->firstOrFail();
        }

        $amenities = [
            ['name' => 'Besplatan Wi-Fi', 'icon' => 'fa-wifi'],
            ['name' => 'Bazen', 'icon' => 'fa-swimming-pool'],
            ['name' => 'Klima uređaj', 'icon' => 'fa-snowflake'],
            ['name' => 'Besplatan parking', 'icon' => 'fa-car'],
            ['name' => 'Kuhinja', 'icon' => 'fa-utensils'],
            ['name' => 'TV', 'icon' => 'fa-tv'],
        ];

        $bookings = DB::table('bookings')
            ->where('product_id', $product->id)
            ->whereIn('status', ['approved', 'confirmed', 'Potvrđeno']) 
            ->get(['start_date', 'end_date']);

        $bookedDates = [];

        foreach ($bookings as $booking) {
            $current = strtotime($booking->start_date);
            $last = strtotime($booking->end_date);

            while ($current <= $last) {
                $bookedDates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
        }

        $bookedDates = array_values(array_unique($bookedDates));

        return view('smestaj.show', compact('product', 'amenities', 'bookedDates'));
    }
}