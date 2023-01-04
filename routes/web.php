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

use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\BkashRefundController;
use App\Http\Controllers\Customer;
use App\Http\Controllers\FawryPaymentController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\LiqPayController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\Seller;
use App\Http\Controllers\SenangPayController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

//for maintenance mode
Route::get('maintenance-mode', [Web\WebController::class, 'maintenance_mode'])->name('maintenance-mode');

Route::middleware('maintenance_mode')->group(function () {
    Route::get('/', [Web\WebController::class, 'home'])->name('home');

    Route::get('quick-view', [Web\WebController::class, 'quick_view'])->name('quick-view');
    Route::get('searched-products', [Web\WebController::class, 'searched_products'])->name('searched-products');

    Route::middleware('customer')->group(function () {
        Route::get('checkout-details', [Web\WebController::class, 'checkout_details'])->name('checkout-details');
        Route::get('checkout-shipping', [Web\WebController::class, 'checkout_shipping'])->name('checkout-shipping')->middleware('customer');
        Route::get('checkout-payment', [Web\WebController::class, 'checkout_payment'])->name('checkout-payment')->middleware('customer');
        Route::get('checkout-review', [Web\WebController::class, 'checkout_review'])->name('checkout-review')->middleware('customer');
        Route::get('checkout-complete', [Web\WebController::class, 'checkout_complete'])->name('checkout-complete')->middleware('customer');
        Route::get('order-placed', [Web\WebController::class, 'order_placed'])->name('order-placed')->middleware('customer');
        Route::get('shop-cart', [Web\WebController::class, 'shop_cart'])->name('shop-cart');
        Route::post('order_note', [Web\WebController::class, 'order_note'])->name('order_note');
        Route::get('digital-product-download/{id}', [Web\WebController::class, 'digital_product_download'])->name('digital-product-download')->middleware('customer');
        Route::get('submit-review/{id}', [Web\UserProfileController::class, 'submit_review'])->name('submit-review');
        Route::post('review', [Web\ReviewController::class, 'store'])->name('review.store');
        Route::get('deliveryman-review/{id}', [Web\ReviewController::class, 'delivery_man_review'])->name('deliveryman-review');
        Route::post('submit-deliveryman-review', [Web\ReviewController::class, 'delivery_man_submit'])->name('submit-deliveryman-review');
    });

    //wallet payment
    Route::get('checkout-complete-wallet', [Web\WebController::class, 'checkout_complete_wallet'])->name('checkout-complete-wallet');

    Route::post('subscription', [Web\WebController::class, 'subscription'])->name('subscription');
    Route::get('search-shop', [Web\WebController::class, 'search_shop'])->name('search-shop');

    Route::get('categories', [Web\WebController::class, 'all_categories'])->name('categories');
    Route::get('category-ajax/{id}', [Web\WebController::class, 'categories_by_category'])->name('category-ajax');

    Route::get('brands', [Web\WebController::class, 'all_brands'])->name('brands');
    Route::get('sellers', [Web\WebController::class, 'all_sellers'])->name('sellers');
    Route::get('seller-profile/{id}', [Web\WebController::class, 'seller_profile'])->name('seller-profile');

    Route::get('flash-deals/{id}', [Web\WebController::class, 'flash_deals'])->name('flash-deals');
    Route::get('terms', [Web\WebController::class, 'termsandCondition'])->name('terms');
    Route::get('privacy-policy', [Web\WebController::class, 'privacy_policy'])->name('privacy-policy');

    Route::get('/product/{slug}', [Web\WebController::class, 'product'])->name('product');
    Route::get('products', [Web\WebController::class, 'products'])->name('products');
    Route::get('orderDetails', [Web\WebController::class, 'orderdetails'])->name('orderdetails');
    Route::get('discounted-products', [Web\WebController::class, 'discounted_products'])->name('discounted-products');

    Route::post('review-list-product', [Web\WebController::class, 'review_list_product'])->name('review-list-product');
    //Chat with seller from product details
    Route::get('chat-for-product', [Web\WebController::class, 'chat_for_product'])->name('chat-for-product');

    Route::get('wishlists', [Web\WebController::class, 'viewWishlist'])->name('wishlists')->middleware('customer');
    Route::post('store-wishlist', [Web\WebController::class, 'storeWishlist'])->name('store-wishlist');
    Route::post('delete-wishlist', [Web\WebController::class, 'deleteWishlist'])->name('delete-wishlist');

    Route::post('/currency', [Web\CurrencyController::class, 'changeCurrency'])->name('currency.change');

    Route::get('about-us', [Web\WebController::class, 'about_us'])->name('about-us');

    //profile Route
    Route::get('user-account', [Web\UserProfileController::class, 'user_account'])->name('user-account');
    Route::post('user-account-update', [Web\UserProfileController::class, 'user_update'])->name('user-update');
    Route::post('user-account-picture', [Web\UserProfileController::class, 'user_picture'])->name('user-picture');
    Route::get('account-address', [Web\UserProfileController::class, 'account_address'])->name('account-address');
    Route::post('account-address-store', [Web\UserProfileController::class, 'address_store'])->name('address-store');
    Route::get('account-address-delete', [Web\UserProfileController::class, 'address_delete'])->name('address-delete');
    ROute::get('account-address-edit/{id}', [Web\UserProfileController::class, 'address_edit'])->name('address-edit');
    Route::post('account-address-update', [Web\UserProfileController::class, 'address_update'])->name('address-update');
    Route::get('account-payment', [Web\UserProfileController::class, 'account_payment'])->name('account-payment');
    Route::get('account-oder', [Web\UserProfileController::class, 'account_oder'])->name('account-oder');
    Route::get('account-order-details', [Web\UserProfileController::class, 'account_order_details'])->name('account-order-details')->middleware('customer');
    Route::get('generate-invoice/{id}', [Web\UserProfileController::class, 'generate_invoice'])->name('generate-invoice');
    Route::get('account-wishlist', [Web\UserProfileController::class, 'account_wishlist'])->name('account-wishlist'); //add to card not work
    Route::get('refund-request/{id}', [Web\UserProfileController::class, 'refund_request'])->name('refund-request');
    Route::get('refund-details/{id}', [Web\UserProfileController::class, 'refund_details'])->name('refund-details');
    Route::post('refund-store', [Web\UserProfileController::class, 'store_refund'])->name('refund-store');
    Route::get('account-tickets', [Web\UserProfileController::class, 'account_tickets'])->name('account-tickets');
    Route::get('order-cancel/{id}', [Web\UserProfileController::class, 'order_cancel'])->name('order-cancel');
    Route::post('ticket-submit', [Web\UserProfileController::class, 'ticket_submit'])->name('ticket-submit');
    Route::get('account-delete/{id}', [Web\UserProfileController::class, 'account_delete'])->name('account-delete');
    // Chatting start
    Route::get('chat/{type}', [Web\ChattingController::class, 'chat_list'])->name('chat');
    Route::get('messages', [Web\ChattingController::class, 'messages'])->name('messages');
    Route::post('messages-store', [Web\ChattingController::class, 'messages_store'])->name('messages_store');
    // chatting end

    //Support Ticket
    Route::prefix('support-ticket')->name('support-ticket.')->group(function () {
        Route::get('{id}', [Web\UserProfileController::class, 'single_ticket'])->name('index');
        Route::post('{id}', [Web\UserProfileController::class, 'comment_submit'])->name('comment');
        Route::get('delete/{id}', [Web\UserProfileController::class, 'support_ticket_delete'])->name('delete');
        Route::get('close/{id}', [Web\UserProfileController::class, 'support_ticket_close'])->name('close');
    });

    Route::get('account-transaction', [Web\UserProfileController::class, 'account_transaction'])->name('account-transaction');
    Route::get('account-wallet-history', [Web\UserProfileController::class, 'account_wallet_history'])->name('account-wallet-history');

    Route::get('wallet', [Web\UserWalletController::class, 'index'])->name('wallet');
    Route::get('loyalty', [Web\UserLoyaltyController::class, 'index'])->name('loyalty');
    Route::post('loyalty-exchange-currency', [Web\UserLoyaltyController::class, 'loyalty_exchange_currency'])->name('loyalty-exchange-currency');

    Route::prefix('track-order')->name('track-order.')->group(function () {
        Route::get('', [Web\UserProfileController::class, 'track_order'])->name('index');
        Route::get('result-view', [Web\UserProfileController::class, 'track_order_result'])->name('result-view');
        Route::get('last', [Web\UserProfileController::class, 'track_last_order'])->name('last');
        Route::any('result', [Web\UserProfileController::class, 'track_order_result'])->name('result');
    });
    //FAQ route
    Route::get('helpTopic', [Web\WebController::class, 'helpTopic'])->name('helpTopic');
    //Contacts
    Route::get('contacts', [Web\WebController::class, 'contacts'])->name('contacts');

    //sellerShop
    Route::get('shopView/{id}', [Web\WebController::class, 'seller_shop'])->name('shopView');
    Route::post('shopView/{id}', [Web\WebController::class, 'seller_shop_product']);

    //top Rated
    Route::get('top-rated', [Web\WebController::class, 'top_rated'])->name('topRated');
    Route::get('best-sell', [Web\WebController::class, 'best_sell'])->name('bestSell');
    Route::get('new-product', [Web\WebController::class, 'new_product'])->name('newProduct');

    Route::prefix('contact')->name('contact.')->group(function () {
        Route::post('store', [Web\WebController::class, 'contact_store'])->name('store');
        Route::get('/code/captcha/{tmp}', [Web\WebController::class, 'captcha'])->name('default-captcha');
    });
});

