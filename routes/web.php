<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController       as AdminProductController;
use App\Http\Controllers\Admin\OrderController         as AdminOrderController;
use App\Http\Controllers\Admin\ReturnRequestController as AdminReturnRequestController;
use App\Http\Controllers\Admin\UserController          as AdminUserController;
use App\Http\Controllers\Admin\ReportController        as AdminReportController;
use App\Http\Controllers\Admin\BannerController        as AdminBannerController;
use App\Http\Controllers\Admin\ReviewController        as AdminReviewController;
use App\Http\Controllers\Admin\ContactController       as AdminContactController;
use App\Http\Controllers\Admin\ShippingFeeController   as AdminShippingFeeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;


// Front controllers
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\CompareController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\ReturnRequestController as FrontReturnRequestController;
use App\Http\Controllers\Front\CouponController as FrontCouponController;
use App\Http\Controllers\Front\NotificationController;
use App\Http\Controllers\Front\ProductController       as FrontProductController;
use App\Http\Controllers\Front\ReviewController        as FrontReviewController;
use App\Http\Controllers\Front\WishlistController      as FrontWishlistController;
use App\Http\Controllers\Front\CartController          as FrontCartController;
use App\Http\Controllers\Front\CheckoutController      as FrontCheckoutController;
use App\Http\Controllers\Front\OrderController         as FrontOrderController;
use App\Http\Controllers\Front\ContactController       as FrontContactController;
use App\Http\Controllers\Front\AddressController       as FrontAddressController;
use App\Http\Controllers\Front\ProfileController       as FrontProfileController;
use App\Http\Controllers\Front\SpinController;


use App\Http\Controllers\Api\ShippingFeeApiController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Notifications\DatabaseNotification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Frontend
Route::get('/',               [HomeController::class,          'index'])->name('home');
Route::get('/about',          [AboutController::class,         'index'])->name('about');
Route::view('/careers',       'front.careers')->name('careers');
Route::view('/policy/warranty','front.policy.warranty')->name('policy.warranty');

