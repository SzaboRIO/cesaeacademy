<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::where('status', 'aprovado')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $recentCourses = Course::where('status', 'aprovado')
            ->orderBy('created_at', 'desc')
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
