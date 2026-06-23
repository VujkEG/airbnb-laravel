<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::latest()->get();
        return view('kategorija.index',compact('categories'));
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
    public function store(StoreCategoryRequest $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'desc'=>'required'
        ]);
        $category=Category::create([
            'name'=>$request->name,
            'desc'=>$request->desc,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);
        return redirect()->route('kategorija.index')->with('status','Uspesno sacuvano');
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
    public function update(UpdateCategoryRequest $request, Category $kategorija)
    {
        $request->validate([
            'name'=>'required|min:3',
            'desc'=>'required'
        ]);
        $kategorija->update([
            'name'=>$request->name,
            'desc'=>$request->desc,
            'updated_by'=>Auth::user()->id
        ]);
        return redirect()->route('kategorija.index')->with('status','Uspesno sacuvano');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $kategorija)
    {
        $kategorija->delete();
    return redirect()->route('kategorija.index')->with('status','Uspesno obrisano');
    }
}
