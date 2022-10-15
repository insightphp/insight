<?php

Route::get('/', \Insight\Http\Controllers\HomeController::class)->name('insight.home');

Route::get('/dashboard', \Insight\Http\Controllers\HomeController::class)->name('dashboard');
Route::get('/dashboard/overview', \Insight\Http\Controllers\HomeController::class)->name('dashboard.overview');
Route::get('/dashboard/notifications', \Insight\Http\Controllers\HomeController::class)->name('dashboard.notifications');
Route::get('/dashboard/analytics', \Insight\Http\Controllers\HomeController::class)->name('dashboard.analytics');
Route::get('/dashboard/saved-reports', \Insight\Http\Controllers\HomeController::class)->name('dashboard.saved-reports');
Route::get('/dashboard/scheduled-reports', \Insight\Http\Controllers\HomeController::class)->name('dashboard.scheduled-reports');
Route::get('/dashboard/user-reports', \Insight\Http\Controllers\HomeController::class)->name('dashboard.user-reports');
Route::get('/projects', \Insight\Http\Controllers\HomeController::class)->name('projects');
Route::get('/projects/pending', \Insight\Http\Controllers\HomeController::class)->name('projects.pending');
Route::get('/projects/published', \Insight\Http\Controllers\HomeController::class)->name('projects.published');
Route::get('/projects/completed', \Insight\Http\Controllers\HomeController::class)->name('projects.completed');
Route::get('/projects/archived', \Insight\Http\Controllers\HomeController::class)->name('projects.archived');
Route::get('/projects/archived/last-30-days', \Insight\Http\Controllers\HomeController::class)->name('projects.archived.last');
Route::get('/projects/archived/all-the-time', \Insight\Http\Controllers\HomeController::class)->name('projects.archived.all');
Route::get('/tasks', \Insight\Http\Controllers\HomeController::class)->name('tasks');
Route::get('/reporting', \Insight\Http\Controllers\HomeController::class)->name('reporting');
Route::get('/users', \Insight\Http\Controllers\HomeController::class)->name('users');

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
