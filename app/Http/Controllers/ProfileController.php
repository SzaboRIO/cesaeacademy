<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Mostra o formulário de edição do perfil do usuário.
     */
    public function edit()
    {
        return view('perfil');
    }

    /**
     * Atualiza as informações do perfil do usuário.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validação dos dados
        $validated = $request->validate([
            'firstname' => ['nullable', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profession' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string'],
            'current_password' => ['nullable', 'required_with:password', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('A senha atual está incorreta.');
                }
            }],
            'password' => ['nullable', 'required_with:current_password', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image'],
        ]);

        // Atualizar dados básicos
        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->email = $validated['email'];
        $user->profession = $validated['profession'];
        $user->biography = $validated['biography'];

        // Atualizar avatar, se fornecido
        if (isset($validated['avatar'])) {
            $avatarPath = $validated['avatar']->store('avatars', 'public');

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $avatarPath;
        }

        // Atualizar senha, se fornecida
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
}
