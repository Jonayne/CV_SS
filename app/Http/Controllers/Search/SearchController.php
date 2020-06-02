<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProfessorRequest;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        if( Gate::denies('buscar-profesor')){
                  return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción.')
                                                ->with('status_color', 'danger');
        }

        return view('search/search');
    }

    public function searchOnDB(SearchProfessorRequest $request)
    {   
        // Validamos los datos.
        $request->validated();

        $nombre = $request->name;
        $correo = $request->email;

        if($nombre && !$correo){
            //ILIKE sólo funciona en Postgresql, busca sin diferenciar entre mayúsculas y minúsculas. Otra 
            // solución es cambiar la codificaciones de la tabla a ci_spanish_algo...
            $users = User::where('nombre', 'ILIKE', '%'.$nombre.'%')->get();
        }
        elseif($correo && !$nombre){
            $users = User::where('email', 'ILIKE', '%'.$correo.'%')->get();
        }
        else{
            $users = User::where('nombre', 'ILIKE', '%'.'$nombre'.'%')->
                    orWhere('email', 'LIKE', '%'.$correo.'%')->get();
        }

        // Sólo queremos buscar profesores, así que filtramos nuestra colección de usuarios resultantes
        //  a sólo los que tengan asignado el rol de profesor.
        $professors = $users->reject(function($user){
            return !$user->hasRole('profesor');
        });

        return view('search/result')->
                with('result', $professors)->
                with('nombre', $nombre)->
                with('correo', $correo);

    }
}
