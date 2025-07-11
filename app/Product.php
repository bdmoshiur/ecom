<?php

namespace App;

use App\Section;
use App\Category;
use App\Fabric;
use App\Sleeve;
use App\Fit;
use App\Pattern;
use App\Occasion;
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
        // $productFilters['fabricArray'] = array('Coton', 'Polyester', 'Wool', 'Pure Cotton');
        // $productFilters['sleeveArray'] = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        // $productFilters['patternArray'] = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        // $productFilters['fitArray'] = array('Regular', 'Slim');
        // $productFilters['occasionArray'] = array('Casual', 'Formal');

        $productFilters['fabricArray'] = Fabric::where('status',1)->pluck('name');
        $productFilters['sleeveArray'] = Sleeve::where('status',1)->pluck('name');
        $productFilters['fitArray'] = Fit::where('status',1)->pluck('name');
        $productFilters['patternArray'] = Pattern::where('status',1)->pluck('name');
        $productFilters['occasionArray'] = Occasion::where('status',1)->pluck('name');

        return $productFilters;
    }

    public static function getDiscountPrice( $product_id)
    {
        $proDetails = Product::select('product_price','product_discount', 'category_id')->where('id',$product_id)->first()->toArray();

        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        // dd($proDetails, $catDetails);
        if($catDetails){
            $catDetails = $catDetails->toArray();
        }

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

    public static function getProductImage($product_id) {
        $getProductImage = Product::select('main_image')->where('id',$product_id)->first();

        if($getProductImage){
            $getProductImage = $getProductImage->toArray();
        } else{
            $getProductImage['main_image'] = "Image Not Found";
        }

        return $getProductImage['main_image'];
    }

    public static function getProductStatus($product_id) {
        $getProductStatus = Product::select('status')->where('id', $product_id)->first()->toArray();

        return $getProductStatus['status'];
    }

    public static function getProductStock($product_id, $product_size) {
        $getProductsStock = ProductsAttribute::select('stock')->where(['product_id' => $product_id, 'size' => $product_size])->first()->toArray();

        return $getProductsStock['stock'];
    }

    public static function getAttributeCount($product_id, $product_size) {
        $getAttributeCount = ProductsAttribute::select('stock')->where(['product_id' => $product_id, 'size' => $product_size, 'status' => 1])->count();

        return $getAttributeCount;
    }

    public static function getCategoryStatus($category_id) {
        $getCategoryStatus = Category::select('status')->where('id', $category_id)->first()->toArray();

        return $getCategoryStatus['status'];
    }

    public static function deleteCartProduct($product_id) {
        Cart::where('product_id', $product_id)->delete();
    }

    public static function productsCountForSubCategories($category_id) {
        $productCount = Product::where(['category_id' => $category_id, 'status'=> 1])->count();

        return $productCount;
    }

    public static function productsCount($category_id) {
        $catIds = Category::select('id')->where('parent_id',$category_id)->get()->toArray();

        $catIds1 = array_flatten($catIds);
        $catIds2 = array($category_id);
        $catIds = array_merge($catIds1, $catIds2);

        $productsCount = Product::whereIn('category_id' , $catIds)->where('status', 1)->count();

        return $productsCount;
    }
}
