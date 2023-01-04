<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace('api\v1')->prefix('v1')->middleware('api_lang')->group(function () {
    Route::prefix('auth')->namespace('auth')->group(function () {
        Route::post('register', 'PassportAuthController@register');
        Route::post('login', 'PassportAuthController@login');

        Route::post('check-phone', 'PhoneVerificationController@check_phone');
        Route::post('verify-phone', 'PhoneVerificationController@verify_phone');

        Route::post('check-email', 'EmailVerificationController@check_email');
        Route::post('verify-email', 'EmailVerificationController@verify_email');

        Route::post('forgot-password', 'ForgotPassword@reset_password_request');
        Route::post('verify-otp', 'ForgotPassword@otp_verification_submit');
        Route::put('reset-password', 'ForgotPassword@reset_password_submit');

        Route::any('social-login', 'SocialAuthController@social_login');
        Route::post('update-phone', 'SocialAuthController@update_phone');
    });

    Route::prefix('config')->group(function () {
        Route::get('/', 'ConfigController@configuration');
    });

    Route::prefix('shipping-method')->middleware('auth:api')->group(function () {
        Route::get('detail/{id}', 'ShippingMethodController@get_shipping_method_info');
        Route::get('by-seller/{id}/{seller_is}', 'ShippingMethodController@shipping_methods_by_seller');
        Route::post('choose-for-order', 'ShippingMethodController@choose_for_order');
        Route::get('chosen', 'ShippingMethodController@chosen_shipping_methods');

        Route::get('check-shipping-type', 'ShippingMethodController@check_shipping_type');
    });

    Route::prefix('cart')->middleware('auth:api')->group(function () {
        Route::get('/', 'CartController@cart');
        Route::post('add', 'CartController@add_to_cart');
        Route::put('update', 'CartController@update_cart');
        Route::delete('remove', 'CartController@remove_from_cart');
        Route::delete('remove-all', 'CartController@remove_all_from_cart');
    });

    Route::get('faq', 'GeneralController@faq');

    Route::prefix('products')->group(function () {
        Route::get('latest', 'ProductController@get_latest_products');
        Route::get('featured', 'ProductController@get_featured_products');
        Route::get('top-rated', 'ProductController@get_top_rated_products');
        Route::any('search', 'ProductController@get_searched_products');
        Route::get('details/{slug}', 'ProductController@get_product');
        Route::get('related-products/{product_id}', 'ProductController@get_related_products');
        Route::get('reviews/{product_id}', 'ProductController@get_product_reviews');
        Route::get('rating/{product_id}', 'ProductController@get_product_rating');
        Route::get('counter/{product_id}', 'ProductController@counter');
        Route::get('shipping-methods', 'ProductController@get_shipping_methods');
        Route::get('social-share-link/{product_id}', 'ProductController@social_share_link');
        Route::post('reviews/submit', 'ProductController@submit_product_review')->middleware('auth:api');
        Route::get('best-sellings', 'ProductController@get_best_sellings');
        Route::get('home-categories', 'ProductController@get_home_categories');
        ROute::get('discounted-product', 'ProductController@get_discounted_product');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', 'NotificationController@get_notifications');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', 'BrandController@get_brands');
        Route::get('products/{brand_id}', 'BrandController@get_products');
    });

    Route::prefix('attributes')->group(function () {
        Route::get('/', 'AttributeController@get_attributes');
    });

    Route::prefix('flash-deals')->group(function () {
        Route::get('/', 'FlashDealController@get_flash_deal');
        Route::get('products/{deal_id}', 'FlashDealController@get_products');
    });

    Route::prefix('deals')->group(function () {
        Route::get('featured', 'DealController@get_featured_deal');
    });

    Route::prefix('dealsoftheday')->group(function () {
        Route::get('deal-of-the-day', 'DealOfTheDayController@get_deal_of_the_day_product');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@get_categories');
        Route::get('products/{category_id}', 'CategoryController@get_products');
    });

    Route::prefix('customer')->middleware('auth:api')->group(function () {
        Route::get('info', 'CustomerController@info');
        Route::put('update-profile', 'CustomerController@update_profile');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');
        Route::get('account-delete/{id}', 'CustomerController@account_delete');

        Route::get('get-restricted-country-list', 'CustomerController@get_restricted_country_list');
        Route::get('get-restricted-zip-list', 'CustomerController@get_restricted_zip_list');

        Route::prefix('address')->group(function () {
            Route::get('list', 'CustomerController@address_list');
            Route::get('get/{id}', 'CustomerController@get_address');
            Route::post('add', 'CustomerController@add_new_address');
            Route::put('update', 'CustomerController@update_address');
            Route::delete('/', 'CustomerController@delete_address');
        });

        Route::prefix('support-ticket')->group(function () {
            Route::post('create', 'CustomerController@create_support_ticket');
            Route::get('get', 'CustomerController@get_support_tickets');
            Route::get('conv/{ticket_id}', 'CustomerController@get_support_ticket_conv');
            Route::post('reply/{ticket_id}', 'CustomerController@reply_support_ticket');
        });

        Route::prefix('wish-list')->group(function () {
            Route::get('/', 'CustomerController@wish_list');
            Route::post('add', 'CustomerController@add_to_wishlist');
            Route::delete('remove', 'CustomerController@remove_from_wishlist');
        });

        Route::prefix('order')->group(function () {
            Route::get('list', 'CustomerController@get_order_list');
            Route::get('details', 'CustomerController@get_order_details');
            Route::get('place', 'OrderController@place_order');
            Route::get('refund', 'OrderController@refund_request');
            Route::post('refund-store', 'OrderController@store_refund');
            Route::get('refund-details', 'OrderController@refund_details');
            Route::post('deliveryman-reviews/submit', 'ProductController@submit_deliveryman_review')->middleware('auth:api');
        });
        // Chatting
        Route::prefix('chat')->group(function () {
            Route::get('list/{type}', 'ChatController@list');
            Route::get('get-messages/{type}/{id}', 'ChatController@get_message');
            Route::post('send-message/{type}', 'ChatController@send_message');
        });

        //wallet
        Route::prefix('wallet')->group(function () {
            Route::get('list', 'UserWalletController@list');
        });
        //loyalty
        Route::prefix('loyalty')->group(function () {
            Route::get('list', 'UserLoyaltyController@list');
            Route::post('loyalty-exchange-currency', 'UserLoyaltyController@loyalty_exchange_currency');
        });
    });

    Route::prefix('order')->group(function () {
        Route::get('track', 'OrderController@track_order');
        Route::get('cancel-order', 'OrderController@order_cancel');
    });

    Route::prefix('banners')->group(function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::prefix('seller')->group(function () {
        Route::get('/', 'SellerController@get_seller_info');
        Route::get('{seller_id}/products', 'SellerController@get_seller_products');
        Route::get('{seller_id}/all-products', 'SellerController@get_seller_all_products');
        Route::get('top', 'SellerController@get_top_sellers');
        Route::get('all', 'SellerController@get_all_sellers');
    });

    Route::prefix('coupon')->middleware('auth:api')->group(function () {
        Route::get('apply', 'CouponController@apply');
    });

    //map api
    Route::prefix('mapapi')->group(function () {
        Route::get('place-api-autocomplete', 'MapApiController@place_api_autocomplete');
        Route::get('distance-api', 'MapApiController@distance_api');
        Route::get('place-api-details', 'MapApiController@place_api_details');
        Route::get('geocode-api', 'MapApiController@geocode_api');
    });
});
