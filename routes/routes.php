<?php

Route::get('/', \Insight\Http\Controllers\HomeController::class)->name('insight.home');

Route::get('/resources/{resource}/create', [\Insight\Http\Controllers\ResourceController::class, 'create'])->name('insight.resources.create');
Route::post('/resources/{resource}/create', [\Insight\Http\Controllers\ResourceController::class, 'store'])->name('insight.resources.store');
Route::post('/resources/{resource}/destroy-many', [\Insight\Http\Controllers\ResourceController::class, 'destroyMany'])->name('insight.resources.destroy-many');
Route::get('/resources/{resource}/{id}/edit', [\Insight\Http\Controllers\ResourceController::class, 'edit'])->name('insight.resources.edit');
Route::patch('/resources/{resource}/{id}/edit', [\Insight\Http\Controllers\ResourceController::class, 'update'])->name('insight.resources.update');
Route::post('/resources/{resource}/{id}/restore', [\Insight\Http\Controllers\ResourceController::class, 'restore'])->name('insight.resources.restore');
Route::delete('/resources/{resource}/{id}', [\Insight\Http\Controllers\ResourceController::class, 'destroy'])->name('insight.resources.destroy');
Route::get('/resources/{resource}/{id}', [\Insight\Http\Controllers\ResourceController::class, 'show'])->name('insight.resources.show');
Route::get('/resources/{resource}', [\Insight\Http\Controllers\ResourceController::class, 'index'])->name('insight.resources.index');

Route::post('/_insight/dialog/{dialog}', \Insight\Http\Controllers\DialogController::class)->name('insight.dialog');