Route::get('/post', [PostController::class, 'index'])->name('posts.index');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/products',       [FrontProductController::class,  'index'])->name('products.index');
Route::get('/products-autocomplete', [FrontProductController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/products/{slug}',[FrontProductController::class,  'show'])->name('products.show');

Route::get('/contact',        [FrontContactController::class,  'create'])->name('contact.create');
Route::post('/contact',       [FrontContactController::class,  'store'])->name('contact.store');

Route::post('/buy-now', [FrontCartController::class, 'buyNow'])->name('cart.buyNow');

// Đặt hàng nhanh - không cần đăng nhập
Route::get('/quick-order', [FrontOrderController::class, 'quickOrderForm'])->name('orders.quick');
Route::post('/quick-order', [FrontOrderController::class, 'submitQuickOrder'])->name('orders.quick.submit');
  Route::get('/checkout/thankyou/{order}', [FrontCheckoutController::class, 'thankyou'])->name('checkout.thankyou');


//TRA CỨU ĐƠN
 Route::get('/track-order', [FrontOrderController::class, 'showTrackingForm'])->name('orders.track');
Route::post('/track-order', [FrontOrderController::class, 'track'])->name('orders.track.submit');

//cart
 Route::get   ('/cart',          [FrontCartController::class,   'index'])->name('cart.index');
    Route::post  ('/cart',          [FrontCartController::class,   'store'])->name('cart.store');
    Route::patch ('/cart/{rowId}',  [FrontCartController::class,   'update'])->name('cart.update');
    Route::delete('/cart/{rowId}',  [FrontCartController::class,   'destroy'])->name('cart.destroy');




// Auth-required Frontend
Route::middleware('auth')->group(function(){
    // Reviews
    Route::post   ('/products/{slug}/reviews',          [FrontReviewController::class,'store'])
         ->name('products.reviews.store');
    Route::put    ('/products/{slug}/reviews/{review}', [FrontReviewController::class,'update'])
         ->name('products.reviews.update');
    Route::delete ('/products/{slug}/reviews/{review}', [FrontReviewController::class,'destroy'])
         ->name('products.reviews.destroy');


    // Cart & Checkout & Orders


    Route::get   ('/checkout',      [FrontCheckoutController::class,'index'])->name('checkout.index');
    Route::post  ('/checkout',      [FrontCheckoutController::class,'store'])->name('checkout.store');

    // Wishlist
    Route::get    ('/wishlist',    [FrontWishlistController::class,'index'])->name('wishlist.index');
    Route::post   ('/wishlist/{slug}', [FrontWishlistController::class,'store'])->name('wishlist.store');
    Route::delete ('/wishlist/{slug}', [FrontWishlistController::class,'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/toggle/{product}', [FrontWishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/count', [FrontWishlistController::class, 'count'])->name('wishlist.count');


    Route::get   ('/orders',        [FrontOrderController::class,  'index'])->name('orders.index');
    Route::post('/orders/{id}/reorder', [FrontOrderController::class, 'reorder'])->name('orders.reorder');
    Route::put('/orders/{order}/cancel', [FrontOrderController::class, 'cancel'])->name('orders.cancel');
    Route::put('/orders/{order}/address', [FrontOrderController::class, 'updateAddress'])->name('orders.updateAddress');

    Route::put('/orders/{order}/confirm', [FrontOrderController::class, 'confirmReceived'])->name('orders.confirm');


        // Return Requests (Yêu cầu hoàn/trả hàng)
    Route::get   ('/returns/create/{order}', [FrontReturnRequestController::class, 'create']) ->name('returns.create');
    Route::post  ('/returns/{order}',         [FrontReturnRequestController::class, 'store'])  ->name('returns.store');
    Route::get('returns/{return}', [FrontReturnRequestController::class, 'show'])->name('returns.show');


    Route::post('/coupon/apply', [FrontCouponController::class, 'apply'])->name('coupon.apply');
    Route::get('/coupon/remove', [FrontCouponController::class, 'remove'])->name('coupon.remove');


    // My Contacts
    Route::get   ('/my-contacts',           [FrontContactController::class,'index'])->name('contacts.index');
    Route::get   ('/my-contacts/{contact}', [FrontContactController::class,'show'])->name('contacts.show');

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Addresses
    Route::resource('profile/addresses', FrontAddressController::class)
         ->names('addresses')     // addresses.index, addresses.create...
         ->except(['show']);

    //vòng quay may mắn
    Route::get('/spin', [SpinController::class, 'index'])->name('spin.index');
    Route::post('/spin/play', [SpinController::class, 'spin'])->name('spin.play');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Profile (Front)
    Route::prefix('profile')->name('front.profile.')->group(function(){
        Route::get   ('',         [FrontProfileController::class,'edit'])           ->name('edit');
        Route::patch ('',         [FrontProfileController::class,'update'])         ->name('update');
        Route::post  ('password', [FrontProfileController::class,'changePassword'])->name('password');
        Route::delete('',         [FrontProfileController::class,'destroy'])        ->name('destroy');
    });
});

// Route API lấy phí ship theo tỉnh
         Route::get('/api/shipping-fee', [ShippingFeeApiController::class, 'getFeeByProvince']);

         // so sánh
    Route::prefix('compare')->group(function () {
        Route::get('/', [CompareController::class, 'index'])->name('compare.index');
        Route::post('/add/{id}', [CompareController::class, 'add'])->name('compare.add');
        Route::delete('/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');
        Route::post('/clear', [CompareController::class, 'clear'])->name('compare.clear');
});

// Google Login
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

// Authentication (Laravel Breeze)
require __DIR__.'/auth.php';

// Admin Backend
Route::middleware(['auth','is_admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

         Route::resource('categories', CategoryController::class);
         Route::resource('products',   AdminProductController::class);
         Route::resource('orders',     AdminOrderController::class)
              ->only(['index','show','update']);
        Route::get('orders/{order}/print', [AdminOrderController::class, 'print'])->name('orders.print');

         Route::resource('users',      AdminUserController::class)
              ->only(['index','edit','update','destroy']);
         Route::resource('banners',    AdminBannerController::class);
         // Route admin phí vận chuyển
         Route::resource('shipping_fees',AdminShippingFeeController::class)->except(['show']);
         Route::resource('reviews',    AdminReviewController::class)
              ->only(['index','show','destroy']);

        Route::post('reviews/{review}/reply', [AdminReviewController::class, 'reply'])->name('reviews.reply');

        // Quản lý tồn kho
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::post('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');

// Lịch sử nhập kho
Route::get('/inventory/logs', [InventoryController::class, 'logs'])->name('inventory.logs');
Route::get('/inventory/{id}/logs', [InventoryController::class, 'logsByVariant'])->name('inventory.logs.by_variant');
Route::get('/inventory/logs/export', [InventoryController::class, 'exportLogs'])->name('inventory.logs.export');



        Route::resource('returns',AdminReturnRequestController::class)->except(['show']);


        Route::resource('coupons', CouponController::class)->except(['show']);

        Route::resource('flash-sales', FlashSaleController::class)->except(['show']);

         Route::get   ('contacts',           [AdminContactController::class,'index'])->name('contacts.index');
         Route::get   ('contacts/{contact}', [AdminContactController::class,'show'])->name('contacts.show');
         Route::post  ('contacts/{contact}/reply', [AdminContactController::class,'reply'])->name('contacts.reply');

         Route::get('reports/sales',         [AdminReportController::class,'sales'])->name('reports.sales');
         Route::get('reports/sales/export',  [AdminReportController::class,'exportSales'])->name('reports.sales.export');
         Route::get('reports/orders',        [AdminReportController::class,'orders'])->name('reports.orders');
         Route::get('reports/orders/export', [AdminReportController::class,'exportOrders'])->name('reports.orders.export');

         Route::resource('posts', AdminPostController::class);
        Route::post('notifications/{id}/read', function ($id) {
    $notification = \Illuminate\Notifications\DatabaseNotification::where('notifiable_id', auth()->id())
                ->where('id', $id)->firstOrFail();
    $notification->markAsRead();
    return response()->noContent();
})->name('admin.notifications.read');

});


