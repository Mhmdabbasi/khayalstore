<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.auth.login');
    });

    /*authentication*/
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/code/captcha/{tmp}', [Admin\Auth\LoginController::class, 'captcha'])->name('default-captcha');
        Route::get('login', [Admin\Auth\LoginController::class, 'login'])->name('login');
        Route::post('login', [Admin\Auth\LoginController::class, 'submit'])->middleware('actch');
        Route::get('logout', [Admin\Auth\LoginController::class, 'logout'])->name('logout');
    });

    /*authenticated*/
    Route::middleware('admin')->group(function () {

        //dashboard routes
        Route::get('/', [Admin\DashboardController::class, 'dashboard'])->name('dashboard'); //previous dashboard route
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [Admin\DashboardController::class, 'dashboard'])->name('index');
            Route::post('order-stats', [Admin\DashboardController::class, 'order_stats'])->name('order-stats');
            Route::post('business-overview', [Admin\DashboardController::class, 'business_overview'])->name('business-overview');
            Route::get('earning-statistics', [Admin\DashboardController::class, 'get_earning_statitics'])->name('earning-statistics');
        });
        //system routes
        Route::get('import-search-function-data', [Admin\SystemController::class, 'importSearchFunctionData'])->name('import-search-function-data');
        Route::get('search-function', [Admin\SystemController::class, 'search_function'])->name('search-function');
        Route::get('maintenance-mode', [Admin\SystemController::class, 'maintenance_mode'])->name('maintenance-mode');
        Route::get('/get-order-data', [Admin\SystemController::class, 'order_data'])->name('get-order-data');

        Route::prefix('custom-role')->name('custom-role.')->middleware('module:user_section')->group(function () {
            Route::get('create', [Admin\CustomRoleController::class, 'create'])->name('create');
            Route::post('create', [Admin\CustomRoleController::class, 'store'])->name('store');
            Route::get('update/{id}', [Admin\CustomRoleController::class, 'edit'])->name('update');
            Route::post('update/{id}', [Admin\CustomRoleController::class, 'update']);
            Route::post('employee-role-status', [Admin\CustomRoleController::class, 'employee_role_status_update'])->name('employee-role-status');
            Route::get('export', [Admin\CustomRoleController::class, 'export'])->name('export');
            Route::post('delete', [Admin\CustomRoleController::class, 'delete'])->name('delete');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('view', [Admin\ProfileController::class, 'view'])->name('view');
            Route::get('update/{id}', [Admin\ProfileController::class, 'edit'])->name('update');
            Route::post('update/{id}', [Admin\ProfileController::class, 'update']);
            Route::post('settings-password', [Admin\ProfileController::class, 'settings_password_update'])->name('settings-password');
        });

        Route::prefix('withdraw')->name('withdraw.')->middleware('module:user_section')->group(function () {
            Route::post('update/{id}', [Admin\WithdrawController::class, 'update'])->name('update');
            Route::post('request', [Admin\WithdrawController::class, 'w_request'])->name('request');
            Route::post('status-filter', [Admin\WithdrawController::class, 'status_filter'])->name('status-filter');
        });

        Route::prefix('deal')->name('deal.')->middleware('module:promotion_management')->group(function () {
            Route::get('flash', [Admin\DealController::class, 'flash_index'])->name('flash');
            Route::post('flash', [Admin\DealController::class, 'flash_submit']);

            // feature deal
            Route::get('feature', [Admin\DealController::class, 'feature_index'])->name('feature');

            Route::get('day', [Admin\DealController::class, 'deal_of_day'])->name('day');
            Route::post('day', [Admin\DealController::class, 'deal_of_day_submit']);
            Route::post('day-status-update', [Admin\DealController::class, 'day_status_update'])->name('day-status-update');

            Route::get('day-update/{id}', [Admin\DealController::class, 'day_edit'])->name('day-update');
            Route::post('day-update/{id}', [Admin\DealController::class, 'day_update']);
            Route::post('day-delete', [Admin\DealController::class, 'day_delete'])->name('day-delete');

            Route::get('update/{id}', [Admin\DealController::class, 'edit'])->name('update');
            Route::get('edit/{id}', [Admin\DealController::class, 'feature_edit'])->name('edit');

            Route::post('update/{id}', [Admin\DealController::class, 'update'])->name('update');
            Route::post('status-update', [Admin\DealController::class, 'status_update'])->name('status-update');
            Route::post('feature-status', [Admin\DealController::class, 'feature_status'])->name('feature-status');

            Route::post('featured-update', [Admin\DealController::class, 'featured_update'])->name('featured-update');
            Route::get('add-product/{deal_id}', [Admin\DealController::class, 'add_product'])->name('add-product');
            Route::post('add-product/{deal_id}', [Admin\DealController::class, 'add_product_submit']);
            Route::post('delete-product', [Admin\DealController::class, 'delete_product'])->name('delete-product');
        });

        Route::prefix('employee')->name('employee.')->middleware('module:user_section')->group(function () {
            Route::get('add-new', [Admin\EmployeeController::class, 'add_new'])->name('add-new');
            Route::post('add-new', [Admin\EmployeeController::class, 'store']);
            Route::get('list', [Admin\EmployeeController::class, 'list'])->name('list');
            Route::get('update/{id}', [Admin\EmployeeController::class, 'edit'])->name('update');
            Route::post('update/{id}', [Admin\EmployeeController::class, 'update']);
            Route::post('status', [Admin\EmployeeController::class, 'status'])->name('status');
        });

        Route::prefix('category')->name('category.')->middleware('module:product_management')->group(function () {
            Route::get('view', [Admin\CategoryController::class, 'index'])->name('view');
            Route::get('fetch', [Admin\CategoryController::class, 'fetch'])->name('fetch');
            Route::post('store', [Admin\CategoryController::class, 'store'])->name('store');
            Route::get('edit/{id}', [Admin\CategoryController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\CategoryController::class, 'update'])->name('update');
            Route::post('delete', [Admin\CategoryController::class, 'delete'])->name('delete');
            Route::post('status', [Admin\CategoryController::class, 'status'])->name('status');
        });

        Route::prefix('sub-category')->name('sub-category.')->middleware('module:product_management')->group(function () {
            Route::get('view', [Admin\SubCategoryController::class, 'index'])->name('view');
            Route::get('fetch', [Admin\SubCategoryController::class, 'fetch'])->name('fetch');
            Route::post('store', [Admin\SubCategoryController::class, 'store'])->name('store');
            Route::post('edit', [Admin\SubCategoryController::class, 'edit'])->name('edit');
            Route::post('update', [Admin\SubCategoryController::class, 'update'])->name('update');
            Route::post('delete', [Admin\SubCategoryController::class, 'delete'])->name('delete');
        });

        Route::prefix('sub-sub-category')->name('sub-sub-category.')->middleware('module:product_management')->group(function () {
            Route::get('view', [Admin\SubSubCategoryController::class, 'index'])->name('view');
            Route::get('fetch', [Admin\SubSubCategoryController::class, 'fetch'])->name('fetch');
            Route::post('store', [Admin\SubSubCategoryController::class, 'store'])->name('store');
            Route::post('edit', [Admin\SubSubCategoryController::class, 'edit'])->name('edit');
            Route::post('update', [Admin\SubSubCategoryController::class, 'update'])->name('update');
            Route::post('delete', [Admin\SubSubCategoryController::class, 'delete'])->name('delete');
            Route::post('get-sub-category', [Admin\SubSubCategoryController::class, 'getSubCategory'])->name('getSubCategory');
            Route::post('get-category-id', [Admin\SubSubCategoryController::class, 'getCategoryId'])->name('getCategoryId');
        });

        Route::prefix('brand')->name('brand.')->middleware('module:product_management')->group(function () {
            Route::get('add-new', [Admin\BrandController::class, 'add_new'])->name('add-new');
            Route::post('add-new', [Admin\BrandController::class, 'store']);
            Route::get('list', [Admin\BrandController::class, 'list'])->name('list');
            Route::get('update/{id}', [Admin\BrandController::class, 'edit'])->name('update');
            Route::post('update/{id}', [Admin\BrandController::class, 'update']);
            Route::post('delete', [Admin\BrandController::class, 'delete'])->name('delete');
            Route::get('export', [Admin\BrandController::class, 'export'])->name('export');
            Route::post('status-update', [Admin\BrandController::class, 'status_update'])->name('status-update');
        });

        Route::prefix('banner')->name('banner.')->middleware('module:promotion_management')->group(function () {
            Route::post('add-new', [Admin\BannerController::class, 'store'])->name('store');
            Route::get('list', [Admin\BannerController::class, 'list'])->name('list');
            Route::post('delete', [Admin\BannerController::class, 'delete'])->name('delete');
            Route::post('status', [Admin\BannerController::class, 'status'])->name('status');
            Route::get('edit/{id}', [Admin\BannerController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [Admin\BannerController::class, 'update'])->name('update');
        });

        Route::prefix('attribute')->name('attribute.')->middleware('module:product_management')->group(function () {
            Route::get('view', [Admin\AttributeController::class, 'index'])->name('view');
            Route::get('fetch', [Admin\AttributeController::class, 'fetch'])->name('fetch');
            Route::post('store', [Admin\AttributeController::class, 'store'])->name('store');
            Route::get('edit/{id}', [Admin\AttributeController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\AttributeController::class, 'update'])->name('update');
            Route::post('delete', [Admin\AttributeController::class, 'delete'])->name('delete');
        });

        Route::prefix('coupon')->name('coupon.')->middleware('module:promotion_management')->group(function () {
            Route::get('add-new', [Admin\CouponController::class, 'add_new'])->name('add-new')->middleware('actch');
            Route::post('store-coupon', [Admin\CouponController::class, 'store'])->name('store-coupon');
            Route::get('update/{id}', [Admin\CouponController::class, 'edit'])->name('update')->middleware('actch');
            Route::post('update/{id}', [Admin\CouponController::class, 'update']);
            Route::get('status/{id}/{status}', [Admin\CouponController::class, 'status'])->name('status');
            Route::delete('delete/{id}', [Admin\CouponController::class, 'delete'])->name('delete');
        });

        Route::prefix('shiprocket')->name('shiprocket.')->group(function () {
            Route::post('login', [Admin\ShipRocketController::class, 'login'])->name('login');
            Route::get('dashboard', [Admin\ShipRocketController::class, 'index'])->name('index');
        });

        Route::prefix('social-login')->name('social-login.')->middleware('module:system_settings')->group(function () {
            Route::get('view', [Admin\BusinessSettingsController::class, 'viewSocialLogin'])->name('view');
            Route::post('update/{service}', [Admin\BusinessSettingsController::class, 'updateSocialLogin'])->name('update');
        });

        Route::prefix('product-settings')->name('product-settings.')->middleware('module:system_settings')->group(function () {
            Route::get('/', [Admin\BusinessSettingsController::class, 'productSettings'])->name('index');
            Route::get('inhouse-shop', [Admin\InhouseShopController::class, 'edit'])->name('inhouse-shop');
            Route::post('inhouse-shop', [Admin\InhouseShopController::class, 'update']);
            Route::post('stock-limit-warning', [Admin\BusinessSettingsController::class, 'stock_limit_warning'])->name('stock-limit-warning');
            Route::post('update-digital-product', [Admin\BusinessSettingsController::class, 'updateDigitalProduct'])->name('update-digital-product');
            Route::post('update-product-brand', [Admin\BusinessSettingsController::class, 'updateProductBrand'])->name('update-product-brand');
        });

        Route::prefix('currency')->name('currency.')->middleware('module:system_settings')->group(function () {
            Route::get('view', [Admin\CurrencyController::class, 'index'])->name('view')->middleware('actch');
            Route::get('fetch', [Admin\CurrencyController::class, 'fetch'])->name('fetch');
            Route::post('store', [Admin\CurrencyController::class, 'store'])->name('store');
            Route::get('edit/{id}', [Admin\CurrencyController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\CurrencyController::class, 'update'])->name('update');
            Route::post('delete', [Admin\CurrencyController::class, 'delete'])->name('delete');
            Route::post('status', [Admin\CurrencyController::class, 'status'])->name('status');
            Route::post('system-currency-update', [Admin\CurrencyController::class, 'systemCurrencyUpdate'])->name('system-currency-update');
        });

        Route::prefix('support-ticket')->name('support-ticket.')->middleware('module:support_section')->group(function () {
            Route::get('view', [Admin\SupportTicketController::class, 'index'])->name('view');
            Route::post('status', [Admin\SupportTicketController::class, 'status'])->name('status');
            Route::get('single-ticket/{id}', [Admin\SupportTicketController::class, 'single_ticket'])->name('singleTicket');
            Route::post('single-ticket/{id}', [Admin\SupportTicketController::class, 'replay_submit'])->name('replay');
        });
        Route::prefix('notification')->name('notification.')->middleware('module:promotion_management')->group(function () {
            Route::get('add-new', [Admin\NotificationController::class, 'index'])->name('add-new');
            Route::post('store', [Admin\NotificationController::class, 'store'])->name('store');
            Route::get('edit/{id}', [Admin\NotificationController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\NotificationController::class, 'update'])->name('update');
            Route::post('status', [Admin\NotificationController::class, 'status'])->name('status');
            Route::post('resend-notification', [Admin\NotificationController::class, 'resendNotification'])->name('resend-notification');
            Route::post('delete', [Admin\NotificationController::class, 'delete'])->name('delete');
        });
        Route::prefix('reviews')->name('reviews.')->middleware('module:user_section')->group(function () {
            Route::get('list', [Admin\ReviewsController::class, 'list'])->name('list')->middleware('actch');
            Route::get('export', [Admin\ReviewsController::class, 'export'])->name('export')->middleware('actch');
            Route::get('status/{id}/{status}', [Admin\ReviewsController::class, 'status'])->name('status');
        });

        Route::prefix('customer')->name('customer.')->middleware('module:user_section')->group(function () {
            Route::get('list', [Admin\CustomerController::class, 'customer_list'])->name('list');
            Route::post('status-update', [Admin\CustomerController::class, 'status_update'])->name('status-update');
            Route::get('view/{user_id}', [Admin\CustomerController::class, 'view'])->name('view');
            Route::delete('delete/{id}', [Admin\CustomerController::class, 'delete'])->name('delete');
            Route::get('subscriber-list', [Admin\CustomerController::class, 'subscriber_list'])->name('subscriber-list');
            Route::get('customer-settings', [Admin\CustomerController::class, 'customer_settings'])->name('customer-settings');
            Route::post('customer-settings-update', [Admin\CustomerController::class, 'customer_update_settings'])->name('customer-settings-update');
            Route::get('customer-list-search', [Admin\CustomerController::class, 'get_customers'])->name('customer-list-search');

            Route::get('export', [Admin\CustomerController::class, 'export'])->name('export');

            Route::prefix('wallet')->name('wallet.')->group(function () {
                Route::post('add-fund', [Admin\CustomerWalletController::class, 'add_fund'])->name('add-fund');
                Route::get('report', [Admin\CustomerWalletController::class, 'report'])->name('report');
            });
            Route::prefix('loyalty')->name('loyalty.')->group(function () {
                Route::get('report', [Admin\CustomerLoyaltyController::class, 'report'])->name('report');
            });
        });

        ///Report
        Route::prefix('report')->name('report.')->middleware('module:report')->group(function () {
            Route::get('order', [Admin\ReportController::class, 'order_index'])->name('order');
            Route::get('earning', [Admin\ReportController::class, 'earning_index'])->name('earning');
            Route::any('set-date', [Admin\ReportController::class, 'set_date'])->name('set-date');
            //sale report inhouse
            Route::get('inhoue-product-sale', [Admin\InhouseProductSaleController::class, 'index'])->name('inhoue-product-sale');
            Route::get('seller-product-sale', [Admin\SellerProductSaleReportController::class, 'index'])->name('seller-product-sale');
        });
        Route::prefix('stock')->name('stock.')->middleware('module:report')->group(function () {
            //product stock report
            Route::get('product-stock', [Admin\ProductStockReportController::class, 'index'])->name('product-stock');
            Route::get('product-stock-export', [Admin\ProductStockReportController::class, 'export'])->name('product-stock-export');
            Route::post('ps-filter', [Admin\ProductStockReportController::class, 'filter'])->name('ps-filter');
            //product in wishlist report
            Route::get('product-in-wishlist', [Admin\ProductWishlistReportController::class, 'index'])->name('product-in-wishlist');
            Route::get('wishlist-product-export', [Admin\ProductWishlistReportController::class, 'export'])->name('wishlist-product-export');
        });
        Route::prefix('sellers')->name('sellers.')->middleware('module:user_section')->group(function () {
            Route::get('seller-add', [Admin\SellerController::class, 'add_seller'])->name('seller-add');
            Route::get('seller-list', [Admin\SellerController::class, 'index'])->name('seller-list');
            Route::get('order-list/{seller_id}', [Admin\SellerController::class, 'order_list'])->name('order-list');
            Route::get('product-list/{seller_id}', [Admin\SellerController::class, 'product_list'])->name('product-list');

            Route::get('order-details/{order_id}/{seller_id}', [Admin\SellerController::class, 'order_details'])->name('order-details');
            Route::get('verification/{id}', [Admin\SellerController::class, 'view'])->name('verification');
            Route::get('view/{id}/{tab?}', [Admin\SellerController::class, 'view'])->name('view');
            Route::post('update-status', [Admin\SellerController::class, 'updateStatus'])->name('updateStatus');
            Route::post('withdraw-status/{id}', [Admin\SellerController::class, 'withdrawStatus'])->name('withdraw_status');
            Route::get('withdraw_list', [Admin\SellerController::class, 'withdraw'])->name('withdraw_list');
            Route::get('withdraw-view/{withdraw_id}/{seller_id}', [Admin\SellerController::class, 'withdraw_view'])->name('withdraw_view');

            Route::post('sales-commission-update/{id}', [Admin\SellerController::class, 'sales_commission_update'])->name('sales-commission-update');
        });
        Route::prefix('product')->name('product.')->middleware('module:product_management')->group(function () {
            Route::get('add-new', [Admin\ProductController::class, 'add_new'])->name('add-new');
            Route::post('store', [Admin\ProductController::class, 'store'])->name('store');
            Route::get('remove-image', [Admin\ProductController::class, 'remove_image'])->name('remove-image');
            Route::post('status-update', [Admin\ProductController::class, 'status_update'])->name('status-update');
            Route::get('list/{type}', [Admin\ProductController::class, 'list'])->name('list');
            Route::get('export-excel/{type}', [Admin\ProductController::class, 'export_excel'])->name('export-excel');
            Route::get('stock-limit-list/{type}', [Admin\ProductController::class, 'stock_limit_list'])->name('stock-limit-list');
            Route::get('get-variations', [Admin\ProductController::class, 'get_variations'])->name('get-variations');
            Route::post('update-quantity', [Admin\ProductController::class, 'update_quantity'])->name('update-quantity');
            Route::get('edit/{id}', [Admin\ProductController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\ProductController::class, 'update'])->name('update');
            Route::post('featured-status', [Admin\ProductController::class, 'featured_status'])->name('featured-status');
            Route::get('approve-status', [Admin\ProductController::class, 'approve_status'])->name('approve-status');
            Route::post('deny', [Admin\ProductController::class, 'deny'])->name('deny');
            Route::post('sku-combination', [Admin\ProductController::class, 'sku_combination'])->name('sku-combination');
            Route::get('get-categories', [Admin\ProductController::class, 'get_categories'])->name('get-categories');
            Route::delete('delete/{id}', [Admin\ProductController::class, 'delete'])->name('delete');
            Route::get('updated-product-list', [Admin\ProductController::class, 'updated_product_list'])->name('updated-product-list');
            Route::post('updated-shipping', [Admin\ProductController::class, 'updated_shipping'])->name('updated-shipping');

            Route::get('view/{id}', [Admin\ProductController::class, 'view'])->name('view');
            Route::get('bulk-import', [Admin\ProductController::class, 'bulk_import_index'])->name('bulk-import');
            Route::post('bulk-import', [Admin\ProductController::class, 'bulk_import_data']);
            Route::get('bulk-export', [Admin\ProductController::class, 'bulk_export_data'])->name('bulk-export');
            Route::get('barcode/{id}', [Admin\ProductController::class, 'barcode'])->name('barcode');
            Route::get('barcode/generate', [Admin\ProductController::class, 'barcode_generate'])->name('barcode.generate');
        });

        Route::prefix('transaction')->name('transaction.')->middleware('module:report')->group(function () {
            Route::get('list', [Admin\TransactionController::class, 'list'])->name('list');
            Route::get('transaction-export', [Admin\TransactionController::class, 'export'])->name('transaction-export');
        });

        Route::prefix('refund-section')->name('refund-section.')->middleware('module:report')->group(function () {
            Route::get('refund-list', [Admin\RefundTransactionController::class, 'list'])->name('refund-list');

            //refund request
            Route::prefix('refund')->name('refund.')->group(function () {
                Route::get('list/{status}', [Admin\RefundController::class, 'list'])->name('list');
                Route::get('details/{id}', [Admin\RefundController::class, 'details'])->name('details');
                Route::get('inhouse-order-filter', [Admin\RefundController::class, 'inhouse_order_filter'])->name('inhouse-order-filter');
                Route::post('refund-status-update', [Admin\RefundController::class, 'refund_status_update'])->name('refund-status-update');
            });

            Route::get('refund-index', [Admin\RefundController::class, 'index'])->name('refund-index');
            Route::post('refund-update', [Admin\RefundController::class, 'update'])->name('refund-update');
        });

        Route::prefix('business-settings')->name('business-settings.')->group(function () {
            Route::middleware('module:system_settings')->group(function () {
                Route::get('sms-module', [Admin\SMSModuleController::class, 'sms_index'])->name('sms-module');
                Route::post('sms-module-update/{sms_module}', [Admin\SMSModuleController::class, 'sms_update'])->name('sms-module-update');
            });

            Route::prefix('shipping-method')->name('shipping-method.')->middleware('module:system_settings')->group(function () {
                Route::get('by/admin', [Admin\ShippingMethodController::class, 'index_admin'])->name('by.admin');
                //Route::get('by/seller', 'ShippingMethodController@index_seller')->name('by.seller');
                Route::post('add', [Admin\ShippingMethodController::class, 'store'])->name('add');
                Route::get('edit/{id}', [Admin\ShippingMethodController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [Admin\ShippingMethodController::class, 'update'])->name('update');
                Route::post('delete', [Admin\ShippingMethodController::class, 'delete'])->name('delete');
                Route::post('status-update', [Admin\ShippingMethodController::class, 'status_update'])->name('status-update');
                Route::get('setting', [Admin\ShippingMethodController::class, 'setting'])->name('setting');
                Route::post('shipping-store', [Admin\ShippingMethodController::class, 'shippingStore'])->name('shipping-store');
            });

            Route::prefix('shipping-type')->name('shipping-type.')->middleware('module:system_settings')->group(function () {
                Route::post('store', [Admin\ShippingTypeController::class, 'store'])->name('store');
            });

            Route::prefix('category-shipping-cost')->name('category-shipping-cost.')->middleware('module:system_settings')->group(function () {
                Route::post('store', [Admin\CategoryShippingCostController::class, 'store'])->name('store');
            });

            Route::prefix('language')->name('language.')->middleware('module:system_settings')->group(function () {
                Route::get('', [Admin\LanguageController::class, 'index'])->name('index');
//                Route::get('app', 'LanguageController@index_app')->name('index-app');
                Route::post('add-new', [Admin\LanguageController::class, 'store'])->name('add-new');
                Route::get('update-status', [Admin\LanguageController::class, 'update_status'])->name('update-status');
                Route::get('update-default-status', [Admin\LanguageController::class, 'update_default_status'])->name('update-default-status');
                Route::post('update', [Admin\LanguageController::class, 'update'])->name('update');
                Route::get('translate/{lang}', [Admin\LanguageController::class, 'translate'])->name('translate');
                Route::post('translate-submit/{lang}', [Admin\LanguageController::class, 'translate_submit'])->name('translate-submit');
                Route::post('remove-key/{lang}', [Admin\LanguageController::class, 'translate_key_remove'])->name('remove-key');
                Route::get('delete/{lang}', [Admin\LanguageController::class, 'delete'])->name('delete');
            });

            Route::prefix('mail')->name('mail.')->middleware('module:system_settings')->group(function () {
                Route::get('/', [Admin\MailController::class, 'index'])->name('index');
                Route::post('update', [Admin\MailController::class, 'update'])->name('update');
                Route::post('update-sendgrid', [Admin\MailController::class, 'update_sendgrid'])->name('update-sendgrid');
                Route::post('send', [Admin\MailController::class, 'send'])->name('send');
            });

            Route::prefix('web-config')->name('web-config.')->middleware('module:system_settings')->group(function () {
                Route::get('/', [Admin\BusinessSettingsController::class, 'companyInfo'])->name('index')->middleware('actch');
                Route::post('update-colors', [Admin\BusinessSettingsController::class, 'update_colors'])->name('update-colors');
                Route::post('update-language', [Admin\BusinessSettingsController::class, 'update_language'])->name('update-language');
                Route::post('update-company', [Admin\BusinessSettingsController::class, 'updateCompany'])->name('company-update');
                Route::post('update-company-email', [Admin\BusinessSettingsController::class, 'updateCompanyEmail'])->name('company-email-update');
                Route::post('update-company-phone', [Admin\BusinessSettingsController::class, 'updateCompanyPhone'])->name('company-phone-update');
                Route::post('upload-web-logo', [Admin\BusinessSettingsController::class, 'uploadWebLogo'])->name('company-web-logo-upload');
                Route::post('upload-mobile-logo', [Admin\BusinessSettingsController::class, 'uploadMobileLogo'])->name('company-mobile-logo-upload');
                Route::post('upload-footer-log', [Admin\BusinessSettingsController::class, 'uploadFooterLog'])->name('company-footer-logo-upload');
                Route::post('upload-fav-icon', [Admin\BusinessSettingsController::class, 'uploadFavIcon'])->name('company-fav-icon');
                Route::post('update-company-copyRight-text', [Admin\BusinessSettingsController::class, 'updateCompanyCopyRight'])->name('company-copy-right-update');
                Route::post('app-store/{name}', [Admin\BusinessSettingsController::class, 'update'])->name('app-store-update');
                Route::get('currency-symbol-position/{side}', [Admin\BusinessSettingsController::class, 'currency_symbol_position'])->name('currency-symbol-position');
                Route::post('shop-banner', [Admin\BusinessSettingsController::class, 'shop_banner'])->name('shop-banner');
                Route::get('app-settings', [Admin\BusinessSettingsController::class, 'app_settings'])->name('app-settings');

                Route::get('db-index', [Admin\DatabaseSettingController::class, 'db_index'])->name('db-index');
                Route::post('db-clean', [Admin\DatabaseSettingController::class, 'clean_db'])->name('clean-db');

                Route::get('environment-setup', [Admin\EnvironmentSettingsController::class, 'environment_index'])->name('environment-setup');
                Route::post('update-environment', [Admin\EnvironmentSettingsController::class, 'environment_setup'])->name('update-environment');

                //sitemap generate
                Route::get('mysitemap', [Admin\SiteMapController::class, 'index'])->name('mysitemap');
                Route::get('mysitemap-download', [Admin\SiteMapController::class, 'download'])->name('mysitemap-download');
            });

            Route::prefix('order-settings')->name('order-settings.')->middleware('module:system_settings')->group(function () {
                Route::get('index', [Admin\OrderSettingsController::class, 'order_settings'])->name('index');
                Route::post('update-order-settings', [Admin\OrderSettingsController::class, 'update_order_settings'])->name('update-order-settings');
            });

            Route::prefix('seller-settings')->name('seller-settings.')->middleware('module:system_settings')->group(function () {
                Route::get('/', [Admin\BusinessSettingsController::class, 'seller_settings'])->name('index')->middleware('actch');
                Route::post('update-seller-settings', [Admin\BusinessSettingsController::class, 'sales_commission'])->name('update-seller-settings');
                Route::post('update-seller-registration', [Admin\BusinessSettingsController::class, 'seller_registration'])->name('update-seller-registration');
                Route::post('seller-pos-settings', [Admin\BusinessSettingsController::class, 'seller_pos_settings'])->name('seller-pos-settings');
                Route::get('business-mode-settings/{mode}', [Admin\BusinessSettingsController::class, 'business_mode_settings'])->name('business-mode-settings');
                Route::post('product-approval', [Admin\BusinessSettingsController::class, 'product_approval'])->name('product-approval');
            });

            Route::prefix('payment-method')->name('payment-method.')->middleware('module:system_settings')->group(function () {
                Route::get('/', [Admin\PaymentMethodController::class, 'index'])->name('index')->middleware('actch');
                Route::post('{name}', [Admin\PaymentMethodController::class, 'update'])->name('update');
            });

            Route::middleware('module:system_settings')->group(function () {
                Route::get('general-settings', [Admin\BusinessSettingsController::class, 'index'])->name('general-settings')->middleware('actch');
                Route::get('update-language', [Admin\BusinessSettingsController::class, 'update_language'])->name('update-language');
                Route::get('about-us', [Admin\BusinessSettingsController::class, 'about_us'])->name('about-us');
                Route::post('about-us', [Admin\BusinessSettingsController::class, 'about_usUpdate'])->name('about-update');
                Route::post('update-info', [Admin\BusinessSettingsController::class, 'updateInfo'])->name('update-info');
                Route::get('announcement', [Admin\BusinessSettingsController::class, 'announcement'])->name('announcement');
                Route::post('update-announcement', [Admin\BusinessSettingsController::class, 'updateAnnouncement'])->name('update-announcement');
                //Social Icon
                Route::get('social-media', [Admin\BusinessSettingsController::class, 'social_media'])->name('social-media');
                Route::get('fetch', [Admin\BusinessSettingsController::class, 'fetch'])->name('fetch');
                Route::post('social-media-store', [Admin\BusinessSettingsController::class, 'social_media_store'])->name('social-media-store');
                Route::post('social-media-edit', [Admin\BusinessSettingsController::class, 'social_media_edit'])->name('social-media-edit');
                Route::post('social-media-update', [Admin\BusinessSettingsController::class, 'social_media_update'])->name('social-media-update');
                Route::post('social-media-delete', [Admin\BusinessSettingsController::class, 'social_media_delete'])->name('social-media-delete');
                Route::post('social-media-status-update', [Admin\BusinessSettingsController::class, 'social_media_status_update'])->name('social-media-status-update');

                Route::get('terms-condition', [Admin\BusinessSettingsController::class, 'terms_condition'])->name('terms-condition');
                Route::post('terms-condition', [Admin\BusinessSettingsController::class, 'updateTermsCondition'])->name('update-terms');
                Route::get('privacy-policy', [Admin\BusinessSettingsController::class, 'privacy_policy'])->name('privacy-policy');
                Route::post('privacy-policy', [Admin\BusinessSettingsController::class, 'privacy_policy_update'])->name('privacy-policy');

                Route::get('fcm-index', [Admin\BusinessSettingsController::class, 'fcm_index'])->name('fcm-index');
                Route::post('update-fcm', [Admin\BusinessSettingsController::class, 'update_fcm'])->name('update-fcm');

                //captcha
                Route::get('captcha', [Admin\BusinessSettingsController::class, 'recaptcha_index'])->name('captcha');
                Route::post('recaptcha-update', [Admin\BusinessSettingsController::class, 'recaptcha_update'])->name('recaptcha_update');
                //google map api
                Route::get('map-api', [Admin\BusinessSettingsController::class, 'map_api'])->name('map-api');
                Route::post('map-api-update', [Admin\BusinessSettingsController::class, 'map_api_update'])->name('map-api-update');

                Route::post('update-fcm-messages', [Admin\BusinessSettingsController::class, 'update_fcm_messages'])->name('update-fcm-messages');

                //analytics
                Route::get('analytics-index', [Admin\BusinessSettingsController::class, 'analytics_index'])->name('analytics-index');
                Route::post('analytics-update', [Admin\BusinessSettingsController::class, 'analytics_update'])->name('analytics-update');
                Route::post('analytics-update-google-tag', [Admin\BusinessSettingsController::class, 'google_tag_analytics_update'])->name('analytics-update-google-tag');
            });

            Route::prefix('delivery-restriction')->name('delivery-restriction.')->middleware('module:system_settings')->group(function () {
                Route::get('/', [Admin\DeliveryRestrictionController::class, 'index'])->name('index');
                Route::post('add-delivery-country', [Admin\DeliveryRestrictionController::class, 'addDeliveryCountry'])->name('add-delivery-country');
                Route::delete('delivery-country-delete', [Admin\DeliveryRestrictionController::class, 'deliveryCountryDelete'])->name('delivery-country-delete');
                Route::post('country-restriction-status-change', [Admin\BusinessSettingsController::class, 'countryRestrictionStatusChange'])->name('country-restriction-status-change');

                Route::post('add-zip-code', [Admin\DeliveryRestrictionController::class, 'addZipCode'])->name('add-zip-code');
                Route::delete('zip-code-delete', [Admin\DeliveryRestrictionController::class, 'zipCodeDelete'])->name('zip-code-delete');
                Route::post('zipcode-restriction-status-change', [Admin\BusinessSettingsController::class, 'zipcodeRestrictionStatusChange'])->name('zipcode-restriction-status-change');
            });
        });
        //order management
        Route::prefix('orders')->name('orders.')->middleware('module:order_management')->group(function () {
            Route::get('list/{status}', [Admin\OrderController::class, 'list'])->name('list');
            Route::get('details/{id}', [Admin\OrderController::class, 'details'])->name('details');
            Route::post('status', [Admin\OrderController::class, 'status'])->name('status');
            Route::post('amount-date-update', [Admin\OrderController::class, 'amount_date_update'])->name('amount-date-update');
            Route::post('payment-status', [Admin\OrderController::class, 'payment_status'])->name('payment-status');
            Route::post('productStatus', [Admin\OrderController::class, 'productStatus'])->name('productStatus');
            Route::get('generate-invoice/{id}', [Admin\OrderController::class, 'generate_invoice'])->name('generate-invoice')->withoutMiddleware(['module:order_management']);
            Route::get('inhouse-order-filter', [Admin\OrderController::class, 'inhouse_order_filter'])->name('inhouse-order-filter');
            Route::post('digital-file-upload-after-sell', [Admin\OrderController::class, 'digital_file_upload_after_sell'])->name('digital-file-upload-after-sell');

            Route::post('update-deliver-info', [Admin\OrderController::class, 'update_deliver_info'])->name('update-deliver-info');
            Route::get('add-delivery-man/{order_id}/{d_man_id}', [Admin\OrderController::class, 'add_delivery_man'])->name('add-delivery-man');

            Route::get('export-order-data/{status}', [Admin\OrderController::class, 'bulk_export_data'])->name('order-bulk-export');
        });

        //pos management
        Route::prefix('pos')->name('pos.')->middleware('module:pos_management')->group(function () {
            Route::get('/', [Admin\POSController::class, 'index'])->name('index');
            Route::get('quick-view', [Admin\POSController::class, 'quick_view'])->name('quick-view');
            Route::post('variant_price', [Admin\POSController::class, 'variant_price'])->name('variant_price');
            Route::post('add-to-cart', [Admin\POSController::class, 'addToCart'])->name('add-to-cart');
            Route::post('remove-from-cart', [Admin\POSController::class, 'removeFromCart'])->name('remove-from-cart');
            Route::post('cart-items', [Admin\POSController::class, 'cart_items'])->name('cart_items');
            Route::post('update-quantity', [Admin\POSController::class, 'updateQuantity'])->name('updateQuantity');
            Route::post('empty-cart', [Admin\POSController::class, 'emptyCart'])->name('emptyCart');
            Route::post('tax', [Admin\POSController::class, 'update_tax'])->name('tax');
            Route::post('discount', [Admin\POSController::class, 'update_discount'])->name('discount');
            Route::get('customers', [Admin\POSController::class, 'get_customers'])->name('customers');
            Route::post('order', [Admin\POSController::class, 'place_order'])->name('order');
            Route::get('orders', [Admin\POSController::class, 'order_list'])->name('orders');
            Route::get('order-details/{id}', [Admin\POSController::class, 'order_details'])->name('order-details');
            Route::post('digital-file-upload-after-sell', [Admin\POSController::class, 'digital_file_upload_after_sell'])->name('digital-file-upload-after-sell');
            Route::get('invoice/{id}', [Admin\POSController::class, 'generate_invoice']);
            Route::any('store-keys', [Admin\POSController::class, 'store_keys'])->name('store-keys');
            Route::get('search-products', [Admin\POSController::class, 'search_product'])->name('search-products');
            Route::get('order-bulk-export', [Admin\POSController::class, 'bulk_export_data'])->name('order-bulk-export');

            Route::post('coupon-discount', [Admin\POSController::class, 'coupon_discount'])->name('coupon-discount');
            Route::get('change-cart', [Admin\POSController::class, 'change_cart'])->name('change-cart');
            Route::get('new-cart-id', [Admin\POSController::class, 'new_cart_id'])->name('new-cart-id');
            Route::post('remove-discount', [Admin\POSController::class, 'remove_discount'])->name('remove-discount');
            Route::get('clear-cart-ids', [Admin\POSController::class, 'clear_cart_ids'])->name('clear-cart-ids');
            Route::get('get-cart-ids', [Admin\POSController::class, 'get_cart_ids'])->name('get-cart-ids');

            Route::post('customer-store', [Admin\POSController::class, 'customer_store'])->name('customer-store');
        });

        Route::prefix('helpTopic')->name('helpTopic.')->middleware('module:system_settings')->group(function () {
            Route::get('list', [Admin\HelpTopicController::class, 'list'])->name('list');
            Route::post('add-new', [Admin\HelpTopicController::class, 'store'])->name('add-new');
            Route::get('status/{id}', [Admin\HelpTopicController::class, 'status']);
            Route::get('edit/{id}', [Admin\HelpTopicController::class, 'edit']);
            Route::post('update/{id}', [Admin\HelpTopicController::class, 'update']);
            Route::post('delete', [Admin\HelpTopicController::class, 'destroy'])->name('delete');
        });

        Route::prefix('contact')->name('contact.')->middleware('module:support_section')->group(function () {
            Route::post('contact-store', [Admin\ContactController::class, 'store'])->name('store');
            Route::get('list', [Admin\ContactController::class, 'list'])->name('list');
            Route::post('delete', [Admin\ContactController::class, 'destroy'])->name('delete');
            Route::get('view/{id}', [Admin\ContactController::class, 'view'])->name('view');
            Route::post('update/{id}', [Admin\ContactController::class, 'update'])->name('update');
            Route::post('send-mail/{id}', [Admin\ContactController::class, 'send_mail'])->name('send-mail');
        });

        Route::prefix('delivery-man')->name('delivery-man.')->middleware('module:user_section')->group(function () {
            Route::get('add', [Admin\DeliveryManController::class, 'index'])->name('add');
            Route::post('store', [Admin\DeliveryManController::class, 'store'])->name('store');
            Route::get('list', [Admin\DeliveryManController::class, 'list'])->name('list');
            Route::get('review-list/{id}', [Admin\DeliveryManController::class, 'review_list'])->name('review-list');
            Route::get('preview/{id}', [Admin\DeliveryManController::class, 'preview'])->name('preview');
            Route::get('edit/{id}', [Admin\DeliveryManController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [Admin\DeliveryManController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [Admin\DeliveryManController::class, 'delete'])->name('delete');
            Route::post('search', [Admin\DeliveryManController::class, 'search'])->name('search');
            Route::post('status-update', [Admin\DeliveryManController::class, 'status'])->name('status-update');
            Route::get('earning-statement-overview/{id}', [Admin\DeliveryManController::class, 'earning_statement_overview'])->name('earning-statement-overview');
            Route::get('collect-cash/{id}', [Admin\DeliveryManCashCollectController::class, 'collect_cash'])->name('collect-cash');
            Route::post('cash-receive/{id}', [Admin\DeliveryManCashCollectController::class, 'cash_receive'])->name('cash-receive');
            Route::get('earning-active-log/{id}', [Admin\DeliveryManController::class, 'earning_active_log'])->name('earning-active-log');
            Route::get('order-wise-earning/{id}', [Admin\DeliveryManController::class, 'order_wise_earning'])->name('order-wise-earning');
            Route::get('ajax-order-status-history/{order}', [Admin\DeliveryManController::class, 'ajax_order_status_history'])->name('ajax-order-status-history');

            Route::get('withdraw-list', [Admin\DeliverymanWithdrawController::class, 'withdraw'])->name('withdraw-list');
            Route::get('withdraw-list-export', [Admin\DeliverymanWithdrawController::class, 'export'])->name('withdraw-list-export');
            Route::post('status-filter', [Admin\DeliverymanWithdrawController::class, 'status_filter'])->name('status-filter');
            Route::get('withdraw-view/{withdraw_id}', [Admin\DeliverymanWithdrawController::class, 'withdraw_view'])->name('withdraw-view');
            Route::post('withdraw-status/{id}', [Admin\DeliverymanWithdrawController::class, 'withdraw_status'])->name('withdraw_status');

            Route::get('chat', [Admin\ChattingController::class, 'chat'])->name('chat');
            Route::get('ajax-message-by-delivery-man', [Admin\ChattingController::class, 'ajax_message_by_delivery_man'])->name('ajax-message-by-delivery-man');
            Route::post('admin-message-store', [Admin\ChattingController::class, 'ajax_admin_message_store'])->name('ajax-admin-message-store');

            Route::prefix('emergency-contact')->name('emergency-contact.')->group(function () {
                Route::get('/', [Admin\EmergencyContactController::class, 'emergency_contact'])->name('index');
                Route::post('add', [Admin\EmergencyContactController::class, 'add'])->name('add');
                Route::post('ajax-status-change', [Admin\EmergencyContactController::class, 'ajax_status_change'])->name('ajax-status-change');
                Route::delete('destroy', [Admin\EmergencyContactController::class, 'destroy'])->name('destroy');
            });

            Route::get('rating/{id}', [Admin\DeliveryManController::class, 'rating'])->name('rating');
        });

        Route::prefix('file-manager')->name('file-manager.')->middleware('module:system_settings')->group(function () {
            Route::get('/download/{file_name}', [Admin\FileManagerController::class, 'download'])->name('download');
            Route::get('/index/{folder_path?}', [Admin\FileManagerController::class, 'index'])->name('index');
            Route::post('/image-upload', [Admin\FileManagerController::class, 'upload'])->name('image-upload');
            Route::delete('/delete/{file_path}', [Admin\FileManagerController::class, 'destroy'])->name('destroy');
        });
    });

    //for test

    /*Route::get('login', 'testController@login')->name('login');*/
});
