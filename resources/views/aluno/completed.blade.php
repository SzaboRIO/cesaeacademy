@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Cursos Concluídos</h1>
    <p>Aqui podes consultar todos os cursos que concluíste.</p>
</div>

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
                        <form action="{{ route('aluno.completed') }}" method="GET" class="row g-3">
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
                                <label for="area" class="form-label">Área</label>
                                <select class="form-select" id="area" name="area">
                                    <option value="" {{ request('area') == '' ? 'selected' : '' }}>Todos</option>
                                    <option value="Development" {{ request('area') == 'Development' ? 'selected' : '' }}>Development</option>
                                    <option value="IT Network" {{ request('area') == 'IT Network' ? 'selected' : '' }}>IT Network</option>
                                    <option value="Media Design" {{ request('area') == 'Media Design' ? 'selected' : '' }}>Media Design</option>
                                    <option value="People" {{ request('area') == 'People' ? 'selected' : '' }}>People</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">
                                    Procurar
                                </button>
                            </div>
                        </form>

                        <!-- Lista de Cursos Concluídos -->
                        <div class="card mt-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th scope="col">Título</th>
                                                <th scope="col">Formador</th>
                                                <th scope="col">Área</th>
                                                <th scope="col">Nível</th>
                                                <th scope="col">Data de conclusão</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($completedEnrollments as $enrollment)
                                                <tr class="clickable-row align-middle" data-href="{{ route('courses.showBySlug', $enrollment->course->slug) }}">
                                                    <td>{{ $enrollment->course->title }}</td>
                                                    <td class="text-center">{{ $enrollment->course->user->firstname }} {{ $enrollment->course->user->lastname }}</td>
                                                    <td class="text-center">{{ $enrollment->course->category->area }}</td>
                                                    <td class="text-center">
                                                        @if($enrollment->course->level == 'Iniciante')
                                                            <span class="badge bg-success">Iniciante</span>
                                                        @elseif($enrollment->course->level == 'Intermédio')
                                                            <span class="badge bg-warning">Intermédio</span>
                                                        @else
                                                            <span class="badge bg-danger">Avançado</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $enrollment->completed_at ? $enrollment->completed_at->format('d/m/Y') : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <p class="mb-0 text-muted">Nenhum curso concluído encontrado.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Navegação">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $completedEnrollments->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $completedEnrollments->previousPageUrl() ? $completedEnrollments->previousPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
                                           aria-label="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">{{ $completedEnrollments->currentPage() }}</span>
                                    </li>
                                    <li class="page-item {{ !$completedEnrollments->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $completedEnrollments->nextPageUrl() ? $completedEnrollments->nextPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>

@endsection
