<?php

use App\Http\Controllers\ActifsFinanciersControllers;
use App\Http\Controllers\DashboardControllers;
use App\Http\Controllers\StopLossControllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardControllers::class, 'index']);
Route::get('/tableau_bord', [DashboardControllers::class, 'dashboard'])->name('dashboard');


Route::get('/actifs/index', [ActifsFinanciersControllers::class, 'index'])->name('actifs.index');
Route::post('/actifs/insert', [ActifsFinanciersControllers::class, 'insert'])->name('actifs.create');
Route::post('/actifs/update/{id}', [ActifsFinanciersControllers::class, 'update'])->name('actifs.update');
Route::post('/actifs/delete', [ActifsFinanciersControllers::class, 'delete'])->name('actifs.delete');
Route::get('/actifs/edit/{id}', [ActifsFinanciersControllers::class, 'edit'])->name('actifs.edit');

Route::get('/stop_loss/index', [StopLossControllers::class, 'index'])->name('stop.index');

