<?php

use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\UsersController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Front\ProductsController;

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
    Route::get('/login-register',[UsersController::class, 'loginRegister'])->name('front.login_register');
    // user login
    Route::post('/login',[UsersController::class, 'loginUser'])->name('front.login');
    // user register
    Route::post('/register',[UsersController::class, 'registerUser'])->name('front.register');
    // logout user
    Route::get('/logout',[UsersController::class, 'logoutUser'])->name('front.logout');

    Route::match(['get','post'],'/check-email',[UsersController::class, 'checkEmail'])->name('front.check_email');
    Route::get('/account',[UsersController::class, 'accountUser'])->name('front.account');

});
