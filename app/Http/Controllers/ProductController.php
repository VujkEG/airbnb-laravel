<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Hvata uobičajene parametre
        $search = trim($request->input('search'));
        $location = trim($request->input('location'));
        $guests = $request->input('guests');
        $selectedCategory = $request->input('category');

        // Ako je lokacija prazna ali imamo search vrednost (ili obrnuto), sinhronizujemo ih radi fleksibilnosti
        if (empty($location) && !empty($search)) {
            $location = $search;
        }

        // POVLAČIMO SAMO KATEGORIJE KOJE IMAJU BAR JEDAN SMEŠTAJ
        $categories = Category::has('products')->withCount('products')->get();
        
        // Pokrećemo osnovni upit za smeštaje
        $query = Product::query()->with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        // Pametno kombinovanje Search i Location filtera da ne izbacuje 0 rezultata
        if (!empty($search) || !empty($location)) {
            $query->where(function($q) use ($search, $location) {
                // Ako imamo search reč (npr. "Beograd" ili "Apartman")
                if (!empty($search)) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('city', 'LIKE', '%' . $search . '%')
                      ->orWhere('location', 'LIKE', '%' . $search . '%');
                }
                
                // Ako imamo eksplicitan location parametar sa početne strane
                if (!empty($location)) {
                    $q->orWhere('city', 'LIKE', '%' . $location . '%')
                      ->orWhere('location', 'LIKE', '%' . $location . '%');
                }
            });
        }

        // 3. Filter: Broj gostiju
        if ($guests) {
            $query->where('guests_limit', '>=', $guests);
        }

        // 4. Filter: Izabrana kategorija
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        // Izvršavamo upit sa paginacijom
        $products = $query->latest()->paginate(9);

        return view('shop', compact('products', 'categories', 'selectedCategory', 'search', 'location', 'guests'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        $product->loadAvg('reviews', 'rating')->loadCount('reviews');

        $amenities = [
            ['name' => 'Besplatan Wi-Fi', 'icon' => 'fa-wifi'],
            ['name' => 'Bazen', 'icon' => 'fa-swimming-pool'],
            ['name' => 'Klima uređaj', 'icon' => 'fa-snowflake'],
            ['name' => 'Besplatan parking', 'icon' => 'fa-car'],
            ['name' => 'Kuhinja', 'icon' => 'fa-utensils'],
            ['name' => 'TV', 'icon' => 'fa-tv'],
        ];

        // POVEZIVANJE SA BAZOM: Izvlačimo sve prihvaćene rezervacije za ovaj smeštaj
        // Prilagodi naziv modela (npr. 'Booking') i statuse ('approved', 'confirmed') tvojoj bazi ako se razlikuju
        $bookings = DB::table('bookings')
            ->where('product_id', $product->id)
            ->whereIn('status', ['approved', 'confirmed', 'Potvrđeno']) 
            ->get(['start_date', 'end_date']);

        $bookedDates = [];

        // Generisanje svih pojedinačnih dana unutar rezervisanih opsega
        foreach ($bookings as $booking) {
            $current = strtotime($booking->start_date);
            $last = strtotime($booking->end_date);

            while ($current <= $last) {
                $bookedDates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
        }

        // Uklanjamo duplikate ako postoje
        $bookedDates = array_values(array_unique($bookedDates));

        return view('smestaj.show', compact('product', 'amenities', 'bookedDates'));
    }
}