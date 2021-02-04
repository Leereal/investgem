<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\BidsController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [RegisteredUserController::class, 'create']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/register/{ref?}', [RegisteredUserController::class, 'create']);

require __DIR__.'/auth.php';

Route::get('/change-password', function () {
    return view('change-password');
})->middleware(['auth'])->name('change-password');

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

Route::get('/withdraw/{id?}', [WithdrawalController::class, 'show'])->middleware(['auth']);

Route::get('/history', [HistoryController::class, 'index'])->middleware(['auth'])->name('history');
Route::get('/referrals', [UserController::class, 'referrals'])->middleware(['auth'])->name('referrals');
Route::post('/changepassword', [UserController::class, 'change_password'])->middleware(['auth']);
Route::put('/update-profile', [UserController::class, 'update'])->middleware(['auth']);

Route::group(['middleware' => 'auth'], function() {
    Route::resources([
    'banks'         => BankController::class,
    'bank-details'  => BankDetailController::class,
    'investments'   => InvestmentController::class,
    'bids'          => BidsController::class,
    'bonus'         => BonusController::class,  
    'withdraw'      => WithdrawalController::class,  
]);
});

Route::get('/deposits', [BidsController::class, 'all'])->middleware(['auth']);
Route::get('/withdrawals', [WithdrawalController::class, 'all'])->middleware(['auth']);
Route::get('/all-investments', [InvestmentController::class, 'all'])->middleware(['auth']);
Route::post('/reinvest', [InvestmentController::class, 'mature_or_reinvest'])->middleware(['auth']);
Route::post('/approve', [BidsController::class, 'approve'])->middleware(['auth']);
Route::post('/approve-withdrawal', [WithdrawalController::class, 'approve'])->middleware(['auth']);
Route::get('/investment', [InvestmentController::class, 'create'])->middleware(['auth']);
Route::get('/members', [UserController::class, 'index'])->middleware(['auth']);
Route::get('/all-bonuses', [BonusController::class, 'all'])->middleware(['auth']);


