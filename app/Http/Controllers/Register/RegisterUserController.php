<?php

namespace App\Http\Controllers\Register;

use App\Curriculum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Role;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller {

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
        if( Gate::denies('registrar-usuario')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $request->session()->forget('searchDataList');
        $cat_pago_list = $this->cat_pago_list;
        $sede_list = $this->sede_list;

        return view('register/register', compact('cat_pago_list', 'sede_list'));
    }

    public function registerUser(RegisterUserRequest $request) {
        $validatedData = $request->validated();
        // Si el usuario modificó el HTML de la página y quiso meter un rol no
        // permitido...
        if($validatedData['role'] !== "control_escolar" && 
                    $validatedData['role'] !== "profesor" && $validatedData['role'] !== "admin") {
            return redirect()->back()->with('status', 'Algo salió mal...')
                                     ->with('status_color', 'danger');
        }

        if($validatedData['role'] === "control_escolar" && Gate::denies('registrar-encargado-ce')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                            ->with('status_color', 'danger');
        } elseif($validatedData['role'] === "profesor" && Gate::denies('registrar-profesor')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                            ->with('status_color', 'danger');
        } elseif($validatedData['role'] === "admin" && Gate::denies('registrar-admin')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                            ->with('status_color', 'danger');
        }
        $random_token = $request->session()->get('random_token');
        if($random_token && !empty($random_token) && (hash_equals($request->unique_token, $random_token))) {
            $request->session()->forget('random_token');
            $rol = Role::where('nombre_rol', $validatedData['role'])->first();

            $new_user = User::create([
                            'nombre' => $validatedData['nombre'],
                            'apellido_paterno' => $validatedData['ap_paterno'],
                            'apellido_materno' => $validatedData['ap_materno'] ?? '',
                            'email' => $validatedData['email'],
                            'password' => Hash::make($validatedData['password']),
                            'sede' => $validatedData['sede'] ?? '',
                            'categoria_de_pago' => $validatedData['cat_pago'] ?? '',
                            'habilitado' => true
                        ]);

            if ($validatedData['role'] === "profesor") {
                $curriculum = new Curriculum();
                $curriculum->user_id = $new_user->id;
                $curriculum->status = 'en_proceso';
                $curriculum->save();
            }

            $new_user->roles()->attach($rol);
        }

        return redirect()->route('home')->with('status', 'Usuario registrado exitosamente.')
                                            ->with('status_color', 'success');

    }

    public function indexCatPago(Request $request, $id, $backPage) {  
        if( Gate::denies('registrar-profesor')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $user = User::findOrFail($id);
        $cat_pago_list = $this->cat_pago_list;
        $curriculum_id = $user->curriculum()->first()->id;

        return view('register/update_cat_pago', compact('cat_pago_list', 'user', 'backPage',  'curriculum_id'));
    }

    public function saveCatPago(Request $request, $id, $backPage) {
        if(Gate::denies('registrar-profesor')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $validatedData = $request->validate([
            'categoria_de_pago' => 'required'
        ]);

        $user = User::findOrFail($id);   

        $user->update($validatedData);
        
        if($backPage && $backPage === 'download_cv') {
            return redirect()->route('curricula.show', array('id'=>$user->curriculum()->first()->id, 'formNum'=>1))->with('status', 'Usuario actualizado exitosamente.')
                                            ->with('status_color', 'success');
        } 
        else if ($backPage && $backPage === 'result' && !Gate::denies('editar-cualquier-usuario')) {
            return redirect()->route('buscar_profesor.indexUser', array('nombre' => session('searchDataList.nombre'),
                                                                        'correo' => session('searchDataList.correo'),
                                                                        'rfc' => session('searchDataList.rfc'),
                                                                        'curp' => session('searchDataList.curp'),
                                                                        'categoria_de_pago' => session('searchDataList.categoria_de_pago'),
                                                                        'rol_usuario' => session('searchDataList.rol_usuario'),
                                                                        'sede' => session('searchDataList.sede'),
                                                                        'status_user' => session('searchDataList.status_user')))
                                            ->with('status', 'Usuario actualizado exitosamente.')
                                            ->with('status_color', 'success');
        }
        else if ($backPage && $backPage === 'result') {
            return redirect()->route('buscar_profesor.searchOnDBProf', array('nombre' => session('searchDataList.nombre'),
                                                                        'correo' => session('searchDataList.correo'),
                                                                        'rfc' => session('searchDataList.rfc'),
                                                                        'curp' => session('searchDataList.curp'),
                                                                        'categoria_de_pago' => session('searchDataList.categoria_de_pago')))
                                            ->with('status', 'Usuario actualizado exitosamente.')
                                            ->with('status_color', 'success');
        }
        else {
            return redirect()->route('home')->with('status', 'Usuario actualizado exitosamente.')
                                            ->with('status_color', 'success');
        }
        
    }
    
}
