<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('kategorija.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategorija.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // POPRAVLJENO: Uklonjena validacija za 'desc' polje
        $request->validate([
            'name' => 'required|min:3',
        ]);

        // POPRAVLJENO: Polje 'desc' se više ne prosleđuje prilikom kreiranja
        $category = Category::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->route('kategorija.index')->with('status', 'Uspešno sačuvano');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $kategorija)
    {
        return view('kategorija.show', compact('kategorija'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $kategorija)
    {
        return view('kategorija.edit', compact('kategorija'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $kategorija)
    {
        // POPRAVLJENO: Uklonjena validacija za 'desc' polje i ovde
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $kategorija->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->route('kategorija.index')->with('status', 'Uspešno sačuvano');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $kategorija)
    {
        $kategorija->delete();
        return redirect()->route('kategorija.index')->with('status', 'Uspešno obrisano');
    }
}