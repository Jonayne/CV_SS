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
        
        // Algunos usuarios de prueba...
        $admin = User::create([
            'nombre' => 'Admin',
            'apellido_paterno' => 'Default',
            'email' => 'admin@admin.com',
            'password' => Hash::make('holaADMIN'),
            'habilitado' => true
            ]);

        $admin->roles()->attach($adminRole);

    }
}
