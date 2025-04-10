<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::where('status', 'aprovado')
            ->withCount('enrollments') // Adiciona o atributo enrollments_count para cada curso.
            ->orderBy('enrollments_count', 'desc') // Ordena do curso com mais inscrições para o que tem menos.
            ->orderBy('id', 'asc') // Ordenação secundária para manter consistência.
            ->limit(8)
            ->get();

        $recentCourses = Course::where('status', 'aprovado')
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact('popularCourses', 'recentCourses'));
    }

    public function about()
    {
        return view('sobre');
    }

    public function collaborate()
    {
        return view('colaborar');
    }
}
