<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Traits\HasRoles;
use App\Models\User;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            
            $view->with('user', $user);
            
            $menuitems= [];
            if ($user && $user->hasRole('super-admin')) {
                $menuitems = [
                    0=> [ 'label'=> 'Escritorio', 'icon'=> 'fas fa-dashboard', 'url'=> 'home' ],
                    1=> [ 'label'=> 'Calendario', 'icon'=> 'fas fa-calendar', 'url'=> 'calendario' ],
                    10=> [ 'label'=> 'Asistencia', 'icon'=> 'fa-solid fa-calendar-xmark', 'url'=> 'asistencia' ],
                    2=> [ 'label'=> 'Administración', 'icon'=> 'fas fa-cogs', 'url'=> 'admin' 
                        ,'submenu'=> [
                            0=> ['label'=> 'Academias', 'icon'=> 'fas fa-school', 'url'=> 'academias' ],
                            1=> ['label'=> 'Profesores', 'icon'=> 'fa-solid fa-person-chalkboard', 'url'=> 'profesores' ],
                            2=> ['label'=> 'Alumnos', 'icon'=> 'fa-solid fa-graduation-cap', 'url'=> 'alumnos' ],
                            3=> ['label'=> 'Asignaturas', 'icon'=> 'fa-solid fa-book-bookmark', 'url'=> 'asignaturas' ],
                            4=> ['label'=> 'Aulas', 'icon'=> 'fa-solid fa-chalkboard-user', 'url'=> 'aulas' ],
                            5=> ['label'=> 'Clientes', 'icon'=> 'fas fa-user-tag', 'url'=> 'clientes' ],
                            10=> ['label'=> 'Grupos', 'icon'=> 'fa-regular fa-folder', 'url'=> 'grupos' ],
                            7=> ['label'=> 'Usuarios', 'icon'=> 'fas fa-users', 'url'=> 'users' ],                            
                            6=> ['label'=> 'Roles', 'icon'=> 'fa-solid fa-tags', 'url'=> 'roles' ],
                            9=> ['label'=> 'Permisos', 'icon'=> 'fa-solid fa-tags', 'url'=> 'permissions' ],
                        ],
                    ],                   
                    4=> [ 'label'=> 'Financiero', 'icon'=> 'fas fa-coins', 'url'=> 'accounting/index' 
                        ,'submenu'=> [
                            0 => ['label'=> 'Resumen', 'icon'=> 'fas fa-tachometer-alt', 'url'=> 'accounting/index' ],
                            1 => ['label'=> 'Facturas Recibidas', 'icon'=> 'fas fa-file-import', 'url'=> 'accounting/in_invoices' ],
                            2 => ['label'=> 'Recibos Recibidas', 'icon'=> 'fas fa-file-import', 'url'=> 'accounting/rec_invoices' ],
                            3 => ['label'=> 'Facturas Emitidas', 'icon'=> 'fas fa-file-export', 'url'=> 'accounting/out_invoices' ],
                            4 => ['label'=> 'Movimientos Tesoreria', 'icon'=> 'fas fa-cash-register', 'url'=> 'accounting/movements' ],
                        ],
                    ],
                    5=> [ 'label'=> 'Configuración', 'icon'=> 'fas fa-cogs', 'url'=> 'settings' ]  
                ];
            }

            if ($user && $user->hasRole('admin')) {
                $menuitems = [
                    0=> [ 'label'=> 'Escritorio', 'icon'=> 'fas fa-dashboard', 'url'=> 'home' ],
                    1=> [ 'label'=> 'Calendario', 'icon'=> 'fas fa-calendar', 'url'=> 'calendario' ],
                    10=> [ 'label'=> 'Asistencia', 'icon'=> 'fa-solid fa-calendar-xmark', 'url'=> 'asistencia' ],
                    2=> [ 'label'=> 'Administración', 'icon'=> 'fas fa-cogs', 'url'=> 'admin' 
                        ,'submenu'=> [
                            0=> ['label'=> 'Academias', 'icon'=> 'fas fa-school', 'url'=> 'academias' ],
                            1=> ['label'=> 'Profesores', 'icon'=> 'fa-solid fa-person-chalkboard', 'url'=> 'profesores' ],
                            2=> ['label'=> 'Alumnos', 'icon'=> 'fa-solid fa-graduation-cap', 'url'=> 'alumnos' ],
                            3=> ['label'=> 'Asignaturas', 'icon'=> 'fa-solid fa-book-bookmark', 'url'=> 'asignaturas' ],
                            4=> ['label'=> 'Aulas', 'icon'=> 'fa-solid fa-chalkboard-user', 'url'=> 'aulas' ],
                            5=> ['label'=> 'Clientes', 'icon'=> 'fas fa-user-tag', 'url'=> 'clientes' ],
                            10=> ['label'=> 'Grupos', 'icon'=> 'fas fa-folder', 'url'=> 'grupos' ],                           
                            7=> ['label'=> 'Usuarios', 'icon'=> 'fas fa-users', 'url'=> 'users' ],                            
                        ],
                    ],                                     
                    /*4=> [ 'label'=> 'Financiero', 'icon'=> 'fas fa-coins', 'url'=> 'accounting/index' 
                        ,'submenu'=> [
                            0=> ['label'=> 'Resumen', 'icon'=> 'fas fa-tachometer-alt', 'url'=> 'accounting/index' ],
                            1=>['label'=> 'Facturas Recibidas', 'icon'=> 'fas fa-file-import', 'url'=> 'accounting/in_invoices' ],
                            2=>['label'=> 'Recibos Recibidas', 'icon'=> 'fas fa-file-import', 'url'=> 'accounting/rec_invoices' ],
                            3=>['label'=> 'Facturas Emitidas', 'icon'=> 'fas fa-file-export', 'url'=> 'accounting/out_invoices' ],
                            4=>['label'=> 'Movimientos Tesoreria', 'icon'=> 'fas fa-cash-register', 'url'=> 'accounting/movements' ],
                        ],
                    ],*/                      
                ];
            }


            
            $view->with('menuitems', $menuitems);
            
        });

    }
}
