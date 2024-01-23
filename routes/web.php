<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\AlerteDiscussionController;
use App\Http\Controllers\AlerteNotificationController;
use App\Http\Controllers\AlertePartenaireController;
use App\Http\Controllers\AlerteUserController;
use App\Http\Controllers\AmbulanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KYCController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

/*Route::get('/', function () {
    return view('welcome');
})->name('welcome');*/

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    Route::get('/', [AdminHomeController::class, 'home'])->name('admin');

    Route::resource('sliders', SliderController::class);

    Route::resource('transaction', TransactionController::class);

    // Resource utilisateurs
    Route::resource('alerte-users', AlerteUserController::class);

    //Vérifications KYC
    Route::get('kyc-verification-non-verified', [KYCController::class, 'nonVerified'])->name('kyc-verification-non-verified');
    Route::get('kyc-verification-en-cours', [KYCController::class,'enCours'])->name('kyc-verification-en-cours');
    Route::get('kyc-verification-verified', [KYCController::class, 'verified'])->name('kyc-verification-verified');
    
    Route::post('kyc-verification-accept/{id}', [KYCController::class,'accept'])->name('kyc-verification-accept');
    Route::post('kyc-verification-refuse/{id}', [KYCController::class ,'refuse'])->name('kyc-verification-refuse');
    
    //Utilisateurs
    Route::get('users-all', [UserController::class, 'all'])->name('users-all');
    Route::get('users-partenaires', [UserController::class, 'partenaire'])->name('users-partenaires');
    Route::get('users-sauvie', [UserController::class, 'sauvie'])->name('users-sauvie');
    
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users-delete');
    

});

Route::group(['middleware' => 'auth', 'prefix' => 'alertes'], function () {
    // Resouces ambulances
    Route::resource('ambulances', AmbulanceController::class);

    Route::post('affect-ambulance', [AmbulanceController::class, 'affectAmbulance'])->name('ambulance.affecter');

    Route::post('traiter-alerte', [AmbulanceController::class, 'alerteTraite'])->name('alertes.traiter');

    Route::get('notifications', [AlerteNotificationController::class, 'index'])->name("me.notifications");

    Route::get('discussion/{id}', [MessagingController::class, 'one'])->name("messaging.one");

    Route::post('message-reponse', [MessagingController::class, 'respondeMessage'])->name("messaging.respond");

    // resources alerts
    Route::resource('alertes', AlerteController::class);

    Route::resource('discussions', AlerteDiscussionController::class);

    Route::resource('partenaires', AlertePartenaireController::class);

});

Route::post('messages/{id}', [AlerteDiscussionController::class, 'getMessages']);

Route::post('alertes-custom', [AlerteController::class, 'customAlertes']);

Route::group(['middleware' => 'auth', 'prefix' => 'accounts'], function () {
    // Voir les notifications
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
});