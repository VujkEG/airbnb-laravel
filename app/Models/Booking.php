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

    // POPRAVLJENO: Koristi se tekstualna putanja do modela Apartman i tačan strani ključ iz baze
    public function product()
    {
        return $this->belongsTo('App\Models\Apartman', 'product_id');
    }
}