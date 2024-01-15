<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\GroomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePekerjaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TransaksiController;
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
})->name('LayananPage');

Route::get('/about', function () {
    return view('pages.about', ['title' => 'Tentang']);
});

Route::get('/contactus', function () {
    return view('pages.contactus', ['title' => 'Hubungi Kami']);
});

Route::get('/dashboard',[AdminController::class,'adminDashboard'])
    ->middleware(['auth:pekerja', 'verified', 'pekerja.status', 'admin.pekerja'])
    ->name('AdminDashboard');


Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/layanan/reservasi-clinic/layanan',[ReservasiController::class,'getLayananPetClinic'])->name('ReservasiClinic');
    Route::post('/layanan/reservasi-clinic/jadwal', [ReservasiController::class, 'chooseServiceAndPet'])->name('chooseServiceAndPet');
    Route::post('/layanan/reservasi-clinic/proses-reservasi', [ReservasiController::class, 'chooseSchedule'])->name('chooseSchedule');

    Route::get('/layanan/reservasi-pet-hotel/layanan',[ReservasiController::class,'getLayananPetHotel'])->name('ReservasiPetHotel');
    Route::post('/layanan/reservasi-pet-hotel/pet', [ReservasiController::class, 'getHewanByLayanan'])->name('GetHewanByLayanan');
    Route::post('/layanan/reservasi-pet-hotel/tanggal', [ReservasiController::class, 'chooseJadwalPetHotel'])->name('ChooseJadwalPetHotel');
    Route::post('/layanan/reservasi-pet-hotel/proses-reservasi', [ReservasiController::class, 'prosesJadwalPetHotel'])->name('ProsesJadwalPetHotel');

    Route::get('/layanan/reservasi-pet-grooming/layanan',[ReservasiController::class,'getLayananPetGrooming'])->name('ReservasiPetGrooming');
    Route::post('/layanan/reservasi-pet-grooming/pet', [ReservasiController::class, 'getHewanGroomingByLayanan'])->name('GetHewanGroomingByLayanan');
    Route::post('/layanan/reservasi-pet-grooming/tanggal', [ReservasiController::class, 'chooseJadwalPetGrooming'])->name('ChooseJadwalPetGrooming');
    Route::post('/layanan/reservasi-pet-grooming/proses-reservasi', [ReservasiController::class, 'prosesJadwalPetGrooming'])->name('ProsesJadwalPetGrooming');
    

    Route::get('/halaman-transaksi/{transaksi_id}',[ReservasiController::class,'showHalamanPembayaran'])->name('ShowHalamanPembayaran');
    Route::patch('/halaman-transaksi/{transaksi_id}/upload-bukti-transfer', [ReservasiController::class, 'kirimBuktiPembayaran'])->name('UploadBuktiTransfer');
});

