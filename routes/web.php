<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ChatbotController;

Route::get('/chat', [ChatbotController::class, 'index']); // Displays chatbot UI
Route::post('/chat/respond', [ChatbotController::class, 'respond']); // Processes chatbot responses
Route::post('/chatbot', [ChatbotController::class, 'getResponse']);
