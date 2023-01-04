<?php

use App\Http\Controllers\api;
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

Route::prefix('v1')->middleware('api_lang')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [api\v1\auth\PassportAuthController::class, 'register']);
        Route::post('login', [api\v1\auth\PassportAuthController::class, 'login']);

        Route::post('check-phone', [api\v1\auth\PhoneVerificationController::class, 'check_phone']);
        Route::post('verify-phone', [api\v1\auth\PhoneVerificationController::class, 'verify_phone']);

        Route::post('check-email', [api\v1\auth\EmailVerificationController::class, 'check_email']);
        Route::post('verify-email', [api\v1\auth\EmailVerificationController::class, 'verify_email']);

        Route::post('forgot-password', [api\v1\auth\ForgotPassword::class, 'reset_password_request']);
        Route::post('verify-otp', [api\v1\auth\ForgotPassword::class, 'otp_verification_submit']);
        Route::put('reset-password', [api\v1\auth\ForgotPassword::class, 'reset_password_submit']);

        Route::any('social-login', [api\v1\auth\SocialAuthController::class, 'social_login']);
        Route::post('update-phone', [api\v1\auth\SocialAuthController::class, 'update_phone']);
    });

    Route::prefix('config')->group(function () {
        Route::get('/', [api\v1\ConfigController::class, 'configuration']);
    });

    Route::prefix('shipping-method')->middleware('auth:api')->group(function () {
        Route::get('detail/{id}', [api\v1\ShippingMethodController::class, 'get_shipping_method_info']);
        Route::get('by-seller/{id}/{seller_is}', [api\v1\ShippingMethodController::class, 'shipping_methods_by_seller']);
        Route::post('choose-for-order', [api\v1\ShippingMethodController::class, 'choose_for_order']);
        Route::get('chosen', [api\v1\ShippingMethodController::class, 'chosen_shipping_methods']);

        Route::get('check-shipping-type', [api\v1\ShippingMethodController::class, 'check_shipping_type']);
    });

    Route::prefix('cart')->middleware('auth:api')->group(function () {
        Route::get('/', [api\v1\CartController::class, 'cart']);
        Route::post('add', [api\v1\CartController::class, 'add_to_cart']);
        Route::put('update', [api\v1\CartController::class, 'update_cart']);
        Route::delete('remove', [api\v1\CartController::class, 'remove_from_cart']);
        Route::delete('remove-all', [api\v1\CartController::class, 'remove_all_from_cart']);
    });

    Route::get('faq', [api\v1\GeneralController::class, 'faq']);

    Route::prefix('products')->group(function () {
        Route::get('latest', [api\v1\ProductController::class, 'get_latest_products']);
        Route::get('featured', [api\v1\ProductController::class, 'get_featured_products']);
        Route::get('top-rated', [api\v1\ProductController::class, 'get_top_rated_products']);
        Route::any('search', [api\v1\ProductController::class, 'get_searched_products']);
        Route::get('details/{slug}', [api\v1\ProductController::class, 'get_product']);
        Route::get('related-products/{product_id}', [api\v1\ProductController::class, 'get_related_products']);
        Route::get('reviews/{product_id}', [api\v1\ProductController::class, 'get_product_reviews']);
        Route::get('rating/{product_id}', [api\v1\ProductController::class, 'get_product_rating']);
        Route::get('counter/{product_id}', [api\v1\ProductController::class, 'counter']);
        Route::get('shipping-methods', [api\v1\ProductController::class, 'get_shipping_methods']);
        Route::get('social-share-link/{product_id}', [api\v1\ProductController::class, 'social_share_link']);
        Route::post('reviews/submit', [api\v1\ProductController::class, 'submit_product_review'])->middleware('auth:api');
        Route::get('best-sellings', [api\v1\ProductController::class, 'get_best_sellings']);
        Route::get('home-categories', [api\v1\ProductController::class, 'get_home_categories']);
        ROute::get('discounted-product', [api\v1\ProductController::class, 'get_discounted_product']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [api\v1\NotificationController::class, 'get_notifications']);
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', [api\v1\BrandController::class, 'get_brands']);
        Route::get('products/{brand_id}', [api\v1\BrandController::class, 'get_products']);
    });

    Route::prefix('attributes')->group(function () {
        Route::get('/', [api\v1\AttributeController::class, 'get_attributes']);
    });

    Route::prefix('flash-deals')->group(function () {
        Route::get('/', [api\v1\FlashDealController::class, 'get_flash_deal']);
        Route::get('products/{deal_id}', [api\v1\FlashDealController::class, 'get_products']);
    });

    Route::prefix('deals')->group(function () {
        Route::get('featured', [api\v1\DealController::class, 'get_featured_deal']);
    });

    Route::prefix('dealsoftheday')->group(function () {
        Route::get('deal-of-the-day', [api\v1\DealOfTheDayController::class, 'get_deal_of_the_day_product']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [api\v1\CategoryController::class, 'get_categories']);
        Route::get('products/{category_id}', [api\v1\CategoryController::class, 'get_products']);
    });

    Route::prefix('customer')->middleware('auth:api')->group(function () {
        Route::get('info', [api\v1\CustomerController::class, 'info']);
        Route::put('update-profile', [api\v1\CustomerController::class, 'update_profile']);
        Route::put('cm-firebase-token', [api\v1\CustomerController::class, 'update_cm_firebase_token']);
        Route::get('account-delete/{id}', [api\v1\CustomerController::class, 'account_delete']);

        Route::get('get-restricted-country-list', [api\v1\CustomerController::class, 'get_restricted_country_list']);
        Route::get('get-restricted-zip-list', [api\v1\CustomerController::class, 'get_restricted_zip_list']);

        Route::prefix('address')->group(function () {
            Route::get('list', [api\v1\CustomerController::class, 'address_list']);
            Route::get('get/{id}', [api\v1\CustomerController::class, 'get_address']);
            Route::post('add', [api\v1\CustomerController::class, 'add_new_address']);
            Route::put('update', [api\v1\CustomerController::class, 'update_address']);
            Route::delete('/', [api\v1\CustomerController::class, 'delete_address']);
        });

        Route::prefix('support-ticket')->group(function () {
            Route::post('create', [api\v1\CustomerController::class, 'create_support_ticket']);
            Route::get('get', [api\v1\CustomerController::class, 'get_support_tickets']);
            Route::get('conv/{ticket_id}', [api\v1\CustomerController::class, 'get_support_ticket_conv']);
            Route::post('reply/{ticket_id}', [api\v1\CustomerController::class, 'reply_support_ticket']);
        });

        Route::prefix('wish-list')->group(function () {
            Route::get('/', [api\v1\CustomerController::class, 'wish_list']);
            Route::post('add', [api\v1\CustomerController::class, 'add_to_wishlist']);
            Route::delete('remove', [api\v1\CustomerController::class, 'remove_from_wishlist']);
        });

        Route::prefix('order')->group(function () {
            Route::get('list', [api\v1\CustomerController::class, 'get_order_list']);
            Route::get('details', [api\v1\CustomerController::class, 'get_order_details']);
            Route::get('place', [api\v1\OrderController::class, 'place_order']);
            Route::get('refund', [api\v1\OrderController::class, 'refund_request']);
            Route::post('refund-store', [api\v1\OrderController::class, 'store_refund']);
            Route::get('refund-details', [api\v1\OrderController::class, 'refund_details']);
            Route::post('deliveryman-reviews/submit', [api\v1\ProductController::class, 'submit_deliveryman_review'])->middleware('auth:api');
        });
        // Chatting
        Route::prefix('chat')->group(function () {
            Route::get('list/{type}', [api\v1\ChatController::class, 'list']);
            Route::get('get-messages/{type}/{id}', [api\v1\ChatController::class, 'get_message']);
            Route::post('send-message/{type}', [api\v1\ChatController::class, 'send_message']);
        });

        //wallet
        Route::prefix('wallet')->group(function () {
            Route::get('list', [api\v1\UserWalletController::class, 'list']);
        });
        //loyalty
        Route::prefix('loyalty')->group(function () {
            Route::get('list', [api\v1\UserLoyaltyController::class, 'list']);
            Route::post('loyalty-exchange-currency', [api\v1\UserLoyaltyController::class, 'loyalty_exchange_currency']);
        });
    });

    Route::prefix('order')->group(function () {
        Route::get('track', [api\v1\OrderController::class, 'track_order']);
        Route::get('cancel-order', [api\v1\OrderController::class, 'order_cancel']);
    });

    Route::prefix('banners')->group(function () {
        Route::get('/', [api\v1\BannerController::class, 'get_banners']);
    });

    Route::prefix('seller')->group(function () {
        Route::get('/', [api\v1\SellerController::class, 'get_seller_info']);
        Route::get('{seller_id}/products', [api\v1\SellerController::class, 'get_seller_products']);
        Route::get('{seller_id}/all-products', [api\v1\SellerController::class, 'get_seller_all_products']);
        Route::get('top', [api\v1\SellerController::class, 'get_top_sellers']);
        Route::get('all', [api\v1\SellerController::class, 'get_all_sellers']);
    });

    Route::prefix('coupon')->middleware('auth:api')->group(function () {
        Route::get('apply', [api\v1\CouponController::class, 'apply']);
    });

    //map api
    Route::prefix('mapapi')->group(function () {
        Route::get('place-api-autocomplete', [api\v1\MapApiController::class, 'place_api_autocomplete']);
        Route::get('distance-api', [api\v1\MapApiController::class, 'distance_api']);
        Route::get('place-api-details', [api\v1\MapApiController::class, 'place_api_details']);
        Route::get('geocode-api', [api\v1\MapApiController::class, 'geocode_api']);
    });
});
