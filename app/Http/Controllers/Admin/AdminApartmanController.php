<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartman;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminApartmanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // POPRAVLJENO: Promenljiva preimenovana u $smestaji radi uklanjanja e-commerce terminologije
        $smestaji = Apartman::with('category')->latest()->paginate(10);
        return view('admin.apartmani.index', compact('smestaji'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.apartmani.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'city'            => 'nullable|string|max:255',
            'location'        => 'required|string|max:255',
            'desc'            => 'required|string',
            'price'           => 'required|numeric|min:0',
            'category_id'     => 'required|exists:categories,id',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images'  => 'nullable|array',
            'gallery_images.*'=> 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'max_guests'      => 'required|integer|min:1',
            'bedrooms'        => 'required|integer|min:1',
            'bathrooms'       => 'required|integer|min:1',
            'amenities'       => 'nullable|array',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'storage/' . $request->file('image')->store('products', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = 'storage/' . $file->store('products', 'public');
            }
        }

        $galleryJson = !empty($galleryPaths) ? json_encode($galleryPaths, JSON_UNESCAPED_UNICODE) : null;
        $amenitiesJson = $request->has('amenities') ? json_encode($request->amenities, JSON_UNESCAPED_UNICODE) : null;

        $spojenaLokacija = $request->location;
        if ($request->filled('city')) {
            $spojenaLokacija = $request->city . ', ' . $request->location;
        }

        Apartman::create([
            'name'            => $request->name,
            'location'        => $spojenaLokacija,
            'description'     => $request->desc,
            'price'           => $request->price,
            'category_id'     => $request->category_id,
            'image'           => $imagePath,
            'gallery_images'  => $galleryJson,
            'max_guests'      => $request->max_guests,
            'bedrooms'        => $request->bedrooms,
            'bathrooms'       => $request->bathrooms,
            'amenities'       => $amenitiesJson,
            'created_by'      => auth()->id(),
            'updated_by'      => auth()->id(),
        ]);

        return redirect('admin/smestaji')->with('status', 'Smeštaj uspešno dodat!');
    }

    public function edit($smestaji)
    {
        // POPRAVLJENO: Promenljiva preimenovana u $smestaj umesto e-commerce naziva $proizvodi
        $smestaj = Apartman::findOrFail($smestaji);
        $categories = Category::all();
        return view('admin.apartmani.edit', compact('smestaj', 'categories'));
    }

    public function update(Request $request, $smestaji)
    {
        $smestaj = Apartman::findOrFail($smestaji);

        $request->validate([
            'name'            => 'required|string|max:255',
            'city'            => 'nullable|string|max:255',
            'location'        => 'required|string|max:255',
            'desc'            => 'required|string',
            'price'           => 'required|numeric|min:0',
            'category_id'     => 'required|exists:categories,id',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images'  => 'nullable|array',
            'gallery_images.*'=> 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'max_guests'      => 'required|integer|min:1',
            'bedrooms'        => 'required|integer|min:1',
            'bathrooms'       => 'required|integer|min:1',
            'amenities'       => 'nullable|array',
        ]);

        $imagePath = $smestaj->image;
        if ($request->hasFile('image')) {
            if ($smestaj->image && file_exists(public_path($smestaj->image))) {
                @unlink(public_path($smestaj->image));
            }
            $imagePath = 'storage/' . $request->file('image')->store('products', 'public');
        }

        $currentGallery = is_string($smestaj->gallery_images) ? json_decode($smestaj->gallery_images, true) : $smestaj->gallery_images;
        $currentGallery = $currentGallery ?? [];

        if ($request->hasFile('gallery_images')) {
            foreach ($currentGallery as $oldImg) {
                if (file_exists(public_path($oldImg))) {
                    @unlink(public_path($oldImg));
                }
            }
            $currentGallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $currentGallery[] = 'storage/' . $file->store('products', 'public');
            }
        }

        $galleryJson = !empty($currentGallery) ? json_encode($currentGallery, JSON_UNESCAPED_UNICODE) : null;
        $amenitiesJson = $request->has('amenities') ? json_encode($request->amenities, JSON_UNESCAPED_UNICODE) : null;

        $spojenaLokacija = $request->location;
        if ($request->filled('city')) {
            $spojenaLokacija = $request->city . ', ' . $request->location;
        }

        $smestaj->update([
            'name'            => $request->name,
            'location'        => $spojenaLokacija,
            'description'     => $request->desc,
            'price'           => $request->price,
            'category_id'     => $request->category_id,
            'image'           => $imagePath,
            'gallery_images'  => $galleryJson,
            'max_guests'      => $request->max_guests,
            'bedrooms'        => $request->bedrooms,
            'bathrooms'       => $request->bathrooms,
            'amenities'       => $amenitiesJson,
            'updated_by'      => auth()->id(),
        ]);

        return redirect('admin/smestaji')->with('status', 'Smeštaj uspešno izmenjen!');
    }

    public function destroy($smestaji)
    {
        $smestaj = Apartman::findOrFail($smestaji);

        if ($smestaj->image && file_exists(public_path($smestaj->image))) {
            @unlink(public_path($smestaj->image));
        }

        $images = is_string($smestaj->gallery_images) ? json_decode($smestaj->gallery_images, true) : $smestaj->gallery_images;
        $images = $images ?? [];
        foreach ($images as $img) {
            if (file_exists(public_path($img))) {
                @unlink(public_path($img));
            }
        }
        
        $smestaj->delete();

        return redirect('admin/smestaji')->with('status', 'Smeštaj uspešno obrisan!');
    }
}