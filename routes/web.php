<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePekerjaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\DataUserController;
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
    return view('pages.home', ['title' => 'Beranda']);
});

Route::get('/layanan', function () {
    return view('pages.layanan', ['title' => 'Layanan']);
})->middleware(['auth.anyguard']);

Route::get('/about', function () {
    return view('pages.about', ['title' => 'Tentang']);
});

Route::get('/contactus', function () {
    return view('pages.contactus', ['title' => 'Hubungi Kami']);
});

Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
})->middleware(['auth:pekerja', 'verified', 'pekerja.status'])->name('adminDashboard');

Route::get('/customerDashboard', function () {
    return view('pages.customer-dashboard');
})->middleware(['auth', 'verified'])->name('customerDashboard');




// Routing untuk CRUD Admin terhadap Data Pekerja
Route::get('/data-user',[AdminController::class,'displayUser'])->middleware(['auth:pekerja'])->name('ShowUserData');
Route::get('/data-user/create-user',[AdminController::class,'CreateUserForm'])->middleware(['auth:pekerja'])->name('CreateUserForm');
Route::post('/data-user/create-user',[AdminController::class,'CreateUser'])->middleware(['auth:pekerja'])->name('CreateUserData');
Route::get('/data-user/{user_id}/update-user',[AdminController::class,'UpdateUserForm'])->middleware(['auth:pekerja'])->name('UpdateUserForm');
// Bisa juga dirouting kayak gini. Gatau best practice nya gimana
// Route::get('/update-user/{user_id}',[AdminController::class,'UpdateUserForm'])->middleware(['auth'])->name('UpdateUserForm');
Route::patch('/data-user/{user_id}/updating-user',[AdminController::class,'updateUser'])->middleware(['auth:pekerja'])->name('UpdateUserData');
Route::delete('/data-user/{user_id}',[AdminController::class,'deleteUser'])->middleware(['auth:pekerja'])->name('DeleteUserData');
// Route::get('/userdatatable',[AdminController::class,'displayUserDatatable'])->middleware(['auth'])->name('ShowUsersData');

// Routing untuk CRUD Admin terhadap Data Pasien / Hewan
Route::get('/data-pasien',[AdminController::class,'displayPasien'])->middleware(['auth:pekerja'])->name('ShowPasienData');

// Routing untuk CRUD Admin terhadap Data Pekerja
Route::get('/data-pekerja',[AdminController::class,'displayPekerja'])->middleware(['auth:pekerja'])->name('ShowPekerjaData');
Route::get('/data-pekerja/create-pekerja',[AdminController::class,'CreatePekerjaForm'])->middleware(['auth:pekerja'])->name('CreatePekerjaForm');
Route::post('/data-pekerja/create-pekerja',[AdminController::class,'CreatePekerja'])->middleware(['auth:pekerja'])->name('CreatePekerjaData');
Route::get('/data-pekerja/{pekerja_id}/update-pekerja',[AdminController::class,'updatePekerjaForm'])->middleware(['auth:pekerja'])->name('UpdatePekerjaForm');
Route::patch('/data-pekerja/{pekerja_id}/updating-pekerja',[AdminController::class,'updatePekerja'])->middleware(['auth:pekerja'])->name('UpdatePekerjaData');
Route::delete('/data-pekerja/{pekerja_id}',[AdminController::class,'deletePekerja'])->middleware(['auth:pekerja'])->name('DeletePekerjaData');
Route::patch('/data-pekerja/{pekerja_id}',[AdminController::class,'nonaktifkanPekerja'])->middleware(['auth:pekerja'])->name('NonaktifPekerja');


// Routing untuk CRUD Data User (Profile dari User / Customer)
Route::get('/profileSetting', [ProfileController::class, 'edit'])->middleware(['auth'])->name('editProfile');
Route::patch('/profileSetting', [ProfileController::class, 'update'])->middleware(['auth'])->name('updateProfile');

// Routing untuk CRUD Data Pekerja (Profile dari pekerja)
Route::get('/pekerjaProfile', [ProfilePekerjaController::class, 'view'])->middleware(['auth:pekerja'])->name('viewProfilePekerja');
Route::patch('/pekerjaProfile', [ProfilePekerjaController::class, 'update'])->middleware(['auth:pekerja'])->name('updateProfilePekerja');

// Routing untuk proses CRUD dari fitur MyPets di dashboard Customer
Route::get('/myPets', [PetsController::class, 'viewPets'])->middleware(['auth'])->name('viewPets');
Route::get('/myPets/add', [PetsController::class, 'createRandomCode'])->middleware(['auth'])->name('registerPets');
Route::post('/myPets/addPet', [PetsController::class, 'storePet'])->middleware(['auth'])->name('register_pet');
Route::get('/myPets/update/{kode_pasien}', [PetsController::class, 'updatePetForm'])->middleware(['auth'])->name('updatePetForms');
Route::post('/myPets/updatePet/{kode_pasien}', [PetsController::class, 'updatePet'])->middleware(['auth'])->name('update_pet');
Route::delete('/myPets/delete/{kode_pasien}', [PetsController::class, 'deletePet'])->middleware(['auth'])->name('delete_pet');


// Route::get('/pets', function () {
//     return view('pages.pets');
// })->middleware(['auth'])->name('viewPets');


// Route::get('/myPets', [PetsController::class, 'show'])->middleware(['auth'])->name('viewPets');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

require __DIR__.'/pekerjaAuth.php';