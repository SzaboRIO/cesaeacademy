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
    public function index()
    {
        $enrollments = Auth::user()->enrollments()->with('course')->get();

        return view('dashboard.aluno.cursos', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $course = $enrollment->course;
        $lesson = $course->lessons()->first();

        return view('dashboard.aluno.curso', compact('enrollment', 'course', 'lesson'));
    }

    public function watchLesson($enrollmentId, $lessonId)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('id', $enrollmentId)
            ->firstOrFail();

        $course = $enrollment->course;
        $lesson = Lesson::where('id', $lessonId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        return view('dashboard.aluno.curso', compact('enrollment', 'course', 'lesson'));
    }

    public function markAsCompleted(Request $request)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('id', $request->enrollment_id)
            ->firstOrFail();

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('course_id', $enrollment->course_id)
            ->firstOrFail();

        // Verificar se já existe um progresso para esta aula
        $progress = StudentProgress::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$progress) {
            $progress = new StudentProgress([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lesson->id,
                'completed' => true,
                'completed_at' => Carbon::now(),
            ]);
        } else {
            $progress->completed = true;
            $progress->completed_at = Carbon::now();
        }

        $progress->save();

        // Verificar se todas as aulas foram concluídas
        $totalLessons = $enrollment->course->lessons()->count();
        $completedLessons = $enrollment->progress()->where('completed', true)->count();

        if ($completedLessons === $totalLessons) {
            $enrollment->completed_at = Carbon::now();
            $enrollment->save();
        }

        return redirect()->back()->with('success', 'Aula marcada como concluída!');
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

        return redirect()->route('aluno.course.show', $enrollment->id)
            ->with('success', 'Inscrição realizada com sucesso!');
    }

    public function certificates()
    {
        $completedEnrollments = Auth::user()->enrollments()
            ->whereNotNull('completed_at')
            ->with('course')
            ->get();

        return view('dashboard.aluno.certificados', compact('completedEnrollments'));
    }

    public function reviews()
    {
        $enrollments = Auth::user()->enrollments()
            ->with('course', 'course.reviews')
            ->get();

        return view('dashboard.aluno.avaliacoes', compact('enrollments'));
    }
}
