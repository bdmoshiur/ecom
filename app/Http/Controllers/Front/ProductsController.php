<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Product;
use App\Category;
use App\Country;
use App\Coupon;
use App\OrderProduct;
use App\Order;
use App\OtherSetting;
use App\User;
use App\Sms;
use App\ShippingCharge;
use App\Delivery_address;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use DB;

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

                $meta_title = $categoryDetails['catDetails']['meta_title'];
                $meta_description = $categoryDetails['catDetails']['meta_description'];
                $meta_keywords = $categoryDetails['catDetails']['meta_keywords'];

                return view('front.products.ajax_products_listing', [
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'meta_title' => $meta_title,
                    'meta_description' => $meta_description,
                    'meta_keywords' => $meta_keywords,
                    'url' => $url,
                ]);
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();

            if (isset($_REQUEST['search']) && !empty($_REQUEST['search']) ) {
                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcambs'] = $search_product;
                $categoryDetails['catDetails']['category_name'] = $search_product;
                $categoryDetails['catDetails']['description'] = "Search Results for " . $search_product;

                $categoryProducts = Product::with('brand')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where(function($query) use ($search_product) {
                    $query->where('products.product_name', 'like', '%' . $search_product . '%')
                        ->orWhere('products.product_code', 'like', '%' . $search_product . '%')
                        ->orWhere('products.product_color', 'like', '%' . $search_product . '%')
                        ->orWhere('products.description', 'like', '%' . $search_product . '%')
                        ->orWhere('categories.category_name', 'like', '%' . $search_product . '%');
                })
                ->where('products.status', 1);

                $categoryProducts = $categoryProducts->get();

                $page_name = 'Search Results';
                return view('front.products.listing', [
                    'page_name' => $page_name,
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                ]);

            }elseif ($categoryCount > 0) {
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

                $meta_title = $categoryDetails['catDetails']['meta_title'];
                $meta_description = $categoryDetails['catDetails']['meta_description'];
                $meta_keywords = $categoryDetails['catDetails']['meta_keywords'];

                return view('front.products.listing', [
                    'page_name' => $page_name,
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'meta_title' => $meta_title,
                    'meta_description' => $meta_description,
                    'meta_keywords' => $meta_keywords,
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

        $groupProducts = [];
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id', 'main_image')->where('id' ,'!=', $id)->where(['group_code' =>$productDetails['group_code'] , 'status' => 1 ])->get()->toArray();
        }

        $meta_title = $productDetails['product_name'];
        $meta_description = $productDetails['description'];
        $meta_keywords = $productDetails['product_name'];

        return view('front.products.detail', [
            'productDetails' => $productDetails,
            'total_stock' => $total_stock,
            'relatedProducts' => $relatedProducts,
            'groupProducts' => $groupProducts,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
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

            if ($data['quantity'] <= 0 || $data['quantity'] == "" ) {
                $data['quantity'] = 1;
            }

            if (empty($data['size'])) {
                $message = 'Please select size';
                Session::flash('error_message', $message);
                return redirect()->back();
            }

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

        $meta_title = 'Shopping Cart E-commerce website';
        $meta_description = 'View shopping cart of E-commerce website';
        $meta_keywords = 'shopping cart, e-commerce website';

        return view('front.products.cart', [
            'userCartItems' => $userCartItems,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
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
            $userCartItems = Cart::userCartItrms();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();


            if($couponCount == 0){
                $userCartItems = Cart::userCartItrms();
                $totalCartItems = totalCartItems();
                Session::forget('coponCode');
                Session::forget('couponAmount');
                return response()->json([
                    'status' => false,
                    'message' => "The coupon is not valid!",
                    'totalCartItems' => $totalCartItems,
                    'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
                ]);
            }else{
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                if ($couponDetails->status == 0) {
                    $message = "This coupon is not active!";
                }

                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');

                if ( $expiry_date < $current_date ) {
                    $message = "This coupon is expired !";
                }

                // check if coupon is for single or multiple time

                if($couponDetails->coupon_type == "Single Times"){
                    //check in orders table if coupon already applied by the user

                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' =>Auth::user()->id])->count();
                    if($couponCount >= 1){
                        $message = "This coupon code is already availed by you!";
                    }

                }

                $userCartItems  = Cart::userCartItrms();
                $catArr = explode(',', $couponDetails->categories);

                if(!empty($couponDetails->users)){
                    $usersArr = explode(',', $couponDetails->users);

                    foreach ($usersArr as $key => $user) {
                        $getUserId =  User::select('id')->where('email',$user)->first()->toArray();
                        $userId[] = $getUserId['id'];
                    }
                }

                $total_amount = 0;
                foreach ($userCartItems as $key => $item) {

                    if (! in_array($item['product']['category_id'], $catArr ) ) {
                        $message = "This coupon code is not for one of the selected products!";
                    }

                    if(!empty($couponDetails->users)){
                        if (! in_array($item['user_id'], $userId)) {
                            $message = "This coupon code is not for you!";
                        }
                    }

                    $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                    $total_amount =  $total_amount + ($attrPrice['final_price']* $item['quantity']);



                }

                if (isset($message)) {
                    $userCartItems = Cart::userCartItrms();
                    $totalCartItems = totalCartItems();
                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
                    ]);
                } else{

                    if($couponDetails->amount_type == "Fixed"){
                        $couponAmount =  $couponDetails->amount;
                    } else{
                        $couponAmount =  $total_amount * ( $couponDetails->amount / 100 );
                    }
                    $grand_total = $total_amount - $couponAmount;

                    Session::put('couponAmount', $couponAmount);
                    Session::put('coponCode', $data['code']);
                    $message = "Coupon code successfully applied. You are availing discount.";

                    $userCartItems = Cart::userCartItrms();
                    $totalCartItems = totalCartItems();

                    return response()->json([
                        'status' => true,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'view' => (string)View::make('front.products.cart_items', ['userCartItems' => $userCartItems])
                    ]);
                }

            }

        }
    }

    public function checkOut(Request $request) {

        $userCartItems = Cart::userCartItrms();

        if (count($userCartItems) == 0) {
            $message = "Shopping cart is empty! Please add products to checkout.";
            Session::flash('error_message',$message);
            return redirect()->route('cart');
        }


        $total_price = 0;
        $total_weight = 0;
        foreach ($userCartItems as $item){
            $product_weight = $item['product']['product_weight'];
            $total_weight = $total_weight + ($product_weight * $item['quantity']) ;
            $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
            $total_price = $total_price + $attrPrice['final_price'] * $item['quantity'];
        }

        // Min / Max cart value check
        $otherSetting = otherSetting::where('id', 1)->first()->toArray();

        if ($total_price < $otherSetting['min_cart_value']) {
            $message = "Min Cart Amount Must be Tk. " . $otherSetting['min_cart_value'] ;
            Session::flash('error_message',$message);

            return redirect()->back();
        }

        if ($total_price > $otherSetting['max_cart_value']) {
            $message = "Max Cart Amount Must be Tk. " . $otherSetting['max_cart_value'];
            Session::flash('error_message',$message);

            return redirect()->back();
        }

        $deliveryAddress = Delivery_address::deliveryAddress();

        foreach ($deliveryAddress as $key => $value) {
            $shipping_charges =  ShippingCharge::getShippingCharges($total_weight,$value['country']);

           $deliveryAddress[$key]['shipping_charges'] =  $shipping_charges;
         // check if delivary address exists in Cod pincodes list
           $deliveryAddress[$key]['codpincodeCount'] = DB::table('cod_pincodes')->where('pincode', $value['pincode'])->count();
         // check if delivary address exists in prepaid pincodes list
           $deliveryAddress[$key]['prepaidpincodeCount'] = DB::table('prepaid_pincodes')->where('pincode', $value['pincode'])->count();
        }


        if ($request->isMethod('post')) {
            $data = $request->all();


                // website sequrity checks

                // fetch user cart items
                foreach ($userCartItems as $key => $cart) {

                    // prevent disable product to order
                    $product_status = Product::getProductStatus($cart['product_id']);
                    if($product_status == 0 ){
                        // Product::deleteCartProduct($cart['product_id']);
                        $message = $cart['product']['product_name'] . " is not available so please remove from cart.";
                        Session::flash('error_message',$message);

                        return redirect()->route('cart');
                    }

                    // prevent out of stock products to order
                    $product_stock = Product::getProductStock($cart['product_id'], $cart['size']);
                    if($product_stock == 0 ){
                        // Product::deleteCartProduct($cart['product_id']);
                        $message = $cart['product']['product_name'] . " is not available so please remove from cart.";
                        Session::flash('error_message',$message);

                        return redirect()->route('cart');
                    }

                    // prevent out of Disable or delete products to order
                    $getAttributeCount = Product::getAttributeCount($cart['product_id'], $cart['size']);
                    if($getAttributeCount == 0 ){
                        // Product::deleteCartProduct($cart['product_id']);
                        $message = $cart['product']['product_name'] . " is not available so please remove from cart.";
                        Session::flash('error_message',$message);

                        return redirect()->route('cart');
                    }

                    // prevent  Disable categories products to order
                    $category_status = Product::getCategoryStatus($cart['product']['category_id']);
                    if($category_status == 0 ){
                        // Product::deleteCartProduct($cart['product_id']);
                        $message = $cart['product']['product_name'] . " is not available so please remove from cart.";
                        Session::flash('error_message',$message);

                        return redirect()->route('cart');
                    }

                }

            if (empty($data['address_id'])) {
                $message = "Please Select Delivery Address!";
                Session::flash('error_message',$message);

                return redirect()->back();
            }
            if (empty($data['payment_gateway'])) {
                $message = "Please Select Payment Method!";
                Session::flash('error_message',$message);

                return redirect()->back();
            }

            if($data['payment_gateway'] == "COD"){
                $payment_method = "COD";
            }else{
                $payment_method = "Prepaid";
            }

            $deliveryAddress = Delivery_address::where('id',$data['address_id'])->first()->toArray();

            //Shipping charges get
            $shipping_charges = ShippingCharge::getShippingCharges($total_weight,$deliveryAddress['country']);

            // Grand total set

            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');
            Session::put('grand_total',$grand_total);

            DB::beginTransaction();
            $order = new Order();

            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('coponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = 'New';
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();


            $cartItemts = Cart::where('user_id', Auth::user()->id)->get()->toArray();

            foreach ($cartItemts as $key => $item) {

                $cartItem = new OrderProduct();

                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name','product_color')->where('id', $item['product_id'])->first()->toArray();

                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];

                $getDiscountAttrPrice = Product::getDiscountAttrPrice($item['product_id'],$item['size']);

                $cartItem->product_price = $getDiscountAttrPrice['final_price'];
                $cartItem->product_quantity = $item['quantity'];
                $cartItem->save();

                if ($data['payment_gateway'] == "COD") {
                    $getProductStock = ProductsAttribute::where(['product_id'=> $item['product_id'], 'size' => $item['size']])->first()->toarray();
                    $newStock = $getProductStock['stock'] - $item['quantity'];

                    ProductsAttribute::where(['product_id'=> $item['product_id'], 'size' => $item['size']])->update(['stock' => $newStock]);
                }


            }

            $cart = Cart::where('user_id', Auth::user()->id)->delete();
            Session::put('order_id',$order_id);

            DB::commit();

            if ($data['payment_gateway'] == "COD") {

                $message = "Dear Customer, Your order ". $order_id . "has been successfully placed with e-commerce website. we will intimate you once your order is shipped";
                $mobile = Auth::user()->mobile;

                Sms::sendSms($message,$mobile);

                $orders_details = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

                $email = Auth::user()->email;
                $user = Auth::user()->name;
                $messageData = [
                    'name' => $user,
                    'email' => $email,
                    'order_id' => $order_id,
                    'orders_details' => $orders_details,
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed E-commerce website');
                });


                return redirect()->route('front.thanks');
            }elseif($data['payment_gateway'] == "Paypal"){
                return redirect()->route('front.paypal');
            }elseif($data['payment_gateway'] == "Bkash"){
                return redirect()->route('front.bkash');
            }else{
                echo "Others payment method comming soon"; die;
            }
            echo "Order Placed"; die;
        }

        $meta_title = 'Checkout Page E-commerce website';

        return view('front.products.checkout',[
            'userCartItems' => $userCartItems,
            'deliveryAddress' => $deliveryAddress,
            'total_price' => $total_price,
            'meta_title' => $meta_title,
        ]);
    }

    public function thanks(){
        if(Session::has('order_id')){
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect()->route('cart');
        }
    }

    public function addEditDeliveryAddress( Request $request , $id = null) {

        if ($id == "") {
            //Add Product Functionality
            $title = "Add Delivery Address";
            $address = new Delivery_address();
            $message = "Delivery Address Added Successfully";
        } else {
            //Edit Product Functionality
            $title = "Edit Delivery Address";
            $address = Delivery_address::find($id);
            $message = "Delivery Address Updated Successfully";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'address' => "required",
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'country' => 'required',
                'pincode' => 'required|numeric|digits:4',
                'mobile'     => 'required|numeric|digits:11',
            ];
            $customMessage = [
                'name.required' => 'Name is Required',
                'name.regex' => 'Valid Name is Required',
                'address.required' => 'Address is Required',
                'city.required' => 'City is Required',
                'city.regex' => 'Valid City is Required',
                'state.required' => 'State is Required',
                'state.regex' => 'Valid State is Required',
                'country.required' => 'Country is Required',
                'pincode.required' => 'Pincode is Required',
                'pincode.numeric' => 'Valid Pincode is Required',
                'pincode.digits' => 'Pincode must be of 4 digits',
                'mobile.required' => 'Mobile is Required',
                'mobile.numeric' => 'Valid Mobile is Required',
                'mobile.digits' => 'Mobile must be of 11 digits',
            ];
            $this->validate($request, $rules, $customMessage);


            $address->user_id =  Auth::user()->id;
            $address->name =  $data['name'];
            $address->address =  $data['address'];
            $address->country =  $data['country'];
            $address->city =  $data['city'];
            $address->state =  $data['state'];
            $address->pincode =  $data['pincode'];
            $address->mobile =  $data['mobile'];
            $address->save();

            Session::put('success_message',$message);

            return redirect()->route('front.checkout');

        }

        $countries = Country::where('status',1)->get()->toArray();

        return view('front.products.add_edit_delivery_address',[
            'title' => $title,
            'countries' => $countries,
            'address' => $address,
        ]);
    }

    public function deleteDeliveryAddress( $id ) {
        Delivery_address::where('id',$id)->delete();

        $message = "Delivery address deleted Successfully";
        Session::put('success_message', $message);
        return redirect()->back();
    }

    public function checkPincode(Request $request) {

        if ($request->isMethod('post')) {
            $data = $request->all();

          if (is_numeric($data['pincode']) && $data['pincode'] > 0 && $data['pincode'] == round($data['pincode'],0)) {

            $codpincodeCount = DB::table('cod_pincodes')->where('pincode', $data['pincode'])->count();
            $prepaidpincodeCount = DB::table('prepaid_pincodes')->where('pincode', $data['pincode'])->count();

            if ( $codpincodeCount == 0 && $prepaidpincodeCount == 0 ) {
                echo "This pincode is not available for delivery"; die;
            }else{
                echo "This pincode is available for delivery"; die;
            }

          }else{
            echo "Please enter valid pincode";
          }

        }

    }


}
