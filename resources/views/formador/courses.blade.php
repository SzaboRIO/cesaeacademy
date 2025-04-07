@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Gestão de Cursos</h1>
    <p>Aqui pode gerir todos os seus cursos (pesquisar, criar, editar e excluir).</p>
</div>

<!-- INÍCIO DO CONTEÚDO DA PÁGINA COM MARGENS -->

<!--
    Esta div envolve o conteúdo principal e aplica margens responsivas nas laterais:
    - mx-3: Aplica uma margem horizontal de 16px (valor padrão do Bootstrap) em todos os tamanhos de tela.
    - mx-md-4: Aplica uma margem horizontal de 24px (valor padrão do Bootstrap) em telas médias (largura mínima de 768px) e maiores.
    - m significa "margin" (margem).
    - x significa "eixo X" ou "horizontal" (esquerda e direita).
    - md = médio, sm = small, lg = large.
-->

@if (session('success'))
    <!-- Container centralizado -->
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">

        <!-- Toast sem cabeçalho, texto centralizado, cor roxa -->
        <div id="myToast"
             class="toast align-items-center show text-white border-0"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-bs-autohide="true"
             data-bs-delay="3000"
             style="
                 background-color: #36236a;
                 text-align: center;
                 border-radius: 8px;
                 font-size: 1rem;
             ">

            <div class="toast-body p-3">
                {{ session('success') }}
            </div>
        </div>
    </div>

    <!-- Script para inicializar o Toast -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myToastEl = document.getElementById('myToast');
            if (myToastEl) {
                var toast = new bootstrap.Toast(myToastEl);
                toast.show(); // dispara o auto-hide
            }
        });
    </script>
@endif

<div class="content-wrapper mx-4 mx-md-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Contêiner Roxo (externo) -->
                <div class="my-5 p-4" style="background-color: #36236a; border-radius: 8px;">

                    <!-- Bloco Branco (interno) -->
                    <div class="p-4" style="background-color: #fff; border-radius: 8px;">

                        <!-- Filtros -->
                        <form action="{{ route('formador.courses') }}" method="GET" class="row g-3">
                            @csrf

                            <div class="col-md-5">
                                <label for="search" class="form-label">Título ou Descrição</label>
                                <input
                                    type="text"
                                    class="form-control bs-default"
                                    id="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Pesquisar..."
                                >
                            </div>

                            <div class="col-md-5">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Todos</option>
                                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">
                                    Procurar
                                </button>
                            </div>
                        </form>

                        <!-- Lista de Cursos -->
                        <div class="card mt-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th scope="col" style="width: 60px; text-align: left">
                                                    <!-- Link para ordenar por "id" -->
                                                    <a href="{{ route('formador.courses', [
                                                        'search' => request('search'),
                                                        'status' => request('status'),
                                                        'sort' => 'id',
                                                        'direction' => (request('sort') === 'id' && request('direction') === 'desc') ? 'asc' : 'desc',
                                                    ]) }}" class="text-dark">
                                                        #
                                                        @if (request('sort') === 'id')
                                                            @if (request('direction') === 'asc')
                                                                <i class="fas fa-sort-up"></i>
                                                            @else
                                                                <i class="fas fa-sort-down"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>

                                                <th scope="col">
                                                    <!-- Link para ordenar por "title" -->
                                                    <a href="{{ route('formador.courses', [
                                                        'search' => request('search'),
                                                        'status' => request('status'),
                                                        'sort' => 'title',
                                                        'direction' => (request('sort') === 'title' && request('direction') === 'asc') ? 'desc' : 'asc',
                                                    ]) }}" class="text-dark">
                                                        Título
                                                        @if (request('sort') === 'title')
                                                            @if (request('direction') === 'asc')
                                                                <i class="fas fa-sort-up"></i>
                                                            @else
                                                                <i class="fas fa-sort-down"></i>
                                                            @endif
                                                        @else
                                                            <i class="fas fa-sort"></i>
                                                        @endif
                                                    </a>
                                                </th>

                                                <th scope="col">Status</th>
                                                <th scope="col">Data de Criação</th>
                                                <th scope="col" style="width: 120px;">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($courses as $course)
                                                <tr class="course-row align-middle" data-course-id="{{ $course->id }}">
                                                    <td>{{ $course->id }}</td>
                                                    <td>{{ $course->title }}</td>
                                                    <td class="text-center">
                                                        @if($course->status == 'aprovado')
                                                            <span class="badge bg-success">Aprovado</span>
                                                        @elseif($course->status == 'pendente')
                                                            <span class="badge bg-warning">Pendente</span>
                                                        @else
                                                            <span class="badge bg-danger">Rejeitado</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $course->created_at->format('d/m/Y') }}</td>
                                                    <td class="text-center align-midle">
                                                        <div class="btn-group" role="group">
                                                            <!-- Botão amarelo (Edição) -->
                                                            <a
                                                                class="btn btn-sm btn-warning edit-user-btn"
                                                                href="{{ route('course.edit', $course->id) }}"
                                                            >
                                                                <!-- Ícone (caneta) -->
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     width="16" height="16"
                                                                     fill="currentColor"
                                                                     color="black"
                                                                     class="bi bi-pen">
                                                                     <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                                                </svg>
                                                            </a>
                                                            <!-- Botão vermelho (Excluir) -->
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-danger rounded-end-3 delete-course-btn"
                                                                data-course-id="{{ $course->id }}"
                                                            >
                                                                <!-- Ícone (lixeira) -->
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor"
                                                                        class="bi bi-trash">
                                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                            <td colspan="6" class="text-center py-4">
                                                <p class="mb-0 text-muted">Nenhum curso encontrado.</p>
                                            </td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Paginação super-minimalista: apenas setas e número da página -->
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Navegação">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $courses->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $courses->previousPageUrl() ? $courses->previousPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
                                           aria-label="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">{{ $courses->currentPage() }}</span>
                                    </li>
                                    <li class="page-item {{ !$courses->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $courses->nextPageUrl() ? $courses->nextPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
                                           aria-label="Próxima">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <br>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <!-- Criação Manual de Curso (se quiser) -->
                            <a href="{{ route('courses.create.formador') }}" class="btn btn-outline-primary my-2 my-sm-0 btn-register">
                                Criar Curso
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCourseModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este curso? Esta ação não pode ser desfeita.</p>
                <p class="text-danger">Atenção: Todos os dados associados a este curso serão excluídos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteCourseForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para chamar o modal de exclusão
    document.querySelectorAll('.delete-course-btn').forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.dataset.courseId;
            document.getElementById('deleteCourseForm').action = `/curso/${courseId}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteCourseModal'));
            deleteModal.show();
        });
    });
</script>

@endsection
