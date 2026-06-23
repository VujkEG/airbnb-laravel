<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Proveri da li tvoj projekat koristi Product ili Smestaj model
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    /**
     * Prikazuje početnu stranicu za Hosta (Dashboard).
     */
    public function index()
    {
        // Uzimamo samo smeštaje koji pripadaju trenutno ulogovanom domaćinu (ako imaš user_id kolonu)
        // Ako nemaš podelu po korisnicima još uvek, povuci sve: Product::all()
        $products = Product::with('category')->get();
        
        return view('admin.dashboard', compact('products'));
    }
}