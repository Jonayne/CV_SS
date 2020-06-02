<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('nombre_rol', 'admin')->first();
        $profesorRole = Role::where('nombre_rol', 'profesor')->first();
        $ceRole = Role::where('nombre_rol', 'control_escolar')->first();
        
        // Algunos usuarios de prueba...
        $admin = User::create([
            'nombre' => 'admin',
            'apellido_paterno' => 'admin',
            'apellido_materno' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('prueba')
            ]);

        $profesor = User::create([
            'nombre' => 'profesor',
            'apellido_paterno' => 'profesor',
            'apellido_materno' => 'profesor',
            'email' => 'profesor@profesor.com',
            'password' => Hash::make('prueba')
            ]);

        $profesor2 = User::create([
            'nombre' => 'profesor2',
            'apellido_paterno' => 'profesor2',
            'apellido_materno' => 'profesor2',
            'email' => 'profesor2@profesor.com',
            'password' => Hash::make('prueba')
            ]);

        $ce= User::create([
            'nombre' => 'ce',
            'apellido_paterno' => 'ce',
            'apellido_materno' => 'ce',
            'email' => 'ce@ce.com',
            'password' => Hash::make('prueba'),
            'sede' => 'DGTIC'
            ]);

        $admin->roles()->attach($adminRole);
        $profesor->roles()->attach($profesorRole);
        $profesor2->roles()->attach($profesorRole);
        $ce->roles()->attach($ceRole);

    }
}
