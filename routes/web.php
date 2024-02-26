<?php

use App\Http\Livewire\Minute;
use App\Models\Meeting;
use App\Models\Minute as ModelsMinute;
use Carbon\Carbon;
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

Route::get('/', function () {
    return redirect('admin/login');
});

Route::get('/pdf', function () {
    return view('welcome');
});

Route::get('/download-pdf/{record}',[App\Http\Controllers\PDFController::class,'createPDF'])->name('create.pdf');
Route::get('/view-minute/{password}',[App\Http\Controllers\PDFController::class,'MyPublishedMeeting']);
Route::get('/complete/{record}',[App\Http\Controllers\PDFController::class,'notifyChairman'])->name('complete');



