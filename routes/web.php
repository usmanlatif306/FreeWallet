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

// Artisan::call('storage:link');

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

use Illuminate\Support\Facades\Artisan;

Route::redirect('/', '/en');

// Route::get('/lang/{lang}', function ($locale){
// 	Session::put('locale', $locale);
//        return redirect('/');
// });


Route::group(['prefix' => 'admin/dashboard'], function () {
	Voyager::routes();

	// trasactionable index file
	Route::get('transactionable', 'AdminTransactionController@index')->name('voyager.transactionable.index');

	// wallet trasaction
	Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
		Route::resource('transaction', 'WalletTrasactionController');
	});
});

Route::get('storage-link', function () {
	Artisan::call('storage:link');
	dd('storage link');
});

Route::group(['prefix' => 'ticketadmin', 'middleware' => 'ticketadmin'], function () {
	Route::get('tickets', 'TicketsController@index')->name('support');
	Route::post('close_ticket/{ticket_id}', 'TicketsController@close')->name('support');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::group(['prefix' => '{language}', 'middleware' => ['setLanguage']], function () {

	Route::get('/', function () {
		return view('welcome');
	});

	//Auth::routes();
	// 2fa routes
	Route::group(['prefix' => '2fa'], function () {
		Route::get('/', 'LoginSecurityController@show2faForm')->name('show2faForm');
		Route::post('/generateSecret', 'LoginSecurityController@generate2faSecret')->name('generate2faSecret');
		Route::post('/enable2fa', 'LoginSecurityController@enable2fa')->name('enable2fa');
		Route::post('/disable2fa', 'LoginSecurityController@disable2fa')->name('disable2fa');
	});

	// Authentication Routes...
	// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	// Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// Registration Routes...
	Route::get('register', 'SignUpController@showRegistrationForm')->name('register');
	Route::post('register', 'SignUpController@register');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}/{email}', 'AccountsController@showResetForm')->name('password.reset');
	//Route::post('password/reset', 'Auth\ResetPasswordController@reset');


	Route::post('reset_password_without_token', 'AccountsController@validatePasswordRequest')->name('reset_password_without_token');
	Route::post('reset_password', 'AccountsController@resetPassword')->name('reset_password');


	//Account Activation Routes...
	Route::get('register/{email}/{token}', 'SignUpController@verifyEmail');
	Route::get('resend/activationlink', 'SignUpController@resendActivactionLink')->middleware('auth');
	Route::get('otp', 'SignUpController@OTP')->middleware('auth');
	Route::get('otp/resend', 'SignUpController@OTPresend')->middleware('auth')->name('resend_otp');
	Route::post('otp', 'SignUpController@postOtp')->middleware('auth');

	Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

	// -------------------------------------------------------------------------------


	Route::get('/wallet/{id}', 'HomeController@wallet')->middleware('auth')->name('wallet.id');

	Route::get('/mail', 'SignUpController@TestMail');
	Route::get('/paysi', 'SignUpController@paysy');

	Route::get('/account_status/{User}', 'HomeController@accountStatus')->middleware('auth');



	//Impersonation routes
	Route::get('impersonate/user/{user_id}', 'ProfileController@impersonateUser')->middleware('auth')->name('impersonateUser');
	Route::impersonate();


	// SEND MONEY ROUTES
	Route::get('/sendmoney', 'MoneyTransferController@sendMoneyForm')->name('sendMoneyForm')->middleware('auth');
	Route::post('/sendmoney', 'MoneyTransferController@sendMoney')->name('sendMoney')->middleware('auth');

	Route::post('/sendMoneyConfirm', 'MoneyTransferController@sendMoneyConfirm')->name('sendMoneyConfirm')->middleware('auth');
	Route::post('/sendMoneyDelete', 'MoneyTransferController@sendMoneyCancel')->name('sendMoneyDelete')->middleware('auth');



	//REQUEST MONEY ROUTES
	Route::get('/requestmoney', 'MoneyTransferController@requestMoneyForm')->name('requestMoneyForm')->middleware('auth');
	Route::post('/requestmoney', 'MoneyTransferController@requestMoney')->name('requestMoney')->middleware('auth');
	// Route::post('/requestMoneyConfirm', 'MoneyTransferController@requestMoneyConfirm')->name('requestMoneyConfirm')->middleware('auth');
	// Route::post('/requestMoneyDelete', 'MoneyTransferController@requestMoneyCancel')->name('requestMoneyDelete')->middleware('auth');

	//Received MONEY ROUTES
	Route::get('/receivedmoney', 'ReceiveHashController@index')->name('receivedMoneyForm')->middleware('auth');
	Route::post('/receivedmoney', 'ReceiveHashController@store')->name('receivedMoneyHash')->middleware('auth');

	// ADD FUNDS ROUTES
	Route::get('/addfunds', 'AddFundController@index')->name('addFundsForm')->middleware('auth');
	Route::post('/addfunds', 'AddFundController@captureFund')->name('addFunds')->middleware('auth');

	// Identity routes
	// Route::view('/identity', 'identity.index')->name('identity.index')->middleware('auth');
	Route::get('/identity', 'IdentityController@index')->name('identity.index')->middleware('auth');
	Route::post('/identity', 'IdentityController@identify')->name('identity.itentify')->middleware('auth');
	Route::view('/identity/camera', 'identity.camera')->name('identity.camera');
	Route::view('/identity/idscaner', 'identity.idscaner')->name('identity.idscaner');
	Route::post('/identity/camera', 'IdentityController@identifyWithCamera')->name('identification_with_camera');



	//WALLET ROUTES
	Route::get('transfer/{currency_id}/methods', 'WalletController@showTransferMethods')->middleware('auth')->name('show.transfermethods');
	Route::get('currencies/methods', 'WalletController@showCurrencies')->middleware('auth')->name('show.currencies');
	Route::get('wallet/create/{method_id}', 'WalletController@showCreateWalletForm')->middleware('auth')->name('show.createwalletform');
	Route::post('wallet/create', 'WalletController@createWallet')->middleware('auth')->name('create.wallet');


	/*	MERCHANT ROUTES	*/

	Route::get('/merchant/storefront/{ref}', 'MerchantController@getStoreFront')->name('storefront');
	Route::get('/merchant/{merchant}/docs', 'MerchantController@integration')->middleware('auth')->name('merchantIntegration');
	Route::get('/mymerchants', 'MerchantController@index')->name('mymerchants')->middleware('auth');

	Route::get('/merchant/new', 'MerchantController@new')->name('merchant.new')->middleware('auth');
	Route::post('/merchant/add', 'MerchantController@add')->name('merchant.add')->middleware('auth');


	/*	IPN ROUTES	*/
	Route::post('/purchase/link', 'RequestController@storeRequest')->name('purchase_link');
	Route::post('/request/status', 'RequestController@requestStatus')->name('purchase_status');
	Route::post('/purchase/confirm', 'IPNController@purchaseConfirmation')->name('purchaseConfirm')->middleware('auth');
	Route::post('/purchase/delete', 'IPNController@purchaseCancelation')->name('purchaseDelete')->middleware('auth');
	Route::post('/ipn/payment', 'IPNController@pay')->name('pay')->middleware('auth');
	Route::post('/ipn/payment/guest', 'IPNController@logandpay')->name('logandpay');

	/*	ADD CREDIT ROUTES	*/
	Route::get('/addcredit/{method_id?}', 'AddCreditController@addCreditForm')->name('add.credit')->middleware(['auth', 'activeUser']);
	Route::get('/deposit', 'AddCreditController@depositMethods')->name('deposit.credit')->middleware('auth');
	Route::get('/deposit/{wallet_id}', 'AddCreditController@depositByWallet')->name('deposit.transfer.form')->middleware('auth');
	Route::post('/addcredit', 'AddCreditController@depositRequest')->name('post.credit')->middleware('auth');

	/*	DEPOSITS ROUTES	*/
	Route::get('/mydeposits', 'DepositController@myDeposits')->name('mydeposits')->middleware('auth');
	Route::put('/confirm/deposit', 'DepositController@confirmDeposit')->name('confirm.deposit')->middleware('auth');

	/* WITHDRAWAL ROUTES */

	route::get('/withdrawal/request/{method_id?}', 'WithdrawalController@getWithdrawalRequestForm')->name('withdrawal.form')->middleware(['auth', 'activeUser']);
	route::get('/payout/{wallet_id}', 'WithdrawalController@payoutForm')->name('payout.form')->middleware(['auth', 'activeUser']);
	route::post('/withdrawal/request', 'WithdrawalController@makeRequest')->name('post.withdrawal')->middleware('auth');
	route::get('/withdrawals', 'WithdrawalController@index')->name('withdrawal.index')->middleware('auth');

	Route::put('/confirm/withdrawal', 'WithdrawalController@confirmWithdrawal')->name('confirm.withdrawal')->middleware('auth');

	/* EXCHANGE ROUTES */
	route::get('/exchange/first/{first_id?}/second/{second_id?}', 'ExchangeController@getExchangeRequestForm')->name('exchange.form')->middleware('auth');
	route::post('/exchange/', 'ExchangeController@exchange')->name('post.exchange')->middleware('auth');

	route::post('/update_rates', 'ExchangeController@updateRate')->middleware('auth');
	route::get('/update_rates', 'ExchangeController@updateRateForm')->middleware('auth');

	route::get('new_ticket', 'TicketsController@create')->name('support');
	route::post('new_ticket', 'TicketsController@store')->name('support');
	route::get('my_tickets', 'TicketsController@userTickets')->name('support');
	Route::get('tickets/{ticket_id}', 'TicketsController@show')->name('support');
	Route::post('comment', 'TicketCommentsController@postTicketComment')->name('support');


	route::get('profile/info', 'ProfileController@personalInfo')->name('profile.info')->middleware('auth');
	route::post('profile/info', 'ProfileController@storePersonalInfo')->name('profile.info.store')->middleware('auth');
	route::get('profile/identity', 'ProfileController@profileIdentity')->name('profile.identity')->middleware('auth');
	route::post('profile/identity', 'ProfileController@storeProfileIdentity')->name('profile.identity.store')->middleware('auth');
	route::get('profile/newpassword', 'ProfileController@newpasswordInfo')->name('profile.newpassword')->middleware('auth');
	route::post('profile/newpassword', 'ProfileController@storeNewpasswordInfo')->name('profile.newpassword.store')->middleware('auth');

	//PAGES ROUTES
	// route::get('page/{id}', "HomeController@getPage");


	//VOUCHERS ROUTES
	route::get('my_vouchers', 'VoucherController@getVouchers')->name('my_vouchers')->middleware('auth');
	route::post('my_vouchers', 'VoucherController@createVoucher')->name('create_my_voucher')->middleware('auth');
	route::post('load_my_voucher', 'VoucherController@loadVoucher')->name('load_my_voucher')->middleware('auth');
	route::post('load_voucher_to_user', 'VoucherController@loadVoucherToUser')->name('load_voucher_to_user')->middleware('auth');
	route::get('makevouchers', 'VoucherController@generateVoucher')->name('makeVouchers')->middleware('auth');
	route::post('generateVoucher', 'VoucherController@postGenerateVoucher')->name('generateVoucher')->middleware('auth');
	route::get('buyvoucher', 'VoucherController@buyvouchermethod')->middleware('auth');

	//PAYPAL VOUCHER ROUTES
	route::get('buyvoucher/paypal', 'PayPalController@buyvoucher')->middleware('auth');
	route::post('buyvoucher/paypal', 'PayPalController@sendRequestToPaypal')->middleware('auth');
	route::get('pay/voucher/paypal/success', 'PayPalController@paySuccess')->middleware('auth');
	Route::post('/merchant/storefront/paypal/{ref}', 'PayPalController@postStoreFront')->name('paypalstorefront');
	Route::get('/merchant/storefront/paypal/success', 'PayPalController@postStoreFrontSuccess');
	Route::get('/merchant/storefront/paypal/cancel', 'PayPalController@postStoreFrontCancel');

	//PAYSTACK VOUCHER ROUTES
	route::get('buyvoucher/paystack', 'PaystackController@buyvoucher')->middleware('auth');
	route::post('buyvoucher/paystack', 'PaystackController@sendRequestToPayStack')->middleware('auth');
	route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');
	Route::post('/merchant/storefront/paystack/{ref}', 'PaystackController@postStoreFront')->name('paystackstorefront');
	Route::get('/merchant/storefront/paystack/success', 'PaystackController@postStoreFrontSuccess');

	//STRIPE VOUCHER ROUTES
	route::get('buyvoucher/stripe', 'StripeController@buyvoucher')->middleware('auth');
	route::post('buyvoucher/stripe', 'StripeController@sendRequestToStripe')->middleware('auth');
	//route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');

	//2CHECKOUT VOUCHER ROUTES
	route::get('buyvoucher/2checkout', 'TwoCheckoutController@buyvoucher')->middleware('auth');
	route::post('buyvoucher/2checkout', 'TwoCheckoutController@sendRequestToStripe')->middleware('auth');
	//route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');

	//TUTORIAL ROUTES


	// route::get('blog', 'BlogController@index' )->name('blog');
	// route::get('blog/{post_excerpt}/{post_id}', 'BlogController@singlePost' )->name('post');

	//TRANSACTIOINS ROUTES
	route::post('transaction/remove', 'TransactionController@deleteMapper')->middleware('auth');

	//ESCROW ROUTES

	route::get('escrow', 'EscrowController@sendForm')->name('escrow')->middleware('auth');
	route::post('escrow', 'EscrowController@store')->middleware('auth');
	route::post('/escrow/refund', 'EscrowController@refund')->middleware('auth');
	route::post('/escrow/release', 'EscrowController@release')->middleware('auth');
	route::get('/escrow/{eid}', 'EscrowController@agreement')->middleware('auth');

	//INVESTMENT

	route::get('investment/plans', 'InvestmentController@plans')->name('investmentplans');
	route::get('investment/plan/{plan_id}', 'InvestmentController@investForm')->name('investmentform')->middleware('auth');
	route::post('investment/store', 'InvestmentController@store')->middleware('auth');
	route::get('myinvestments', 'InvestmentController@myInvestments')->name('myinvestments')->middleware('auth');
	route::post('investment/take_profit', 'InvestmentController@takeProfit')->name('takeProfit')->middleware('auth');

	//ADMINISTRATION ROUTES

	route::get('users/all', 'ProfileController@getUsers')->middleware('auth');

	//DEMO ROUTES

	route::get('demo/index', 'DemoController@index');
	route::get('demo/user', 'DemoController@user')->name('demouser');
	route::get('demo/admin', 'DemoController@admin')->name('demoadmin');

	route::get('/me/{user_name}', 'ProfileController@me');
});
