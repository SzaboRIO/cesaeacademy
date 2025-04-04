@extends('layouts.main_layout')

@section('content')

<div class="courses-container">
    <!-- Header da página de cursos -->
    <div class="courses-header">
        <h1>Cursos</h1>
        <p>Temos uma oferta variada de cursos, para que possa escolher aquele que mais se adpata aos seus interesses.</p>
    </div>

    <!-- Filtros e ordenação -->
    <div class="filter-sort-container">
        <div class="filters-section">
            <button class="filter-toggle">
                <i class="fas fa-sliders-h"></i> Filtros
            </button>

            <!-- Accordion de filtros -->
            <div class="filters-accordion">
                <div class="filter-group">
                    <button class="accordion-button">
                        Destinatários
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Destinatários -->
                    </div>
                </div>

                <div class="filter-group">
                    <button class="accordion-button">
                        Habilitações literárias
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Habilitações literárias -->
                    </div>
                </div>

                <div class="filter-group">
                    <button class="accordion-button">
                        Local
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Local -->
                    </div>
                </div>

                <div class="filter-group">
                    <button class="accordion-button">
                        Áreas de Formação
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Áreas de Formação -->
                    </div>
                </div>

                <div class="filter-group">
                    <button class="accordion-button">
                        Duração
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Duração -->
                    </div>
                </div>

                <div class="filter-group">
                    <button class="accordion-button">
                        Horário
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <!-- Conteúdo do filtro Horário -->
                    </div>
                </div>
            </div>
        </div>

        <div class="sort-section">
            <span>Ordenar por</span>
            <div class="select-wrapper">
                <select name="sort" id="sort">
                    <option value="">Selecionar</option>
                    <option value="price_asc">Preço: Menor para Maior</option>
                    <option value="price_desc">Preço: Maior para Menor</option>
                    <option value="name_asc">Nome: A-Z</option>
                    <option value="name_desc">Nome: Z-A</option>
                    <option value="date_asc">Data: Mais Recente</option>
                </select>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- Contador de resultados -->
    <div class="results-count">
        <span>{{ $courses->count() }} resultados</span>
    </div>

    <!-- Grid de cursos -->
    <div class="courses-grid">
        @foreach($courses as $course)
        <div class="course-card">
            <a href="{{ route('courses.show', $course->id) }}">
                <div class="course-image">
                    <img src="{{ $course->image_url ?? asset('images/default-course.jpg') }}" alt="{{ $course->title }}">
                </div>
                <div class="course-info">
                    <h3>{{ $course->title }}</h3>
                    <p class="course-location">{{ $course->location }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="pagination-container">
        {{ $courses->links() }}
    </div>
</div>







@endsection
