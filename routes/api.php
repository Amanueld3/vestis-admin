<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('contact', ContactController::class);
Route::get('blogs', [BlogController::class, 'index']);
Route::get('galleries', [BlogController::class, 'galleries']);
Route::get('products', [ProductController::class, 'index']);
Route::get('partners', [PartnerController::class, 'index']);
