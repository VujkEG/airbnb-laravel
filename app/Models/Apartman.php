<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Apartman extends Model
{
    use HasFactory;

    protected $table = 'apartmani';

    protected $fillable = [
        'name',
        'slug',
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

    // POPRAVLJENO: Automatski konvertuje JSON stringove iz baze u prave PHP nizove
    protected $casts = [
        'amenities' => 'array',
        'gallery_images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($apartman) {
            if (empty($apartman->slug)) {
                $apartman->slug = Str::slug($apartman->name);
            }
        });

        static::updating(function ($apartman) {
            $apartman->slug = Str::slug($apartman->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
}