Route::middleware(['auth:pekerja', 'pekerja.status', 'admin.pekerja'])->group(function () {
    
    // Routing untuk CRUD Admin terhadap Data Pekerja
    Route::get('/data-user',[AdminController::class,'displayUser'])->name('ShowUserData');
    Route::get('/data-user/create-user',[AdminController::class,'CreateUserForm'])->name('CreateUserForm');
    Route::post('/data-user/create-user',[AdminController::class,'CreateUser'])->name('CreateUserData');
    Route::get('/data-user/{user_id}/update-user',[AdminController::class,'UpdateUserForm'])->name('UpdateUserForm');
    // Bisa juga dirouting kayak gini. Gatau best practice nya gimana
    // Route::get('/update-user/{user_id}',[AdminController::class,'UpdateUserForm'])->middleware(['auth'])->name('UpdateUserForm');
    Route::patch('/data-user/{user_id}/updating-user',[AdminController::class,'updateUser'])->name('UpdateUserData');
    Route::delete('/data-user/{user_id}',[AdminController::class,'deleteUser'])->name('DeleteUserData');
    // Route::get('/userdatatable',[AdminController::class,'displayUserDatatable'])->middleware(['auth'])->name('ShowUsersData');

    // Routing untuk CRUD Admin terhadap Data Pasien / Hewan
    Route::get('/data-pasien',[AdminController::class,'displayPasien'])->name('ShowPasienData');

    // Routing untuk CRUD Admin terhadap Data Pekerja
    Route::get('/data-pekerja',[AdminController::class,'displayPekerja'])->name('ShowPekerjaData');
    Route::get('/data-pekerja/create-pekerja',[AdminController::class,'CreatePekerjaForm'])->name('CreatePekerjaForm');
    Route::post('/data-pekerja/create-pekerja',[AdminController::class,'CreatePekerja'])->name('CreatePekerjaData');
    Route::get('/data-pekerja/{pekerja_id}/update-pekerja',[AdminController::class,'updatePekerjaForm'])->name('UpdatePekerjaForm');
    Route::patch('/data-pekerja/{pekerja_id}/updating-pekerja',[AdminController::class,'updatePekerja'])->name('UpdatePekerjaData');
    Route::delete('/data-pekerja/{pekerja_id}',[AdminController::class,'deletePekerja'])->name('DeletePekerjaData');
    Route::patch('/data-pekerja/{pekerja_id}',[AdminController::class,'nonaktifkanPekerja'])->name('NonaktifPekerja');

    // Routing untuk CRUD Admin terhadap Data Kategori Layanan dan Layanan nya
    Route::get('/data-kategori-layanan',[AdminController::class,'displayKategori'])->name('ShowKategoriData');
    Route::get('/data-kategori-layanan/create-kategori',[AdminController::class,'CreateKategoriForm'])->name('CreateKategoriForm');
    Route::post('/data-kategori-layanan/create-kategori',[AdminController::class,'CreateKategori'])->name('CreateKategoriData');
    Route::delete('/data-kategori-layanan/{kategori_layanan_id}',[AdminController::class,'deleteKategori'])->name('DeleteKategoriData');
    Route::get('/data-kategori-layanan/{kategori_layanan_id}/update-kategori',[AdminController::class,'updateKategoriForm'])->name('UpdateKategoriForm');
    Route::patch('/data-kategori-layanan/{kategori_layanan_id}/updating-kategori',[AdminController::class,'updateKategori'])->name('UpdateKategoriData');

    Route::get('/data-layanan',[AdminController::class,'displayLayanan'])->name('ShowLayananData');
    Route::get('/data-layanan/create-layanan',[AdminController::class,'CreateLayananForm'])->name('CreateLayananForm');
    Route::post('/data-layanan/create-layanan',[AdminController::class,'CreateLayanan'])->name('CreateLayananData');
    Route::get('/data-layanan/{layanan_id}/update-layanan',[AdminController::class,'updateLayananForm'])->name('UpdateLayananForm');
    Route::patch('/data-layanan/{layanan_id}/updating-layanan',[AdminController::class,'updateLayanan'])->name('UpdateLayananData');
    Route::delete('/data-layanan/{layanan_id}',[AdminController::class,'deleteLayanan'])->name('DeleteLayananData');

    // Routing untuk CRUD Jadwal Clinic
    Route::get('/data-jadwal',[AdminController::class,'displayJadwal'])->name('ShowJadwalKlinik');
    Route::get('/data-jadwal/create-jadwal',[AdminController::class,'createJadwalForm'])->name('CreateJadwalForm');
    Route::post('/data-jadwal/create-jadwal',[AdminController::class,'createJadwal'])->name('CreateJadwalKlinik');
    Route::get('/data-jadwal/{jadwal_klinik_id}/details',[AdminController::class,'detailsJadwal'])->name('DetailsJadwal');
    Route::get('/data-jadwal/{jadwal_klinik_id}/update-jadwal',[AdminController::class,'updateJadwalForm'])->name('UpdateJadwalForm');
    Route::patch('/data-jadwal/{jadwal_klinik_id}/updating-jadwal',[AdminController::class,'updateJadwal'])->name('UpdateJadwalData');
    Route::delete('/data-jadwal/{jadwal_klinik_id}',[AdminController::class,'deleteJadwal'])->name('DeleteJadwalData');

    // Routing untuk display, konfirmasi bukti bayar, dan cetak laporan transaksi
    Route::get('/data-transaksi/konfirmasi-pembayaran', [AdminController::class,'tampilkanBuktiTransfer'])->name('ShowBuktiPembayaran');
    Route::get('/data-transaksi/download-bukti/{transaksi_id}', [AdminController::class,'downloadBukti'])->name('DownloadBuktiPembayaran');
    Route::get('/data-transaksi', [AdminController::class,'displayTransaksi'])->name('ShowTransaksi');
    Route::get('/data-transaksi/{transaksi_id}/details',[AdminController::class,'detailsTransaksi'])->name('DetailsTransaksi');
    Route::patch('/data-transaksi/{transaksi_id}/selesaikan',[AdminController::class,'selesaikanTransaksi'])->name('SelesaikanTransaksi');
    Route::patch('/data-transaksi/{transaksi_id}/nonaktifkan',[AdminController::class,'nonaktifkanTransaksi'])->name('NonaktifkanTransaksi');

    Route::post('/data-transaksi/konfirmasi-pembayaran/{transaction}', [AdminController::class,'konfirmasiBuktiTransfer'])->name('KonfirmasiPembayaran');

    Route::get('/data-transaksi/laporan', [AdminController::class,'displayLaporanTransaksi'])->name('ShowLaporanTransaksi');
    Route::post('/cetak-laporan-transaksi', [AdminController::class, 'cetak_laporan'])->name('cetak_laporan');
    Route::post('/view-laporan-transaksi', [AdminController::class,'view_laporan'])->name('view_laporan');
});
    

