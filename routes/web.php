<?php

use App\Http\Controllers\Admin\AccessAdminController;
use App\Http\Controllers\Admin\AccessOperatorController;
use App\Http\Controllers\Admin\LoginController as loginAdminController;
use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Admin\AdminSoalManage;
use App\Http\Controllers\Admin\UjianController as AdminUjianController;
use App\Http\Controllers\Admin\TokenController as AdminTokenController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;

use App\Http\Controllers\Operator\LoginController as loginOperatorController;
use App\Http\Controllers\Operator\OperatorController as OperatorController;
use App\Http\Controllers\Operator\OperatorSoalManage;
use App\Http\Controllers\Operator\UjianController as OperatorUjianController;
use App\Http\Controllers\Operator\TokenController as OperatorTokenController;
use App\Http\Controllers\Operator\UserController as OperatorUserController;
use App\Http\Controllers\Operator\LaporanController as OperatorLaporanController;

use App\Http\Controllers\liveController;
use App\Http\Controllers\User\UserController as UserController;
use App\Http\Controllers\User\LoginController as loginUserController;
use App\Http\Controllers\User\ExamController as ExamUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/live-view/{id}/{token}', [liveController::class, 'index'])->name('live-view');
Route::get('/getData', [liveController::class, 'getData'])->name('getData');

Route::prefix('operator')->group(function () {
    // Redirect To Login
    Route::get('/', function () {
        return redirect()->route('operator.login');
    });

    Route::middleware('redirectAuth')->group(function () {
        Route::get('/login', [loginOperatorController::class, 'showLoginForm'])->name('operator.login');
    });
    Route::post('/login', [loginOperatorController::class, 'login']);
    Route::post('/logout', [loginOperatorController::class, 'logout'])->name('operator.logout');

    // After Login
    Route::middleware(['auth:operator'])->group(function () {
        Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');

        // New Soal
        Route::get('/soal/{kategori}/{sub}', [OperatorSoalManage::class, 'index'])->name('operator.soal.cat');
        Route::get('/get-soals/{kategori}/{sub}', [OperatorSoalManage::class, 'getData'])->name('operator.get.soal.cat');
        Route::get('/soal-tambah/{kategori}/{sub}', [OperatorSoalManage::class, 'create'])->name('operator.soal.create.cat');
        Route::post('/soal-store', [OperatorSoalManage::class, 'store'])->name('operator.soal.store.cat');
        Route::get('/soal-edit/{id}', [OperatorSoalManage::class, 'edit'])->name('operator.soal.edit.cat');
        Route::put('/soal-update/{id}', [OperatorSoalManage::class, 'update'])->name('operator.soal.update.cat');
        Route::delete('/soal-delete/{id}', [OperatorSoalManage::class, 'destroy'])->name('operator.soal.delete.cat');

        Route::get('/ujian', [OperatorUjianController::class, 'index'])->name('operator.ujian');
        Route::get('/ujian-tambah', [OperatorUjianController::class, 'create'])->name('operator.ujian.create');
        Route::get('/get-ujian', [OperatorUjianController::class, 'getData'])->name('operator.get.ujian');
        Route::post('/ujian-store', [OperatorUjianController::class, 'store'])->name('operator.ujian.store');
        Route::get('/ujian-edit/{id}', [OperatorUjianController::class, 'edit'])->name('operator.ujian.edit');
        Route::put('/ujian-update/{id}', [OperatorUjianController::class, 'update'])->name('operator.ujian.update');
        Route::delete('/ujian-delete/{id}', [OperatorUjianController::class, 'destroy'])->name('operator.ujian.delete');

        Route::get('/ujian/tabel-pertanyaan/{id}', [OperatorUjianController::class, 'tabel'])->name('operator.ujian.tabel');
        Route::get('/ujian/pilih-pertanyaan/{id}/{kategori}/{sub}/{no}', [OperatorUjianController::class, 'pertanyaan'])->name('operator.ujian.question-list');
        Route::post('/ujian/pertanyaan-store/{id}', [OperatorUjianController::class, 'storex'])->name('operator.ujian.question-store');
        Route::post('/ujian/import/{id}', [OperatorUjianController::class, 'import'])->name('operator.ujian.import-list');
        Route::get('/ujian/export/{id}', [OperatorUjianController::class, 'generatePDF'])->name('admin.ujian.export');

        Route::get('/token', [OperatorTokenController::class, 'index'])->name('operator.token');
        Route::get('/token-tambah', [OperatorTokenController::class, 'create'])->name('operator.token.create');
        Route::get('/get-token', [OperatorTokenController::class, 'getData'])->name('operator.get.token');
        Route::post('/token-store', [OperatorTokenController::class, 'store'])->name('operator.token.store');
        Route::get('/token-edit/{id}', [OperatorTokenController::class, 'edit'])->name('operator.token.edit');
        Route::put('/token-update/{id}', [OperatorTokenController::class, 'update'])->name('operator.token.update');
        Route::delete('/token-delete/{id}', [OperatorTokenController::class, 'destroy'])->name('operator.token.delete');

        Route::get('/user', [OperatorUserController::class, 'index'])->name('operator.user');
        Route::get('/user-tambah', [OperatorUserController::class, 'create'])->name('operator.user.create');
        Route::get('/get-user', [OperatorUserController::class, 'getData'])->name('operator.get.user');
        Route::post('/user-store', [OperatorUserController::class, 'store'])->name('operator.user.store');
        Route::get('/user-edit/{id}', [OperatorUserController::class, 'edit'])->name('operator.user.edit');
        Route::put('/user-update/{id}', [OperatorUserController::class, 'update'])->name('operator.user.update');
        Route::delete('/user-delete/{id}', [OperatorUserController::class, 'destroy'])->name('operator.user.delete');
        Route::get('/user-report/{id}', [OperatorUserController::class, 'report'])->name('operator.report.examuser');

        Route::get('/laporan', [OperatorLaporanController::class, 'index'])->name('operator.laporan');
        Route::post('/laporan/results', [OperatorLaporanController::class, 'report'])->name('operator.laporan.result');
        Route::post('/laporan/stop-exam', [OperatorLaporanController::class, 'stopExam'])->name('operator.stopUserExam');

        Route::post('/laporan-cetak-by-user', [OperatorLaporanController::class, 'printUser'])->name('operator.report.user');
        Route::get('/laporan-cetak-all/{id}/{token}', [OperatorLaporanController::class, 'printAll'])->name('operator.report.all');
        Route::get('/laporan-cetak-user-exam/{id}', [OperatorLaporanController::class, 'printUserExam'])->name('operator.report.userExam');

        Route::get('/dashboard/active-users-count', [OperatorController::class, 'getActiveUsersCount'])->name('dashboard.activeUsersCount');
        Route::get('/dashboard/participants-by-date', [OperatorController::class, 'getParticipantsByDate'])->name('dashboard.participantsByDate');
        Route::get('/dashboard/gender-distribution', [OperatorController::class, 'getGenderDistribution'])->name('dashboard.genderDistribution');
    });
});

