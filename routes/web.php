<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\ParameterProsesController;
use App\Http\Controllers\ParameterSikapController;
use App\Http\Controllers\ParameterSolusiController;
use App\Http\Controllers\ParameterQmController;
use App\Http\Controllers\PenilaianTappingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('navigation', NavigationController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    
    // Parameter QM Routes (Dashboard)
    Route::get('/parameter-qm', [ParameterQmController::class, 'index'])->name('parameter-qm.index');
    
    // Parameter Proses Routes
    Route::resource('parameter-proses', ParameterProsesController::class);
    
    // Parameter Sikap Routes
    Route::resource('parameter-sikap', ParameterSikapController::class);
    
    // Parameter Solusi Routes
    Route::resource('parameter-solusi', ParameterSolusiController::class);
    
    // Penilaian Tapping Routes
    Route::resource('penilaian-tappings', PenilaianTappingController::class);
    Route::get('penilaian-tappings/download/peak/{peak}', [PenilaianTappingController::class, 'downloadPeakDetail'])->name('penilaian-tappings.download-peak');
    Route::get('penilaian-tappings/download/agent/{agentId}/peak/{peak}', [PenilaianTappingController::class, 'downloadAgentDetail'])->name('penilaian-tappings.download-agent');
});
