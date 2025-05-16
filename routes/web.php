<?php

use App\Http\Controllers\Admin\Content\BannerController;
use App\Http\Controllers\Admin\Content\FaqController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Market\BrandController;
use App\Http\Controllers\Admin\Market\CityController;
use App\Http\Controllers\Admin\Market\CommentController;
use App\Http\Controllers\Admin\Market\DeliveryController;
use App\Http\Controllers\Admin\Market\DiscountController;
use App\Http\Controllers\Admin\Market\GalleryController;
use App\Http\Controllers\Admin\Market\OrderController;
use App\Http\Controllers\Admin\Market\ProductPropertiesController;
use App\Http\Controllers\Admin\Market\ProvinceController;
use App\Http\Controllers\Customer\Profile\CompareController;
use App\Http\Controllers\Customer\Profile\FavoriteController;
use App\Http\Controllers\Customer\Profile\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\Market\PaymentController;
use App\Http\Controllers\Customer\Profile\ProfileAddressController;
use App\Http\Controllers\Customer\Profile\ProfileController;
use App\Http\Controllers\Customer\Profile\ProfileTicketController;
use App\Http\Controllers\Customer\SalesProcess\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Admin\Market\ProductColorController;
use App\Http\Controllers\Admin\Market\ProductController;
use App\Http\Controllers\Customer\Market\ProductController as CustomerProductController;
use App\Http\Controllers\Admin\Market\ProductGuaranteeController;
use App\Http\Controllers\Admin\Market\PropertyController;
use App\Http\Controllers\Admin\Market\PropertyValueController;
use App\Http\Controllers\Admin\Market\StoreController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Notify\EmailController;
use App\Http\Controllers\Admin\Notify\EmailFileController;
use App\Http\Controllers\Admin\Notify\SmsController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Admin\Ticket\TicketCategoryController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use App\Http\Controllers\Admin\Ticket\TicketPriorityController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Auth\Customer\LoginRegisterController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\SalesProcess\AddressController;
use App\Http\Controllers\Customer\SalesProcess\CartController;
use App\Http\Controllers\Customer\SalesProcess\ProfileCompletionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Market\CategoryController;
use App\Http\Controllers\Admin\Content\CategoryController as ContentCategoryController;
use App\Http\Controllers\Admin\Content\CommentController as ContentCommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// admin 
Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');


    // --/market/
    Route::prefix('market')->namespace('Market')->group(function () {
        // category
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.market.category.index');
            Route::get('/search', [CategoryController::class, 'search'])->name('admin.market.category.search');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.market.category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.market.category.store');
            Route::get('/status/{category}', [CategoryController::class, 'status'])->name('admin.market.category.status');
            Route::get('/show-in-menu/{category}', [CategoryController::class, 'showInMenu'])->name('admin.market.category.showInMenu');
            Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('admin.market.category.edit');
            Route::put('/update/{category}', [CategoryController::class, 'update'])->name('admin.market.category.update');
            Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('admin.market.category.destroy');
        });

        // brand

        Route::prefix('brand')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.market.brand.index');
            Route::get('/search', [BrandController::class, 'search'])->name('admin.market.brand.search');
            Route::get('/create', [BrandController::class, 'create'])->name('admin.market.brand.create');
            Route::post('/store', [BrandController::class, 'store'])->name('admin.market.brand.store');
            Route::get('/status/{brand}', [BrandController::class, 'status'])->name('admin.market.brand.status');
            Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('admin.market.brand.edit');
            Route::put('/update/{brand}', [BrandController::class, 'update'])->name('admin.market.brand.update');
            Route::delete('/destroy/{brand}', [BrandController::class, 'destroy'])->name('admin.market.brand.destroy');
        });

        // comment
        Route::prefix('comment')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('admin.market.comment.index');
            Route::get('/search', [CommentController::class, 'search'])->name('admin.market.comment.search');
            Route::get('/show/{comment}', [CommentController::class, 'show'])->name('admin.market.comment.show');
            Route::post('/answer/{comment}', [CommentController::class, 'answer'])->name('admin.market.comment.answer');
            Route::get('/status/{comment}', [CommentController::class, 'status'])->name('admin.market.comment.status');
            Route::get('/approved/{comment}', [CommentController::class, 'approved'])->name('admin.market.comment.approved');

        });

        // delivery
        Route::prefix('delivery')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('admin.market.delivery.index');
            Route::get('/search', [DeliveryController::class, 'search'])->name('admin.market.delivery.search');
            Route::get('/create', [DeliveryController::class, 'create'])->name('admin.market.delivery.create');
            Route::post('/store', [DeliveryController::class, 'store'])->name('admin.market.delivery.store');
            Route::get('/edit/{delivery}', [DeliveryController::class, 'edit'])->name('admin.market.delivery.edit');
            Route::get('/status/{delivery}', [DeliveryController::class, 'status'])->name('admin.market.delivery.status');
            Route::put('/update/{delivery}', [DeliveryController::class, 'update'])->name('admin.market.delivery.update');
            Route::delete('/destroy/{delivery}', [DeliveryController::class, 'destroy'])->name('admin.market.delivery.destroy');


            Route::prefix('province')->group(function () {
                Route::get('/', [ProvinceController::class, 'index'])->name('admin.market.delivery-province.index');
                Route::get('/search', [ProvinceController::class, 'search'])->name('admin.market.delivery-province.search');
                Route::get('/create', [ProvinceController::class, 'create'])->name('admin.market.delivery-province.create');
                Route::post('/store', [ProvinceController::class, 'store'])->name('admin.market.delivery-province.store');
                Route::get('/edit/{province}', [ProvinceController::class, 'edit'])->name('admin.market.delivery-province.edit');
                Route::get('/{province}/cities', [ProvinceController::class, 'cities'])->name('admin.market.delivery-province.cities');
                Route::put('/update/{province}', [ProvinceController::class, 'update'])->name('admin.market.delivery-province.update');
                Route::delete('/destroy/{province}', [ProvinceController::class, 'destroy'])->name('admin.market.delivery-province.destroy');

            });


            Route::prefix('city')->group(function () {
                Route::get('/search/{province}', [CityController::class, 'search'])->name('admin.market.delivery-city.search');
                Route::get('/create/{province}', [CityController::class, 'create'])->name('admin.market.delivery-city.create');
                Route::post('/store/{province}', [CityController::class, 'store'])->name('admin.market.delivery-city.store');
                Route::get('/edit/{city}', [CityController::class, 'edit'])->name('admin.market.delivery-city.edit');
                Route::put('/update/{city}', [CityController::class, 'update'])->name('admin.market.delivery-city.update');
                Route::delete('/destroy/{city}', [CityController::class, 'destroy'])->name('admin.market.delivery-city.destroy');

            });
        });

        // discount
        Route::prefix('discount')->group(function () {
            Route::get('/copan', [DiscountController::class, 'copan'])->name('admin.market.discount.copan');
            Route::get('/copan/search', [DiscountController::class, 'copanSearch'])->name('admin.market.discount.copan.search');
            Route::get('/copan/create', [DiscountController::class, 'copanCreate'])->name('admin.market.discount.copan.create');
            Route::post('/copan/store', [DiscountController::class, 'copanStore'])->name('admin.market.discount.copan.store');
            Route::get('/copan/edit/{copan}', [DiscountController::class, 'copanEdit'])->name('admin.market.discount.copan.edit');
            Route::delete('/copan/destroy/{copan}', [DiscountController::class, 'copanDestroy'])->name('admin.market.discount.copan.destroy');
            Route::put('/copan/update/{copan}', [DiscountController::class, 'copanUpdate'])->name('admin.market.discount.copan.update');
            Route::get('/common-discount', [DiscountController::class, 'commonDiscount'])->name('admin.market.discount.commonDiscount');
            Route::get('/common-discount/search', [DiscountController::class, 'commonDiscountSearch'])->name('admin.market.discount.commonDiscount.search');
            Route::get('/common-discount/create', [DiscountController::class, 'commonDiscountCreate'])->name('admin.market.discount.commonDiscount.create');
            Route::post('/common-discount/store', [DiscountController::class, 'commonDiscountStore'])->name('admin.market.discount.commonDiscount.store');
            Route::get('/common-discount/edit/{commonDiscount}', [DiscountController::class, 'commonDiscountEdit'])->name('admin.market.discount.commonDiscount.edit');
            Route::put('/common-discount/update/{commonDiscount}', [DiscountController::class, 'commonDiscountUpdate'])->name('admin.market.discount.commonDiscount.update');
            Route::delete('/common-discount/destroy/{commonDiscount}', [DiscountController::class, 'commonDiscountDestroy'])->name('admin.market.discount.commonDiscount.destroy');
            Route::get('/amazing-sale', [DiscountController::class, 'amazingSale'])->name('admin.market.discount.amazingSale');
            Route::get('/amazing-sale/search', [DiscountController::class, 'amazingSaleSearch'])->name('admin.market.discount.amazingSale.search');
            Route::get('/amazing-sale/create', [DiscountController::class, 'amazingSaleCreate'])->name('admin.market.discount.amazingSale.create');
            Route::post('/amazing-sale/store', [DiscountController::class, 'amazingSaleStore'])->name('admin.market.discount.amazingSale.store');
            Route::get('/amazing-sale/edit/{amazingSale}', [DiscountController::class, 'amazingSaleEdit'])->name('admin.market.discount.amazingSale.edit');
            Route::put('/amazing-sale/update/{amazingSale}', [DiscountController::class, 'amazingSaleUpdate'])->name('admin.market.discount.amazingSale.update');
            Route::delete('/amazing-sale/destroy/{amazingSale}', [DiscountController::class, 'amazingSaleDestroy'])->name('admin.market.discount.amazingSale.destroy');
            Route::get('/copan-status/{copan}', [DiscountController::class, 'copanStatus'])->name('admin.market.discount.copan-status');
            Route::get('/common-discount-status/{commonDiscount}', [DiscountController::class, 'commonDiscountStatus'])->name('admin.market.discount.commonDiscount-status');
            Route::get('/amazing-sale-status/{amazingSale}', [DiscountController::class, 'amazingSaleStatus'])->name('admin.market.discount.amazingSale-status');

        });

        // order
        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'all'])->name('admin.market.order.all');

            Route::get('/new-order', [OrderController::class, 'newOrder'])->name('admin.market.order.newOrder');

            Route::get('/unpaid', [OrderController::class, 'unpaidOrder'])->name('admin.market.order.unpaidOrder');

            Route::get('/sending', [OrderController::class, 'sendingOrder'])->name('admin.market.order.sendingOrder');

            Route::get('/canceled', [OrderController::class, 'canceledOrder'])->name('admin.market.order.canceledOrder');

            Route::get('/returned', [OrderController::class, 'returnedOrder'])->name('admin.market.order.returnedOrder');

            Route::get('/show/{order}', [OrderController::class, 'show'])->name('admin.market.order.show');
            Route::get('/detail/{order}', [OrderController::class, 'detail'])->name('admin.market.orde.detail');

            // Route::get('/create', [OrderController::class, 'create'])->name('admin.market.order.create');

            // Route::post('/store', [OrderController::class, 'store'])->name('admin.market.order.store');

            Route::get('/change-order-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('admin.market.order.changeOrderStutus');
            Route::put('/tracking-post-code/{order}', [OrderController::class, 'postalTrackingCode'])->name('admin.market.order.postalTrackingCode');

            Route::get('/change-send-status/{order}', [OrderController::class, 'changeSendStatus'])->name('admin.market.order.changeSendStutus');

            Route::get('/cancel-order/{order}', [OrderController::class, 'cancelOrder'])->name('admin.market.order.cancelOrder');

            // Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('admin.market.order.edit');

            // Route::put('/update/{id}', [OrderController::class, 'update'])->name('admin.market.order.update');

            // Route::delete('/destroy/{id}', [OrderController::class, 'destroy'])->name('admin.market.order.destroy');
        });

        // payment
        Route::prefix('payment')->group(function () {
            Route::get('/', [PaymentController::class, 'all'])->name('admin.market.payment.all');

            Route::get('/online', [PaymentController::class, 'online'])->name('admin.market.payment.online');

            Route::get('/offline', [PaymentController::class, 'offline'])->name('admin.market.payment.offline');

            Route::get('/cash', [PaymentController::class, 'cash'])->name('admin.market.payment.cash');

            Route::get('/canceled/{payment}', [PaymentController::class, 'canceled'])->name('admin.market.payment.canceled');

            Route::get('/returned/{payment}', [PaymentController::class, 'returned'])->name('admin.market.payment.returned');

            Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('admin.market.payment.show');
        });

        // product
        Route::prefix('product')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.market.product.index');
            Route::get('/search', [ProductController::class, 'search'])->name('admin.market.product.search');
            Route::get('/status/{product}', [ProductController::class, 'status'])->name('admin.market.product.status');
            Route::get('/create', [ProductController::class, 'create'])->name('admin.market.product.create');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.market.product.store');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('admin.market.product.edit');
            Route::get('/show/{product}', [ProductController::class, 'show'])->name('admin.market.product.show');
            Route::put('/update/{product}', [ProductController::class, 'update'])->name('admin.market.product.update');
            Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('admin.market.product.destroy');
            Route::delete('/deletemeta/{meta}', [ProductController::class, 'deleteMeta'])->name('admin.market.product.deleteMeta');

            // properties
            Route::get('/properties/{product}', [ProductPropertiesController::class, 'properties'])->name('admin.market.product.properties');
            Route::get('/properties/search/{product}', [ProductPropertiesController::class, 'search'])->name('admin.market.product.properties-search');
            Route::post('/properties/{product}', [ProductPropertiesController::class, 'storeProperties'])->name('admin.market.product.properties.store');
            Route::put('/properties/{product}/{attribute}', [ProductPropertiesController::class, 'updateProperties'])->name('admin.market.product.properties.update');


            Route::get('/property-values/{product}/{attribute}', [ProductPropertiesController::class, 'propertyValues'])->name('admin.market.product.properties.values');
            Route::post('/property-value/store/{product}/{attribute}', [ProductPropertiesController::class, 'storePropertyValue'])->name('admin.market.product.properties.store-value');
            Route::put('/property-value/update/{value}', [ProductPropertiesController::class, 'updatePropertyValue'])->name('admin.market.product.properties.update-value');

            // product-color

            Route::get('/color/{product}', [ProductColorController::class, 'index'])->name('admin.market.product-color.index');
            Route::get('/color/search/{product}', [ProductColorController::class, 'search'])->name('admin.market.product-color.search');
            Route::post('/color/{product}/store', [ProductColorController::class, 'store'])->name('admin.market.product-color.store');
            Route::get('/color/status/{color}', [ProductColorController::class, 'status'])->name('admin.market.product-color.status');
            Route::put('/color/update/{product}/{color}', [ProductColorController::class, 'update'])->name('admin.market.product-color.update');
            Route::delete('/color/destroy/{product}/{color}', [ProductColorController::class, 'destroy'])->name('admin.market.product-color.destroy');

            // product-guarantee

            Route::get('/guarantee/{product}', [ProductGuaranteeController::class, 'index'])->name('admin.market.product-guarantee.index');
            Route::get('/guarantee/search/{product}', [ProductGuaranteeController::class, 'search'])->name('admin.market.product-guarantee.search');
            Route::get('/guarantee/{product}/create', [ProductGuaranteeController::class, 'create'])->name('admin.market.product-guarantee.create');
            Route::post('/guarantee/{product}/store', [ProductGuaranteeController::class, 'store'])->name('admin.market.product-guarantee.store');
            Route::get('/guarantee/status/{guarantee}', [ProductGuaranteeController::class, 'status'])->name('admin.market.product-guarantee.status');
            Route::get('/guarantee/edit/{product}/{guarantee}', [ProductGuaranteeController::class, 'edit'])->name('admin.market.product-guarantee.edit');
            Route::put('/guarantee/update/{product}/{guarantee}', [ProductGuaranteeController::class, 'update'])->name('admin.market.product-guarantee.update');
            Route::delete('/guarantee/destroy/{product}/{guarantee}', [ProductGuaranteeController::class, 'destroy'])->name('admin.market.product-guarantee.destroy');

            // gallery

            Route::get('/gallery/{product}', [GalleryController::class, 'index'])->name('admin.market.gallery.index');
            Route::get('/gallery/search/{product}', [GalleryController::class, 'search'])->name('admin.market.gallery.search');
            Route::get('/gallery/create/{product}', [GalleryController::class, 'create'])->name('admin.market.gallery.create');
            Route::post('/gallery/store/{product}', [GalleryController::class, 'store'])->name('admin.market.gallery.store');
            Route::get('/gallery/edit/{product}/{gallery}', [GalleryController::class, 'edit'])->name('admin.market.gallery.edit');
            Route::put('/gallery/update/{product}/{gallery}', [GalleryController::class, 'update'])->name('admin.market.gallery.update');
            Route::delete('/gallery/destroy/{product}/{gallery}', [GalleryController::class, 'destroy'])->name('admin.market.gallery.destroy');

        });


        // property
        Route::prefix('property')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('admin.market.property.index');
            Route::get('/search', [PropertyController::class, 'search'])->name('admin.market.property.search');
            Route::get('/create', [PropertyController::class, 'create'])->name('admin.market.property.create');
            Route::post('/store', [PropertyController::class, 'store'])->name('admin.market.property.store');
            Route::get('/edit/{attribute}', [PropertyController::class, 'edit'])->name('admin.market.property.edit');
            Route::put('/update/{attribute}', [PropertyController::class, 'update'])->name('admin.market.property.update');
            Route::delete('/destroy/{attribute}', [PropertyController::class, 'destroy'])->name('admin.market.property.destroy');


            // property-value

            Route::get('/value/{attribute}', [PropertyValueController::class, 'index'])->name('admin.market.property-value.index');
            Route::get('/value/{attribute}/create', [PropertyValueController::class, 'create'])->name('admin.market.property-value.create');
            Route::post('/value/{attribute}/store', [PropertyValueController::class, 'store'])->name('admin.market.property-value.store');
            Route::get('/value/edit/{attribute}/{value}', [PropertyValueController::class, 'edit'])->name('admin.market.property-value.edit');
            Route::put('/value/update/{attribute}/{value}', [PropertyValueController::class, 'update'])->name('admin.market.property-value.update');
            Route::delete('/value/destroy/{attribute}/{value}', [PropertyValueController::class, 'destroy'])->name('admin.market.property-value.destroy');



        });



        // store
        Route::prefix('store')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('admin.market.store.index');
            Route::get('/search', [StoreController::class, 'search'])->name('admin.market.store.search');
            Route::get('/add-to-store/{product}', [StoreController::class, 'addToStore'])->name('admin.market.store.addToStore');
            Route::post('/store/{product}', [StoreController::class, 'store'])->name('admin.market.store.store');
            Route::get('/edit/{product}', [StoreController::class, 'edit'])->name('admin.market.store.edit');
            Route::put('/update/{product}', [StoreController::class, 'update'])->name('admin.market.store.update');

        });


    });

    // --/content/
    Route::prefix('content')->namespace('Content')->group(function () {

        // category
        Route::prefix('category')->group(function () {
            Route::get('/', [ContentCategoryController::class, 'index'])->name('admin.content.category.index');
            Route::get('/search', [ContentCategoryController::class, 'search'])->name('admin.content.category.search');
            Route::get('/create', [ContentCategoryController::class, 'create'])->name('admin.content.category.create');
            // Route::get('/create', [ContentCategoryController::class, 'create'])->name('admin.content.category.create')->middleware('can:create, App\Models\Content\PostCategory');
            // Route::get('/create', [ContentCategoryController::class, 'create'])->name('admin.content.category.create')->can('create', Post::class);
            Route::post('/store', [ContentCategoryController::class, 'store'])->name('admin.content.category.store');
            Route::get('/edit/{postCategory}', [ContentCategoryController::class, 'edit'])->name('admin.content.category.edit');
            Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('admin.content.category.update');
            // Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('admin.content.category.update')->middleware('can:update,postCategory');
            // Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('admin.content.category.update')->can('update','postCategory');
            Route::get('/status/{postCategory}', [ContentCategoryController::class, 'status'])->name('admin.content.category.status');
            Route::delete('/destroy/{postCategory}', [ContentCategoryController::class, 'destroy'])->name('admin.content.category.destroy');
        });

        // banner
        Route::prefix('banner')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('admin.content.banner.index');
            Route::get('/search', [BannerController::class, 'search'])->name('admin.content.banner.search');
            Route::get('/create', [BannerController::class, 'create'])->name('admin.content.banner.create');
            Route::post('/store', [BannerController::class, 'store'])->name('admin.content.banner.store');
            Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('admin.content.banner.edit');
            Route::put('/update/{banner}', [BannerController::class, 'update'])->name('admin.content.banner.update');
            Route::get('/status/{banner}', [BannerController::class, 'status'])->name('admin.content.banner.status');
            Route::delete('/destroy/{banner}', [BannerController::class, 'destroy'])->name('admin.content.banner.destroy');
        });


        // comment
        Route::prefix('comment')->group(function () {
            Route::get('/', [ContentCommentController::class, 'index'])->name('admin.content.comment.index');
            Route::get('/search', [ContentCommentController::class, 'search'])->name('admin.content.comment.search');
            Route::get('/show/{comment}', [ContentCommentController::class, 'show'])->name('admin.content.comment.show');
            Route::get('/status/{comment}', [ContentCommentController::class, 'status'])->name('admin.content.comment.status');
            Route::get('/approved/{comment}', [ContentCommentController::class, 'approved'])->name('admin.content.comment.approved');
            Route::post('/answer/{comment}', [ContentCommentController::class, 'answer'])->name('admin.content.comment.answer');
            Route::get('/show/{comment}', [ContentCommentController::class, 'show'])->name('admin.content.comment.show');
            Route::delete('/destroy/{comment}', [ContentCommentController::class, 'destroy'])->name('admin.content.comment.destroy');

        });


        // faq
        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('admin.content.faq.index');
            Route::get('/search', [FaqController::class, 'search'])->name('admin.content.faq.search');
            Route::get('/create', [FaqController::class, 'create'])->name('admin.content.faq.create');
            Route::post('/store', [FaqController::class, 'store'])->name('admin.content.faq.store');
            Route::get('/show/{faq}', [FaqController::class, 'show'])->name('admin.content.faq.show');
            Route::get('/status/{faq}', [FaqController::class, 'status'])->name('admin.content.faq.status');
            Route::get('/edit/{faq}', [FaqController::class, 'edit'])->name('admin.content.faq.edit');
            Route::put('/update/{faq}', [FaqController::class, 'update'])->name('admin.content.faq.update');
            Route::delete('/destroy/{faq}', [FaqController::class, 'destroy'])->name('admin.content.faq.destroy');

        });



        // menu
        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('admin.content.menu.index');
            Route::get('/search', [MenuController::class, 'search'])->name('admin.content.menu.search');
            Route::get('/create', [MenuController::class, 'create'])->name('admin.content.menu.create');
            Route::post('/store', [MenuController::class, 'store'])->name('admin.content.menu.store');
            Route::get('/status/{menu}', [MenuController::class, 'status'])->name('admin.content.menu.status');
            Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('admin.content.menu.edit');
            Route::put('/update/{menu}', [MenuController::class, 'update'])->name('admin.content.menu.update');
            Route::delete('/destroy/{menu}', [MenuController::class, 'destroy'])->name('admin.content.menu.destroy');

        });

        // page
        Route::prefix('page')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('admin.content.page.index');
            Route::get('/search', [PageController::class, 'search'])->name('admin.content.page.search');
            Route::get('/create', [PageController::class, 'create'])->name('admin.content.page.create');
            Route::get('/show/{page}', [PageController::class, 'show'])->name('admin.content.page.show');
            Route::get('/status/{page}', [PageController::class, 'status'])->name('admin.content.page.status');
            Route::post('/store', [PageController::class, 'store'])->name('admin.content.page.store');
            Route::get('/edit/{page}', [PageController::class, 'edit'])->name('admin.content.page.edit');
            Route::put('/update/{page}', [PageController::class, 'update'])->name('admin.content.page.update');
            Route::delete('/destroy/{page}', [PageController::class, 'destroy'])->name('admin.content.page.destroy');

        });


        // post
        Route::prefix('post')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.content.post.index');
            Route::get('/search', [PostController::class, 'search'])->name('admin.content.post.search');
            Route::get('/create', [PostController::class, 'create'])->name('admin.content.post.create');
            Route::get('/show', [PostController::class, 'show'])->name('admin.content.post.show');
            Route::post('/store', [PostController::class, 'store'])->name('admin.content.post.store');
            Route::get('/edit/{post}', [PostController::class, 'edit'])->name('admin.content.post.edit');
            Route::get('/status/{post}', [PostController::class, 'status'])->name('admin.content.post.status');
            Route::get('/commentable/{post}', [PostController::class, 'commentable'])->name('admin.content.post.commentable');
            Route::put('/update/{post}', [PostController::class, 'update'])->name('admin.content.post.update');
            Route::delete('/destroy/{post}', [PostController::class, 'destroy'])->name('admin.content.post.destroy');

        });

    });

    // user
    Route::prefix('user')->namespace('User')->group(function () {
        // admin-user
        Route::prefix('admin-user')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.admin-user.index');
            Route::get('/search', [AdminUserController::class, 'search'])->name('admin.user.admin-user.search');
            Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.admin-user.create');
            Route::get('/status/{admin}', [AdminUserController::class, 'status'])->name('admin.user.admin-user.status');
            Route::get('/activation/{admin}', [AdminUserController::class, 'activation'])->name('admin.user.admin-user.activation');
            Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.admin-user.store');
            Route::get('/edit/{admin}', [AdminUserController::class, 'edit'])->name('admin.user.admin-user.edit');
            Route::put('/update/{admin}', [AdminUserController::class, 'update'])->name('admin.user.admin-user.update');
            Route::delete('/destroy/{admin}', [AdminUserController::class, 'destroy'])->name('admin.user.admin-user.destroy');
            Route::get('/roles/{admin}', [AdminUserController::class, 'roles'])->name('admin.user.admin-user.roles');
            Route::post('/roles/{admin}/store', [AdminUserController::class, 'rolesStore'])->name('admin.user.admin-user.roles-store');
            Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions'])->name('admin.user.admin-user.permissions');
            Route::post('/permissions/{admin}/store', [AdminUserController::class, 'permissionsStore'])->name('admin.user.admin-user.permissions-store');
        });

        // customer
        Route::prefix('customer')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('admin.user.customer.index');
            Route::get('/search', [CustomerController::class, 'search'])->name('admin.user.customer.search');
            Route::get('/create', [CustomerController::class, 'create'])->name('admin.user.customer.create');
            Route::post('/store', [CustomerController::class, 'store'])->name('admin.user.customer.store');
            Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('admin.user.customer.edit');
            Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('admin.user.customer.update');
            Route::delete('/destroy/{customer}', [CustomerController::class, 'destroy'])->name('admin.user.customer.destroy');
            Route::get('/status/{customer}', [CustomerController::class, 'status'])->name('admin.user.customer.status');
            Route::get('/activation/{customer}', [CustomerController::class, 'activation'])->name('admin.user.customer.activation');
        });

        // role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index');
            Route::get('/search', [RoleController::class, 'search'])->name('admin.user.role.search');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create');
            Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('admin.user.role.permission-form');
            Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.user.role.edit');
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.user.role.update');
            Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy');
            Route::put('/permission/{role}', [RoleController::class, 'permission'])->name('admin.user.role.permission');


        });


        // permission
        Route::prefix('permission')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
            Route::get('/search', [PermissionController::class, 'search'])->name('admin.user.permission.search');
            Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
            Route::get('/status/{permission}', [PermissionController::class, 'status'])->name('admin.user.permission.status');
            Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
            Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
            Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');

        });


    });

    // notify
    Route::prefix('notify')->namespace('Notify')->group(function () {
        // email
        Route::prefix('email')->group(function () {
            Route::get('/', [EmailController::class, 'index'])->name('admin.notify.email.index');
            Route::get('/search', [EmailController::class, 'search'])->name('admin.notify.email.search');
            Route::get('/create', [EmailController::class, 'create'])->name('admin.notify.email.create');
            Route::post('/store', [EmailController::class, 'store'])->name('admin.notify.email.store');
            Route::get('/status/{email}', [EmailController::class, 'status'])->name('admin.notify.email.status');
            Route::get('/show/{email}', [EmailController::class, 'show'])->name('admin.notify.email.show');
            Route::get('/edit/{email}', [EmailController::class, 'edit'])->name('admin.notify.email.edit');
            Route::put('/update/{email}', [EmailController::class, 'update'])->name('admin.notify.email.update');
            Route::delete('/destroy/{email}', [EmailController::class, 'destroy'])->name('admin.notify.email.destroy');
            Route::get('/send-mail/{email}', [EmailController::class, 'sendMail'])->name('admin.notify.email.send');

        });
        // email-file
        Route::prefix('email-file')->group(function () {
            Route::get('/{email}', [EmailFileController::class, 'index'])->name('admin.notify.email-file.index');
            Route::get('/search/{email}', [EmailFileController::class, 'search'])->name('admin.notify.email-file.search');
            Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('admin.notify.email-file.create');
            Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('admin.notify.email-file.store');
            Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('admin.notify.email-file.status');
            Route::get('/show/{file}', [EmailFileController::class, 'show'])->name('admin.notify.email-file.show');
            Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('admin.notify.email-file.edit');
            Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('admin.notify.email-file.update');
            Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('admin.notify.email-file.destroy');
            Route::get('/open-file/{file}', [EmailFileController::class, 'openFile'])->name('admin.notify.email-file.openFile');
        });

        // sms
        Route::prefix('sms')->group(function () {
            Route::get('/', [SmsController::class, 'index'])->name('admin.notify.sms.index');
            Route::get('/search', [SmsController::class, 'search'])->name('admin.notify.sms.search');
            Route::get('/create', [SmsController::class, 'create'])->name('admin.notify.sms.create');
            Route::get('/show', [SmsController::class, 'show'])->name('admin.notify.sms.show');
            Route::post('/store', [SmsController::class, 'store'])->name('admin.notify.sms.store');
            Route::get('/status/{sms}', [SmsController::class, 'status'])->name('admin.notify.sms.status');
            Route::get('/edit/{sms}', [SmsController::class, 'edit'])->name('admin.notify.sms.edit');
            Route::put('/update/{sms}', [SmsController::class, 'update'])->name('admin.notify.sms.update');
            Route::delete('/destroy/{sms}', [SmsController::class, 'destroy'])->name('admin.notify.sms.destroy');
            Route::get('/send-sms/{sms}', [SmsController::class, 'sendSms'])->name('admin.notify.sms.send');
        });


    });


    // ticket
    Route::prefix('ticket')->namespace('Ticket')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('admin.ticket.index');
        Route::get('/search', [TicketController::class, 'search'])->name('admin.ticket.search');
        Route::get('/new-tickets', [TicketController::class, 'newTickets'])->name('admin.ticket.newTickets');
        Route::get('/open-tickets', [TicketController::class, 'openTickets'])->name('admin.ticket.openTickets');
        Route::get('/close-tickets', [TicketController::class, 'closeTickets'])->name('admin.ticket.closeTickets');
        Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('admin.ticket.answer');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('admin.ticket.show');
        Route::get('/change/{ticket}', [TicketController::class, 'change'])->name('admin.ticket.change');




        // ticket-category
        Route::prefix('category')->namespace('Ticket')->group(function () {
            Route::get('/', [TicketCategoryController::class, 'index'])->name('admin.ticket.category.index');
            Route::get('/search', [TicketCategoryController::class, 'search'])->name('admin.ticket.category.search');
            Route::get('/create', [TicketCategoryController::class, 'create'])->name('admin.ticket.category.create');
            Route::get('/status/{ticketCategory}', [TicketCategoryController::class, 'status'])->name('admin.ticket.category.status');
            Route::post('/store', [TicketCategoryController::class, 'store'])->name('admin.ticket.category.store');
            Route::get('/edit/{ticketCategory}', [TicketCategoryController::class, 'edit'])->name('admin.ticket.category.edit');
            Route::put('/update/{ticketCategory}', [TicketCategoryController::class, 'update'])->name('admin.ticket.category.update');
            Route::delete('/destroy/{ticketCategory}', [TicketCategoryController::class, 'destroy'])->name('admin.ticket.category.destroy');

        });

        // ticket-priority
        Route::prefix('priority')->namespace('Ticket')->group(function () {
            Route::get('/', [TicketPriorityController::class, 'index'])->name('admin.ticket.priority.index');
            Route::get('/search', [TicketPriorityController::class, 'search'])->name('admin.ticket.priority.search');
            Route::get('/create', [TicketPriorityController::class, 'create'])->name('admin.ticket.priority.create');
            Route::get('/status/{ticketPriority}', [TicketPriorityController::class, 'status'])->name('admin.ticket.priority.status');
            Route::post('/store', [TicketPriorityController::class, 'store'])->name('admin.ticket.priority.store');
            Route::get('/edit/{ticketPriority}', [TicketPriorityController::class, 'edit'])->name('admin.ticket.priority.edit');
            Route::put('/update/{ticketPriority}', [TicketPriorityController::class, 'update'])->name('admin.ticket.priority.update');
            Route::delete('/destroy/{ticketPriority}', [TicketPriorityController::class, 'destroy'])->name('admin.ticket.priority.destroy');

        });
        // ticket-admin

        Route::prefix('admin')->namespace('Ticket')->group(function () {
            Route::get('/', [TicketAdminController::class, 'index'])->name('admin.ticket.admin.index');
            Route::get('/search', [TicketAdminController::class, 'search'])->name('admin.ticket.admin.search');
            Route::get('/set/{admin}', [TicketAdminController::class, 'set'])->name('admin.ticket.admin.set');


        });
    });

    // setting
    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.setting.index');
        Route::get('/edit', [SettingController::class, 'edit'])->name('admin.setting.edit');
        Route::put('/update', [SettingController::class, 'update'])->name('admin.setting.update');
    });

    Route::post('/notification/read-all', [NotificationController::class, 'readAll'])->name('admin.notification.readAll');

});

