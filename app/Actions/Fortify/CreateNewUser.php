<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'firstname' => ['nullable', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'profession' => ['nullable', 'string', 'max:255'],
        ])->validate();

        return User::create([
            'firstname' => $input['firstname']?? null,
            'lastname' => $input['lastname']?? null,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'profession' => $input['profession'] ?? null,
            'role' => 'aluno', // Por padrão, novos usuários são alunos
        ]);
    }
}
