<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'total_price',
        'status'
    ];

    // Relacija sa korisnikom koji je rezervisao
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacija sa smeštajem (proizvodom)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}