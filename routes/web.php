<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*Rute vezane za admin panel*/
Route::middleware(['auth:sanctum', 'verified'])->get('/admin/dashboard', function () {
    return view('admin/dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->post('/admin/image_upload', [ImageController::Class, 'storeNewsImage'])->name('news.image.upload');
Route::middleware(['auth:sanctum', 'verified'])->get('/admin/image_delete', [ImageController::Class, 'deleteNewsImage'])->name('news.image.delete');
Route::middleware(['auth:sanctum', 'verified'])->resource('admin/news', NewsController::Class)->except(['show']);
Route::get('admin/news/{id}', [NewsController::Class, 'show'])->name('news.show');

/*Rute vezane za welcome page*/
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/news', [NewsController::class, 'showAll'])->name('news');
Route::get('/new-member', [MemberController::Class], 'create')->name('member.create');
