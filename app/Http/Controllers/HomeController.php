<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $totalCategories = $categories->count();
        $totalProducts = Product::count();
        
        // Dodat proračun recenzija za featured kartice na home stranici
        $featuredProducts = Product::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'totalCategories', 'totalProducts', 'featuredProducts'));
    }

    public function shop(Request $request)
    {
        $categories = Category::withCount('products')->get();
        
        // Dodat proračun recenzija i ovde
        $query = Product::with('category')->withAvg('reviews', 'rating')->withCount('reviews');

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