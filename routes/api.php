<?php

use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('forms')->group(function () {
    Route::get('/', [FormController::class, 'index']);          // لیست فرم‌ها
    Route::get('/{id}', [FormController::class, 'show']);       // نمایش فرم خاص
    Route::post('/', [FormController::class, 'store']);         // ذخیره فرم جدید
    Route::put('/{id}', [FormController::class, 'update']);     // به‌روزرسانی فرم
    Route::delete('/{id}', [FormController::class, 'destroy']); // حذف فرم
});
