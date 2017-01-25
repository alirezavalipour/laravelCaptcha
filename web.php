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
//Route::get('/as' . 'syncController@getSync');

use App\User;


Route::get('/client/update/{ip?}', 'syncController@update');
Route::get('/sync/request/{ip?}', 'syncController@requestSync');
Route::post('/sync/product/new', 'syncController@newProductSync');
Route::post('/sync/product/update', 'syncController@updateProductSync');
Route::post('/sync/language/new', 'syncController@newLanguageSync');
Route::post('/sync/language/update', 'syncController@updateLanguageSync');
Route::post('/sync/category/new', 'syncController@newCategorySync');
Route::post('/sync/category/update', 'syncController@updateCategorySync');
Route::post('/sync/package/new', 'syncController@newPackageSync');
Route::post('/sync/package/update', 'syncController@updatePackageSync');
Route::post('/sync/provider/new', 'syncController@newProviderSync');
Route::post('/sync/provider/update', 'syncController@updateProviderSync');
Route::post('/sync/order/server', 'syncController@orderServerSync');
Route::post('/sync/buylog/server', 'syncController@buyLogServerSync');
Route::post('/sync/voucher/new', 'syncController@newVoucherSync');
Route::get('/sync/order', 'syncController@orderSync');
Route::post('user/update/password', 'userController@updatePasswordServer');
Route::post('/sync/user/update', 'userController@updateUserCreditServer'); # update credit
Route::post('/sync/user/voucher', 'voucherController@syncUserVoucherServer'); # server update voucher
Route::post('/sync/user/order', 'orderController@syncUserOrderServer'); # server update voucher
Route::post('/sync/user/buylog', 'orderController@syncUserBuyLogServer'); # server update voucher
Route::get('/sync/voucher/all', 'syncController@voucherSyncAll'); # sync not synced voucher
Route::post('/sync/voucher/server', 'syncController@voucherSyncAllServer'); # sync not synced voucher  server side
Route::post('/sync/payment/all', 'syncController@paymentSyncAll'); # sync not synced payments  server side
Route::post('/sync/payment/server', 'paymentController@SyncServer'); # sync not synced voucher  server side

// user routes


Route::get('signup', 'userController@create');
Route::get('forgetpassword', 'userController@forgetPasswordShowForm');
Route::post('forgetpassword', 'userController@forgetPassword');
Route::post('changepassword', 'userController@changePassword');
Route::post('resetpassword', 'userController@resetPassword');
Route::get('resetpassword', 'userController@resetPasswordShowForm');
Route::post('user/validate/retry', 'userController@userAuthApi');
Route::post('user/register', 'userController@register');
Route::get('user/register/complete/{mobile}', 'userController@completeForm');
Route::post('user/validate', 'userController@validateMobile');
Route::post('user/server/register', 'userController@registerServer');
Route::post('user/sync', 'userController@sync');
Route::post('user/server/detail/get', 'userController@getUserDetail');
Route::post('user/server/detail/get/nopass', 'userController@getUserDetailWithoutPassword');
Route::get('user/credit/add', 'userController@credit');
Route::post('user/order', 'orderController@order');
Route::post('user/order/get', 'orderController@getUserOrder');
Route::post('user/server/order/get', 'orderController@getUserOrderServer');

Route::post('ajax/payment/au/request', 'paymentController@store');
Route::get('user/server/payment/ipg/check', 'paymentController@ipgCheckServer');
Route::get('user/client/payment/ipg/check', 'paymentController@ipgCheckClient');

Route::get('user/client/payment/ipg/charge', 'paymentController@ipgUserCharge');
Route::get('user/server/payment/ipg/charge', 'paymentController@ipgUserCharge');

