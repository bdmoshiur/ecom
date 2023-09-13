<?php

use App\Category;
use App\CmsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\UsersController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\PaypalController;
use App\Http\Controllers\Front\PayumoneyController;
use App\Http\Controllers\Front\CmsPageController;
use App\Http\Controllers\Front\RatingsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderssController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\RatingController;




// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

    Route::match(['get', 'post'], '/', 'AdminController@login')->name('admin.admin');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('settings', 'AdminController@settings')->name('admin.settings');
        Route::get('logout', 'AdminController@logout')->name('admin.logout');
        Route::post('check-current-password', 'AdminController@checkCurrentPassword')->name('admin.check.current.password');
        Route::post('update-current-password', 'AdminController@updateCurrentPassword')->name('admin.update.current.password');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails')->name('admin.update.admin.details');

        //Sections
        Route::get('sections', 'SectionController@sections')->name('admin.sections');
        Route::post('/update-section-status', 'SectionController@updateSectionStatus');

        //Brands
        Route::get('brands', 'BrandController@brands')->name('admin.brands');
        Route::post('/update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand')->name('admin.add.edit.brands');
        Route::get('delete_brand/{id}', 'BrandController@deleteBrands')->name('admin.delete.brand');

        // Categories
        Route::get('categories', 'CategoryController@categories')->name('admin.categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory')->name('admin.add.edit.categories');

        Route::post('append-categories-lavel', 'CategoryController@appendCategoryLevel')->name('admin.append.category.level');
        Route::get('delete_category_image/{id}', 'CategoryController@deleteCategoryImage')->name('admin.delete.category.image');
        Route::get('delete_category/{id}', 'CategoryController@deleteCategories')->name('admin.delete.category');

        // products
        Route::get('products', 'ProductController@products')->name('admin.products');
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct')->name('admin.add.edit.products');

        Route::post('append-products-lavel', 'ProductController@appendProductLevel')->name('admin.append.product.level');
        Route::get('delete_product_image/{id}', 'ProductController@deleteProductImage')->name('admin.delete.product.image');
        Route::get('delete_product_video/{id}', 'ProductController@deleteProductVideo')->name('admin.delete.product.vedio');
        Route::get('delete_product/{id}', 'ProductController@deleteProduct')->name('admin.delete.product');

        // Products Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductController@addAttributes')->name('admin.add_attributes');
        Route::post('edit_attributes/{id}', 'ProductController@editAttributes')->name('admin.edit_attributes');
        Route::post('update-attribute-status', 'ProductController@updateAttributeStatus');
        Route::get('delete_attribute/{id}', 'ProductController@deleteAttribute')->name('admin.delete.attribute');


        // Product Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductController@addImagess')->name('admin.add_images');
        Route::post('update-image-status', 'ProductController@updateImageStatus');
        Route::get('delete_image/{id}', 'ProductController@deleteImage')->name('admin.delete.image');
        Route::post('edit_images/{id}', 'ProductController@editImages')->name('admin.edit_images');

        //Banners
        Route::get('banners', 'BannerController@banners')->name('admin.banners');
        Route::post('/update-banner-status', 'BannerController@updateBannerStatus');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannerController@addEditBanner')->name('admin.add.edit.banners');
        Route::get('delete_banner/{id}', 'BannerController@deleteBanners')->name('admin.delete.banner');

        //Coupons
        Route::get('coupons', [CouponController::class,'coupons'])->name('admin.coupons');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}',[CouponController::class,'addEditCoupon'])->name('admin.add.edit.coupons');
        Route::post('/update-coupon-status', [CouponController::class,'updateCouponStatus']);
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', [CouponController::class,'addEditCoupon'])->name('admin.add.edit.coupons');
        Route::get('delete_coupon/{id}', [CouponController::class,'deleteCoupon'])->name('admin.delete.coupon');


        // Orders
        Route::get('/orders',[OrderssController::class,'orders'])->name('admin.orders');
        Route::get('/orders/details/{id}',[OrderssController::class,'ordersDetails'])->name('admin.orders.details');
        Route::post('/update/orders/status',[OrderssController::class,'updateOrdersStaus'])->name('admin.update.orderstatus');
        Route::get('/view/orders/invoice/{id}',[OrderssController::class,'viewOrdersInvoice'])->name('admin.view.orders.invoice');
        Route::get('/print/pdf/invoice/{id}',[OrderssController::class,'printPdfInvoice'])->name('admin.print.pdf.invoice');


        // view orders charts
        Route::get('view-orders-charts', [OrderssController::class, 'viewOrdersCharts'])->name('view.orders.charts');


        // shipping charges
        Route::get('/view/shipping/charges',[ShippingController::class, 'viewShippingCharges'])->name('admin.shipping.charges');
        Route::match(['get', 'post'],'/edit/shipping/charges/{id}',[ShippingController::class, 'updateShippingCharges'])->name('admin.update.shipping.charges');
        Route::post('/update-shipping-status', [ShippingController::class, 'updateShippingStatus']);


        // Users
        Route::get('/users', [UserController::class, 'users'])->name('admin.users');
        Route::post('/update-user-status', [UserController::class,'updateUserStatus']);

        // view users charts
        Route::get('view-users-charts', [UserController::class, 'viewUsersCharts'])->name('view.users.charts');
        Route::get('view-users-countries', [UserController::class, 'viewUsersCountries'])->name('view.users.countries');


        // cms pages
        Route::get('/cms_pages', [CmsController::class, 'cmsPages'])->name('admin.cms.pages');
        Route::match(['get', 'post'],'/add-edit-cms-pages/{id?}',[CmsController::class, 'addEditCmsPage'])->name('admin.add.edit.cms.pages');
        Route::post('/update-cms-pages-status', [CmsController::class, 'updateCmsPageStatus']);
        Route::get('delete_cmspage/{id}', [CmsController::class,'deleteCmsPages'])->name('admin.delete.cms.pages');


        // Admins subadmins
        Route::get('/admins-subadmins', [AdminController::class, 'adminsSubadmins'])->name('admin.admins.subadmins');
        Route::match(['get', 'post'],'/add-edit-admin-subadmin/{id?}',[AdminController::class, 'addEditAdminSubadmin'])->name('admin.add.edit.admin.subadmin');
        Route::post('/update-admin-status', [AdminController::class, 'updatAdminsStatus']);
        Route::get('delete_admin/{id}', [AdminController::class,'deleteAdmin'])->name('admin.delete.admins');
        Route::match(['get', 'post'], 'update-role/{id?}', [AdminController::class,'updateRole'])->name('admin.update.role');


        // Others Settings
        Route::match(['get', 'post'], 'update-other-setting', [AdminController::class,'updateOtherSetting'])->name('admin.update.other.settings');

        // Currency Conver route
        Route::get('/currencies', [CurrencyController::class, 'currencies'])->name('admin.currencies');
        Route::match(['get', 'post'], 'add-edit-currency/{id?}', [CurrencyController::class,'addEditCurrency'])->name('admin.add.edit.currency');
        Route::post('/update-currency-status', [CurrencyController::class, 'updatCurrencyStatus']);
        Route::get('delete_currency/{id}', [CurrencyController::class, 'deleteCurrencies'])->name('admin.delete.currency');


        // Ratings Routes
        Route::get('/ratings', [RatingController::class, 'ratings'])->name('admin.ratings');
        Route::post('/update-rating-status', [RatingController::class, 'updatRatingStatus']);

    });
});

