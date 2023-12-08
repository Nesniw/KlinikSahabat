<?php

use App\Http\Controllers\ProfileController;
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
})->middleware(['auth']);

Route::get('/about', function () {
    return view('pages.about', ['title' => 'Tentang']);
});

Route::get('/contactus', function () {
    return view('pages.contactus', ['title' => 'Hubungi Kami']);
});

Route::get('/dashboard', function () {
    return view('admin.admin-dashboard');
})->middleware(['auth', 'verified'])->name('adminDashboard');

Route::get('/customerDashboard', function () {
    return view('pages.customer-dashboard');
})->middleware(['auth', 'verified'])->name('customerDashboard');

Route::get('/dashboard/userdata',[AdminController::class,'displayUser'])->middleware(['auth'])->name('ShowUserData');
Route::get('/dashboard/userdatatable',[AdminController::class,'displayUserDatatable'])->middleware(['auth'])->name('ShowUsersData');

Route::get('/profileSetting', [ProfileController::class, 'edit'])->middleware(['auth'])->name('editProfile');
Route::patch('/profileSetting', [ProfileController::class, 'update'])->middleware(['auth'])->name('updateProfile');

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
