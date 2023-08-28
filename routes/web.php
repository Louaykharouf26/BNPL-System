<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BnplController;
use App\Http\Controllers\updatecvv;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/SignUp', function () {
    return view('SignUp');
});
Route::get('/SignIn', function () {
    return view('SignIn');
});

Route::get('/testpage', [BnplController::class, 'calculateTotalPaidAmount']);
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store']);
Route::get('/ProductsAdd', function () {
    return view('products');
});
Route::get('/BNPL', function () {
    return view('BNPLform');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/listproduits', [App\Http\Controllers\ProductController::class, 'list'])->name('productslist');

Route::post('/submit-form', [BnplController::class, 'handleFormSubmission'])->name('submit.form');

Route::post('/calculate-installments', [BnplController::class, 'calculateMonthlyInstallments'])->name('calculate.installments');
Route::get('/bnpl-result', [BnplController::class, 'showBNPLResult'])->name('bnpl.result');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/calculate-installments', [BnplController::class, 'calculateMonthlyInstallments'])->name('calculate.installments');
    Route::get('/bnpl-result', [BnplController::class, 'showBNPLResult'])->name('bnpl.result');
    Route::get('/calculate-installments', [BnplController::class, 'calculateMonthlyInstallments'])->name('calculate.installments');
    Route::get('/reminder',[BnplController::class, 'ReminderPage'] )->name('reminder');
    

    
    
});
Route::group(['middleware' => 'adminonly'], function () {
    Route::get('/payment/success', [BnplController::class, 'showPaymentSuccess'])->name('payment.success');
    
    
});
Route::get('/update-cvv-form', [updatecvv::class, 'showCvvForm'])->name('cvv_form');
Route::post('/update-cvv', [updatecvv::class, 'updateCvv'])->name('update_cvv');

use App\Http\Controllers\PaymentController;

/*Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment-success', function () {
    return view('payment_success'); // Create a view for success message
})->name('payment.success');
Route::get('/payment-failure', function () {
    return view('payment_failure'); // Create a view for failure message
})->name('payment.failure');*/
Route::get('/make-payment', [PaymentController::class, 'makePayment']);
Route::post('/make-payment', [PaymentController::class, 'makePayment'])->name('make-payment');

//Route::get('/payment/success', [BnplController::class, 'showPaymentSuccess'])->name('payment.success');
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::post('/submit-installments', [BnplController::class, 'handleFormSubmission'])->name('submitInstallments');
Route::post('/submit-reminder-installments', [BnplController::class, 'handleFormSubmission1'])->name('submitreminderInstallments');
Route::post('/logout', [BnplController::class, 'logout'])->name('logout');
Route::get('/reminder/success', [BnplController::class, 'showReminderSuccess'])->name('reminder.success');
Route::get('/reminder-payment', [PaymentController::class, 'reminderPayment']);
Route::post('/reminder-payment', [PaymentController::class, 'reminderPayment'])->name('reminder-payment');
