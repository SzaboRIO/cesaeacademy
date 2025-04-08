<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function markAsCompleted(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $enrollment = Enrollment::where('id', $validated['enrollment_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $lesson = Lesson::findOrFail($validated['lesson_id']);

        // Verificar se já existe um progresso para esta aula
        $progress = StudentProgress::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$progress) {
            $progress = new StudentProgress([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lesson->id,
                'completed' => true,
                'completed_at' => now(),
            ]);
        } else {
            $progress->completed = true;
            $progress->completed_at = now();
        }

        $progress->save();

        // Verificar se todas as aulas foram concluídas
        $totalLessons = 0;
        foreach ($enrollment->course->modules as $module) {
            $totalLessons += $module->lessons->count();
        }

        $completedLessons = $enrollment->progress()->where('completed', true)->count();

        if ($completedLessons >= $totalLessons) {
            $enrollment->completed_at = now();
            $enrollment->save();
        }

        return redirect()->back()->with('success', 'Aula concluída!');
    }

    public function enroll($courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('status', 'aprovado')
            ->firstOrFail();

        // Verificar se o usuário já está inscrito
        $existingEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('aluno.course.show', $existingEnrollment->id)
                ->with('info', 'Você já está inscrito neste curso.');
        }

        // Criar nova inscrição
        $enrollment = Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'enrolled_at' => Carbon::now(),
        ]);

        // Remover dos favoritos se estiver lá
        \App\Models\Favorite::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->delete();

        return redirect()->back()->with('success', 'Inscrição realizada com sucesso!');
    }

    public function reviews()
    {
        $enrollments = Auth::user()->enrollments()
            ->with('course', 'course.reviews')
            ->get();

        return view('dashboard.aluno.avaliacoes', compact('enrollments'));
    }
}
