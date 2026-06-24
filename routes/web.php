<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::redirect('/' , 'blog/list');

Route::group(['prefix' => 'blog'] , function(){

    Route::get('list' , [BlogController::class , 'list'])->name('blog#list');
    Route::post('create' , [BlogController::class , 'create'])->name('blog#create');
    Route::get('delete/{id}' , [BlogController::class , 'delete'])->name('blog#delete');
    Route::get('edit/{id}' , [BlogController::class , 'edit'])->name('blog#edit');
    Route::post('update/{id}' , [BlogController::class , 'update'])->name('blog#update');
});
