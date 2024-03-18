<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunitiesController;
use App\Http\Controllers\HousesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UsersController;
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

Route::middleware('admin')->group(function() {
    Route::get('/vartotojai', [UsersController::class, 'showUsersPage'])->name('users.show');
    Route::post('/sukurti-vartotoja', [UsersController::class, 'createUser'])->name('users.create');
    Route::post('/istrinti-vartotoja/{id}', [UsersController::class, 'deleteUser'])->name('users.delete');
    Route::post('/redaguoti-vartotoja/{id}', [UsersController::class, 'editUser'])->name('users.edit');

    Route::post('/redaguoti-paslauga/{id}', [ServicesController::class, 'editService'])->name('services.edit');
    Route::post('/kurti-paslauga/{id}', [ServicesController::class, 'createService'])->name('services.create');

    Route::get('/bendrijos/{id}/namu-sarasas', [CommunitiesController::class, 'showCommunitiesHouses'])->name('communities.houses');
    Route::post('/sukurti-bendrija', [CommunitiesController::class, 'createCommunity'])->name('communities.create');
    Route::post('/redaguoti-bendrija/{id}', [CommunitiesController::class, 'editCommunity'])->name('communities.edit');
    Route::post('/istrinti-bendrija/{id}', [CommunitiesController::class, 'deleteCommunity'])->name('communities.delete');

    Route::get('/namai', [HousesController::class, 'showHousesPage'])->name('houses.show');
    Route::post('/sukurti-nama', [HousesController::class, 'createHouse'])->name('houses.create');
    Route::post('/redaguoti-nama/{id}', [HousesController::class, 'editHouse'])->name('houses.edit');
    Route::post('/istrinti-nama/{id}', [HousesController::class, 'deleteHouse'])->name('houses.delete');
});

Route::middleware('manager')->group(function() {
    Route::get('/bendrijos', [CommunitiesController::class, 'showCommunitiesPage'])->name('communities.show');
    Route::get('/bendrijos/{id}/paslaugu-sarasas', [CommunitiesController::class, 'showCommunitiesServices'])->name('communities.services');
    Route::post('/bendrijos/{id}/redaguoti-paslauga', [CommunitiesController::class, 'editService'])->name('communities.services.edit');
});

Route::middleware('auth')->group(function() {
    Route::get('/paslaugos', [ServicesController::class, 'showServicesPage'])->name('services.show');
    Route::post('/atsijungti', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/prisijungimas', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/prisijungimas', [AuthController::class, 'authenticate'])->name('login.submit');
Route::get('/', [AuthController::class, 'home'])->name('home');

