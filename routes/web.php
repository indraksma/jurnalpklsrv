<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\SsoController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('jurnal');
    } else {
        return view('auth.loginsso');
    }
});

Route::get('login', [SsoController::class, 'showForm'])->name('login');
Route::get('sso', [SsoController::class, 'sso']);
Route::get('ssocek', [SsoController::class, 'ssocek'])->name('ssocek');
Route::get('ssoout', [SsoController::class, 'logout'])->name('ssoout');
Route::get('logout', [SsoController::class, 'logout'])->name('logout');
Route::get('home', App\Http\Livewire\Jurnal::class)->name('home')->middleware('auth');

Route::middleware(['auth', 'role:admin|pokja|guru|waka'])->group(function () {
    Route::get('siswa-pkl', App\Http\Livewire\Siswapkl::class)->name('siswa-pkl');
    Route::get('siswa-pkl/tambah', App\Http\Livewire\Addsiswapkl::class)->name('siswa-pkl.tambah');
    Route::get('dudi', App\Http\Livewire\Dudi::class)->name('dudi');
    Route::get('jurnal', App\Http\Livewire\Jurnal::class)->name('jurnal');
    Route::get('jurnal/tambah', App\Http\Livewire\AddJurnal::class)->name('jurnal.tambah');
    Route::get('jurnal/edit', App\Http\Livewire\EditJurnal::class)->name('jurnal.edit');
    Route::get('nilai', App\Http\Livewire\NilaiPkl::class)->name('nilai');
    Route::get('laporan', App\Http\Livewire\Laporan::class)->name('laporan');
    Route::get('laporan/pkl/{siswaid}/{taid}/{bulan}', [CetakController::class, 'cetak_laporan'])->name('cetak.laporan2');
    Route::get('laporan/siswa/{kelasid}', [CetakController::class, 'cetak_kelas'])->name('cetak.laporan1');
    Route::get('doc', App\Http\Livewire\Setting\LinkDokumentasi::class)->name('doc');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('riwayat-siswa', App\Http\Livewire\RiwayatSiswa::class)->name('riwayat-siswa');
    Route::get('siswa', App\Http\Livewire\Siswa::class)->name('siswa');
    Route::get('users', App\Http\Livewire\Setting\User::class)->name('users');
    //Route::post('import-user', [UserController::class, 'import'])->name('import-user');
    Route::get('ta', App\Http\Livewire\Setting\TahunAjaran::class)->name('ta');
    Route::get('tp', App\Http\Livewire\Setting\TujuanPembelajaran::class)->name('tp');
    Route::get('jurusan', App\Http\Livewire\Setting\Jurusan::class)->name('jurusan');
    Route::get('kelas', App\Http\Livewire\Setting\Kelas::class)->name('kelas');
    Route::get('jenis-kegiatan', App\Http\Livewire\Setting\JenisKegiatan::class)->name('jenis-kegiatan');
});
