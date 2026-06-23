<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.kategorije.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategorije.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.kategorije.index')->with('status', 'Kategorija uspešno dodana!');
    }

    // POPRAVLJENO: Hvata parametar $regije iz ruter resursa
    public function edit($regije)
    {
        $kategorije = Category::findOrFail($regije);
        return view('admin.kategorije.edit', compact('kategorije'));
    }

    // POPRAVLJENO: Hvata parametar $regije iz ruter resursa
    public function update(Request $request, $regije)
    {
        $kategorije = Category::findOrFail($regije);

        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $kategorije->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.kategorije.index')->with('status', 'Kategorija uspešno izmenjena!');
    }

    // POPRAVLJENO: Hvata parametar $regije iz ruter resursa
    public function destroy($regije)
    {
        $kategorije = Category::findOrFail($regije);
        $kategorije->delete();
        
        return redirect()->route('admin.kategorije.index')->with('status', 'Kategorija obrisana!');
    }
}