<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Buscar formador
        $formador = User::where('role', 'formador')->first();

        // Buscar categorias
        $aiCategory = Category::where('name', 'Inteligência Artificial')->first();
        $marketingCategory = Category::where('name', 'Marketing Digital')->first();
        $linuxCategory = Category::where('name', 'Linux')->first();
        $formacaoCategory = Category::where('name', 'Formação')->first();

        // Criar cursos
        $courses = [
            [
                'title' => 'Inteligência Artificial e Data Science',
                'description' => 'A presente formação tem como objetivo desenvolver conhecimentos e competências sobre Inteligência Artificial, bem como permitir a identificação e compreensão de modelos e algoritmos, com recurso à linguagem de programação Python, para transformar dados em decisões estratégicas, melhorando a eficiência e a eficácia no contexto empresarial.',
                'image' => null,
                'level' => 'Intermediário',
                'duration' => 1800, // 30 horas
                'what_you_will_learn' => 'Proporcionar aos formandos uma compreensão sólida dos conceitos básicos de Inteligência Artificial (IA), ética, governança de dados, e como utilizar Python para preparar e manipular dados para modelos de IA.',
                'category_id' => $aiCategory->id,
                'instructor_id' => $formador->id,
                'status' => 'aprovado',
                'published_at' => Carbon::now(),
            ],
            [
                // database/seeders/CourseSeeder.php (continuação)
                'title' => 'Marketing Digital: Meios, Conteúdos e Estratégias',
                'description' => 'Aprenda a criar e implementar estratégias eficazes de marketing digital para alavancar o seu negócio. Este curso aborda desde conceitos fundamentais até técnicas avançadas de marketing de conteúdo, SEO, email marketing e análise de métricas.',
                'image' => null,
                'level' => 'Iniciante',
                'duration' => 1200, // 20 horas
                'what_you_will_learn' => 'Desenvolver estratégias de marketing digital eficazes, criar conteúdo de qualidade, otimizar para mecanismos de busca e analisar o desempenho de campanhas.',
                'category_id' => $marketingCategory->id,
                'instructor_id' => $formador->id,
                'status' => 'aprovado',
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'Linux OS and Network Essentials',
                'description' => 'Domine os fundamentos do sistema operacional Linux e conceitos essenciais de redes. Este curso prático fornece as habilidades necessárias para administrar sistemas Linux e gerenciar configurações de rede básicas.',
                'image' => null,
                'level' => 'Iniciante',
                'duration' => 1500, // 25 horas
                'what_you_will_learn' => 'Instalar e configurar o Linux, gerenciar usuários e permissões, trabalhar com linha de comando, configurar redes IP e solucionar problemas comuns.',
                'category_id' => $linuxCategory->id,
                'instructor_id' => $formador->id,
                'status' => 'aprovado',
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'Formador + Digital',
                'description' => 'Capacite-se como formador para o ambiente digital. Aprenda metodologias pedagógicas adaptadas ao ensino online, técnicas de engajamento e ferramentas digitais para criar experiências de aprendizagem eficazes.',
                'image' => null,
                'level' => 'Intermediário',
                'duration' => 1200, // 20 horas
                'what_you_will_learn' => 'Planejar formações online, criar materiais didáticos interativos, conduzir sessões virtuais dinâmicas e avaliar o aprendizado à distância.',
                'category_id' => $formacaoCategory->id,
                'instructor_id' => $formador->id,
                'status' => 'pendente',
                'published_at' => null,
            ],
        ];

        foreach ($courses as $courseData) {
            $courseData['slug'] = Str::slug($courseData['title']);
            Course::create($courseData);
        }
    }
}
