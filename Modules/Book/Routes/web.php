<?php

use Illuminate\Support\Facades\Route;
use Modules\Book\Http\Controllers\BookAdminController;

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

Route::prefix('books')->group(function (){
   Route::get('/' , [\Modules\Book\Http\Controllers\BookController::class , 'index'])->name('books.index');
   Route::get('show/{book}' , [\Modules\Book\Http\Controllers\BookController::class , 'show'])->name('books.show');
   Route::get('library' , [\Modules\Book\Http\Controllers\BookController::class , 'library'])->name('books.library');
   Route::get('download/{book}' , [\Modules\Book\Http\Controllers\BookController::class , 'download'])->name('books.download');
   Route::get('{book}/purchase' , [\Modules\Payment\Http\Controllers\PaymentController::class , 'purchase'])->name('books.purchase');
    Route::get('{book}/purchase/result' , [\Modules\Payment\Http\Controllers\PaymentController::class , 'result'])->name('books.purchase.result');
    Route::get('transactions' ,[\Modules\Book\Http\Controllers\BookController::class , 'transactions'])->name('books.transactions');
});

Route::middleware('auth')->get('logout' , [\Modules\Book\Http\Controllers\BookController::class , 'logout'])->name('logout');

Route::prefix('admin')->group(function (){
    Route::prefix('book')->group(function (){
        Route::get('/' , [BookAdminController::class , 'index'])->name('admin.book.index');
        Route::get('create' , [BookAdminController::class , 'create'])->name('admin.book.create');
        Route::post('create/store' , [BookAdminController::class , 'store'])->name('admin.book.store');
        Route::get('edit/{book}' , [BookAdminController::class , 'edit'])->name('admin.book.edit');
        Route::put('update/{book}' , [BookAdminController::class , 'update'])->name('admin.book.update');
        Route::delete('destroy/{book}' , [BookAdminController::class , 'destroy'])->name('admin.book.destroy');
        Route::get('status/{book}' , [BookAdminController::class , 'status'])->name('admin.book.status');
    });
});
