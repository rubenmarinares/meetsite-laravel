<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AcademiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfesorController;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

use App\Http\Controllers\Auth\AuthenticatedSessionController as AuthenticatedSessionControllerManual;




Route::get('/', function () {
    return view('welcome');
});


/*RUTA PARA DETERMINAR SI ESTOY LOGADO */
Route::get('/auth/check', function () {
    return response()->json(['authenticated' => true]);
})->middleware('auth');

//Route::get('home', function () {return view('home');})->name('home')->middleware('auth');
use App\Http\Controllers\HomeController;
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

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
Route::delete('users/{user}',[UserController::class,'destroy'])->name('users.destroy')->middleware('auth'); 
Route::put('users/{user}',[UserController::class,'update'])->name('users.update')->middleware('auth');
/*Route::put('users/{user}', function (){
    dd('Update alcanzado');
})->name('users.update');*/


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
Route::post('/academias/set/{academia}', [AcademiaController::class, 'setAcademia'])->name('academia.set')->middleware('auth'); ;


//ROUTES FOR PROFESORES
Route::get('/profesores', [ProfesorController::class, 'index'])->name('profesores.index')->middleware('auth');
Route::get('/profesores/{profesor}/view', [ProfesorController::class, 'view'])->name('profesores.view')->middleware('auth');
Route::get('profesores/create',[ProfesorController::class,'create'])->name('profesores.create')->middleware('auth');
Route::post('profesores',[ProfesorController::class,'store'])->name('profesores.store')->middleware('auth');
Route::get('profesores/{profesor}/edit',[ProfesorController::class,'edit'])->name('profesores.edit')->middleware('auth');
Route::put('profesores/{profesor}',[ProfesorController::class,'update'])->name('profesores.update')->middleware('auth');
Route::delete('profesores/{profesor}',[ProfesorController::class,'destroy'])->name('profesores.destroy')->middleware('auth'); 


//ROUTES FOR ALUMNOS
use App\Http\Controllers\AlumnoController;
Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index')->middleware('auth');
Route::get('/alumnos/{profesor}/view', [AlumnoController::class, 'view'])->name('alumnos.view')->middleware('auth');
Route::get('alumnos/create',[AlumnoController::class,'create'])->name('alumnos.create')->middleware('auth');
Route::post('alumnos',[AlumnoController::class,'store'])->name('alumnos.store')->middleware('auth');
Route::get('alumnos/{alumno}/edit',[AlumnoController::class,'edit'])->name('alumnos.edit')->middleware('auth');
Route::put('alumnos/{alumno}',[AlumnoController::class,'update'])->name('alumnos.update')->middleware('auth');
Route::delete('alumnos/{alumno}',[AlumnoController::class,'destroy'])->name('alumnos.destroy')->middleware('auth'); 

//ROUTES FOR ASIGNATURAS
use App\Http\Controllers\AsignaturaController;
Route::get('/asignaturas', [AsignaturaController::class, 'index'])->name('asignaturas.index')->middleware('auth');
Route::get('/asignaturas/{asignatura}/view', [AsignaturaController::class, 'view'])->name('asignaturas.view')->middleware('auth');
Route::get('asignaturas/create',[AsignaturaController::class,'create'])->name('asignaturas.create')->middleware('auth');
Route::post('asignaturas',[AsignaturaController::class,'store'])->name('asignaturas.store')->middleware('auth');
Route::get('asignaturas/{asignatura}/edit',[AsignaturaController::class,'edit'])->name('asignaturas.edit')->middleware('auth');
Route::put('asignaturas/{asignatura}',[AsignaturaController::class,'update'])->name('asignaturas.update')->middleware('auth');
Route::delete('asignaturas/{asignatura}',[AsignaturaController::class,'destroy'])->name('asignaturas.destroy')->middleware('auth'); 


//ROUTES FOR Aulas
use App\Http\Controllers\AulaController;
Route::get('/aulas', [AulaController::class, 'index'])->name('aulas.index')->middleware('auth');
Route::get('/aulas/{aula}/view', [AulaController::class, 'view'])->name('aulas.view')->middleware('auth');
Route::get('aulas/create',[AulaController::class,'create'])->name('aulas.create')->middleware('auth');
Route::post('aulas',[AulaController::class,'store'])->name('aulas.store')->middleware('auth');
Route::get('aulas/{aula}/edit',[AulaController::class,'edit'])->name('aulas.edit')->middleware('auth');
Route::put('aulas/{aula}',[AulaController::class,'update'])->name('aulas.update')->middleware('auth');
Route::delete('aulas/{aula}',[AulaController::class,'destroy'])->name('aulas.destroy')->middleware('auth'); 



//ROUTES FOR Clientes
use App\Http\Controllers\ClienteController;
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index')->middleware('auth');
Route::get('/clientes/{cliente}/view', [ClienteController::class, 'view'])->name('clientes.view')->middleware('auth');
Route::get('clientes/create',[ClienteController::class,'create'])->name('clientes.create')->middleware('auth');
Route::post('clientes',[ClienteController::class,'store'])->name('clientes.store')->middleware('auth');
Route::get('clientes/{cliente}/edit',[ClienteController::class,'edit'])->name('clientes.edit')->middleware('auth');
Route::put('clientes/{cliente}',[ClienteController::class,'update'])->name('clientes.update')->middleware('auth');
Route::delete('clientes/{cliente}',[ClienteController::class,'destroy'])->name('clientes.destroy')->middleware('auth'); 



//ROUTES FOR Grupos
use App\Http\Controllers\GrupoController;
Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index')->middleware('auth');
Route::get('/grupos/{grupo}/view', [GrupoController::class, 'view'])->name('grupos.view')->middleware('auth');
Route::get('grupos/create',[GrupoController::class,'create'])->name('grupos.create')->middleware('auth');
Route::post('grupos',[GrupoController::class,'store'])->name('grupos.store')->middleware('auth');
Route::get('grupos/{grupo}/edit',[GrupoController::class,'edit'])->name('grupos.edit')->middleware('auth');
Route::put('grupos/{grupo}',[GrupoController::class,'update'])->name('grupos.update')->middleware('auth');
Route::delete('grupos/{grupo}',[GrupoController::class,'destroy'])->name('grupos.destroy')->middleware('auth'); 


//ROUTE FOR CALENDARIO
use App\Http\Controllers\CalendarioController;
//Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index')->middleware('auth');
Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index')->middleware('auth');;
Route::get('/calendario/events', [CalendarioController::class, 'events'])->name('calendario.events');
