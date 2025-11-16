<?php

use App\Models\Setting;
use Livewire\Volt\Volt;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Web Interface
// Route::get('/', function () {
//     return view('led.index');
// });

// ESP8266 Endpoint - Returns "1" or "0"
// ESP8266 Endpoint - Returns "1" or "0"
Route::get('/led/status', function () {
    $status = Setting::getValue('led_status', '0');
    return response($status, 200)->header('Content-Type', 'text/plain');
});

// Control endpoints (optional)
Route::get('/led/on', function () {
    Setting::setValue('led_status', '1');
    return response('1', 200)->header('Content-Type', 'text/plain');
});

Route::get('/led/off', function () {
    Setting::setValue('led_status', '0');
    return response('0', 200)->header('Content-Type', 'text/plain');
});

// Alternative endpoint
Route::get('/read_led.php', function () {
    $status = Setting::getValue('led_status', '0');
    return response($status, 200)
        ->header('Content-Type', 'text/plain');
});
