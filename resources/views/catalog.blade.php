@extends('layouts.main_layout')

@section('content')

<!-- CAROUSEL -->

    <!-- data-bs-interval="3000" dita o intervalo de tempo que o carousel leva para mudar para o próximo slide -->
    <!-- "mb-5" na class aplica uma "margin bottom" ao final do carousel -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade mb-5 mb-md-5" data-bs-ride="carousel" data-bs-interval="3000">

        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">

            <!-- Image 1 -->
            <div class="carousel-item active">
                <img src="{{ asset('images/carousel_1.jpg') }}" class="d-block w-100" alt="">
            </div>

            <!-- Image 2 -->
            <div class="carousel-item">
                <img src="{{ asset('images/carousel_2.jpg') }}" class="d-block w-100" alt="">
            </div>

            <!-- Image 3 -->
            <div class="carousel-item">
                <img src="{{ asset('images/carousel_3.jpg') }}" class="d-block w-100" alt="">
            </div>

        </div>

        <!-- Carousel buttons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

    <div class="courses-container m-0 p-0">
        <div class="container-fluid">
            <div class="row h-100 m-2">
                <div class="col-md-3">
                    <x-course-filter :categories="$categories" />
                    <div class="results-count my-2">
                        <span>{{ $courses->count() }} resultados</span>
                    </div>
                </div>
                <div class="col-md-9 d-flex flex-column">
                    <div class="courses-grid d-flex flex-wrap justify-content-start gap-4 flex-grow-1 min-vh-60">
                        @foreach($courses as $course)
                            <!-- Card de curso -->
                            <div class="col-md-4 mb-4" style="max-width: 430px;">
                                <a href="{{ route('courses.showBySlug', $course->slug) }}" style="text-decoration: none; color: inherit;">
                                    <div class="card h-100">
                                        <!-- Imagem do curso dinâmica -->
                                        <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/default-course.png') }}"
                                             class="card-img-top w-100 img-fluid"
                                             alt="{{ $course->title }}"
                                             style="object-fit: cover; height: 180px;">
                                        <div class="card-body">
                                            <!-- Título do curso -->
                                            <h5 class="card-title">{{ $course->title }}</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <!-- Exemplo de item dinâmico -->
                                            <li class="list-group-item">Área: {{ $course->category->area ?? 'N/D' }}</li>
                                            <li class="list-group-item">Nível: {{ $course->level }} | {{ $course->duration }}h</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Paginação super-minimalista: apenas setas e número da página -->
                    <div class="d-flex justify-content-center mt-3">
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
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Para categorias
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const categoryAllCheckbox = document.getElementById('categoryAll');

        if (categoryCheckboxes.length > 0 && categoryAllCheckbox) {
            categoryCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('click', function() {
                    // Quando uma categoria específica é clicada, desmarque "Todos"
                    categoryAllCheckbox.checked = false;
                });
            });

            categoryAllCheckbox.addEventListener('click', function() {
                // Quando "Todos" é clicado, desmarque todas as categorias específicas
                if (this.checked) {
                    categoryCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }
            });
        }

        // Mesmo para níveis
        const levelCheckboxes = document.querySelectorAll('.level-checkbox');
        const levelAllCheckbox = document.getElementById('levelAll');

        if (levelCheckboxes.length > 0 && levelAllCheckbox) {
            levelCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('click', function() {
                    levelAllCheckbox.checked = false;
                });
            });

            levelAllCheckbox.addEventListener('click', function() {
                if (this.checked) {
                    levelCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }
            });
        }
    });
    </script>

@endsection
