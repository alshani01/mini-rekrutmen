<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CandidateController::class, 'index'])->name('candidates.index');

Route::prefix('candidates')->name('candidates.')->group(function () {
    Route::post('/', [CandidateController::class, 'store'])->name('store');
    Route::patch('/{candidate}', [CandidateController::class, 'update'])->name('update');
    Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');
});