Route::get('/', [HomeController::class, 'home'])->name('customer.home');
Route::post('/autocomplete', [HomeController::class, 'autocomplete'])->name('customer.products.autocomplete');
Route::get('/products/{category:slug?}', [HomeController::class, 'products'])->name('customer.products');
Route::get('/page/{page:slug}', [HomeController::class, 'page'])->name('customer.page');

Route::
        namespace('SalesProcess')->group(function () {
            // cart
            Route::get('/cart', [CartController::class, 'cart'])->name('customer.sales-process.cart');
            Route::post('/cart', [CartController::class, 'updateCart'])->name('customer.sales-process.update-cart');
            Route::post('/add-to-cart/{product:slug}', [CartController::class, 'addToCart'])->name('customer.sales-process.add-to-cart');
            Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('customer.sales-process.remove-from-cart');

            // profile-completion
            Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('customer.sales-process.profile-completion');
            Route::post('/profile-completion', [ProfileCompletionController::class, 'updateProfile'])->name('customer.sales-process.profile-completion-update');
            Route::get('/confirm-profile-info/{token}', [ProfileCompletionController::class, 'confirmProfileInfoForm'])->name('customer.sales-process.profile-info-confirm-form');
            Route::post('/confirm-profile-info/{token}', [ProfileCompletionController::class, 'confirmProfileInfo'])->name('customer.sales-process.profile-info-confirm');
            Route::get('/resend-otp/{token}', [ProfileCompletionController::class, 'resendOtp'])->name('customer.sales-process.resend-otp');


            Route::middleware('profile.completion')->group(function () {
                // address
                Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('customer.sales-process.address-and-delivery');
                Route::post('/add-address', [AddressController::class, 'addAddress'])->name('customer.sales-process.add-address');
                Route::put('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('customer.sales-process.update-address');
                Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('customer.sales-process.get-cities');
                Route::post('/choose-address-and-delivery', [AddressController::class, 'chooseAddressAndDelivery'])->name('customer.sales-process.choose-address-and-delivery');

                // payment
                Route::get('/payment', [CustomerPaymentController::class, 'payment'])->name('customer.sales-process.payment');
                Route::post('/copan-discount', [CustomerPaymentController::class, 'copanDisount'])->name('customer.sales-process.copan-discount');
                Route::post('/payment-submit', [CustomerPaymentController::class, 'paymentSubmit'])->name('customer.sales-process.payment-submit');
                Route::any('/payment-callback/{order}/{onlinePayment}', [CustomerPaymentController::class, 'paymentCallback'])->name('customer.sales-process.payment-callback');

            });
        });



Route::
        namespace('Market')->group(function () {
            Route::get('/product/{product:slug}', [CustomerProductController::class, 'product'])->name('customer.market.product');
            Route::post('/product/add-comment/{product:slug}', [CustomerProductController::class, 'addComment'])->name('customer.market.add-comment');
            Route::get('/product/add-to-favorite/{product}', [CustomerProductController::class, 'addToFavorite'])->name('customer.market.add-to-favorite');
            Route::post('/product/add-rate/{product:slug}', [CustomerProductController::class, 'addRate'])->name('customer.market.add-rate');
            Route::get('/product/compare/{product}', [CustomerProductController::class, 'compare'])->name('customer.market.compare');
            Route::get('/product/add-to-compare/{product}', [CustomerProductController::class, 'addToCompare'])->name('customer.market.add-to-compare');
            Route::get('/product/remove-from-compare/{product}', [CustomerProductController::class, 'removeFromCompare'])->name('customer.market.remove-from-compare');

        });

Route::
        namespace('Auth')->group(function () {
            Route::get('/login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');
            Route::middleware('throttle:customer-login-register-limitter')->post('/login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.customer.login-register');
            Route::get('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');
            Route::middleware('throttle:customer-login-confirm-limitter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
            Route::middleware('throttle:customer-login-resend-otp-limitter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
            Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');

        });

Route::
        namespace('Profile')->group(function () {
            Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.profile.orders');
            Route::get('/order-factor/{order}', [CustomerOrderController::class, 'factor'])->name('customer.profile.order-factor');
            Route::get('/order-detail/{order}', [CustomerOrderController::class, 'detail'])->name('customer.profile.order-detail');
            Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('customer.profile.my-favorites');
            Route::get('/my-favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('customer.profile.my-favorites-remove');
            Route::get('/profile', [ProfileController::class, 'index'])->name('customer.profile.index');
            Route::put('/profile/update', [ProfileController::class, 'update'])->name('customer.profile.update');
            Route::get('/profile/user-contact-confirm/{token}', [ProfileController::class, 'userCantactConfirmForm'])->name('customer.profile.user-contact-confirm-form');
            Route::post('/profile/user-contact-confirm/{token}', [ProfileController::class, 'userCantactConfirm'])->name('customer.profile.user-contact-confirm');
            Route::put('/profile/mobile-confirm', [ProfileController::class, 'mobileConfirm'])->name('customer.profile.mobile.confirm');
            Route::put('/profile/email-confirm', [ProfileController::class, 'emailConfirm'])->name('customer.profile.email.confirm');
            Route::get('/profile-resend-otp/{token}', [ProfileController::class, 'profileResendOtp'])->name('customer.profile.resend-otp');

            Route::get('/my-addresses', [ProfileAddressController::class, 'index'])->name('customer.profile.my-addresses');
            Route::get('/my-tickets', [ProfileTicketController::class, 'index'])->name('customer.profile.my-tickets');
            Route::get('/ticket-details/{ticket}', [ProfileTicketController::class, 'ticketDetails'])->name('customer.profile.ticket-details');
            Route::get('/ticket-create', [ProfileTicketController::class, 'ticketCreate'])->name('customer.profile.ticket-create');
            Route::post('/ticket-store', [ProfileTicketController::class, 'ticketStore'])->name('customer.profile.ticket-store');
            Route::post('/ticket-answer/{ticket}', [ProfileTicketController::class, 'ticketAnswer'])->name('customer.profile.ticket-answer');
            Route::get('/my-compare-list', [CompareController::class, 'index'])->name('customer.profile.my-compare-list');



        });


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
