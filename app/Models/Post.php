<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable=['name','desc','slug', 'image', 'category_id', 'created_by', 'updated_by'];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function editor()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
