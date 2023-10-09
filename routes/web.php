<?php

use App\CmsPage;
use App\Category;
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
use App\Http\Controllers\Front\NewsletterSubscriberController as FrontSubscriberController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderssController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CodpincodeController;
use App\Http\Controllers\Admin\FabricController;
use App\Http\Controllers\Admin\SleeveController;
use App\Http\Controllers\Admin\FitController;
use App\Http\Controllers\Admin\PatternController;
use App\Http\Controllers\Admin\OccasionController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PrepaidpincodeController;
use App\Http\Controllers\Admin\MediaController;

use App\Http\Controllers\Admin\NewsletterSubscriberController as AdminSubscriberController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\HomeController;




// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout'])->name('sslcommerz');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

    Route::match(['get', 'post'], '/', [AdminController::class,'login'])->name('admin.admin');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('settings', [AdminController::class,'settings'])->name('admin.settings');
        Route::get('logout', [AdminController::class,'logout'])->name('admin.logout');
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword'])->name('admin.check.current.password');
        Route::post('update-current-password', [AdminController::class,'updateCurrentPassword'])->name('admin.update.current.password');
        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails'])->name('admin.update.admin.details');

        //Sections
        Route::get('sections', [SectionController::class,'sections'])->name('admin.sections');
        Route::post('/update-section-status', [SectionController::class,'updateSectionStatus']);
        Route::match(['get', 'post'], 'add-edit-section/{id?}', [SectionController::class, 'addEditSection'])->name('admin.add.edit.sections');
        Route::get('delete_section/{id}', [SectionController::class, 'deleteSections'])->name('admin.delete.section');

        //Brands
        Route::get('brands', [BrandController::class,'brands'])->name('admin.brands');
        Route::post('/update-brand-status', [BrandController::class, 'updateBrandStatus']);
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', [BrandController::class, 'addEditBrand'])->name('admin.add.edit.brands');
        Route::get('delete_brand/{id}', [BrandController::class, 'deleteBrands'])->name('admin.delete.brand');

        // Categories
        Route::get('categories', [CategoryController::class,'categories'])->name('admin.categories');
        Route::post('update-category-status', [CategoryController::class,'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}', [CategoryController::class, 'addEditCategory'])->name('admin.add.edit.categories');

        Route::get('append-categories-lavel', [CategoryController::class,'appendCategoryLevel'])->name('admin.append.category.level');
        Route::get('delete_category_image/{id}', [CategoryController::class,'deleteCategoryImage'])->name('admin.delete.category.image');
        Route::get('delete_category/{id}', [CategoryController::class, 'deleteCategories'])->name('admin.delete.category');

        // products
        Route::get('products', [ProductController::class, 'products'])->name('admin.products');
        Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [ProductController::class, 'addEditProduct'])->name('admin.add.edit.products');

        Route::post('append-products-lavel', [ProductController::class,'appendProductLevel'])->name('admin.append.product.level');
        Route::get('delete_product_image/{id}', [ProductController::class, 'deleteProductImage'])->name('admin.delete.product.image');
        Route::get('delete_product_video/{id}', [ProductController::class, 'deleteProductVideo'])->name('admin.delete.product.vedio');
        Route::get('delete_product/{id}', [ProductController::class,'deleteProduct'])->name('admin.delete.product');

        // Products Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', [ProductController::class, 'addAttributes'])->name('admin.add_attributes');
        Route::post('edit_attributes/{id}', [ProductController::class, 'editAttributes'])->name('admin.edit_attributes');
        Route::post('update-attribute-status', [ProductController::class, 'updateAttributeStatus']);
        Route::get('delete_attribute/{id}', [ProductController::class,'deleteAttribute'])->name('admin.delete.attribute');

        // Product Images
        Route::match(['get', 'post'], 'add-images/{id}', [ProductController::class, 'addImagess'])->name('admin.add_images');
        Route::post('update-image-status', [ProductController::class, 'updateImageStatus']);
        Route::get('delete_image/{id}', [ProductController::class,'deleteImage'])->name('admin.delete.image');
        Route::post('edit_images/{id}', [ProductController::class,'editImages'])->name('admin.edit_images');

        //Products Tools
        // Fabric routes
        Route::get('fabric', [FabricController::class,'fabric'])->name('admin.fabric');
        Route::post('/update-fabric-status', [FabricController::class,'updateFabricStatus']);
        Route::match(['get', 'post'], 'add-edit-fabric/{id?}', [FabricController::class,'addEditFabric'])->name('admin.add.edit.fabric');
        Route::get('delete_fabric/{id}', [FabricController::class,'deleteFabrics'])->name('admin.delete.fabric');

        // Sleeve routes
        Route::get('sleeve', [SleeveController::class,'sleeve'])->name('admin.sleeve');
        Route::post('/update-sleeve-status', [SleeveController::class,'updateSleeveStatus']);
        Route::match(['get', 'post'], 'add-edit-sleeve/{id?}', [SleeveController::class,'addEditSleeve'])->name('admin.add.edit.sleeve');
        Route::get('delete_sleeve/{id}', [SleeveController::class,'deleteSleeve'])->name('admin.delete.sleeve');

        // Fit routes
        Route::get('fit', [FitController::class,'fit'])->name('admin.fit');
        Route::post('/update-fit-status', [FitController::class,'updateFitStatus']);
        Route::match(['get', 'post'], 'add-edit-fit/{id?}', [FitController::class,'addEditFit'])->name('admin.add.edit.fit');
        Route::get('delete_fit/{id}', [FitController::class,'deleteFits'])->name('admin.delete.fit');

        // Pattern routes
        Route::get('pattern', [PatternController::class, 'pattern'])->name('admin.pattern');
        Route::post('/update-pattern-status', [PatternController::class, 'updatePatternStatus']);
        Route::match(['get', 'post'], 'add-edit-pattern/{id?}', [PatternController::class, 'addEditPattern'])->name('admin.add.edit.pattern');
        Route::get('delete_pattern/{id}', [PatternController::class, 'deletePatterns'])->name('admin.delete.pattern');

        // Occasion routes
        Route::get('occasion', [OccasionController::class, 'occasion'])->name('admin.occasion');
        Route::post('/update-occasion-status', [OccasionController::class, 'updateOccasionStatus']);
        Route::match(['get', 'post'], 'add-edit-occasion/{id?}', [OccasionController::class, 'addEditOccasion'])->name('admin.add.edit.occasion');
        Route::get('delete_occasion/{id}', [OccasionController::class, 'deleteOccasions'])->name('admin.delete.occasion');

        // Country routes
        Route::get('country', [CountryController::class, 'country'])->name('admin.country');
        Route::post('/update-country-status', [CountryController::class, 'updateCountryStatus']);
        Route::match(['get', 'post'], 'add-edit-country/{id?}', [CountryController::class, 'addEditCountry'])->name('admin.add.edit.country');
        Route::get('delete_country/{id}', [CountryController::class, 'deleteCountry'])->name('admin.delete.country');

        // Codpincodes routes
        Route::get('codpincode', [CodpincodeController::class, 'codpincode'])->name('admin.codpincode');
        Route::post('/update-codpincode-status', [CodpincodeController::class, 'updateCodpincodeStatus']);
        Route::match(['get', 'post'], 'add-edit-codpincode/{id?}', [CodpincodeController::class, 'addEditCodpincode'])->name('admin.add.edit.codpincode');
        Route::get('delete_codpincode/{id}', [CodpincodeController::class, 'deleteCodpincode'])->name('admin.delete.codpincode');

        // Prepaidpincodes routes
        Route::get('prepaidpincode', [PrepaidpincodeController::class,'prepaidpincode'])->name('admin.prepaidpincode');
        Route::post('/update-prepaidpincode-status', [PrepaidpincodeController::class,'updatePrepaidpincodeStatus']);
        Route::match(['get', 'post'], 'add-edit-prepaidpincode/{id?}', [PrepaidpincodeController::class,'addEditPrepaidpincode'])->name('admin.add.edit.prepaidpincode');
        Route::get('delete_prepaidpincode/{id}', [PrepaidpincodeController::class,'deletePrepaidpincode'])->name('admin.delete.prepaidpincode');

        // Media routes
        Route::get('media', [MediaController::class, 'media'])->name('admin.media');
        Route::post('/update-media-status', [MediaController::class, 'updateMediaStatus']);
        Route::match(['get', 'post'], 'add-edit-media/{id?}', [MediaController::class, 'addEditMedia'])->name('admin.add.edit.media');
        Route::get('delete_media/{id}', [MediaController::class, 'deleteMedia'])->name('admin.delete.media');

        //Banners
        Route::get('banners', [BannerController::class, 'banners'])->name('admin.banners');
        Route::post('/update-banner-status', [BannerController::class, 'updateBannerStatus']);
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', [BannerController::class,'addEditBanner'])->name('admin.add.edit.banners');
        Route::get('delete_banner/{id}', [BannerController::class, 'deleteBanners'])->name('admin.delete.banner');

        //Coupons
        Route::get('coupons', [CouponController::class,'coupons'])->name('admin.coupons');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}',[CouponController::class,'addEditCoupon'])->name('admin.add.edit.coupons');
        Route::post('/update-coupon-status', [CouponController::class,'updateCouponStatus']);
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', [CouponController::class,'addEditCoupon'])->name('admin.add.edit.coupons');
        Route::get('delete_coupon/{id}', [CouponController::class,'deleteCoupon'])->name('admin.delete.coupon');

        // Admin Orders
        Route::get('/orders',[OrderssController::class,'orders'])->name('admin.orders');
        Route::get('/orders/details/{id}',[OrderssController::class,'ordersDetails'])->name('admin.orders.details');
        Route::post('/update/orders/status',[OrderssController::class,'updateOrdersStaus'])->name('admin.update.orderstatus');
        Route::get('/view/orders/invoice/{id}',[OrderssController::class,'viewOrdersInvoice'])->name('admin.view.orders.invoice');
        Route::get('/print/pdf/invoice/{id}',[OrderssController::class,'printPdfInvoice'])->name('admin.print.pdf.invoice');

        //Orders Exports
        Route::get('export/orders', [OrderssController::class, 'exportOrders'])->name('admin.export.orders');

        // view orders charts
        Route::get('view-orders-charts', [OrderssController::class, 'viewOrdersCharts'])->name('view.orders.charts');

        // Shipping charges
        Route::get('/view/shipping/charges',[ShippingController::class, 'viewShippingCharges'])->name('admin.shipping.charges');
        Route::match(['get', 'post'],'/edit/shipping/charges/{id}',[ShippingController::class, 'updateShippingCharges'])->name('admin.update.shipping.charges');
        Route::post('/update-shipping-status', [ShippingController::class, 'updateShippingStatus']);

        // Users
        Route::get('/users', [UserController::class, 'users'])->name('admin.users');
        Route::post('/update-user-status', [UserController::class,'updateUserStatus']);

        // view users charts
        Route::get('view-users-charts', [UserController::class, 'viewUsersCharts'])->name('view.users.charts');
        Route::get('view-users-countries', [UserController::class, 'viewUsersCountries'])->name('view.users.countries');

        //User exports
        Route::get('export/users', [UserController::class, 'exportUsers'])->name('admin.export.users');

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

        //Ratings Routes
        Route::get('/ratings', [RatingController::class, 'ratings'])->name('admin.ratings');
        Route::post('/update-rating-status', [RatingController::class, 'updatRatingStatus']);

        //Return Requests
        Route::get('/return-requests',[OrderssController::class,'returnRequest'])->name('admin.return.requests');
        Route::post('/return-requests-update',[OrderssController::class,'returnRequestUpdate'])->name('admin.return.requests.update');

        //Exchange Requests
        Route::get('/exchange-requests',[OrderssController::class,'exchangeRequest'])->name('admin.exchange.requests');
        Route::post('/exchange-requests-update',[OrderssController::class,'exchangeRequestUpdate'])->name('admin.exchange.requests.update');

        //Exchange Requests
        Route::get('/newsletter-subscriber',[AdminSubscriberController::class,'newsletterSubscriber'])->name('admin.newsletter.subscriber');
        Route::post('/update-subscriber-status', [AdminSubscriberController::class, 'updateSubscriberStatus'])->name('admin.update.subscriber.status');
        Route::get('delete_subscriber/{id}', [AdminSubscriberController::class, 'deleteSubscriber'])->name('admin.delete.subscriber');
        Route::get('export-newsletter-emails', [AdminSubscriberController::class, 'exportNewslettermails'])->name('admin.export.newsletter.emails');

        // import COD pincode
        Route::match(['get', 'post'], 'update-cod-pincodes', [ImportController::class,'addEditCodPincode'])->name('admin.add.edit.cod.pincodes');

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

    // new product route
    Route::get('new/product', [ProductsController::class, 'newProduct'])->name('front.new.product');

    // new product route
    Route::get('topsellers/product', [ProductsController::class, 'topSellersProduct'])->name('front.top.sellers.product');

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

    // User email check and password confirmation
    Route::match(['get','post'],'/check-email',[UsersController::class, 'checkEmail'])->name('front.check_email');
    Route::match(['get','post'],'/confirm/{code}',[UsersController::class, 'confirmAccount'])->name('front.confirm');
    Route::match(['get','post'],'/forgot/password',[UsersController::class, 'forgotPassword'])->name('front.forgot.password');

    //check delivery pincode
    Route::post('/check-pincode',[ProductsController::class, 'checkPincode'])->name('front.check.pincode');

    // Search Product
    Route::get('/search/product', [ProductsController::class, 'listing'])->name('front.product.search');

    // Contact us
    Route::match(['get','post'],'/contact',[CmsPageController::class, 'contactUs'])->name('front.contactus');

     // Rating add
    Route::match(['get','post'],'/add-rating', [RatingsController::class, 'addRating'])->name('front.add.rating');

    //Subscriber route
    Route::post('/add-subscriber-email',[FrontSubscriberController::class,'addSubscriber'])->name('admin.add.subscriber.email');

    // Front user auth route
        Route::group(['middleware' =>['auth']],function () {
        Route::post('/check-password',[UsersController::class, 'checkUserPassword'])->name('front.check.user.password');
        Route::post('/update-password',[UsersController::class, 'updateUserPassword'])->name('front.update.user.password');
        Route::match(['get','post'],'/account',[UsersController::class, 'account'])->name('front.account');

        // User Orders
        Route::get('/orders',[OrdersController::class,'orders'])->name('front.orders');
        Route::get('/orders-details/{id}',[OrdersController::class,'ordersDetails'])->name('front.orders.details');
        Route::match(['get','post'],'/orders-cancel/{id}',[OrdersController::class,'ordersCancel'])->name('front.orders.cancel');
        Route::match(['get','post'],'/orders-return/{id}',[OrdersController::class,'ordersReturn'])->name('front.orders.return');
        Route::post('/get-product-size',[OrdersController::class,'getProductSize'])->name('front.get.product.size');

        // Applay Voupon
        Route::post('/apply-coupon',[ProductsController::class, 'applyCoupon']);
        Route::match(['get','post'],'/checkout',[ProductsController::class, 'checkOut'])->name('front.checkout');
        Route::match(['get','post'],'/add-edit-delivery-address/{id?}',[ProductsController::class, 'addEditDeliveryAddress'])->name('front.add.edit.delivery.address');
        Route::get('/delete-delivery-address/{id}',[ProductsController::class, 'deleteDeliveryAddress'])->name('front.delete.delivery.address');
        Route::get('/thanks',[ProductsController::class, 'thanks'])->name('front.thanks');

        //Applay Paypal
        Route::get('/paypal',[PaypalController::class, 'paypal'])->name('front.paypal');
        Route::get('/paypal/success',[PaypalController::class, 'success'])->name('front.paypal.success');
        Route::get('/paypal/fail',[PaypalController::class, 'fail'])->name('front.paypal.fail');
        Route::post('/paypal/ipn',[PaypalController::class, 'ipn'])->name('front.paypal.ipn');

        //Paymoney


        // Wishlist
        Route::post('/update-wishlist',[ProductsController::class, 'updateWishList'])->name('front.update.wishlist');
        Route::get('/wishlist/list', [ProductsController::class, 'wishlistList'])->name('front.wishlist.list');
        Route::post('/delete-wishlist-item', [ProductsController::class, 'deleteWishlishItem'])->name('front.delete.wishlist.item');

        // Bkash
        Route::post('/bkash',[PaypalController::class, 'bkash'])->name('front.bkash');

    });

});
