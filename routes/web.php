<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==================== AUTH ====================
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect to registration (if needed)
Route::get('register', function () {
    return redirect()->route('register');
});

// Laravel default auth routes
Route::group(['middleware' => ['web']], function () {
    Auth::routes();
});

// ==================== DASHBOARD ====================
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// ==================== PENGADAAN ====================
use App\Http\Controllers\PengadaanController;

Route::middleware(['auth'])->group(function () {
    Route::resource('pengadaan', PengadaanController::class);
    Route::get('/monitoring_pengadaan', [PengadaanController::class, 'index'])->name('monitoring_pengadaan');
    Route::get('/proyek', [PengadaanController::class, 'proyekIndex'])->name('proyek.index');
    Route::get('/proyek/create', [PengadaanController::class, 'proyekCreate'])->name('proyek.create');
    Route::post('/proyek/store', [PengadaanController::class, 'proyekStore'])->name('proyek.store');
    Route::get('/proyek/{id}/edit', [PengadaanController::class, 'proyekEdit'])->name('proyek.edit');
    Route::put('/proyek/{id}', [PengadaanController::class, 'proyekUpdate'])->name('proyek.update');
    Route::delete('/proyek/{id}', [PengadaanController::class, 'proyekDestroy'])->name('proyek.destroy');
});

// ==================== PERSIAPAN PENGADAAN ====================
use App\Http\Controllers\PersiapanPengadaanController;

Route::middleware(['auth'])->group(function () {
    // Proyek (Tab 1)
    Route::get('/persiapan-pengadaan', [PersiapanPengadaanController::class, 'index'])->name('persiapan_pengadaan');
    Route::post('/persiapan-pengadaan', [PersiapanPengadaanController::class, 'store'])->name('persiapan_pengadaan.store');
    Route::get('/persiapan-pengadaan/{id}/edit', [PersiapanPengadaanController::class, 'edit'])->name('proyek.edit');
    Route::put('/persiapan-pengadaan/{id}', [PersiapanPengadaanController::class, 'update'])->name('proyek.update');

    // Plan Pengajuan (Tab 2)
    Route::get('/persiapan-pengadaan/plan/create', [PersiapanPengadaanController::class, 'createPlan'])->name('persiapan_pengadaan.plan.create');
    Route::post('/persiapan-pengadaan/plan', [PersiapanPengadaanController::class, 'storePlan'])->name('persiapan_pengadaan.plan.store');
    Route::get('/persiapan-pengadaan/plan/{id}/edit', [PersiapanPengadaanController::class, 'editPlan'])->name('persiapan_pengadaan.plan.edit');
    Route::put('/persiapan-pengadaan/plan/{id}', [PersiapanPengadaanController::class, 'updatePlan'])->name('persiapan_pengadaan.plan.update');
    Route::delete('/persiapan-pengadaan/plan/{id}', [PersiapanPengadaanController::class, 'destroyPlan'])->name('persiapan_pengadaan.plan.destroy');
});


// ==================== DATA PENGADAAN ====================
use App\Http\Controllers\DataPengadaanController;

Route::middleware(['auth'])->group(function () {
    Route::resource('data_pengadaan', DataPengadaanController::class);

    // Manual routes (optional)
    Route::get('/data-pengadaan', [DataPengadaanController::class, 'index'])->name('data_pengadaan');
    Route::get('/data-pengadaan/create', [DataPengadaanController::class, 'create'])->name('data_pengadaan.create');
    Route::post('/data-pengadaan', [DataPengadaanController::class, 'store'])->name('data_pengadaan.store');
    Route::get('/data-pengadaan/{id}/edit', [DataPengadaanController::class, 'edit'])->name('data_pengadaan.edit');
    Route::put('/data-pengadaan/{id}', [DataPengadaanController::class, 'update'])->name('data_pengadaan.update');
    Route::delete('/data_pengadaan/{id}', [DataPengadaanController::class, 'destroy'])->name('data_pengadaan.destroy');
});

// ==================== MONITORING GR ====================
use App\Http\Controllers\MonitoringGRController;

Route::middleware(['auth'])->group(function () {
    Route::resource('monitoring_gr', MonitoringGRController::class);
    Route::get('/monitoring-gr', [MonitoringGRController::class, 'index'])->name('monitoring.gr');

    // 🔥 Route baru untuk Chart AJAX
    Route::get('/api/chart-penagihan', [MonitoringGRController::class, 'getChartData']);
});

// ==================== LAPORAN ====================
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LaporanTahunanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('laporan.bulanan');
    Route::get('/api/laporan/bulanan', [LaporanBulananController::class, 'bulanan'])->name('api.laporan.bulanan');
    Route::get('/laporan/bulanan/export', [LaporanBulananController::class, 'exportPdf'])->name('laporan.export');
    Route::get('/laporan/tahunan', [LaporanTahunanController::class, 'index'])->name('laporan.tahunan');
    Route::get('/laporan/export/data-pengadaan', [LaporanBulananController::class, 'exportDataPengadaan'])->name('export.data-pengadaan');
    Route::get('/laporan/bulanan/pengadaan', [LaporanBulananController::class, 'loadPengadaan'])->name('laporan.bulanan.pengadaan');
    Route::get('/laporan/bulanan/user', [LaporanBulananController::class, 'loadUser'])->name('laporan.bulanan.user');
});

// ==================== ANALISIS DATA ====================
use App\Http\Controllers\AnalisisDataController;

Route::middleware(['auth'])->group(function () {
    Route::get('/analisis-data', [AnalisisDataController::class, 'index'])->name('analisis.data');
});

// ==================== USER & PROFILE MANAGEMENT ====================
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    // Profile & Settings User
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/photo', [UserController::class, 'updateProfilePhoto'])->name('profile.photo.update');
    Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');

    // Additional profile controller (optional)
    Route::post('/profile/upload-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.upload.photo');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update.alt');
});

// ==================== ADMIN USER MANAGEMENT (AdminMiddleware) ====================
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('daftaruser');
    Route::get('/users/add', [UserController::class, 'add'])->name('users.add');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ==================== STATIC VIEWS ====================
Route::get('/gr-ba', function () {
    return view('gr_ba');
})->name('gr-ba');

Route::get('/report-ispp', function () {
    return view('report_ispp');
})->name('report_ispp');

Route::get('/penyerapan-anggaran', function () {
    return view('penyerapan_anggaran');
})->name('penyerapan_anggaran');
