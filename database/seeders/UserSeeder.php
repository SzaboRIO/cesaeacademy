<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Criar administrador
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Sistema',
            'email' => 'admin@cesae.pt',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Criar formador
        User::create([
            'firstname' => 'Formador',
            'lastname' => 'Exemplo',
            'email' => 'formador@cesae.pt',
            'password' => Hash::make('password'),
            'profession' => 'Professor de Tecnologia',
            'role' => 'formador',
        ]);

        // Criar aluno
        User::create([
            'firstname' => 'Aluno',
            'lastname' => 'Exemplo',
            'email' => 'aluno@cesae.pt',
            'password' => Hash::make('password'),
            'profession' => 'Estudante',
            'role' => 'aluno',
        ]);
    }
}
