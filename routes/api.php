<?php

use App\Http\Controllers\BookReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuth\AuthController;
use App\Http\Controllers\BooksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    // User Registration and Login

Route::middleware('api')->group(function () {
    Route::post('/register', [AuthController::class, 'Register'])->name('user.register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::middleware('jwt.verify')->group(function () {

    // Book Management
    Route::controller(BooksController::class)->prefix('books')->group(function () {

        Route::get('/', 'index'); // Get all books

        // Book Management (Admin Only)
        Route::middleware('is_admin')->group(function () {

            Route::post('/store', 'store'); // Add a new book
            Route::put('/{id}/update', 'update');  // Update book details
            Route::delete('/{id}/delete', 'destroy');  // Delete a book by ID
            // Routes for Reports (Admin Only)
            Route::get('/borrowed','borrowedBooksReport'); // Report of currently borrowed books
            Route::get('/popular', 'popularBooksReport'); // Report of popular books

        });

        // Borrowing and Returning Books
        Route::post('/borrow',  'borrow'); // Borrow a book
        Route::post('/return',  'return'); // Return a borrowed book
        Route::get( '/borrowing-history','borrowingHistory'); // Get borrowing history

    });


    // Book Reports (Admin Only)
    Route::middleware('is_admin')->controller(BookReportsController::class)->prefix('reports')->group(function () {

        Route::get('/borrowed', 'borrowedBooksReport'); // Report of currently borrowed books
        Route::get('/popular', 'popularBooksReport'); // Report of popular books

    });



});
