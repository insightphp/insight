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
Route::get('/tasks', \Insight\Http\Controllers\HomeController::class)->name('tasks');
Route::get('/reporting', \Insight\Http\Controllers\HomeController::class)->name('reporting');
Route::get('/users', \Insight\Http\Controllers\HomeController::class)->name('users');
