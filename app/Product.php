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

    public static function getDiscountPrice( $product_id)
    {
        $proDetails = Product::select('product_price','product_discount', 'category_id')->where('id',$product_id)->first()->toArray();

        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        // dd($proDetails, $catDetails);

        if($proDetails['product_discount'] > 0){
            // if product discount is added from admin panel
            $discounted_Price = $proDetails['product_price'] - ($proDetails['product_price'] * $proDetails['product_discount']/100);
             // Sale price = cost price - disaount price
            // 450          500   - (500*10/100 = 50)
        } else if($catDetails['category_discount'] > 0){
            // if product discount is not added and category discount added from admin panel
            $discounted_Price = $proDetails['product_price'] - ($proDetails['product_price'] * $catDetails['category_discount']/100);
        } else {
            $discounted_Price = 0;
        }
        return $discounted_Price;
    }

    public static function getDiscountAttrPrice( $product_id, $size)
    {
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_price','product_discount', 'category_id')->where('id',$product_id)->first()->toArray();

        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();

        if($proDetails['product_discount'] > 0){
            // if product discount is added from admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $proDetails['product_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
             // Sale price = cost price - disaount price
            // 450          500   - (500*10/100 = 50)
        } else if($catDetails['category_discount'] > 0){
            // if product discount is not added and category discount added from admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $catDetails['category_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else {
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return ['product_price' =>$proAttrPrice['price'] ,'final_price' => $final_price, 'discount' =>$discount];
    }


}
