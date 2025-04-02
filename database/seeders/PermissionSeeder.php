<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'criar_conta', 'description' => 'Criar uma conta', 'type' => 'escrita'],
            ['name' => 'login', 'description' => 'Autenticar na plataforma', 'type' => 'escrita'],
            ['name' => 'logout', 'description' => 'Sair da plataforma', 'type' => 'escrita'],
            ['name' => 'aceitar_inscricoes_formadores', 'description' => 'Aceitar inscrições de formadores', 'type' => 'escrita'],
            ['name' => 'criar_utilizador', 'description' => 'Criar utilizadores', 'type' => 'escrita'],
            ['name' => 'atribuir_papeis', 'description' => 'Atribuir papéis aos utilizadores', 'type' => 'escrita'],
            ['name' => 'gerir_permissoes', 'description' => 'Gerir permissões', 'type' => 'escrita'],
            ['name' => 'eliminar_utilizador', 'description' => 'Eliminar utilizadores', 'type' => 'escrita'],
            ['name' => 'restaurar_utilizador', 'description' => 'Restaurar contas suspensas', 'type' => 'escrita'],
            ['name' => 'ver_todos_utilizadores', 'description' => 'Ver todos os utilizadores', 'type' => 'leitura'],
            ['name' => 'ver_perfil', 'description' => 'Ver próprio perfil', 'type' => 'leitura'],
            ['name' => 'editar_perfil', 'description' => 'Editar dados pessoais', 'type' => 'escrita'],
            ['name' => 'eliminar_conta', 'description' => 'Solicitar eliminação de conta', 'type' => 'escrita'],
            ['name' => 'ver_historico_atividades_proprias', 'description' => 'Ver histórico de atividades próprias', 'type' => 'leitura'],
            ['name' => 'visualizar_todos_cursos', 'description' => 'Visualizar todos os cursos', 'type' => 'leitura'],
            ['name' => 'inscrever_curso', 'description' => 'Inscrever-se em cursos', 'type' => 'escrita'],
            ['name' => 'aceder_conteudos', 'description' => 'Aceder a conteúdos do curso', 'type' => 'leitura'],
            ['name' => 'favoritar_cursos', 'description' => 'Favoritar cursos', 'type' => 'escrita'],
            ['name' => 'ver_cursos_concluidos', 'description' => 'Ver cursos concluídos', 'type' => 'leitura'],
            ['name' => 'avaliar_cursos', 'description' => 'Avaliar cursos concluídos', 'type' => 'escrita'],
            ['name' => 'criar_curso', 'description' => 'Criar cursos', 'type' => 'escrita'],
            ['name' => 'editar_curso', 'description' => 'Editar cursos próprios', 'type' => 'escrita'],
            ['name' => 'aprovar_curso', 'description' => 'Aprovar e publicar cursos', 'type' => 'escrita'],
            ['name' => 'eliminar_curso', 'description' => 'Eliminar qualquer curso', 'type' => 'escrita'],
            ['name' => 'gerir_categorias', 'description' => 'Gerir categorias de cursos', 'type' => 'escrita'],
            ['name' => 'ver_todos_cursos', 'description' => 'Ver todos os cursos', 'type' => 'leitura'],
            ['name' => 'previsualizar_curso', 'description' => 'Pré-visualizar curso', 'type' => 'leitura'],
            ['name' => 'destacar_cursos', 'description' => 'Destacar cursos na homepage', 'type' => 'escrita'],
            ['name' => 'ver_alunos_inscritos', 'description' => 'Ver alunos inscritos', 'type' => 'leitura'],
            ['name' => 'ver_estatistica_cursos', 'description' => 'Ver estatísticas dos cursos', 'type' => 'leitura'],
            ['name' => 'ver_avaliacoes_cursos', 'description' => 'Monitorizar avaliações de cursos', 'type' => 'leitura'],
            ['name' => 'ver_tickets_suporte', 'description' => 'Ver tickets de suporte', 'type' => 'leitura'],
            ['name' => 'responder_suporte', 'description' => 'Responder tickets de suporte', 'type' => 'escrita'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
