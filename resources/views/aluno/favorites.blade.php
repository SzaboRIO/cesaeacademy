@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Meus Cursos Favoritos</h1>
    <p>Aqui podes consultar todos os cursos que marcaste como favorito.</p>
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
                        <form action="{{ route('aluno.favorites') }}" method="GET" class="row g-3">
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

                        <!-- Lista de Cursos -->
                        <div class="card mt-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th scope="col">Título</th>
                                                <th scope="col">Formador</th>
                                                <th scope="col">Área</th>
                                                <th scope="col">Nível</th>
                                                <th scope="col">Data de favorito</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($favorites as $favorite)
                                                <tr class="clickable-row align-middle" data-href="{{ route('course.show', $favorite->course->slug) }}">
                                                    <td>{{ $favorite->course->title }}</td>
                                                    <td>{{ $favorite->course->user->firstname }} {{ $favorite->course->user->lastname }}</td>
                                                    <td>{{ $favorite->course->category->area }}</td>
                                                    <td class="text-center">
                                                        @if($favorite->course->level == 'Iniciante')
                                                            <span class="badge bg-success">Iniciante</span>
                                                        @elseif($favorite->course->level == 'Intermédio')
                                                            <span class="badge bg-warning">Intermédio</span>
                                                        @else
                                                            <span class="badge bg-danger">Avançado</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $favorite->created_at ? $favorite->created_at->format('d/m/Y') : 'N/A' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <p class="mb-0 text-muted">Nenhum curso favorito encontrado.</p>
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
                                    <li class="page-item {{ $favorites->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $favorites->previousPageUrl() ? $favorites->previousPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
                                           aria-label="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">{{ $favorites->currentPage() }}</span>
                                    </li>
                                    <li class="page-item {{ !$favorites->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                           href="{{ $favorites->nextPageUrl() ? $favorites->nextPageUrl().'&'.http_build_query(request()->except('page')) : '#' }}"
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
