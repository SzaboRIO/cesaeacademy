<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run()
    {
        // Buscar cursos
        $aiCourse = Course::where('title', 'Inteligência Artificial e Data Science')->first();

        if ($aiCourse) {
            // Criar aulas para o curso de IA
            $lessons = [
                // Módulo 1
                [
                    'title' => 'Introdução à Inteligência Artificial',
                    'description' => 'Nesta aula, apresentamos os conceitos básicos de Inteligência Artificial, sua história e aplicações atuais.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 1,
                    'order' => 1,
                ],
                [
                    'title' => 'Ética, Responsabilidade e Governança de Dados',
                    'description' => 'Discutimos os aspectos éticos da IA, responsabilidade no desenvolvimento e uso de sistemas inteligentes e princípios de governança de dados.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 1,
                    'order' => 2,
                ],
                [
                    'title' => 'Fundamentos de Python para Análise de Dados',
                    'description' => 'Introdução à linguagem Python e suas bibliotecas para análise de dados, como NumPy e Pandas.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 1,
                    'order' => 3,
                ],
                [
                    'title' => 'Preparação de Dados para IA',
                    'description' => 'Aprenda técnicas de limpeza, transformação e preparação de dados para modelos de IA.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 1,
                    'order' => 4,
                ],

                // Módulo 2
                [
                    'title' => 'Introdução à Visualização de Dados',
                    'description' => 'Conheça as principais técnicas e ferramentas para visualização de dados com Python.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 2,
                    'order' => 1,
                ],
                [
                    'title' => 'Técnicas de Análise Exploratória de Dados',
                    'description' => 'Aprenda métodos para explorar e entender dados antes de aplicar modelos de IA.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 2,
                    'order' => 2,
                ],
                [
                    'title' => 'Séries Temporais',
                    'description' => 'Estudo de dados sequenciais ordenados no tempo e técnicas específicas para sua análise.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 2,
                    'order' => 3,
                ],

                // Módulo 3
                [
                    'title' => 'Introdução a Machine Learning',
                    'description' => 'Fundamentos de aprendizado de máquina, tipos de algoritmos e aplicações.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 3,
                    'order' => 1,
                ],
                [
                    'title' => 'Construção de Modelos Preditivos',
                    'description' => 'Desenvolvimento prático de modelos de previsão usando scikit-learn e outras bibliotecas.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 3,
                    'order' => 2,
                ],
                [
                    'title' => 'Avaliação e Otimização de Modelos',
                    'description' => 'Métodos para medir o desempenho de modelos de IA e técnicas de otimização.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 3,
                    'order' => 3,
                ],
                [
                    'title' => 'Deep Learning – Conceitos Básicos',
                    'description' => 'Introdução às redes neurais profundas e suas aplicações.',
                    'course_id' => $aiCourse->id,
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // URL de exemplo
                    'module' => 3,
                    'order' => 4,
                ],
            ];

            foreach ($lessons as $lessonData) {
                Lesson::create($lessonData);
            }
        }

        // Adicionar aulas para outros cursos seguindo o mesmo padrão
    }
}
