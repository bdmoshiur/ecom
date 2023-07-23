<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Product;
use App\Category;
use App\Coupon;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $url = $data['url'];
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }

                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == 'product_latest') {
                        $categoryProducts->orderBy('id', 'desc');
                    } else if ($data['sort'] == 'priduct_name_a_z') {
                        $categoryProducts->orderBy('product_name', 'asc');
                    } else if ($data['sort'] == 'priduct_name_z_a') {
                        $categoryProducts->orderBy('product_name', 'desc');
                    } else if ($data['sort'] == 'price_lowest') {
                        $categoryProducts->orderBy('product_price', 'asc');
                    } else if ($data['sort'] == 'price_highest') {
                        $categoryProducts->orderBy('product_price', 'desc');
                    }
                } else {
                    $categoryProducts->orderBy('id', 'desc');
                }
                $categoryProducts = $categoryProducts->paginate(30);
                return view('front.products.ajax_products_listing', [
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'url' => $url,
                ]);
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                $categoryProducts = $categoryProducts->paginate(30);

                //products Filters
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];
                $page_name = 'listing';
                return view('front.products.listing', [
                    'page_name' => $page_name,
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'url' => $url,
                    'fabricArray' => $fabricArray,
                    'sleeveArray' => $sleeveArray,
                    'patternArray' => $patternArray,
                    'fitArray' => $fitArray,
                    'occasionArray' => $occasionArray,
                ]);
            } else {
                abort(404);
            }
        }
    }

    public function detail($id)
    {
        $productDetails = Product::with(['category', 'brand', 'attributes' => function ($query) {
            $query->where('status', 1);
        }, 'images'])->find($id)->toArray();
        // dd($productDetails);
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        $relatedProducts = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(3)->inRandomOrder()->get()->toArray();
        // dd($relatedProducts);
        return view('front.products.detail', [
            'productDetails' => $productDetails,
            'total_stock' => $total_stock,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getDiscountAttrPrice = Product::getDiscountAttrPrice($data['product_id'], $data['size']);
            return $getDiscountAttrPrice;
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first()->toArray();
            if ($getProductStock['stock'] < $data['quantity']) {
                Session::flash('error_message', 'Required quantity is not available');
                return redirect()->back();
            }

            // Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            if (Auth::check()) {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => Auth::user()->id])->count();
            } else {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => Session::get('session_id')])->count();
            }

            // check product alreaday exist in cart
            if ($countProducts > 0) {
                Session::flash('error_message', 'Product already exists in cart');
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 0;
            }
            // Save Product In Cart
            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            Session::flash('success_message', 'Product has been added in cart');
            return redirect()->route('cart');
        }
    }

    public function cart()
    {
        $userCartItems = Cart::userCartItrms();
        // dd($userCartItems);
        return view('front.products.cart', [
            'userCartItems' => $userCartItems,
        ]);
    }

    public function updateCarItemQty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $cartDetails = Cart::find($data['cartid']);
            $availableStock = ProductsAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size']])->first()->toArray();

            if ($data['new_qty'] > $availableStock['stock']) {
                $userCartItems = Cart::userCartItrms();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Stock is not available',
                    'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems]),
                ]);
            }

            $availableSize = ProductsAttribute::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size'], 'status' => 1])->count();

            if ($availableSize == 0) {
                $userCartItems = Cart::userCartItrms();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size is not available ',
                    'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
                ]);
            }

            Cart::where('id', $data['cartid'])->update(['quantity' => $data['new_qty']]);
            $userCartItems = Cart::userCartItrms();
            $totalCartItems = totalCartItems();

            return response()->json([
                'status' => true,
                'totalCartItems' => $totalCartItems,
                'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
            ]);
        }
    }

    public function deleteCartItem(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Cart::where('id',$data['cartid'])->delete();
            $userCartItems = Cart::userCartItrms();
            $totalCartItems = totalCartItems();

            return response()->json([
                'totalCartItems' => $totalCartItems,
                'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
            ]);

        }
    }

    public function applyCoupon(Request $request ) {
        if ($request->ajax()) {
            $data = $request->all();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();


            if($couponCount == 0){
                $userCartItems = Cart::userCartItrms();
                $totalCartItems = totalCartItems();

                return response()->json([
                    'status' => false,
                    'message' => "The coupon is not valid",
                    'totalCartItems' => $totalCartItems,
                    'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
                ]);
            }else{

            }

        }
    }
}
