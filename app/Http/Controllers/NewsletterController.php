<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function newsletter(Request $request)
    {
        // Validação simples: verifique se o email é válido e obrigatório.
        $request->validate([
            'email' => 'required|email|unique:newsletter,email',
        ]);

        // Cria um novo assinante
        Newsletter::create([
            'email' => $request->input('email')
        ]);

        // Opcionalmente, pode redirecionar de volta com uma mensagem de sucesso.
        return redirect()->back()->with('success', 'Obrigado por se subscrever!');
    }
}
