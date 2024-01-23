<?php

use App\Http\Controllers\AlertePersonneAPrevenirController;
use App\Http\Controllers\api\AlerteController;
use App\Http\Controllers\api\AlerteMessageController;
use App\Http\Controllers\api\AlertePartenaireController;
use App\Http\Controllers\api\AlerteSanteStructure;
use App\Http\Controllers\api\AlertUserNotificationController;
use App\Http\Controllers\api\AskForHelpController;
use App\Http\Controllers\api\DiscussionController;
use App\Http\Controllers\api\EnroleController;
use App\Http\Controllers\api\SliderController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Connexion
Route::post('login', [AuthController::class, 'login']);

// Connexion avec le code qr
Route::post('login-with-qr', [AuthController::class, 'loginWithQr']);
Route::post('login-with-google', [AuthController::class, 'loginWithGoogle']);

// Inscription / Enregitrement du compte
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // Mot de passe oublié
    Route::post('change-password', [AuthController::class, 'change_password']);
    Route::post('/me/update', [AuthController::class, 'change_profile']);

    // ressources alertes
    Route::apiResource('alertes', AlerteController::class);

    // ressources api
    Route::resource('messages', AlerteMessageController::class);

    // Ressuorces discussions
    Route::resource('discussions', DiscussionController::class);

    // Liste des messages d'un sujet donné
    Route::post('discussion-messages', [AlerteMessageController::class, 'discussionFromPopup']);

    // Alerte proches
    Route::post('alerte_personne_a_prevenir', [AlertePersonneAPrevenirController::class, 'index']);

    // Liste des proches
    Route::post('personne_a_prevenir_list', [AlertePersonneAPrevenirController::class, 'listeDesProches']);

    // Alerte proche
    Route::post('prevenir_une_personne', [AlertePersonneAPrevenirController::class, 'alerterUnProche']);

    // Ressuorces discussions
    Route::resource('alerte_sante_structure', AlerteSanteStructure::class);

    // Ressuorces transactions
    Route::resource('transactions', TransactionController::class);

    Route::post('transactions-partenaires', [TransactionController::class, 'transactionPartenaire']);

    // Ressuorces partenaires
    Route::resource('partenaires', AlertePartenaireController::class);

    // Ressuorces transactions
    Route::post('save-payment', [TransactionController::class, 'addPayment']);

    //
    // Route::post('messages', [AlerteMessageController::class, 'store']);

    // Information d'un enrole
    Route::post('enrole', [EnroleController::class, 'index'])->middleware('api');

    // Trouver un enrole en utilisant son nom
    Route::post('find-enrole-by-name', [EnroleController::class, 'findEnroleByName']);

    // Trouver un utilisateur en utilisant son nom
    Route::post('find-user-by-name', [EnroleController::class, 'findUserByName']);

    Route::post('send-verification', [EnroleController::class, 'saveKyc']);

    Route::resource('ask-for-help', AskForHelpController::class);

    Route::resource('notifications', AlertUserNotificationController::class);

});

Route::post('sliders', [SliderController::class, 'index']);

//Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:api']]);
