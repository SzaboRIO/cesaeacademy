<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Método para receber e armazenar a avaliação
    public function store(Request $request)
    {
        // 1. Validação dos dados recebidos
        $data = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string',
        ]);

        // 2. Criar a avaliação (review)
        Review::create([
            'user_id'   => Auth::id(),
            'course_id' => $data['course_id'],
            'rating'    => $data['rating'],
            'comment'   => $data['comment'] ?? null,
        ]);

        // 3. Redirecionar de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Avaliação enviada com sucesso!');
    }
}
