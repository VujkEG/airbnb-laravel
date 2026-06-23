<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.proizvodi.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.proizvodi.create', compact('categories'));
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
            'gallery_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
        if ($request->hasFile('gallery_image_1')) {
            $galleryPaths[0] = 'storage/' . $request->file('gallery_image_1')->store('products', 'public');
        }
        if ($request->hasFile('gallery_image_2')) {
            $galleryPaths[1] = 'storage/' . $request->file('gallery_image_2')->store('products', 'public');
        }

        ksort($galleryPaths);
        $galleryJson = !empty($galleryPaths) ? json_encode(array_values($galleryPaths), JSON_UNESCAPED_UNICODE) : null;
        $amenitiesJson = $request->has('amenities') ? json_encode($request->amenities, JSON_UNESCAPED_UNICODE) : null;

        // Spajamo grad i adresu u lokaciju ako je grad unesen, da ne puca baza zbog 'city' kolone
        $spojenaLokacija = $request->location;
        if ($request->filled('city')) {
            $spojenaLokacija = $request->city . ', ' . $request->location;
        }

        Product::create([
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

        return redirect()->route('admin.proizvodi.index')->with('status', 'Smeštaj uspešno dodat!');
    }

    public function edit($smestaji)
    {
        $proizvodi = Product::findOrFail($smestaji);
        $categories = Category::all();
        return view('admin.proizvodi.edit', compact('proizvodi', 'categories'));
    }

    public function update(Request $request, $smestaji)
    {
        $proizvodi = Product::findOrFail($smestaji);

        $request->validate([
            'name'            => 'required|string|max:255',
            'city'            => 'nullable|string|max:255',
            'location'        => 'required|string|max:255',
            'desc'            => 'required|string',
            'price'           => 'required|numeric|min:0',
            'category_id'     => 'required|exists:categories,id',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'max_guests'      => 'required|integer|min:1',
            'bedrooms'        => 'required|integer|min:1',
            'bathrooms'       => 'required|integer|min:1',
            'amenities'       => 'nullable|array',
        ]);

        $imagePath = $proizvodi->image;
        if ($request->hasFile('image')) {
            if ($proizvodi->image && file_exists(public_path($proizvodi->image))) {
                @unlink(public_path($proizvodi->image));
            }
            $imagePath = 'storage/' . $request->file('image')->store('products', 'public');
        }

        $currentGallery = is_string($proizvodi->gallery_images) ? json_decode($proizvodi->gallery_images, true) : $proizvodi->gallery_images;
        $currentGallery = $currentGallery ?? [];

        if ($request->hasFile('gallery_image_1')) {
            if (isset($currentGallery[0]) && file_exists(public_path($currentGallery[0]))) {
                @unlink(public_path($currentGallery[0]));
            }
            $currentGallery[0] = 'storage/' . $request->file('gallery_image_1')->store('products', 'public');
        }

        if ($request->hasFile('gallery_image_2')) {
            if (isset($currentGallery[1]) && file_exists(public_path($currentGallery[1]))) {
                @unlink(public_path($currentGallery[1]));
            }
            $currentGallery[1] = 'storage/' . $request->file('gallery_image_2')->store('products', 'public');
        }

        ksort($currentGallery);
        $galleryJson = !empty($currentGallery) ? json_encode(array_values($currentGallery), JSON_UNESCAPED_UNICODE) : null;
        $amenitiesJson = $request->has('amenities') ? json_encode($request->amenities, JSON_UNESCAPED_UNICODE) : null;

        $spojenaLokacija = $request->location;
        if ($request->filled('city')) {
            $spojenaLokacija = $request->city . ', ' . $request->location;
        }

        $proizvodi->update([
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

        return redirect()->route('admin.proizvodi.index')->with('status', 'Smeštaj uspešno izmenjen!');
    }

    public function destroy($smestaji)
    {
        $proizvodi = Product::findOrFail($smestaji);

        if ($proizvodi->image && file_exists(public_path($proizvodi->image))) {
            @unlink(public_path($proizvodi->image));
        }

        $images = is_string($proizvodi->gallery_images) ? json_decode($proizvodi->gallery_images, true) : $proizvodi->gallery_images;
        $images = $images ?? [];
        foreach ($images as $img) {
            if (file_exists(public_path($img))) {
                @unlink(public_path($img));
            }
        }
        
        $proizvodi->delete();

        return redirect()->route('admin.proizvodi.index')->with('status', 'Smeštaj uspešno obrisan!');
    }
}