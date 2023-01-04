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

use Illuminate\Support\Facades\Route;

Route::namespace('Seller')->prefix('seller')->name('seller.')->group(function () {

    /*authentication*/
    Route::namespace('Auth')->prefix('auth')->name('auth.')->group(function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::get('forgot-password', 'ForgotPasswordController@forgot_password')->name('forgot-password');
        Route::post('forgot-password', 'ForgotPasswordController@reset_password_request');
        Route::get('otp-verification', 'ForgotPasswordController@otp_verification')->name('otp-verification');
        Route::post('otp-verification', 'ForgotPasswordController@otp_verification_submit');
        Route::get('reset-password', 'ForgotPasswordController@reset_password_index')->name('reset-password');
        Route::post('reset-password', 'ForgotPasswordController@reset_password_submit');
    });

    /*authenticated*/
    Route::middleware('seller')->group(function () {
        //dashboard routes

        Route::get('/get-order-data', 'SystemController@order_data')->name('get-order-data');

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('dashboard', 'DashboardController@dashboard');
            Route::get('/', 'DashboardController@dashboard')->name('index');
            Route::post('order-stats', 'DashboardController@order_stats')->name('order-stats');
            Route::post('business-overview', 'DashboardController@business_overview')->name('business-overview');
            Route::get('earning-statistics', 'DashboardController@get_earning_statitics')->name('earning-statistics');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::post('image-upload', 'ProductController@imageUpload')->name('image-upload');
            Route::get('remove-image', 'ProductController@remove_image')->name('remove-image');
            Route::get('add-new', 'ProductController@add_new')->name('add-new');
            Route::post('add-new', 'ProductController@store');
            Route::post('status-update', 'ProductController@status_update')->name('status-update');
            Route::get('list', 'ProductController@list')->name('list');
            Route::get('stock-limit-list/{type}', 'ProductController@stock_limit_list')->name('stock-limit-list');
            Route::get('get-variations', 'ProductController@get_variations')->name('get-variations');
            Route::post('update-quantity', 'ProductController@update_quantity')->name('update-quantity');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::post('update/{id}', 'ProductController@update')->name('update');
            Route::post('sku-combination', 'ProductController@sku_combination')->name('sku-combination');
            Route::get('get-categories', 'ProductController@get_categories')->name('get-categories');
            Route::get('barcode', 'ProductController@get_categories')->name('get-categories');
            Route::get('barcode/{id}', 'ProductController@barcode')->name('barcode');

            Route::delete('delete/{id}', 'ProductController@delete')->name('delete');

            Route::get('view/{id}', 'ProductController@view')->name('view');
            Route::get('bulk-import', 'ProductController@bulk_import_index')->name('bulk-import');
            Route::post('bulk-import', 'ProductController@bulk_import_data');
            Route::get('bulk-export', 'ProductController@bulk_export_data')->name('bulk-export');
        });
        //refund request
        Route::prefix('refund')->name('refund.')->group(function () {
            Route::get('list/{status}', 'RefundController@list')->name('list');
            Route::get('details/{id}', 'RefundController@details')->name('details');
            Route::get('inhouse-order-filter', 'RefundController@inhouse_order_filter')->name('inhouse-order-filter');
            Route::post('refund-status-update', 'RefundController@refund_status_update')->name('refund-status-update');
        });
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('list/{status}', 'OrderController@list')->name('list');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            Route::get('generate-invoice/{id}', 'OrderController@generate_invoice')->name('generate-invoice');
            Route::post('status', 'OrderController@status')->name('status');
            Route::post('amount-date-update', 'OrderController@amount_date_update')->name('amount-date-update');
            Route::post('productStatus', 'OrderController@productStatus')->name('productStatus');
            Route::post('payment-status', 'OrderController@payment_status')->name('payment-status');
            Route::post('digital-file-upload-after-sell', 'OrderController@digital_file_upload_after_sell')->name('digital-file-upload-after-sell');

            Route::post('update-deliver-info', 'OrderController@update_deliver_info')->name('update-deliver-info');
            Route::get('add-delivery-man/{order_id}/{d_man_id}', 'OrderController@add_delivery_man')->name('add-delivery-man');
            Route::get('export-order-data/{status}', 'OrderController@bulk_export_data')->name('order-bulk-export');
        });
        //pos management
        Route::prefix('pos')->name('pos.')->group(function () {
            Route::get('/', 'POSController@index')->name('index');
            Route::get('quick-view', 'POSController@quick_view')->name('quick-view');
            Route::post('variant_price', 'POSController@variant_price')->name('variant_price');
            Route::post('add-to-cart', 'POSController@addToCart')->name('add-to-cart');
            Route::post('remove-from-cart', 'POSController@removeFromCart')->name('remove-from-cart');
            Route::post('cart-items', 'POSController@cart_items')->name('cart_items');
            Route::post('update-quantity', 'POSController@updateQuantity')->name('updateQuantity');
            Route::post('empty-cart', 'POSController@emptyCart')->name('emptyCart');
            Route::post('tax', 'POSController@update_tax')->name('tax');
            Route::post('discount', 'POSController@update_discount')->name('discount');
            Route::get('customers', 'POSController@get_customers')->name('customers');
            Route::post('order', 'POSController@place_order')->name('order');
            Route::get('orders', 'POSController@order_list')->name('orders');
            Route::get('order-details/{id}', 'POSController@order_details')->name('order-details');
            Route::post('digital-file-upload-after-sell', 'POSController@digital_file_upload_after_sell')->name('digital-file-upload-after-sell');
            Route::get('invoice/{id}', 'POSController@generate_invoice');
            Route::any('store-keys', 'POSController@store_keys')->name('store-keys');
            Route::get('search-products', 'POSController@search_product')->name('search-products');
            Route::get('order-bulk-export', 'POSController@bulk_export_data')->name('order-bulk-export');

            Route::post('coupon-discount', 'POSController@coupon_discount')->name('coupon-discount');
            Route::get('change-cart', 'POSController@change_cart')->name('change-cart');
            Route::get('new-cart-id', 'POSController@new_cart_id')->name('new-cart-id');
            Route::post('remove-discount', 'POSController@remove_discount')->name('remove-discount');
            Route::get('clear-cart-ids', 'POSController@clear_cart_ids')->name('clear-cart-ids');
            Route::get('get-cart-ids', 'POSController@get_cart_ids')->name('get-cart-ids');

            Route::post('customer-store', 'POSController@customer_store')->name('customer-store');
        });
        //Product Reviews

        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('list', 'ReviewsController@list')->name('list');
            Route::get('export', 'ReviewsController@export')->name('export')->middleware('actch');
            Route::get('status/{id}/{status}', 'ReviewsController@status')->name('status');
        });

        // Messaging
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/chat/{type}', 'ChattingController@chat')->name('chat');
            Route::get('/ajax-message-by-user', 'ChattingController@ajax_message_by_user')->name('ajax-message-by-user');
            Route::post('/ajax-seller-message-store', 'ChattingController@ajax_seller_message_store')->name('ajax-seller-message-store');
        });
        // profile

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('view', 'ProfileController@view')->name('view');
            Route::get('update/{id}', 'ProfileController@edit')->name('update');
            Route::post('update/{id}', 'ProfileController@update');
            Route::post('settings-password', 'ProfileController@settings_password_update')->name('settings-password');

            Route::get('bank-edit/{id}', 'ProfileController@bank_edit')->name('bankInfo');
            Route::post('bank-update/{id}', 'ProfileController@bank_update')->name('bank_update');
        });
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('view', 'ShopController@view')->name('view');
            Route::get('edit/{id}', 'ShopController@edit')->name('edit');
            Route::post('update/{id}', 'ShopController@update')->name('update');
        });

        Route::prefix('withdraw')->name('withdraw.')->group(function () {
            Route::post('request', 'WithdrawController@w_request')->name('request');
            Route::delete('close/{id}', 'WithdrawController@close_request')->name('close');
        });

        Route::prefix('business-settings')->name('business-settings.')->group(function () {
            Route::prefix('shipping-method')->name('shipping-method.')->group(function () {
                Route::get('add', 'ShippingMethodController@index')->name('add');
                Route::post('add', 'ShippingMethodController@store');
                Route::get('edit/{id}', 'ShippingMethodController@edit')->name('edit');
                Route::put('update/{id}', 'ShippingMethodController@update')->name('update');
                Route::post('delete', 'ShippingMethodController@delete')->name('delete');
                Route::post('status-update', 'ShippingMethodController@status_update')->name('status-update');
            });

            Route::prefix('shipping-type')->name('shipping-type.')->group(function () {
                Route::post('store', 'ShippingTypeController@store')->name('store');
            });
            Route::prefix('category-shipping-cost')->name('category-shipping-cost.')->group(function () {
                Route::post('store', 'CategoryShippingCostController@store')->name('store');
            });

            Route::prefix('withdraw')->name('withdraw.')->group(function () {
                Route::get('list', 'WithdrawController@list')->name('list');
                Route::get('cancel/{id}', 'WithdrawController@close_request')->name('cancel');
                Route::post('status-filter', 'WithdrawController@status_filter')->name('status-filter');
            });
        });

        Route::prefix('delivery-man')->name('delivery-man.')->group(function () {
            Route::get('add', 'DeliveryManController@index')->name('add');
            Route::post('store', 'DeliveryManController@store')->name('store');
            Route::get('list', 'DeliveryManController@list')->name('list');
            Route::get('preview/{id}', 'DeliveryManController@preview')->name('preview');
            Route::get('edit/{id}', 'DeliveryManController@edit')->name('edit');
            Route::post('update/{id}', 'DeliveryManController@update')->name('update');
            Route::delete('delete/{id}', 'DeliveryManController@delete')->name('delete');
            Route::post('search', 'DeliveryManController@search')->name('search');
            Route::post('status-update', 'DeliveryManController@status')->name('status-update');
            Route::get('earning-statement/{id}', 'DeliveryManController@earning_statement')->name('earning-statement');
            Route::get('collect-cash/{id}', 'DeliveryManCashCollectController@collect_cash')->name('collect-cash');
            Route::post('cash-receive/{id}', 'DeliveryManCashCollectController@cash_receive')->name('cash-receive');
            Route::get('withdraw-list', 'DeliverymanWithdrawController@withdraw')->name('withdraw-list');
            Route::get('withdraw-list-export', 'DeliverymanWithdrawController@export')->name('withdraw-list-export');
            Route::post('status-filter', 'DeliverymanWithdrawController@status_filter')->name('status-filter');
            Route::get('withdraw-view/{withdraw_id}', 'DeliverymanWithdrawController@withdraw_view')->name('withdraw-view');
            Route::post('withdraw-status/{id}', 'DeliverymanWithdrawController@withdrawStatus')->name('withdraw_status');

            Route::get('earning-active-log/{id}', 'DeliveryManController@earning_active_log')->name('earning-active-log');
            Route::get('order-wise-earning/{id}', 'DeliveryManController@order_wise_earning')->name('order-wise-earning');
            Route::get('ajax-order-status-history/{order}', 'DeliveryManController@ajax_order_status_history')->name('ajax-order-status-history');

            Route::prefix('emergency-contact')->name('emergency-contact.')->group(function () {
                Route::get('/', 'EmergencyContactController@emergency_contact')->name('index');
                Route::post('add', 'EmergencyContactController@add')->name('add');
                Route::post('ajax-status-change', 'EmergencyContactController@ajax_status_change')->name('ajax-status-change');
                Route::delete('destroy', 'EmergencyContactController@destroy')->name('destroy');
            });

            Route::get('rating/{id}', 'DeliveryManController@rating')->name('rating');
        });
    });
});
