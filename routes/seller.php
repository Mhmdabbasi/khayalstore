<?php

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

use App\Http\Controllers\Seller;
use Illuminate\Support\Facades\Route;

Route::prefix('seller')->name('seller.')->group(function () {

    /*authentication*/
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/code/captcha/{tmp}', [Seller\Auth\LoginController::class, 'captcha'])->name('default-captcha');
        Route::get('login', [Seller\Auth\LoginController::class, 'login'])->name('login');
        Route::post('login', [Seller\Auth\LoginController::class, 'submit']);
        Route::get('logout', [Seller\Auth\LoginController::class, 'logout'])->name('logout');

        Route::get('forgot-password', [Seller\Auth\ForgotPasswordController::class, 'forgot_password'])->name('forgot-password');
        Route::post('forgot-password', [Seller\Auth\ForgotPasswordController::class, 'reset_password_request']);
        Route::get('otp-verification', [Seller\Auth\ForgotPasswordController::class, 'otp_verification'])->name('otp-verification');
        Route::post('otp-verification', [Seller\Auth\ForgotPasswordController::class, 'otp_verification_submit']);
        Route::get('reset-password', [Seller\Auth\ForgotPasswordController::class, 'reset_password_index'])->name('reset-password');
        Route::post('reset-password', [Seller\Auth\ForgotPasswordController::class, 'reset_password_submit']);
    });

    /*authenticated*/
    Route::middleware('seller')->group(function () {
        //dashboard routes

        Route::get('/get-order-data', [Seller\SystemController::class, 'order_data'])->name('get-order-data');

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('dashboard', [Seller\DashboardController::class, 'dashboard']);
            Route::get('/', [Seller\DashboardController::class, 'dashboard'])->name('index');
            Route::post('order-stats', [Seller\DashboardController::class, 'order_stats'])->name('order-stats');
            Route::post('business-overview', [Seller\DashboardController::class, 'business_overview'])->name('business-overview');
            Route::get('earning-statistics', [Seller\DashboardController::class, 'get_earning_statitics'])->name('earning-statistics');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::post('image-upload', [Seller\ProductController::class, 'imageUpload'])->name('image-upload');
            Route::get('remove-image', [Seller\ProductController::class, 'remove_image'])->name('remove-image');
            Route::get('add-new', [Seller\ProductController::class, 'add_new'])->name('add-new');
            Route::post('add-new', [Seller\ProductController::class, 'store']);
            Route::post('status-update', [Seller\ProductController::class, 'status_update'])->name('status-update');
            Route::get('list', [Seller\ProductController::class, 'list'])->name('list');
            Route::get('stock-limit-list/{type}', [Seller\ProductController::class, 'stock_limit_list'])->name('stock-limit-list');
            Route::get('get-variations', [Seller\ProductController::class, 'get_variations'])->name('get-variations');
            Route::post('update-quantity', [Seller\ProductController::class, 'update_quantity'])->name('update-quantity');
            Route::get('edit/{id}', [Seller\ProductController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Seller\ProductController::class, 'update'])->name('update');
            Route::post('sku-combination', [Seller\ProductController::class, 'sku_combination'])->name('sku-combination');
            Route::get('get-categories', [Seller\ProductController::class, 'get_categories'])->name('get-categories');
            Route::get('barcode', [Seller\ProductController::class, 'get_categories'])->name('get-categories');
            Route::get('barcode/{id}', [Seller\ProductController::class, 'barcode'])->name('barcode');

            Route::delete('delete/{id}', [Seller\ProductController::class, 'delete'])->name('delete');

            Route::get('view/{id}', [Seller\ProductController::class, 'view'])->name('view');
            Route::get('bulk-import', [Seller\ProductController::class, 'bulk_import_index'])->name('bulk-import');
            Route::post('bulk-import', [Seller\ProductController::class, 'bulk_import_data']);
            Route::get('bulk-export', [Seller\ProductController::class, 'bulk_export_data'])->name('bulk-export');
        });
        //refund request
        Route::prefix('refund')->name('refund.')->group(function () {
            Route::get('list/{status}', [Seller\RefundController::class, 'list'])->name('list');
            Route::get('details/{id}', [Seller\RefundController::class, 'details'])->name('details');
            Route::get('inhouse-order-filter', [Seller\RefundController::class, 'inhouse_order_filter'])->name('inhouse-order-filter');
            Route::post('refund-status-update', [Seller\RefundController::class, 'refund_status_update'])->name('refund-status-update');
        });
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('list/{status}', [Seller\OrderController::class, 'list'])->name('list');
            Route::get('details/{id}', [Seller\OrderController::class, 'details'])->name('details');
            Route::get('generate-invoice/{id}', [Seller\OrderController::class, 'generate_invoice'])->name('generate-invoice');
            Route::post('status', [Seller\OrderController::class, 'status'])->name('status');
            Route::post('amount-date-update', [Seller\OrderController::class, 'amount_date_update'])->name('amount-date-update');
            Route::post('productStatus', [Seller\OrderController::class, 'productStatus'])->name('productStatus');
            Route::post('payment-status', [Seller\OrderController::class, 'payment_status'])->name('payment-status');
            Route::post('digital-file-upload-after-sell', [Seller\OrderController::class, 'digital_file_upload_after_sell'])->name('digital-file-upload-after-sell');

            Route::post('update-deliver-info', [Seller\OrderController::class, 'update_deliver_info'])->name('update-deliver-info');
            Route::get('add-delivery-man/{order_id}/{d_man_id}', [Seller\OrderController::class, 'add_delivery_man'])->name('add-delivery-man');
            Route::get('export-order-data/{status}', [Seller\OrderController::class, 'bulk_export_data'])->name('order-bulk-export');
        });
        //pos management
        Route::prefix('pos')->name('pos.')->group(function () {
            Route::get('/', [Seller\POSController::class, 'index'])->name('index');
            Route::get('quick-view', [Seller\POSController::class, 'quick_view'])->name('quick-view');
            Route::post('variant_price', [Seller\POSController::class, 'variant_price'])->name('variant_price');
            Route::post('add-to-cart', [Seller\POSController::class, 'addToCart'])->name('add-to-cart');
            Route::post('remove-from-cart', [Seller\POSController::class, 'removeFromCart'])->name('remove-from-cart');
            Route::post('cart-items', [Seller\POSController::class, 'cart_items'])->name('cart_items');
            Route::post('update-quantity', [Seller\POSController::class, 'updateQuantity'])->name('updateQuantity');
            Route::post('empty-cart', [Seller\POSController::class, 'emptyCart'])->name('emptyCart');
            Route::post('tax', [Seller\POSController::class, 'update_tax'])->name('tax');
            Route::post('discount', [Seller\POSController::class, 'update_discount'])->name('discount');
            Route::get('customers', [Seller\POSController::class, 'get_customers'])->name('customers');
            Route::post('order', [Seller\POSController::class, 'place_order'])->name('order');
            Route::get('orders', [Seller\POSController::class, 'order_list'])->name('orders');
            Route::get('order-details/{id}', [Seller\POSController::class, 'order_details'])->name('order-details');
            Route::post('digital-file-upload-after-sell', [Seller\POSController::class, 'digital_file_upload_after_sell'])->name('digital-file-upload-after-sell');
            Route::get('invoice/{id}', [Seller\POSController::class, 'generate_invoice']);
            Route::any('store-keys', [Seller\POSController::class, 'store_keys'])->name('store-keys');
            Route::get('search-products', [Seller\POSController::class, 'search_product'])->name('search-products');
            Route::get('order-bulk-export', [Seller\POSController::class, 'bulk_export_data'])->name('order-bulk-export');

            Route::post('coupon-discount', [Seller\POSController::class, 'coupon_discount'])->name('coupon-discount');
            Route::get('change-cart', [Seller\POSController::class, 'change_cart'])->name('change-cart');
            Route::get('new-cart-id', [Seller\POSController::class, 'new_cart_id'])->name('new-cart-id');
            Route::post('remove-discount', [Seller\POSController::class, 'remove_discount'])->name('remove-discount');
            Route::get('clear-cart-ids', [Seller\POSController::class, 'clear_cart_ids'])->name('clear-cart-ids');
            Route::get('get-cart-ids', [Seller\POSController::class, 'get_cart_ids'])->name('get-cart-ids');

            Route::post('customer-store', [Seller\POSController::class, 'customer_store'])->name('customer-store');
        });
        //Product Reviews

        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('list', [Seller\ReviewsController::class, 'list'])->name('list');
            Route::get('export', [Seller\ReviewsController::class, 'export'])->name('export')->middleware('actch');
            Route::get('status/{id}/{status}', [Seller\ReviewsController::class, 'status'])->name('status');
        });

        // Messaging
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/chat/{type}', [Seller\ChattingController::class, 'chat'])->name('chat');
            Route::get('/ajax-message-by-user', [Seller\ChattingController::class, 'ajax_message_by_user'])->name('ajax-message-by-user');
            Route::post('/ajax-seller-message-store', [Seller\ChattingController::class, 'ajax_seller_message_store'])->name('ajax-seller-message-store');
        });
        // profile

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('view', [Seller\ProfileController::class, 'view'])->name('view');
            Route::get('update/{id}', [Seller\ProfileController::class, 'edit'])->name('update');
            Route::post('update/{id}', [Seller\ProfileController::class, 'update']);
            Route::post('settings-password', [Seller\ProfileController::class, 'settings_password_update'])->name('settings-password');

            Route::get('bank-edit/{id}', [Seller\ProfileController::class, 'bank_edit'])->name('bankInfo');
            Route::post('bank-update/{id}', [Seller\ProfileController::class, 'bank_update'])->name('bank_update');
        });
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('view', [Seller\ShopController::class, 'view'])->name('view');
            Route::get('edit/{id}', [Seller\ShopController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Seller\ShopController::class, 'update'])->name('update');
        });

        Route::prefix('withdraw')->name('withdraw.')->group(function () {
            Route::post('request', [Seller\WithdrawController::class, 'w_request'])->name('request');
            Route::delete('close/{id}', [Seller\WithdrawController::class, 'close_request'])->name('close');
        });

        Route::prefix('business-settings')->name('business-settings.')->group(function () {
            Route::prefix('shipping-method')->name('shipping-method.')->group(function () {
                Route::get('add', [Seller\ShippingMethodController::class, 'index'])->name('add');
                Route::post('add', [Seller\ShippingMethodController::class, 'store']);
                Route::get('edit/{id}', [Seller\ShippingMethodController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [Seller\ShippingMethodController::class, 'update'])->name('update');
                Route::post('delete', [Seller\ShippingMethodController::class, 'delete'])->name('delete');
                Route::post('status-update', [Seller\ShippingMethodController::class, 'status_update'])->name('status-update');
            });

            Route::prefix('shipping-type')->name('shipping-type.')->group(function () {
                Route::post('store', [Seller\ShippingTypeController::class, 'store'])->name('store');
            });
            Route::prefix('category-shipping-cost')->name('category-shipping-cost.')->group(function () {
                Route::post('store', [Seller\CategoryShippingCostController::class, 'store'])->name('store');
            });

            Route::prefix('withdraw')->name('withdraw.')->group(function () {
                Route::get('list', [Seller\WithdrawController::class, 'list'])->name('list');
                Route::get('cancel/{id}', [Seller\WithdrawController::class, 'close_request'])->name('cancel');
                Route::post('status-filter', [Seller\WithdrawController::class, 'status_filter'])->name('status-filter');
            });
        });

        Route::prefix('delivery-man')->name('delivery-man.')->group(function () {
            Route::get('add', [Seller\DeliveryManController::class, 'index'])->name('add');
            Route::post('store', [Seller\DeliveryManController::class, 'store'])->name('store');
            Route::get('list', [Seller\DeliveryManController::class, 'list'])->name('list');
            Route::get('preview/{id}', [Seller\DeliveryManController::class, 'preview'])->name('preview');
            Route::get('edit/{id}', [Seller\DeliveryManController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Seller\DeliveryManController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [Seller\DeliveryManController::class, 'delete'])->name('delete');
            Route::post('search', [Seller\DeliveryManController::class, 'search'])->name('search');
            Route::post('status-update', [Seller\DeliveryManController::class, 'status'])->name('status-update');
            Route::get('earning-statement/{id}', [Seller\DeliveryManController::class, 'earning_statement'])->name('earning-statement');
            Route::get('collect-cash/{id}', [Seller\DeliveryManCashCollectController::class, 'collect_cash'])->name('collect-cash');
            Route::post('cash-receive/{id}', [Seller\DeliveryManCashCollectController::class, 'cash_receive'])->name('cash-receive');
            Route::get('withdraw-list', [Seller\DeliverymanWithdrawController::class, 'withdraw'])->name('withdraw-list');
            Route::get('withdraw-list-export', [Seller\DeliverymanWithdrawController::class, 'export'])->name('withdraw-list-export');
            Route::post('status-filter', [Seller\DeliverymanWithdrawController::class, 'status_filter'])->name('status-filter');
            Route::get('withdraw-view/{withdraw_id}', [Seller\DeliverymanWithdrawController::class, 'withdraw_view'])->name('withdraw-view');
            Route::post('withdraw-status/{id}', [Seller\DeliverymanWithdrawController::class, 'withdrawStatus'])->name('withdraw_status');

            Route::get('earning-active-log/{id}', [Seller\DeliveryManController::class, 'earning_active_log'])->name('earning-active-log');
            Route::get('order-wise-earning/{id}', [Seller\DeliveryManController::class, 'order_wise_earning'])->name('order-wise-earning');
            Route::get('ajax-order-status-history/{order}', [Seller\DeliveryManController::class, 'ajax_order_status_history'])->name('ajax-order-status-history');

            Route::prefix('emergency-contact')->name('emergency-contact.')->group(function () {
                Route::get('/', [Seller\EmergencyContactController::class, 'emergency_contact'])->name('index');
                Route::post('add', [Seller\EmergencyContactController::class, 'add'])->name('add');
                Route::post('ajax-status-change', [Seller\EmergencyContactController::class, 'ajax_status_change'])->name('ajax-status-change');
                Route::delete('destroy', [Seller\EmergencyContactController::class, 'destroy'])->name('destroy');
            });

            Route::get('rating/{id}', [Seller\DeliveryManController::class, 'rating'])->name('rating');
        });
    });
});
