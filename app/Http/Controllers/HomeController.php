<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Apartman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. STAVKA: Izvlačimo SVE jedinstvene gradove/lokacije iz baze za dropdown pretrage
        // Čistimo putanju (uzimamo samo tekst pre zareza ako postoji struktura "Grad, Država")
        $allLocations = Apartman::pluck('location')
            ->map(function($loc) {
                if (str_contains($loc, ',')) {
                    return trim(explode(',', $loc)[0]);
                }
                return trim($loc);
            })
            ->unique()
            ->filter()
            ->values();

        // 2. STAVKA: Striktno fiksiramo na maksimalno 4 najpopularnije kategorije na home page-u
        $categories = Category::withCount('apartmani as products_count')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        $totalCategories = Category::count();
        $totalProducts = Apartman::count();
        
        // 3. STAVKA: Aktivne kartice na home page dobijaju paginaciju (8 po stranici) - daje strelice, ništa ne nestaje
        $featuredProducts = Apartman::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->paginate(8, ['*'], 'home_page');

        return view('home', compact('categories', 'totalCategories', 'totalProducts', 'featuredProducts', 'allLocations'));
    }

    public function shop(Request $request)
    {
        $categories = Category::withCount('apartmani as products_count')->get();
        $query = Apartman::with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $selectedCategory = $request->category;
        $search = $request->search;

        return view('shop', compact('products', 'categories', 'selectedCategory', 'search'));
    }

    public function about()
    {
        return view('about');
    }
}