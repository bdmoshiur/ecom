<?php

namespace App;

use App\Section;
use App\Category;
use App\ProductsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id');
    }
}
