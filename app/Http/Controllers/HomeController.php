<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademiaRequest;
use App\Models\Academia;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{    
    /*public function __construct()
    {
        $this->authorizeResource(Academia::class);
    }
    */
    
    

    public function index():View{

        $user = Auth::user();


        if($user->hasRole('super-admin')){
            $academias=Academia::query()->orderByRaw('academia')->get();
        }else{            
             $academias = Academia::query()
                            ->whereHas('users', function ($query) use ($user) {
                                $query->where('users.id', $user->id);
                            })
                            ->withCount([
                                'alumnos as academia_alumnos',
                                'profesores as academia_profesores',
                                'asignaturas as academia_asignaturas',
                                'clientes as academia_clientes',
                                'users as academia_users',
                                'aulas as academia_aulas'
                            ])
                            ->with(['users' => function ($query) {
                                $query->whereHas('roles', function ($roleQuery) {
                                    $roleQuery->where('name', 'admin');
                                });
                            }])
                            ->orderByRaw('academia')
                            ->get();               
        }                       
        //return view('academias.index',compact('academias'));
        return view('home.index',[
            'academias'=>$academias,
            'emptyMessage'=>'No tienes academias asignadas',
        ]);

    }


    


    
}
