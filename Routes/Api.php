<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Panggil Product Controller sabagai object
use App\Http\Controllers\ProductController;

//Buat route untuk menambahkan data produk
Route ::post('/product', [ProductController::class, 'store']);
Route ::get('/product', [ProductController::class, 'showAll']);
Route ::get('/product/{id}', [ProductController::class, 'showById']);
Route ::get('/product/search/product_name={product_name}', [ProductController::class, 'showByName']);
