<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Role;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {   
        if( Gate::denies('registrar-usuario')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        return view('register/register');
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

        $rol = Role::where('nombre_rol', $validatedData['role'])->first();

        $new_user = User::create([
                        'nombre' => $validatedData['nombre'],
                        'apellido_paterno' => $validatedData['ap_paterno'],
                        'apellido_materno' => $validatedData['ap_materno'],
                        'email' => $validatedData['email'],
                        'password' => Hash::make($validatedData['password']),
                        'sede' => $validatedData['sede'] ?? ''
                    ]);

        $new_user->roles()->attach($rol);

        return redirect()->route('home')->with('status', 'Usuario registrado exitosamente.')
                                            ->with('status_color', 'success');

    }
    
}
