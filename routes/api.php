<?php

use App\Http\Controllers\telegram\TelegramController;
use Illuminate\Support\Facades\Route;


Route::post('/earnVibe', [TelegramController::class, 'index']);
