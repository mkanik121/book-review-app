<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;



Route::get("/",[HomeController::class,'index'])->name('home');
Route::get("books/detail/{id}",[HomeController::class,'BookDetail'])->name('books.detail');
Route::post("books/StoreReview",[HomeController::class,'StoreReview'])->name('books.StoreReview');



Route::group(['prefix' => 'account'], function(){


     Route::group(['middleware' => 'guest'], function(){
        Route::get("login", [AccountController::class,'login'])->name('account.login');
        Route::post("auhtnticate", [AccountController::class,'auhtnticate'])->name('account.auhtnticate');
        Route::get("register", [AccountController::class,'register'])->name('account.register');
        Route::post("register", [AccountController::class,'ProcessRegister'])->name('account.ProcessRegister');
     });

     Route::group(['middleware' => 'auth'], function(){
        Route::get("profile", [AccountController::class,'profile'])->name('account.profile');
        Route::post("ProfileUpdate", [AccountController::class,'ProfileUpdate'])->name('account.ProfileUpdate');
        Route::get("logout", [AccountController::class,'logout'])->name('account.logout');
        Route::get("books", [BookController::class,'index'])->name('books.list');
        Route::get("books/create", [BookController::class,'create'])->name('books.create');
        Route::post("books/store", [BookController::class,'store'])->name('books.store');
        Route::get("books/edit/{id}", [BookController::class,'edit'])->name('books.edit');
        Route::post("books/update/{id}", [BookController::class,'update'])->name('books.update');
        Route::delete("books/delete/", [BookController::class,'delete'])->name('books.delete');
        Route::get("list/reviews", [ReviewController::class,'index'])->name('list.review');
        Route::get("list/reviewEdit/{id}", [ReviewController::class,'reviewEdit'])->name('list.reviewEdit');
        Route::post("list/reviewEdit/reviewUpdate/{id}", [ReviewController::class,'reviewUpdate'])->name('list.reviewUpdate');
        Route::post("list/review/Delete/", [ReviewController::class,'reviewDelete'])->name('list.reviewDelete');

        Route::get("my/Reviews", [AccountController::class,'myReviews'])->name('account.myReviews');

        
     });

});
