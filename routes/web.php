<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminSoalManage;
use App\Http\Controllers\Operator\OperatorSoalManage;

// New Soal
Route::get('/soal', [AdminSoalManage::class, 'index'])->name('admin.soal.cat');
Route::get('/get-soals', [AdminSoalManage::class, 'getData'])->name('admin.get.soal.cat');
Route::get('/soal-tambah', [AdminSoalManage::class, 'create'])->name('admin.soal.create.cat');
Route::post('/soal-store', [AdminSoalManage::class, 'store'])->name('admin.soal.store.cat');
Route::get('/soal-edit/{id}', [AdminSoalManage::class, 'edit'])->name('admin.soal.edit.cat');
Route::put('/soal-update/{id}', [AdminSoalManage::class, 'update'])->name('admin.soal.update.cat');
Route::delete('/soal-delete/{id}', [AdminSoalManage::class, 'destroy'])->name('admin.soal.delete.cat');
