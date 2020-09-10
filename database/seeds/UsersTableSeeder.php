<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('nombre_rol', 'admin')->first();
        $ceRole = Role::where('nombre_rol', 'control_escolar')->first();
        
        // Algunos usuarios de prueba...
        $admin = User::create([
            'nombre' => 'Admin',
            'apellido_paterno' => 'Prueba',
            'apellido_materno' => 'Prueba',
            'email' => 'admin@admin.com',
            'password' => Hash::make('prueba')
            ]);

        $ce= User::create([
            'nombre' => 'Encargado',
            'apellido_paterno' => 'Prueba',
            'apellido_materno' => 'Prueba',
            'email' => 'ce@ce.com',
            'password' => Hash::make('prueba'),
            'sede' => 'DGTIC'
            ]);

        $admin->roles()->attach($adminRole);
        $ce->roles()->attach($ceRole);

    }
}
