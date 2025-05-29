<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AcademiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

use App\Http\Controllers\Auth\AuthenticatedSessionController as AuthenticatedSessionControllerManual;




Route::get('/', function () {
    return view('welcome');
});


Route::get('home', function () {return view('home');})->name('home')->middleware('auth');

//FORTIFY PASSWORD
Route::get('/login', fn() => view('auth.login'))->name('login');
//Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/login', [AuthenticatedSessionControllerManual::class, 'store'])->middleware(['guest'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');;
Route::get('/register', fn() => view('auth.register'))->name('register')->middleware('auth');
Route::post('/register', [RegisteredUserController::class, 'store']);


//ROUTES FOR USERS
//Route::resource('users', UserController::class);
Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('users/create',[UserController::class,'create'])->name('users.create')->middleware('auth');
Route::post('users',[UserController::class,'store'])->name('users.store')->middleware('auth');
Route::get('users/{user}/edit',[UserController::class,'edit'])->name('users.edit')->middleware('auth');
Route::put('users/{user}',[UserController::class,'update'])->name('users.update')->middleware('auth');
Route::delete('users/{user}',[UserController::class,'destroy'])->name('users.destroy')->middleware('auth'); 


//ROUTES FOR ROLES
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('auth');
Route::get('roles/create',[RoleController::class,'create'])->name('roles.create')->middleware('auth');
Route::post('roles',[RoleController::class,'store'])->name('roles.store')->middleware('auth');
Route::get('roles/{role}/edit',[RoleController::class,'edit'])->name('roles.edit')->middleware('auth');
Route::put('roles/{role}',[RoleController::class,'update'])->name('roles.update')->middleware('auth');
Route::delete('roles/{role}',[RoleController::class,'destroy'])->name('roles.destroy')->middleware('auth');


//ROUTES FOR PERMISOS

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('permissions/create',[PermissionController::class,'create'])->name('permissions.create');
Route::post('permissions',[PermissionController::class,'store'])->name('permissions.store');
Route::get('permissions/{permission}/edit',[PermissionController::class,'edit'])->name('permissions.edit');
Route::put('permissions/{permission}',[PermissionController::class,'update'])->name('permissions.update');
Route::delete('permissions/{permission}',[PermissionController::class,'destroy'])->name('permissions.destroy');


//ROUTES FOR ACADEMIAS
Route::get('/academias', [AcademiaController::class, 'index'])->name('academias.index')->middleware('auth');
Route::get('/academias/{academia}/view', [AcademiaController::class, 'view'])->name('academias.view')->middleware('auth');
Route::get('academias/create',[AcademiaController::class,'create'])->name('academias.create')->middleware('auth');
Route::post('academias',[AcademiaController::class,'store'])->name('academias.store')->middleware('auth');
Route::get('academias/{academia}/edit',[AcademiaController::class,'edit'])->name('academias.edit')->middleware('auth');
Route::put('academias/{academia}',[AcademiaController::class,'update'])->name('academias.update')->middleware('auth');
Route::delete('academias/{academia}',[AcademiaController::class,'destroy'])->name('academias.destroy')->middleware('auth'); 