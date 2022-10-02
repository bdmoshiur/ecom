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
    function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductsImage::class, 'product_id');
    }
    public static function productFilters()
    {
        $productFilters['fabricArray'] = array('Coton', 'Polyester', 'Wool', 'Pure Cotton');
        $productFilters['sleeveArray'] = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $productFilters['patternArray'] = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $productFilters['fitArray'] = array('Regular', 'Slim');
        $productFilters['occasionArray'] = array('Casual', 'Formal');
        return $productFilters;
    }
}