Route::get('user/client/payment/order/check', 'paymentController@orderAuCheckClient');
Route::get('user/client/payment/ipg/charge/check', 'paymentController@orderAuChargeClient');
Route::post('user/server/payment/order/response', 'paymentController@orderAuCheckResponseServer');
Route::post('user/server/charge', 'paymentController@chargeUser');
Route::post('user/server/au/bank/get', 'paymentController@getAuFromBankCharge');

// sms server
Route::get('server/sms/{mobile}/{code}', 'userController@serverSendSms');

Route::group(['middleware' => ['auth', 'cookie']], function () {
    Route::post('user/payment/ipg', 'paymentController@store');
    Route::get('profile/{id}/edit', 'userController@edit');
    Route::get('profile/{id}', 'userController@profile');
    Route::get('profile/{id}/credit', 'userController@credit');
    Route::post('user/credit', 'userController@addCredit');
    Route::get('user/{id}/order', 'userController@userOrderProductView');
    Route::get('user/voucher', 'voucherController@show');
    Route::post('user/voucher/check', 'voucherController@checkVoucher');
    Route::get('user/register-complete/', 'userController@userCompleteRegistration');
    Route::get('product/{id}', 'productController@find');
});


Route::get('product', 'productController@index');
//Route::post('/user/sync/server', 'userController@syncServer');

Route::get('login', 'userController@login');
Route::post('login', 'userController@authenticate');
Route::get('logout', 'userController@logout');

Route::group(['middleware' => ['cookie']], function () {
    Route::get('category/{name}', 'categoryController@find');
    Route::get('category/{name}/index', 'categoryController@get');
    Route::get('/', 'pageController@home');
    Route::get('product/{id}/view', 'productController@get');
});


Route::get('/role', 'adminController@index')->middleware(['admin', 'auth']);
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {

    Route::get('/', 'adminController@index');
    Route::get('/category', 'categoryController@adminIndex');
    Route::get('/category/{id}/delete', 'categoryController@destroy');
    Route::get('/category/{id}/edit', 'categoryController@update');
    Route::get('/category/create', 'categoryController@create');
    Route::post('/category/register', 'categoryController@register');
    Route::post('/ajax/category/search', 'categoryController@search');

    Route::get('/user', 'userController@usersList');
    Route::get('/user/{id}/edit', 'userController@userEdit');
    Route::get('/user/{id}/delete', 'userController@userDelete');
    Route::get('/user/create', 'userController@userCreate');
    Route::post('/user/register', 'userController@userRegister');

    Route::get('/product', 'productController@productsList');
    Route::get('/product/{id}/view', 'productController@findProduct');
    Route::get('/product/{id}/edit', 'productController@edit');
    Route::get('/product/{id}/delete', 'productController@destroy');
    Route::get('/product/create', 'productController@create');
    Route::post('/product/register', 'productController@register');

    Route::get('/package/create', 'packageController@create');
    Route::get('/package', 'packageController@AdminIndex');
    Route::get('/package/{id}/view', 'packageController@adminFind');
    Route::get('/package/search', 'packageController@AdminIndex');
    Route::get('/package/{id}/edit', 'packageController@edit');
    Route::get('/package/{id}/delete', 'packageController@destroy');
    Route::post('/package/register', 'packageController@register');
    Route::post('/ajax/package/search', 'packageController@search');

    Route::get('/provider', 'providerController@adminIndex');
    Route::get('/provider/create', 'providerController@create');
    Route::get('/provider/{id}/edit', 'providerController@edit');
    Route::get('/provider/{id}/delete', 'providerController@destroy');
    Route::get('/provider/{id}/view', 'providerController@adminFind');

    Route::get('/user/order', 'orderController@orders');
    Route::get('/user/{id}/order', 'adminController@adminUserOrders');

    Route::get('/voucher', 'voucherController@index');
    Route::post('/voucher/create', 'voucherController@create');
    Route::post('/voucher/csv', 'voucherController@csv');


});


Route::get('/cookie', 'captchaController@cookie');
Route::get('/captcha', 'captchaController@create');