<?php
/*
 * File name: web.php
 * Last modified: 2022.04.15 at 19:06:55
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

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

Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();

Route::get('payments/failed', 'PayPalController@index')->name('payments.failed');
Route::get('payments/razorpay/checkout', 'RazorPayController@checkout');
Route::post('payments/razorpay/pay-success/{bookingId}', 'RazorPayController@paySuccess');
Route::get('payments/razorpay', 'RazorPayController@index');

Route::get('payments/stripe/checkout', 'StripeController@checkout');
Route::get('payments/stripe/pay-success/{bookingId}/{paymentMethodId}', 'StripeController@paySuccess');
Route::get('payments/stripe', 'StripeController@index');

Route::get('payments/paymongo/checkout', 'PayMongoController@checkout');
Route::get('payments/paymongo/processing/{bookingId}/{paymentMethodId}', 'PayMongoController@processing');
Route::get('payments/paymongo/success/{bookingId}/{paymentIntentId}', 'PayMongoController@success');
Route::get('payments/paymongo', 'PayMongoController@index');

Route::get('payments/stripe-fpx/checkout', 'StripeFPXController@checkout');
Route::get('payments/stripe-fpx/pay-success/{bookingId}', 'StripeFPXController@paySuccess');
Route::get('payments/stripe-fpx', 'StripeFPXController@index');

Route::get('payments/flutterwave/checkout', 'FlutterWaveController@checkout');
Route::get('payments/flutterwave/pay-success/{bookingId}/{transactionId}', 'FlutterWaveController@paySuccess');
Route::get('payments/flutterwave', 'FlutterWaveController@index');

Route::get('payments/paystack/checkout', 'PayStackController@checkout');
Route::get('payments/paystack/pay-success/{bookingId}/{reference}', 'PayStackController@paySuccess');
Route::get('payments/paystack', 'PayStackController@index');

Route::get('payments/paypal/express-checkout', 'PayPalController@getExpressCheckout')->name('paypal.express-checkout');
Route::get('payments/paypal/express-checkout-success', 'PayPalController@getExpressCheckoutSuccess');
Route::get('payments/paypal', 'PayPalController@index')->name('paypal.index');

Route::get('firebase/sw-js', 'AppSettingController@initFirebase');


Route::get('storage/app/public/{id}/{conversion}/{filename?}', 'UploadController@storage');
Route::middleware('auth')->group(function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::post('uploads/store', 'UploadController@store')->name('medias.create');
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/remove-media', 'UserController@removeMedia');
    Route::resource('users', 'UserController');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['middleware' => ['permission:medias']], function () {
        Route::get('uploads/all/{collection?}', 'UploadController@all');
        Route::get('uploads/collectionsNames', 'UploadController@collectionsNames');
        Route::post('uploads/clear', 'UploadController@clear')->name('medias.delete');
        Route::get('medias', 'UploadController@index')->name('medias');
        Route::get('uploads/clear-all', 'UploadController@clearAll');
    });

    Route::group(['middleware' => ['permission:permissions.index']], function () {
        Route::get('permissions/role-has-permission', 'PermissionController@roleHasPermission');
        Route::get('permissions/refresh-permissions', 'PermissionController@refreshPermissions');
    });
    Route::group(['middleware' => ['permission:permissions.index']], function () {
        Route::post('permissions/give-permission-to-role', 'PermissionController@givePermissionToRole');
        Route::post('permissions/revoke-permission-to-role', 'PermissionController@revokePermissionToRole');

    });

    Route::get('modules', 'ModuleController@index')->name('modules.index');
    Route::put('modules/{id}', 'ModuleController@enable')->name('modules.enable');
    Route::post('modules/{id}/install', 'ModuleController@install')->name('modules.install');
    Route::post('modules/{id}/update', 'ModuleController@update')->name('modules.update');

    Route::group(['middleware' => ['permission:app-settings']], function () {
        Route::prefix('settings')->group(function () {
            Route::resource('permissions', 'PermissionController');
            Route::resource('roles', 'RoleController');
            Route::resource('customFields', 'CustomFieldController');
            Route::resource('currencies', 'CurrencyController')->except([
                'show'
            ]);
            Route::resource('taxes', 'TaxController')->except([
                'show'
            ]);
            Route::get('users/login-as-user/{id}', 'UserController@loginAsUser')->name('users.login-as-user');
            Route::patch('update', 'AppSettingController@update');
            Route::patch('updateLanguage', 'AppSettingController@updateLanguage');
            Route::patch('translate', 'AppSettingController@translate');
            Route::get('sync-translation', 'AppSettingController@syncTranslation');
            Route::get('clear-cache', 'AppSettingController@clearCache');
            Route::get('check-update', 'AppSettingController@checkForUpdates');
            // disable special character and number in route params
            Route::get('/{type?}/{tab?}', 'AppSettingController@index')
                ->where('type', '[A-Za-z]*')->where('tab', '[A-Za-z]*')->name('app-settings');
        });
    });

    Route::resource('eProviderTypes', 'EProviderTypeController')->except([
        'show'
    ]);
    Route::post('eProviders/remove-media', 'EProviderController@removeMedia');
    Route::resource('eProviders', 'EProviderController')->except([
//        'show'
    ]);

    Route::get('eProvider/{id}', 'EProviderController@CreateEserviesProvider')->name('eProviders.CreateEserviesProvider');
    Route::post('eProvider/{id}', 'EProviderController@StoreEserviesProvider')->name('eProviders.StoreEserviesProvider');
    Route::get('eProvider_services/{id}', 'EProviderController@EditServiesProvider')->name('eProviders.EditServiesProvider');
    Route::post('eProvider_services/{id}', 'EProviderController@UpdateEserviesProvider')->name('eProviders.UpdateEserviesProvider');
    Route::get('eProvider_/{id}', 'EProviderController@DestroyEserviesProvider')->name('eProvider_.DestroyEserviesProvider');
    Route::post('eProviders/{id}', 'EProviderController@UpdateEserviesProvider')->name('eProviders.UpdateEserviesProvider');
    Route::get('eProvider_/{id}', 'EProviderController@DestroyEserviesProvider')->name('eProviders.DestroyEserviesProvider');
    Route::get('check_doctor_name/{id}', 'EProviderController@CheckDoctorName');
    Route::get('e_Providers/{id}', 'EProviderController@ShowService')->name('e_Providers.ShowService');


    
    
    Route::get('requestedEProviders', 'EProviderController@requestedEProviders')->name('requestedEProviders.index');

    Route::resource('addresses', 'AddressController')->except([
        'show'
    ]);
    Route::resource('awards', 'AwardController');
    Route::resource('experiences', 'ExperienceController');

    Route::resource('availabilityHours', 'AvailabilityHourController')->except([
        'show'
    ]);
    Route::post('eServices/remove-media', 'EServiceController@removeMedia');
    Route::resource('eServices', 'EServiceController')->except([
        'show'
    ]);
    Route::resource('eServiceTypes', 'EServiceTypeController')->except([
//        'show'
    ]);
    Route::get('eServiceTypesname', 'EServiceTypeController@namesindex')->name("eServiceTypes.namesindex");
    Route::resource('faqCategories', 'FaqCategoryController')->except([
        'show'
    ]);
    Route::post('categories/remove-media', 'CategoryController@removeMedia');
    Route::resource('categories', 'CategoryController')->except([
        'show'
    ]);
    Route::resource('bookingStatuses', 'BookingStatusController')->except([
        'show',
    ]);
    Route::post('galleries/remove-media', 'GalleryController@removeMedia');
    Route::resource('galleries', 'GalleryController')->except([
        'show'
    ]);


    Route::resource('eServiceReviews', 'EServiceReviewController')->except([
        'show'
    ]);
    Route::resource('payments', 'PaymentController')->except([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);
    Route::post('paymentMethods/remove-media', 'PaymentMethodController@removeMedia');
    Route::resource('paymentMethods', 'PaymentMethodController')->except([
        'show'
    ]);
    Route::resource('paymentStatuses', 'PaymentStatusController')->except([
        'show'
    ]);
    Route::resource('faqs', 'FaqController')->except([
        'show'
    ]);
    Route::resource('favorites', 'FavoriteController')->except([
        'show'
    ]);
    Route::resource('notifications', 'NotificationController')->except([
        'create', 'store', 'update', 'edit',
    ]);

    Route::resource('bookings', 'BookingController');

    Route::get('booking/{id}', 'BookingController@uploadFile')->name('booking.upload_file');
    Route::post('booking/{id}', 'BookingController@StoreReservationFile')->name('booking.StoreReservationFile');


    Route::resource('earnings', 'EarningController')->except([
        'show', 'edit', 'update'
    ]);

    Route::get('eProviderPayouts/create/{id}', 'EProviderPayoutController@create')->name('eProviderPayouts.create');
    Route::resource('eProviderPayouts', 'EProviderPayoutController')->except([
        'show', 'edit', 'update', 'create'
    ]);
    Route::resource('optionGroups', 'OptionGroupController')->except([
        'show'
    ]);
    Route::post('options/remove-media', 'OptionController@removeMedia');
    Route::resource('options', 'OptionController')->except([
        'show'
    ]);
    Route::resource('coupons', 'CouponController')->except([
        'show'
    ]);
    Route::post('slides/remove-media', 'SlideController@removeMedia');
    Route::resource('slides', 'SlideController')->except([
        'show'
    ]);
    Route::resource('customPages', 'CustomPageController');

    Route::resource('wallets', 'WalletController')->except([
        'show'
    ]);
    Route::resource('walletTransactions', 'WalletTransactionController')->except([
        'show', 'edit', 'update', 'destroy'
    ]);

    Route::resource('PatientMedical', 'PatientMedicalFileController');

    // ==== Strat VideoSdk ====// 
    Route::get('meeting_Creates', 'VideoSDKController@MeetingCreate');
    Route::get('meeting_Ids', 'VideoSDKController@meetingId');
    Route::get('meetings_validate', 'VideoSDKController@MeetingsValidation');
    // ==== End VideoSdk ====// 

    // ==== Strat Speciality ====// 
    Route::resource('speciality', 'SpecialityController');
    // ==== End Speciality ====// 

    


    Route::get('getTokens', 'PatientMedicalFileController@getTokens');
    Route::get('created', 'PatientMedicalFileController@created');
    Route::get('meetingIds', 'PatientMedicalFileController@meetingIds');
    Route::get('validateMeetings', 'PatientMedicalFileController@validateMeetings');

    
});