Route::group(['namespace' => 'Front'], function () {
    // home page route
    Route::get('/', [IndexController::class, 'index'])->name('index');

    // lisining category route
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach($catUrls as $url){
        Route::get('/'.$url, [ProductsController::class, 'listing'])->name('index'.$url);
    }

    // Cms Page route
    $cmsUrls = CmsPage::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach($cmsUrls as $url){
        Route::get('/'.$url, [CmsPageController::class, 'cmsPage'])->name('cmspage'. '.' .$url);
    }

    // product detail route
    Route::get('/product/{id}', [ProductsController::class, 'detail'])->name('product');

    // getproduct attribute price
    Route::post('/get-product-price', [ProductsController::class, 'getProductPrice']);
    // add to cart route
    Route::post('/add-to-cart', [ProductsController::class, 'addToCart'])->name('addToCart');
    // shoping cart route
    Route::get('/cart', [ProductsController::class, 'cart'])->name('cart');
    //Update Cart Item Quantity
    Route::post('/update-cart-item-qty', [ProductsController::class, 'updateCarItemQty']);
    //Delete Cart Item Quantity
    Route::post('/delete-cart-item', [ProductsController::class, 'deleteCartItem']);

    //Login Register page show route
    Route::get('/login-register',[UsersController::class, 'loginRegister'])->name('login');
    // user login
    Route::post('/login',[UsersController::class, 'loginUser'])->name('front.login');
    // user register
    Route::post('/register',[UsersController::class, 'registerUser'])->name('front.register');
    // logout user
    Route::get('/logout',[UsersController::class, 'logoutUser'])->name('front.logout');

    Route::match(['get','post'],'/check-email',[UsersController::class, 'checkEmail'])->name('front.check_email');
    Route::match(['get','post'],'/confirm/{code}',[UsersController::class, 'confirmAccount'])->name('front.confirm');
    Route::match(['get','post'],'/forgot/password',[UsersController::class, 'forgotPassword'])->name('front.forgot.password');

    //check delivery pincode
    Route::post('/check-pincode',[ProductsController::class, 'checkPincode'])->name('front.check.pincode');
    // Search Product
    Route::get('/search/product', [ProductsController::class, 'listing'])->name('front.product.search');

    // Contact us
    Route::match(['get','post'],'/contact',[CmsPageController::class, 'contactUs'])->name('front.contactus');

    Route::match(['get','post'],'/add-rating', [RatingsController::class, 'addRating'])->name('front.add.rating');



    Route::group(['middleware' =>['auth']],function () {
        Route::post('/check-password',[UsersController::class, 'checkUserPassword'])->name('front.check.user.password');
        Route::post('/update-password',[UsersController::class, 'updateUserPassword'])->name('front.update.user.password');
        Route::match(['get','post'],'/account',[UsersController::class, 'account'])->name('front.account');

        Route::get('/orders',[OrdersController::class,'orders'])->name('front.orders');
        Route::get('/orders-details/{id}',[OrdersController::class,'ordersDetails'])->name('front.orders.details');

        Route::post('/apply-coupon',[ProductsController::class, 'applyCoupon']);
        Route::match(['get','post'],'/checkout',[ProductsController::class, 'checkOut'])->name('front.checkout');
        Route::match(['get','post'],'/add-edit-delivery-address/{id?}',[ProductsController::class, 'addEditDeliveryAddress'])->name('front.add.edit.delivery.address');
        Route::get('/delete-delivery-address/{id}',[ProductsController::class, 'deleteDeliveryAddress'])->name('front.delete.delivery.address');
        Route::get('/thanks',[ProductsController::class, 'thanks'])->name('front.thanks');


        //paypal
        Route::get('/paypal',[PaypalController::class, 'paypal'])->name('front.paypal');
        Route::get('/paypal/success',[PaypalController::class, 'success'])->name('front.paypal.success');
        Route::get('/paypal/fail',[PaypalController::class, 'fail'])->name('front.paypal.fail');
        Route::post('/paypal/ipn',[PaypalController::class, 'ipn'])->name('front.paypal.ipn');

        // Bkash
        Route::post('/bkash',[PaypalController::class, 'bkash'])->name('front.bkash');



    });





});
