@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Meus Cursos</h1>
    <p>Aqui podes consultar todos os cursos em que estás inscrito neste momento.</p>
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
                        <form action="{{ route('aluno.courses') }}" method="GET" class="row g-3">
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
                                <label for="category" class="form-label">Área</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" {{ request('category') == '' ? 'selected' : '' }}>Todos</option>
                                    <option value="Development" {{ request('category') == 'Development' ? 'selected' : '' }}>Development</option>
                                    <option value="IT Network" {{ request('category') == 'IT Network' ? 'selected' : '' }}>IT Network</option>
                                    <option value="Media Design" {{ request('category') == 'Media Design' ? 'selected' : '' }}>Media Design</option>
                                    <option value="People" {{ request('category') == 'People' ? 'selected' : '' }}>People</option>
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
                                                <th scope="col">
                                                    <!-- Link para ordenar por "title" -->
                                                    <a href="{{ route('aluno.courses', [
                                                        'search' => request('search'),
                                                        'status' => request('category'),
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

                                                <th scope="col" style="width: 60px; text-align: left">
                                                    <!-- Link para ordenar por "formador" -->
                                                    <a href="{{ route('admin.courses', [
                                                        'search' => request('search'),
                                                        'status' => request('status'),
                                                        'sort' => 'formador',
                                                        'direction' => (request('sort') === 'formador' && request('direction') === 'asc') ? 'desc' : 'asc',
                                                    ]) }}" class="text-dark">
                                                        Formador
                                                        @if (request('sort') === 'formador')
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

                                                <th scope="col">Área</th>
                                                <th scope="col">Nível</th>
                                                <th scope="col">Data de inscrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($courses as $course)
                                                <tr class="course-row align-middle" data-course-id="{{ $course->id }}">
                                                    <td>{{ $course->title }}</td>
                                                    <td>{{ $course->formador }}</td>
                                                    <td>{{ $course->category }}</td>
                                                    <td class="text-center">
                                                        @if($course->level == 'Iniciante')
                                                            <span class="badge bg-success">Iniciante</span>
                                                        @elseif($course->level == 'Intermédio')
                                                            <span class="badge bg-warning">Intermédio</span>
                                                        @else
                                                            <span class="badge bg-danger">Avançado</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $course->created_at->format('d/m/Y') }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
