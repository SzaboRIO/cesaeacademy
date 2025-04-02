<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::where('status', 'aprovado');

        // Filtros
        if ($request->has('area')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('area', $request->area);
            });
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->paginate(12);
        $categories = Category::all();

        return view('cursos', compact('courses', 'categories'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'aprovado')
            ->firstOrFail();

        return view('curso.show', compact('course'));
    }

    public function showByArea($area)
    {
        $courses = Course::whereHas('category', function($query) use ($area) {
            $query->where('area', $area);
        })->where('status', 'aprovado')->paginate(12);

        return view('cursos', compact('courses', 'area'));
    }
}