Route::prefix('admin')->group(function () {
    // Redirect To Login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Login & Proses Login
    Route::middleware('redirectAuth')->group(function () {
        Route::get('/login', [loginAdminController::class, 'showLoginForm'])->name('admin.login');
    });
    Route::post('/login', [loginAdminController::class, 'login']);
    Route::post('/logout', [loginAdminController::class, 'logout'])->name('admin.logout');

    // After Login
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // New Soala
        Route::get('/soal/{kategori}/{sub}', [AdminSoalManage::class, 'index'])->name('admin.soal.cat');
        Route::get('/get-soals/{kategori}/{sub}', [AdminSoalManage::class, 'getData'])->name('admin.get.soal.cat');
        Route::get('/soal-tambah/{kategori}/{sub}', [AdminSoalManage::class, 'create'])->name('admin.soal.create.cat');
        Route::post('/soal-store', [AdminSoalManage::class, 'store'])->name('admin.soal.store.cat');
        Route::get('/soal-edit/{id}', [AdminSoalManage::class, 'edit'])->name('admin.soal.edit.cat');
        Route::put('/soal-update/{id}', [AdminSoalManage::class, 'update'])->name('admin.soal.update.cat');
        Route::delete('/soal-delete/{id}', [AdminSoalManage::class, 'destroy'])->name('admin.soal.delete.cat');

        Route::get('/ujian', [AdminUjianController::class, 'index'])->name('admin.ujian');
        Route::get('/ujian-tambah', [AdminUjianController::class, 'create'])->name('admin.ujian.create');
        Route::get('/get-ujian', [AdminUjianController::class, 'getData'])->name('admin.get.ujian');
        Route::post('/ujian-store', [AdminUjianController::class, 'store'])->name('admin.ujian.store');
        Route::get('/ujian-edit/{id}', [AdminUjianController::class, 'edit'])->name('admin.ujian.edit');
        Route::put('/ujian-update/{id}', [AdminUjianController::class, 'update'])->name('admin.ujian.update');
        Route::delete('/ujian-delete/{id}', [AdminUjianController::class, 'destroy'])->name('admin.ujian.delete');

        Route::get('/ujian/tabel-pertanyaan/{id}', [AdminUjianController::class, 'tabel'])->name('admin.ujian.tabel');
        Route::get('/ujian/pilih-pertanyaan/{id}/{kategori}/{sub}/{no}', [AdminUjianController::class, 'pertanyaan'])->name('admin.ujian.question-list');
        Route::post('/ujian/pertanyaan-store/{id}', [AdminUjianController::class, 'storex'])->name('admin.ujian.question-store');
        
        Route::post('/ujian/import/{id}', [AdminUjianController::class, 'import'])->name('admin.ujian.import-list');
        Route::get('/ujian/export/{id}', [AdminUjianController::class, 'generatePDF'])->name('admin.ujian.export');

        Route::get('/token', [AdminTokenController::class, 'index'])->name('admin.token');
        Route::get('/token-tambah', [AdminTokenController::class, 'create'])->name('admin.token.create');
        Route::get('/get-token', [AdminTokenController::class, 'getData'])->name('admin.get.token');
        Route::post('/token-store', [AdminTokenController::class, 'store'])->name('admin.token.store');
        Route::get('/token-edit/{id}', [AdminTokenController::class, 'edit'])->name('admin.token.edit');
        Route::put('/token-update/{id}', [AdminTokenController::class, 'update'])->name('admin.token.update');
        Route::delete('/token-delete/{id}', [AdminTokenController::class, 'destroy'])->name('admin.token.delete');

        Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user');
        Route::get('/user-tambah', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::get('/get-user', [AdminUserController::class, 'getData'])->name('admin.get.user');
        Route::post('/user-store', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/user-edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/user-update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user-delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.delete');
        route::get('/user-report/{id}', [AdminUserController::class, 'report'])->name('admin.report.examuser');

        Route::get('/operator', [AccessOperatorController::class, 'index'])->name('admin.operator');
        Route::get('/operator-tambah', [AccessOperatorController::class, 'create'])->name('admin.operator.create');
        Route::get('/get-operator', [AccessOperatorController::class, 'getData'])->name('admin.get.operator');
        Route::post('/operator-store', [AccessOperatorController::class, 'store'])->name('admin.operator.store');
        Route::get('/operator-edit/{id}', [AccessOperatorController::class, 'edit'])->name('admin.operator.edit');
        Route::put('/operator-update/{id}', [AccessOperatorController::class, 'update'])->name('admin.operator.update');
        Route::get('/operator-change/{id}', [AccessOperatorController::class, 'change'])->name('admin.operator.change');
        Route::put('/operator-modify/{id}', [AccessOperatorController::class, 'modify'])->name('admin.operator.modify');
        Route::delete('/operator-delete/{id}', [AccessOperatorController::class, 'destroy'])->name('admin.operator.delete');

        Route::get('/admin', [AccessAdminController::class, 'index'])->name('admin.admin');
        Route::get('/admin-tambah', [AccessAdminController::class, 'create'])->name('admin.admin.create');
        Route::get('/get-admin', [AccessAdminController::class, 'getData'])->name('admin.get.admin');
        Route::post('/admin-store', [AccessAdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/admin-edit/{id}', [AccessAdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/admin-update/{id}', [AccessAdminController::class, 'update'])->name('admin.admin.update');
        Route::get('/admin-change/{id}', [AccessAdminController::class, 'change'])->name('admin.admin.change');
        Route::put('/admin-modify/{id}', [AccessAdminController::class, 'modify'])->name('admin.admin.modify');
        Route::delete('/admin-delete/{id}', [AccessAdminController::class, 'destroy'])->name('admin.admin.delete');

        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::post('/laporan/results', [AdminLaporanController::class, 'report'])->name('admin.laporan.result');
        Route::post('/laporan/stop-exam', [AdminLaporanController::class, 'stopExam'])->name('admin.stopUserExam');

        Route::post('/laporan-cetak-by-user', [AdminLaporanController::class, 'printUser'])->name('admin.report.user');
        Route::get('/laporan-cetak-all/{id}/{token}', [AdminLaporanController::class, 'printAll'])->name('admin.report.all');
        Route::get('/laporan-cetak-user-exam/{id}', [AdminLaporanController::class, 'printUserExam'])->name('admin.report.userExam');

        Route::get('/dashboard/active-users-count', [AdminController::class, 'getActiveUsersCount'])->name('dashboard.activeUsersCount');
        Route::get('/dashboard/participants-by-date', [AdminController::class, 'getParticipantsByDate'])->name('dashboard.participantsByDate');
        Route::get('/dashboard/gender-distribution', [AdminController::class, 'getGenderDistribution'])->name('dashboard.genderDistribution');
    });
});

// Routes for Users/Members
Route::middleware('redirectAuth')->group(function () {
    Route::get('/login', [loginUserController::class, 'showLoginForm'])->name('login');
});
Route::post('/login', [loginUserController::class, 'login']);
Route::get('password/reset', [loginUserController::class, 'showLinkRequestForm'])->name('password.reset');
Route::post('password/email', [loginUserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('register', [loginUserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [loginUserController::class, 'register']);
Route::post('/logout', [loginUserController::class, 'logout'])->name('user.logout');


Route::middleware(['auth:web'])->prefix('users')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::post('exam/{id}/verifyToken', [ExamUserController::class, 'verifyToken'])->name('exam.verifyToken');
    Route::get('exam/{id}/{token}/proses', [ExamUserController::class, 'proses'])->name('exam.start');
    Route::post('exam/update-timer/{id}', [ExamUserController::class, 'updateTimeLeft'])->name('exam.updateTimer');
    Route::post('exam/question', [ExamUserController::class, 'getQuestion'])->name('exam.getQuest');
    Route::get('exam/return/{sesId}', [ExamUserController::class, 'continueExam'])->name('exam.continue');
    Route::post('exam/submit', [ExamUserController::class, 'saveAnswer'])->name('exam.submit');
    Route::get('exam/stop/{id}/{token}', [ExamUserController::class, 'stopCat'])->name('exam.stopCat');
});
