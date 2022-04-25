<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'title',
        'description',
        'price',
        'thumbnail',
    ];

    public function categories()
    {
        return $this->hasmany(Category::class);
    }
}