//Seller shop apply
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('apply', [Seller\Auth\RegisterController::class, 'create'])->name('apply');
    Route::post('apply', [Seller\Auth\RegisterController::class, 'store']);
});

//check done
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('variant_price', [Web\CartController::class, 'variant_price'])->name('variant_price');
    Route::post('add', [Web\CartController::class, 'addToCart'])->name('add');
    Route::post('remove', [Web\CartController::class, 'removeFromCart'])->name('remove');
    Route::post('nav-cart-items', [Web\CartController::class, 'updateNavCart'])->name('nav-cart');
    Route::post('updateQuantity', [Web\CartController::class, 'updateQuantity'])->name('updateQuantity');
});

//Seller shop apply
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::post('apply', [Web\CouponController::class, 'apply'])->name('apply');
});
//check done

// SSLCOMMERZ Start
/*Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');*/
Route::post('pay-ssl', [SslCommerzPaymentController::class, 'index']);
Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('ssl-success');
Route::post('/fail', [SslCommerzPaymentController::class, 'fail'])->name('ssl-fail');
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('ssl-cancel');
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn'])->name('ssl-ipn');
//SSLCOMMERZ END

/*paypal*/
/*Route::get('/paypal', function (){return view('paypal-test');})->name('paypal');*/
Route::post('pay-paypal', [PaypalPaymentController::class, 'payWithpaypal'])->name('pay-paypal');
Route::get('paypal-status', [PaypalPaymentController::class, 'getPaymentStatus'])->name('paypal-status');
Route::get('paypal-success', [PaypalPaymentController::class, 'success'])->name('paypal-success');
Route::get('paypal-fail', [PaypalPaymentController::class, 'fail'])->name('paypal-fail');
/*paypal*/

