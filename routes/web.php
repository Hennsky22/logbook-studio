<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ChecklistPemeriksaanController;
use App\Http\Controllers\MonitoringPublikController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect('/logbooks')
        : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Login dan Logout
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman Admin dan Kepala Studio
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,kepala_studio'])->group(function () {

    // Dashboard dan laporan
    Route::get('/logbooks', [LogbookController::class, 'index'])
        ->name('logbooks.index');

    Route::get('/reports', [LogbookController::class, 'reports'])
        ->name('reports.index');

    // Inventaris
    Route::get('/barang', [ManagementController::class, 'items'])
        ->name('items.index');

    Route::get('/barang/{item}/foto', [ManagementController::class, 'showItemPhoto'])
        ->name('items.photo');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('loans.index');

    // Pemeliharaan
    Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])
        ->name('maintenance.index');
});

/*
|--------------------------------------------------------------------------
| Detail Data
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,kepala_studio'])->group(function () {

    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('loans.show');

    Route::get('/pemeliharaan/{pemeliharaan}', [PemeliharaanController::class, 'show'])
        ->name('maintenance.show');
});

/*
|--------------------------------------------------------------------------
| Operasional Logbook, Peminjaman, dan Pemeliharaan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,kepala_studio'])->group(function () {

    // Logbook
    Route::get('/logbooks/create', [LogbookController::class, 'create'])
        ->name('logbooks.create');

    Route::post('/logbooks', [LogbookController::class, 'store'])
        ->name('logbooks.store');

    // Peminjaman
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create'])
        ->name('loans.create');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('loans.store');

    Route::post('/peminjaman/{peminjaman}/pengembalian', [PeminjamanController::class, 'returnItem'])
        ->name('loans.return');

    // Pemeliharaan
    Route::get('/pemeliharaan/tambah', [PemeliharaanController::class, 'create'])
        ->name('maintenance.create');

    Route::post('/pemeliharaan', [PemeliharaanController::class, 'store'])
        ->name('maintenance.store');
});

/*
|--------------------------------------------------------------------------
| Khusus Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Inventaris
    Route::get('/barang/tambah', [ManagementController::class, 'createItem'])
        ->name('items.create');

    Route::post('/barang', [ManagementController::class, 'storeItem'])
        ->name('items.store');

    Route::get('/barang/{item}/edit', [ManagementController::class, 'editItem'])
        ->name('items.edit');

    Route::put('/barang/{item}', [ManagementController::class, 'updateItem'])
        ->name('items.update');

    Route::delete('/barang/{item}', [ManagementController::class, 'destroyItem'])
        ->name('items.destroy');

    // Penghapusan peminjaman
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])
        ->name('loans.destroy');

    // Penghapusan pemeliharaan
    Route::delete('/pemeliharaan/{pemeliharaan}', [PemeliharaanController::class, 'destroy'])
        ->name('maintenance.destroy');

    // Edit pemeliharaan
    Route::get('/pemeliharaan/{pemeliharaan}/edit', [PemeliharaanController::class, 'edit'])
        ->name('maintenance.edit');

    Route::put('/pemeliharaan/{pemeliharaan}', [PemeliharaanController::class, 'update'])
        ->name('maintenance.update');
});

/*
|--------------------------------------------------------------------------
| Manajemen User
|--------------------------------------------------------------------------
| Hanya Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('manajemen-user')
    ->name('management.users.')
    ->group(function () {

        Route::get('/', [UserManagementController::class, 'index'])
            ->name('index');

        Route::get('/tambah', [UserManagementController::class, 'create'])
            ->name('create');

        Route::post('/', [UserManagementController::class, 'store'])
            ->name('store');

        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])
            ->name('edit');

        Route::put('/{user}', [UserManagementController::class, 'update'])
            ->name('update');

        Route::delete('/{user}', [UserManagementController::class, 'destroy'])
            ->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Kepala Studio
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'role:kepala_studio'])
    ->name('dashboard.user');

Route::get('/dashboard/inventaris', [UserDashboardController::class, 'inventory'])
    ->middleware(['auth', 'role:kepala_studio'])
    ->name('dashboard.inventory');

/*
|--------------------------------------------------------------------------
| Checklist dan History Kepala Studio
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kepala_studio'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Monitoring laporan harian khusus kepala studio
        Route::get('/monitoring', [
            UserDashboardController::class,
            'monitoring'
        ])->name('monitoring');

        // Halaman checklist
        Route::get('/checklist', [
            ChecklistPemeriksaanController::class,
            'index'
        ])->name('checklist');

        // Simpan seluruh pemeriksaan
        Route::post('/checklist/simpan-semua', [
            ChecklistPemeriksaanController::class,
            'storeAll'
        ])->name('checklist.all');

        // Simpan pemeriksaan satu per satu
        Route::post('/checklist', [
            ChecklistPemeriksaanController::class,
            'store'
        ])->name('checklist.store');

        // Simpan personel
        Route::post('/checklist/crew', [
            ChecklistPemeriksaanController::class,
            'storeCrew'
        ])->name('checklist.crew');

        // Simpan keterangan
        Route::post('/checklist/keterangan', [
            ChecklistPemeriksaanController::class,
            'storeKeterangan'
        ])->name('checklist.keterangan');

        // Riwayat pemeriksaan
        Route::get('/history', [
            ChecklistPemeriksaanController::class,
            'history'
        ])->name('history');
    });

/*
|--------------------------------------------------------------------------
| Alias Riwayat
|--------------------------------------------------------------------------
*/

Route::get('/riwayat', [
    ChecklistPemeriksaanController::class,
    'history'
])
    ->middleware(['auth', 'role:kepala_studio'])
    ->name('history');

/*
|--------------------------------------------------------------------------
| MONITORING PUBLIK TANPA LOGIN
|--------------------------------------------------------------------------
*/

// Halaman utama monitoring publik
Route::get('/monitoring', [
    MonitoringPublikController::class,
    'index'
])->name('monitoring.public');

// Data monitoring untuk pembaruan otomatis
Route::get('/monitoring/data', [
    MonitoringPublikController::class,
    'data'
])->name('monitoring.public.data');

// Data detail studio untuk pembaruan otomatis
Route::get('/monitoring/{studio}/data', [
    MonitoringPublikController::class,
    'detailData'
])
    ->whereIn('studio', [
        'master-control-room',
        'berita',
        'penyiaran'
    ])
    ->name('monitoring.public.detail.data');

// Halaman detail masing-masing studio
Route::get('/monitoring/{studio}', [
    MonitoringPublikController::class,
    'detail'
])
    ->whereIn('studio', [
        'master-control-room',
        'berita',
        'penyiaran'
    ])
    ->name('monitoring.public.detail');
