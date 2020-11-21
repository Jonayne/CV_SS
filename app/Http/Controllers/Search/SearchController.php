<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    protected $cat_pago_list = ['Académico de otra dependencia de la UNAM que expide recibo de honorarios (Tiempo completo o asignatura) (Ei)',
                        'Interno Auxiliar que expide recibo de honorarios (IAX)',
                        'Interno Asociado que expide recibo de honorarios (IAS)',
                        'Interno Titular que expide recibo de honorarios (ITT)',
                        'Interno Investigador que expide recibo de honorarios (IIN)',
                        'Interno Investigador que emite factura (IIF)',
                        'No tiene relación con la UNAM y SÍ emite recibo de honorarios (Evi)',
                        'No tiene relación con la UNAM Emite factura (Ev)',
                        'Es becario de la DGTIC que expide recibo de honorarios (Eiii)',
                        'Es personal de honorarios de la DGTIC que expide recibo de honorarios (Eii)',
                        'Es Académico de la UNAM que emite factura (Eviii)',
                        'Caso especial (Z)'];
    
    protected $sede_list = [ 'Ciudad Universitaria', 'Centro Mascarones', 'Centro San Agustín', 
                            'Centro Polanco', 'Sede Virtual' ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {   
        if( Gate::denies('buscar-profesor')) {
                  return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                                ->with('status_color', 'danger');
        }
        
        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $rfc = $request->input('rfc');
        $curp = $request->input('curp');
        $categoria_de_pago = $request->input('categoria_de_pago');

        // Si el usuario quiere limpiar los campos de búsqueda.
        // Todo esto se podría hacer con Javascript, y mejorar, pero mhneee. 8)
        if(!$request->input('cls') === '') {
            $searchDataList = $request->session()->get('searchDataList');
        
            // Para guardar los datos de búsqueda.
            if($nombre || $correo  || $rfc || $curp || $categoria_de_pago) {
                $searchDataList = $request->all();
                $request->session()->put('searchDataList', $searchDataList);
            }
            else if(!empty($searchDataList)) {
                $nombre = $searchDataList['nombre'];
                $correo = $searchDataList['correo'];
                $rfc = $searchDataList['rfc'];
                $curp = $searchDataList['curp'];
                $categoria_de_pago = $searchDataList['categoria_de_pago'];
            } 
        } else {
            $request->session()->forget('searchDataList');
        }

        $cat_pago_list = $this->cat_pago_list;

        return view('search/search', compact('cat_pago_list', 'nombre', 'correo', 'rfc', 'curp', 'categoria_de_pago'));
    }

    public function indexUser(Request $request) {   
        if( Gate::denies('editar-cualquier-usuario')) {
                  return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                                ->with('status_color', 'danger');
        }

        $cat_pago_list = $this->cat_pago_list;
        $sede_list = $this->sede_list;

        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $rfc = $request->input('rfc');
        $curp = $request->input('curp');
        $categoria_de_pago = $request->input('categoria_de_pago');
        $rol_usuario = $request->input('rol_usuario');
        $sede = $request->input('sede');
        $status_user = $request->input('status_user');

        if(!$request->input('cls') === '') {
            $searchDataList = $request->session()->get('searchDataList');
        
            // Para guardar los datos de búsqueda.
            if($nombre || $correo  || $rfc || $curp || $categoria_de_pago) {
                $searchDataList = $request->all();
                $request->session()->put('searchDataList', $searchDataList);
            }
            else if(!empty($searchDataList)) {
                $nombre = $searchDataList['nombre'];
                $correo = $searchDataList['correo'];
                $rfc = $searchDataList['rfc'];
                $curp = $searchDataList['curp'];
                $categoria_de_pago = $searchDataList['categoria_de_pago'];
                $rol_usuario = $searchDataList['rol_usuario'];
                $sede = $searchDataList['sede'];
                $status_user = $searchDataList['status_user'];
            } 
        } else {
            $request->session()->forget('searchDataList');
        }

        $users = DB::table('users')->
                    leftJoin('curricula', 'curricula.user_id', '=', 'users.id')
                    ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                    ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                    ->select('curricula.id as id_curriculum', 'users.id as id_user', 
                        'users.nombre', 'users.apellido_paterno', 'users.apellido_materno', 'curp',
                        'rfc', 'users.email', 'curricula.email_personal', 'habilitado', 'categoria_de_pago', 'sede', 'nombre_rol', 'status');

        if($nombre) {
            $users->where(function($query) use ($nombre) {
                $query->orWhere('users.nombre', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('users.apellido_paterno', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('users.apellido_materno', 'ILIKE', '%'.$nombre.'%');
            });
        }

        if($correo) {
            $users->where(function($query) use ($correo) {
                $query->orWhere('users.email', 'ILIKE', '%'.$correo.'%');
            });
        }
        
        if($rfc) {
            $users->where('rfc', 'ILIKE', '%'.$rfc.'%');
        }

        if($curp) {
            $users->where('curp', 'ILIKE', '%'.$curp.'%');
        }

        if($categoria_de_pago) {
            $users->where('categoria_de_pago', ''.$categoria_de_pago.'');
        }

        if($status_user) {
            $users->where('habilitado', ''.$status_user.'');
        }

        if($sede) {
            $users->where('sede', ''.$sede.'');
        }

        if($rol_usuario) {
            $users->where('nombre_rol', ''.$rol_usuario.'');
        }

        $users->orderByDesc('habilitado');

        //$users->dump(); 

        $users_list = $users->get();

        return view('search/search', compact('cat_pago_list', 'nombre', 'correo', 'rfc', 'curp', 
                        'categoria_de_pago', 'rol_usuario', 'sede_list', 'sede', 'status_user' , 'users_list'));
    }

    public function searchOnDBProf(Request $request) {   

        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $rfc = $request->input('rfc');
        $curp = $request->input('curp');
        $categoria_de_pago = $request->input('categoria_de_pago');

        $searchDataList = $request->session()->get('searchDataList');

        if(!$nombre && !$correo && !$rfc && !$curp && !$categoria_de_pago && empty($searchDataList)) {
            return redirect()->route('buscar_profesor.index')->with('status', 'Introduzca al menos un campo de búsqueda.')
                                                ->with('status_color', 'danger');
        } 
        else if(!empty($searchDataList) && !$nombre && !$correo && !$rfc && !$curp && !$categoria_de_pago) {
            $nombre = $searchDataList['nombre'];
            $correo = $searchDataList['correo'];
            $rfc = $searchDataList['rfc'];
            $curp = $searchDataList['curp'];
            $categoria_de_pago = $searchDataList['categoria_de_pago'];
        } 
        else {
            $searchDataList = $request->all();
            $request->session()->put('searchDataList', $searchDataList);
        }

        // Al ser los profesores los únicos con un curriculum, son los 
        // únicos que entrarán en el filtro.
        $users = DB::table('curricula')->
                    leftJoin('users', 'curricula.user_id', '=', 'users.id')
                    ->select('curricula.id as id_curriculum', 'users.id as id_user', 'curricula.nombre', 'curricula.apellido_paterno', 'curricula.apellido_materno', 
                        'users.nombre', 'users.apellido_paterno', 'users.apellido_materno', 'curp',
                        'rfc', 'users.email', 'curricula.email_personal', 'status', 'categoria_de_pago');

        if($nombre) {
            // ILIKE sólo funciona en Postgresql, busca sin diferenciar entre mayúsculas y minúsculas. Otra 
            // solución es cambiar la codificaciones de la tabla a ci_spanish_algo...

            // Aquí el closure nos ayuda a parentizar la consulta
            // (pues el OR y AND tienen la misma precedencia y pueden generar ambigüedad sin paréntesis)
            $users->where(function($query) use ($nombre) {
                $query->orWhere('curricula.nombre', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('curricula.apellido_paterno', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('curricula.apellido_materno', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('users.nombre', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('users.apellido_paterno', 'ILIKE', '%'.$nombre.'%')->
                        orWhere('users.apellido_materno', 'ILIKE', '%'.$nombre.'%');
            });
        }

        if($correo) {
            $users->where(function($query) use ($correo) {
                $query->orWhere('users.email', 'ILIKE', '%'.$correo.'%')->
                        orWhere('curricula.email_personal', 'ILIKE', '%'.$correo.'%');
            });
        }

        if($rfc) {
            $users->where('rfc', 'ILIKE', '%'.$rfc.'%');
        }

        if($curp) {
            $users->where('curp', 'ILIKE', '%'.$curp.'%');
        }

        if($categoria_de_pago) {
            $users->where('categoria_de_pago', ''.$categoria_de_pago.'');
        }

        $users->orderBy('status');

        return view('search/result')->
                with('result', $users->get())->
                with('nombre', $nombre)->
                with('rfc', $rfc)->
                with('curp', $curp)->
                with('correo', $correo)->
                with('categoria_de_pago', $categoria_de_pago);
    }
}