/*Route::get('stripe', function (){
return view('stripe-test');
});*/
Route::get('pay-stripe', [StripePaymentController::class, 'payment_process_3d'])->name('pay-stripe');
Route::get('pay-stripe/success', [StripePaymentController::class, 'success'])->name('pay-stripe.success');
Route::get('pay-stripe/fail', [StripePaymentController::class, 'success'])->name('pay-stripe.fail');

// Get Route For Show Payment razorpay Form
Route::get('paywithrazorpay', [RazorPayController::class, 'payWithRazorpay'])->name('paywithrazorpay');
Route::post('payment-razor', [RazorPayController::class, 'payment'])->name('payment-razor');
Route::post('payment-razor/payment2', [RazorPayController::class, 'payment_mobile'])->name('payment-razor.payment2');
Route::get('payment-razor/success', [RazorPayController::class, 'success'])->name('payment-razor.success');
Route::get('payment-razor/fail', [RazorPayController::class, 'success'])->name('payment-razor.fail');

Route::get('payment-success', [Customer\PaymentController::class, 'success'])->name('payment-success');
Route::get('payment-fail', [Customer\PaymentController::class, 'fail'])->name('payment-fail');

//senang pay
Route::match(['get', 'post'], '/return-senang-pay', [SenangPayController::class, 'return_senang_pay'])->name('return-senang-pay');

