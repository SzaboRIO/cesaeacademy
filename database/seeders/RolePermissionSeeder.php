<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Atribuir permissões aos papéis
        $rolePermissions = [
            // Admin
            ['role' => 'admin', 'permission_name' => 'aceitar_inscricoes_formadores'],
            ['role' => 'admin', 'permission_name' => 'criar_utilizador'],
            ['role' => 'admin', 'permission_name' => 'atribuir_papeis'],
            ['role' => 'admin', 'permission_name' => 'gerir_permissoes'],
            ['role' => 'admin', 'permission_name' => 'eliminar_utilizador'],
            ['role' => 'admin', 'permission_name' => 'restaurar_utilizador'],
            ['role' => 'admin', 'permission_name' => 'ver_todos_utilizadores'],
            ['role' => 'admin', 'permission_name' => 'ver_perfil'],
            ['role' => 'admin', 'permission_name' => 'editar_perfil'],
            ['role' => 'admin', 'permission_name' => 'visualizar_todos_cursos'],
            ['role' => 'admin', 'permission_name' => 'aprovar_curso'],
            ['role' => 'admin', 'permission_name' => 'eliminar_curso'],
            ['role' => 'admin', 'permission_name' => 'gerir_categorias'],
            ['role' => 'admin', 'permission_name' => 'ver_todos_cursos'],
            ['role' => 'admin', 'permission_name' => 'previsualizar_curso'],
            ['role' => 'admin', 'permission_name' => 'destacar_cursos'],
            ['role' => 'admin', 'permission_name' => 'ver_tickets_suporte'],
            ['role' => 'admin', 'permission_name' => 'responder_suporte'],

            // Formador
            ['role' => 'formador', 'permission_name' => 'ver_perfil'],
            ['role' => 'formador', 'permission_name' => 'editar_perfil'],
            ['role' => 'formador', 'permission_name' => 'eliminar_conta'],
            ['role' => 'formador', 'permission_name' => 'ver_historico_atividades_proprias'],
            ['role' => 'formador', 'permission_name' => 'visualizar_todos_cursos'],
            ['role' => 'formador', 'permission_name' => 'criar_curso'],
            ['role' => 'formador', 'permission_name' => 'editar_curso'],
            ['role' => 'formador', 'permission_name' => 'previsualizar_curso'],
            ['role' => 'formador', 'permission_name' => 'ver_alunos_inscritos'],
            ['role' => 'formador', 'permission_name' => 'ver_estatistica_cursos'],

            // Aluno
            ['role' => 'aluno', 'permission_name' => 'ver_perfil'],
            ['role' => 'aluno', 'permission_name' => 'editar_perfil'],
            ['role' => 'aluno', 'permission_name' => 'eliminar_conta'],
            ['role' => 'aluno', 'permission_name' => 'ver_historico_atividades_proprias'],
            ['role' => 'aluno', 'permission_name' => 'visualizar_todos_cursos'],
            ['role' => 'aluno', 'permission_name' => 'inscrever_curso'],
            ['role' => 'aluno', 'permission_name' => 'aceder_conteudos'],
            ['role' => 'aluno', 'permission_name' => 'favoritar_cursos'],
            ['role' => 'aluno', 'permission_name' => 'ver_cursos_concluidos'],
            ['role' => 'aluno', 'permission_name' => 'avaliar_cursos'],

            // Utilizador (não registrado)
            ['role' => 'utilizador', 'permission_name' => 'visualizar_todos_cursos'],
        ];

        foreach ($rolePermissions as $rp) {
            $permission = Permission::where('name', $rp['permission_name'])->first();

            if ($permission) {
                RolePermission::create([
                    'role' => $rp['role'],
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
