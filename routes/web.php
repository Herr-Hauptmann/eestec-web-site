<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/dashboard', function () {
    return view('admin/dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->post('/admin/image_upload', [ImageController::Class, 'storeNewsImage'])->name('news.image.upload');

Route::middleware(['auth:sanctum', 'verified'])->resource('admin/news', NewsController::Class);