//paystack
Route::post('/paystack-pay', [PaystackController::class, 'redirectToGateway'])->name('paystack-pay');
Route::get('/paystack-callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack-callback');
Route::get('/paystack', function () {
    return view('paystack');
});

// paymob
Route::post('/paymob-credit', [PaymobController::class, 'credit'])->name('paymob-credit');
Route::get('/paymob-callback', [PaymobController::class, 'callback'])->name('paymob-callback');

//paytabs
Route::any('/paytabs-payment', [PaytabsController::class, 'payment'])->name('paytabs-payment');
Route::any('/paytabs-response', [PaytabsController::class, 'callback_response'])->name('paytabs-response');

//bkash
Route::prefix('bkash')->group(function () {
    // Payment Routes for bKash
    Route::post('get-token', [BkashPaymentController::class, 'getToken'])->name('bkash-get-token');
    Route::post('create-payment', [BkashPaymentController::class, 'createPayment'])->name('bkash-create-payment');
    Route::post('execute-payment', [BkashPaymentController::class, 'executePayment'])->name('bkash-execute-payment');
    Route::get('query-payment', [BkashPaymentController::class, 'queryPayment'])->name('bkash-query-payment');
    Route::post('success', [BkashPaymentController::class, 'bkashSuccess'])->name('bkash-success');

    // Refund Routes for bKash
    Route::get('refund', [BkashRefundController::class, 'index'])->name('bkash-refund');
    Route::post('refund', [BkashRefundController::class, 'refund'])->name('bkash-refund');
});

//fawry
Route::get('/fawry', [FawryPaymentController::class, 'index'])->name('fawry');
Route::any('/fawry-payment', [FawryPaymentController::class, 'payment'])->name('fawry-payment');

// The callback url after a payment
Route::get('mercadopago/home', [MercadoPagoController::class, 'index'])->name('mercadopago.index');
Route::post('mercadopago/make-payment', [MercadoPagoController::class, 'make_payment'])->name('mercadopago.make_payment');
Route::get('mercadopago/get-user', [MercadoPagoController::class, 'get_test_user'])->name('mercadopago.get-user');

// The route that the button calls to initialize payment
Route::post('/flutterwave-pay', [FlutterwaveController::class, 'initialize'])->name('flutterwave_pay');
// The callback url after a payment
Route::get('/rave/callback', [FlutterwaveController::class, 'callback'])->name('flutterwave_callback');

// The callback url after a payment PAYTM
Route::get('paytm-payment', [PaytmController::class, 'payment'])->name('paytm-payment');
Route::any('paytm-response', [PaytmController::class, 'callback'])->name('paytm-response');

// The callback url after a payment LIQPAY
Route::get('liqpay-payment', [LiqPayController::class, 'payment'])->name('liqpay-payment');
Route::any('liqpay-callback', [LiqPayController::class, 'callback'])->name('liqpay-callback');

Route::get('/test', function () {
    $product = \App\Model\Product::find(116);
    $quantity = 6;

    return view('seller-views.product.barcode-pdf', compact('product', 'quantity'));
});
