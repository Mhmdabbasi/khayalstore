<?php

use App\Http\Controllers\api;
use Illuminate\Support\Facades\Route;

Route::prefix('v2')->middleware('api_lang')->group(function () {
    Route::prefix('seller')->group(function () {
        Route::get('seller-info', [api\v2\seller\SellerController::class, 'seller_info']);
        Route::get('account-delete', [api\v2\seller\SellerController::class, 'account_delete']);
        Route::get('seller-delivery-man', [api\v2\seller\SellerController::class, 'seller_delivery_man']);
        Route::get('shop-product-reviews', [api\v2\seller\SellerController::class, 'shop_product_reviews']);
        Route::get('shop-product-reviews-status', [api\v2\seller\SellerController::class, 'shop_product_reviews_status']);
        Route::put('seller-update', [api\v2\seller\SellerController::class, 'seller_info_update']);
        Route::get('monthly-earning', [api\v2\seller\SellerController::class, 'monthly_earning']);
        Route::get('monthly-commission-given', [api\v2\seller\SellerController::class, 'monthly_commission_given']);
        Route::put('cm-firebase-token', [api\v2\seller\SellerController::class, 'update_cm_firebase_token']);

        Route::get('shop-info', [api\v2\seller\SellerController::class, 'shop_info']);
        Route::get('transactions', [api\v2\seller\SellerController::class, 'transaction']);
        Route::put('shop-update', [api\v2\seller\SellerController::class, 'shop_info_update']);

        Route::post('balance-withdraw', [api\v2\seller\SellerController::class, 'withdraw_request']);
        Route::delete('close-withdraw-request', [api\v2\seller\SellerController::class, 'close_withdraw_request']);

        Route::prefix('brands')->group(function () {
            Route::get('/', [api\v2\seller\BrandController::class, 'getBrands']);
        });

        Route::prefix('products')->group(function () {
            Route::post('upload-images', [api\v2\seller\ProductController::class, 'upload_images']);
            Route::post('upload-digital-product', [api\v2\seller\ProductController::class, 'upload_digital_product']);
            Route::post('add', [api\v2\seller\ProductController::class, 'add_new']);
            Route::get('list', [api\v2\seller\ProductController::class, 'list']);
            Route::get('stock-out-list', [api\v2\seller\ProductController::class, 'stock_out_list']);
            Route::get('status-update', [api\v2\seller\ProductController::class, 'status_update']);
            Route::get('edit/{id}', [api\v2\seller\ProductController::class, 'edit']);
            Route::put('update/{id}', [api\v2\seller\ProductController::class, 'update']);
            Route::delete('delete/{id}', [api\v2\seller\ProductController::class, 'delete']);
            Route::get('barcode/generate', [api\v2\seller\ProductController::class, 'barcode_generate']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('list', [api\v2\seller\OrderController::class, 'list']);
            Route::get('/{id}', [api\v2\seller\OrderController::class, 'details']);
            Route::put('order-detail-status/{id}', [api\v2\seller\OrderController::class, 'order_detail_status']);
            Route::put('assign-delivery-man', [api\v2\seller\OrderController::class, 'assign_delivery_man']);
            Route::put('order-wise-product-upload', [api\v2\seller\OrderController::class, 'digital_file_upload_after_sell']);
            Route::put('delivery-charge-date-update', [api\v2\seller\OrderController::class, 'amount_date_update']);

            Route::post('assign-third-party-delivery', [api\v2\seller\OrderController::class, 'assign_third_party_delivery']);
            Route::post('update-payment-status', [api\v2\seller\OrderController::class, 'update_payment_status']);
        });
        Route::prefix('refund')->group(function () {
            Route::get('list', [api\v2\seller\RefundController::class, 'list']);
            Route::get('refund-details', [api\v2\seller\RefundController::class, 'refund_details']);
            Route::post('refund-status-update', [api\v2\seller\RefundController::class, 'refund_status_update']);
        });

        Route::prefix('shipping')->group(function () {
            Route::get('get-shipping-method', [api\v2\seller\shippingController::class, 'get_shipping_type']);
            Route::get('selected-shipping-method', [api\v2\seller\shippingController::class, 'selected_shipping_type']);
            Route::get('all-category-cost', [api\v2\seller\shippingController::class, 'all_category_cost']);
            Route::post('set-category-cost', [api\v2\seller\shippingController::class, 'set_category_cost']);
        });

        Route::prefix('shipping-method')->group(function () {
            Route::get('list', [api\v2\seller\ShippingMethodController::class, 'list']);
            Route::post('add', [api\v2\seller\ShippingMethodController::class, 'store']);
            Route::get('edit/{id}', [api\v2\seller\ShippingMethodController::class, 'edit']);
            Route::put('status', [api\v2\seller\ShippingMethodController::class, 'status_update']);
            Route::put('update/{id}', [api\v2\seller\ShippingMethodController::class, 'update']);
            Route::delete('delete/{id}', [api\v2\seller\ShippingMethodController::class, 'delete']);
        });

        Route::prefix('messages')->group(function () {
            Route::get('list/{type}', [api\v2\seller\ChatController::class, 'list']);
            Route::get('get-message/{type}/{id}', [api\v2\seller\ChatController::class, 'get_message']);
            Route::post('send/{type}', [api\v2\seller\ChatController::class, 'send_message']);
            Route::get('search/{type}', [api\v2\seller\ChatController::class, 'search']);
        });

        Route::prefix('auth')->group(function () {
            Route::post('login', [api\v2\seller\auth\LoginController::class, 'login']);

            Route::post('forgot-password', [api\v2\seller\auth\ForgotPasswordController::class, 'reset_password_request']);
            Route::post('verify-otp', [api\v2\seller\auth\ForgotPasswordController::class, 'otp_verification_submit']);
            Route::put('reset-password', [api\v2\seller\auth\ForgotPasswordController::class, 'reset_password_submit']);
        });

        Route::prefix('registration')->group(function () {
            Route::post('/', [api\v2\seller\auth\RegisterController::class, 'store']);
        });
    });
    Route::post('ls-lib-update', [api\v2\LsLibController::class, 'lib_update']);

    Route::prefix('delivery-man')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [api\v2\delivery_man\auth\LoginController::class, 'login']);
            Route::post('forgot-password', [api\v2\delivery_man\auth\LoginController::class, 'reset_password_request']);
            Route::post('verify-otp', [api\v2\delivery_man\auth\LoginController::class, 'otp_verification_submit']);
            Route::post('reset-password', [api\v2\delivery_man\auth\LoginController::class, 'reset_password_submit']);
        });

        Route::middleware('delivery_man_auth')->group(function () {
            Route::put('is-online', [api\v2\delivery_man\DeliveryManController::class, 'is_online']);
            Route::get('info', [api\v2\delivery_man\DeliveryManController::class, 'info']);
            Route::post('distance-api', [api\v2\delivery_man\DeliveryManController::class, 'distance_api']);
            Route::get('current-orders', [api\v2\delivery_man\DeliveryManController::class, 'get_current_orders']);
            Route::get('all-orders', [api\v2\delivery_man\DeliveryManController::class, 'get_all_orders']);
            Route::post('record-location-data', [api\v2\delivery_man\DeliveryManController::class, 'record_location_data']);
            Route::get('order-delivery-history', [api\v2\delivery_man\DeliveryManController::class, 'get_order_history']);
            Route::put('update-order-status', [api\v2\delivery_man\DeliveryManController::class, 'update_order_status']);
            Route::put('update-expected-delivery', [api\v2\delivery_man\DeliveryManController::class, 'update_expected_delivery']);
            Route::put('update-payment-status', [api\v2\delivery_man\DeliveryManController::class, 'order_payment_status_update']);
            Route::put('order-update-is-pause', [api\v2\delivery_man\DeliveryManController::class, 'order_update_is_pause']);
            Route::get('order-details', [api\v2\delivery_man\DeliveryManController::class, 'get_order_details']);
            Route::get('last-location', [api\v2\delivery_man\DeliveryManController::class, 'get_last_location']);
            Route::put('update-fcm-token', [api\v2\delivery_man\DeliveryManController::class, 'update_fcm_token']);

            Route::get('delivery-wise-earned', [api\v2\delivery_man\DeliveryManController::class, 'delivery_wise_earned']);
            Route::get('order-list-by-date', [api\v2\delivery_man\DeliveryManController::class, 'order_list_date_filter']);
            Route::get('search', [api\v2\delivery_man\DeliveryManController::class, 'search']);
            Route::get('profile-dashboard-counts', [api\v2\delivery_man\DeliveryManController::class, 'profile_dashboard_counts']);
            Route::post('change-status', [api\v2\delivery_man\DeliveryManController::class, 'change_status']);
            Route::put('update-info', [api\v2\delivery_man\DeliveryManController::class, 'update_info']);
            Route::put('bank-info', [api\v2\delivery_man\DeliveryManController::class, 'bank_info']);
            Route::get('review-list', [api\v2\delivery_man\DeliveryManController::class, 'review_list']);
            Route::put('save-review', [api\v2\delivery_man\DeliveryManController::class, 'is_saved']);
            Route::get('collected_cash_history', [api\v2\delivery_man\DeliveryManController::class, 'collected_cash_history']);
            Route::get('emergency-contact-list', [api\v2\delivery_man\DeliveryManController::class, 'emergency_contact_list']);
            Route::get('notifications', [api\v2\delivery_man\DeliveryManController::class, 'get_all_notification']);

            Route::post('withdraw-request', [api\v2\delivery_man\WithdrawController::class, 'withdraw_request']);
            Route::get('withdraw-list-by-approved', [api\v2\delivery_man\WithdrawController::class, 'withdraw_list_by_approved']);

            Route::prefix('messages')->group(function () {
                Route::get('list/{type}', [api\v2\delivery_man\ChatController::class, 'list']);
                Route::get('get-message/{type}/{id}', [api\v2\delivery_man\ChatController::class, 'get_message']);
                Route::post('send-message/{type}', [api\v2\delivery_man\ChatController::class, 'send_message']);
                Route::get('search/{type}', [api\v2\delivery_man\ChatController::class, 'search']);
            });
        });
    });
});
