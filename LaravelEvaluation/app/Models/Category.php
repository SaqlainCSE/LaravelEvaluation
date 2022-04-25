<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sub_categories()
    {
        return $this->hasmany(SubCategory::class);
    }
}
