<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;
Route::get('/chatbot', \App\Http\Livewire\Dashboard\ChatbotComponenet::class)->name('dashboard.chatbot');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Livewire\Dashboard\DashboardComponent::class)->name('dashboard');
    Route::get('/dashboard/setup', \App\Http\Livewire\Dashboard\SetupComponent::class)->name('setup');
    Route::get('/dashboard/invoice', \App\Http\Livewire\Dashboard\InvoiceComponent::class)->name('dashboard.invoice');
    Route::get('/dashboard/attribute', \App\Http\Livewire\Dashboard\AttributeComponent::class)->name('dashboard.attribute');
    Route::get('/dashboard/users', \App\Http\Livewire\Dashboard\UserComponent::class)->name('users');
    Route::get('/dashboard/categories', \App\Http\Livewire\Dashboard\CategoryComponent::class)->name('categories');
    Route::get('/dashboard/brands', \App\Http\Livewire\Dashboard\BrandComponent::class)->name('brands');
    Route::get('/dashboard/units', \App\Http\Livewire\Dashboard\UnitComponent::class)->name('units');
    Route::get('/dashboard/products', \App\Http\Livewire\Dashboard\ProductComponent::class)->name('products');
    Route::get('/dashboard/purchases', \App\Http\Livewire\Dashboard\PurchaseComponent::class)->name('purchases');
    Route::get('email/verify', Verify::class)->middleware('throttle:6,1')->name('verification.notice');
    Route::get('password/confirm', Confirm::class)->name('password.confirm');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::post('logout', LogoutController::class)->name('logout');
});
Route::get('pdf', [\App\Http\Controllers\PdfController::class, 'index'])->name('pdf');
Route::get('invoice/pdf/{slug:id}', [\App\Http\Controllers\PdfController::class, 'invoice'])->name('pdf.invoice');
Route::get('purchase/pdf/{slug:id}', [\App\Http\Controllers\PdfController::class, 'purchase'])->name('pdf.purchase');
Route::get('/', \App\Http\Livewire\HomeComponent::class)->name('home');
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
Route::get('password/reset', Email::class)->name('password.request');
Route::get('password/reset/{token}', Reset::class)->name('password.reset');

