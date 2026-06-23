<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'location',
        'description', 
        'price', 
        'category_id', 
        'image', 
        'gallery_images',
        'max_guests', 
        'bedrooms', 
        'bathrooms', 
        'amenities', 
        'created_by', 
        'updated_by'
    ];

    // Automatski pretvara amenities (Wi-Fi, Klima, Parking...) iz baze u niz i obrnuto
    protected $casts = [
        'amenities' => 'array',
    ];

    /**
     * NOVO / PAMETNO REŠENJE: Virtuelni Accessor za grad.
     * Ako u kodu pozoveš $product->city, sistem će automatski uzeti sve pre prvog zareza iz lokacije.
     * Na ovaj način tvoj front-end prikaz (Zlatibor, Beograd...) radi savršeno bez menjanja baze podataka!
     */
    public function getCityAttribute()
    {
        if (!empty($this->location) && str_contains($this->location, ',')) {
            return trim(explode(',', $this->location)[0]);
        }
        return $this->location ?? 'Srbija';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}