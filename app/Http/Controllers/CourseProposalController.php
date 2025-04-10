<?php

namespace App\Http\Controllers;

use App\Models\CourseProposal;
use Illuminate\Http\Request;

class CourseProposalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'como_descobriu' => 'required|string',
            'descricao' => 'required|string',
        ]);

        CourseProposal::create($validated);

        return redirect()->back()->with('success', 'Sua proposta foi enviada com sucesso! Em breve entraremos em contato.');
    }
}
