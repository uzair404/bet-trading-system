<?php

use App\Http\Controllers\BetsController;
use App\Http\Controllers\ProfileController;
use App\Models\BetsModel;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    if(auth()->check()){
        return redirect(route('dashboard'));
    }
    return view('welcome');
});

Route::get('/search', function () {
    return view('search');
});
Route::get('/dashboard', function () {
    $data['bets'] = BetsModel::where('user_id', Auth::user()->id)->get();
    $data['bets_dates'] = BetsModel::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->pluck('date')->toArray();
    $data['bets_balance'] = BetsModel::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->pluck('rolling_balance')->toArray();
    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/update-starting-balance', [BetsController::class, 'updateStartingBalance'])->name('update_starting_balance');

Route::middleware(['auth','verified'])->group(function () {
    //apis
    Route::post('/bet/add', [BetsController::class, 'add_new']);
    Route::delete('/bet/delete/{id}', [BetsController::class, 'delete']);

    Route::get('/get-starting-balance/{id}', function ($id) {
        $starting_balance = User::where('id', $id)->first()->starting_balance;
        return response()->json(['starting_balance' => $starting_balance]);
    })->name('get_startingBalance');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