// Routing untuk CRUD Data User (Profile dari User / Customer)
Route::get('/profileSetting', [ProfileController::class, 'edit'])->middleware(['auth'])->name('editProfile');
Route::patch('/profileSetting', [ProfileController::class, 'update'])->middleware(['auth'])->name('updateProfile');

// Routing untuk CRUD Data Pekerja (Profile dari pekerja)
Route::get('/pekerjaProfile', [ProfilePekerjaController::class, 'view'])->middleware(['auth:pekerja'])->name('viewProfilePekerja');
Route::patch('/pekerjaProfile', [ProfilePekerjaController::class, 'update'])->middleware(['auth:pekerja'])->name('updateProfilePekerja');

Route::middleware(['auth:pekerja', 'dokter.pekerja'])->group(function () {
    // Routing untuk Dokter 
    Route::get('/jadwal-aktif-dokter', [DokterController::class,'showJadwalAktif'])->name('ShowJadwalAktif');
    Route::get('/tambah-keterangan-dan-medikasi/{transaksi_id}',[DokterController::class,'tambahKeteranganDanMedikasi'])->name('TambahKeteranganDanMedikasi');
    Route::post('/proses-tambah-keterangan',[DokterController::class,'prosesTambahKeteranganDanMedikasi'])->name('ProsesTambahKeteranganDanMedikasi');
});

Route::middleware(['auth:pekerja', 'groomer.pekerja'])->group(function () {
    // Routing untuk Groomer 
    Route::get('/konfirmasi-proses-grooming', [GroomerController::class,'konfirmasiProsesGrooming'])->name('KonfirmasiProsesGrooming');
    Route::patch('/konfirmasi-selesai-grooming/{transaksi_id}', [GroomerController::class, 'konfirmasiSelesaiGrooming'])->name('KonfirmasiSelesaiGrooming');
});

// Routing untuk proses CRUD dari fitur MyPets di dashboard Customer
Route::get('/myPets', [PetsController::class, 'viewPets'])->middleware(['auth'])->name('viewPets');
Route::get('/myPets/add', [PetsController::class, 'createRandomCode'])->middleware(['auth'])->name('registerPets');
Route::post('/myPets/addPet', [PetsController::class, 'storePet'])->middleware(['auth'])->name('register_pet');
Route::get('/myPets/update/{kode_pasien}', [PetsController::class, 'updatePetForm'])->middleware(['auth'])->name('updatePetForms');
Route::post('/myPets/updatePet/{kode_pasien}', [PetsController::class, 'updatePet'])->middleware(['auth'])->name('update_pet');
Route::delete('/myPets/delete/{kode_pasien}', [PetsController::class, 'deletePet'])->middleware(['auth'])->name('delete_pet');

Route::get('/myPets/rekam-medis/{kode_pasien}',[PetsController::class, 'showRekamMedis'])->middleware(['auth'])->name('ShowRekamMedis');


// Routing untuk proses CRUD dari fitur MyTransaksi di dashboard Customer
Route::get('/myTransaksi', [TransaksiController::class, 'viewTransaksi'])->middleware(['auth'])->name('ViewTransaksi');
Route::get('/myTransaksi/{transaksi_id}/detail', [TransaksiController::class, 'detailMyTransaksi'])->middleware(['auth'])->name('DetailMyTransaksi');
Route::get('/myTransaksi/{transaksi_id}/pembayaran', [TransaksiController::class, 'detailPembayaran'])->middleware(['auth'])->name('DetailPembayaran');
Route::get('/myTransaksi/{transaksi_id}/rekam-medis', [TransaksiController::class, 'detailRekamMedis'])->middleware(['auth'])->name('DetailRekamMedis');
Route::post('/myTransaksi/invoice/{transaksi_id}', [TransaksiController::class, 'viewInvoice'])->middleware(['auth'])->name('ViewInvoice');

Route::post('/view-laporan-transaksi', [AdminController::class,'view_laporan'])->middleware(['auth:pekerja'])->name('view_laporan');

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