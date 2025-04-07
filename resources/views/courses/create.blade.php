@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Criar Novo Curso</h1>
    <p>Aqui pode criar um novo curso, incluindo módulos e aulas.</p>
</div>

<!-- INÍCIO DO CONTEÚDO DA PÁGINA COM MARGENS -->
<div class="content-wrapper mx-4 mx-md-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Contêiner Roxo (externo) -->
                <div class="my-5 p-4"
                     style="background-color: #36236a;
                            border-radius: 8px;">

                    <!-- Bloco Branco (interno) -->
                    <div class="p-4"
                         style="background-color: #fff;
                                border-radius: 8px;">

                        <h3 class="mb-3" style="color: #543e92;">Informações do Curso</h3>

                        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Status (para admin only) -->
                            @if (Auth::user()->isAdmin())
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select form-select-purple" id="status" name="status">
                                        <option value="">Selecione o status</option>
                                        <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="aprovado" {{ old('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ old('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                    </select>
                                </div>
                            @endif

                            <!-- Título do Curso -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Título do Curso</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    required
                                >
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    required
                                >{{ old('description') }}</textarea>
                            </div>

                            <!-- Objetivos -->
                            <div class="mb-3">
                                <label for="objectives" class="form-label">Objetivos</label>
                                <textarea
                                    class="form-control"
                                    id="objectives"
                                    name="objectives"
                                    rows="3"
                                    required
                                >{{ old('objectives') }}</textarea>
                            </div>

                            <!-- Nível -->
                            <div class="mb-3">
                                <label for="level" class="form-label">Nível</label>
                                <select class="form-select form-select-purple" id="level" name="level" required>
                                    <option value="">Selecione o nível</option>
                                    <option value="Iniciante" {{ old('level') == 'Iniciante' ? 'selected' : '' }}>Iniciante</option>
                                    <option value="Intermédio" {{ old('level') == 'Intermédio' ? 'selected' : '' }}>Intermédio</option>
                                    <option value="Avançado" {{ old('level') == 'Avançado' ? 'selected' : '' }}>Avançado</option>
                                </select>
                            </div>

                            <!-- Duração em horas -->
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duração (em horas)</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="duration"
                                    name="duration"
                                    value="{{ old('duration') }}"
                                    min="1"
                                    required
                                >
                            </div>

                            <!-- Categoria -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoria</label>
                                <select class="form-select form-select-purple" id="category_id" name="category_id" required>
                                    <option value="">Selecione a categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags (separadas por vírgulas)</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tags"
                                    name="tags"
                                    value="{{ old('tags') }}"
                                    placeholder="Ex: php,laravel,programação"
                                >
                            </div>

                            <!-- Imagem do Curso -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagem do Curso</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="image"
                                    name="image"
                                    accept="image/*"
                                    required
                                >
                            </div>

                            <!-- Vídeo de Introdução -->
                            <div class="mb-3">
                                <label for="video_url" class="form-label">URL do Vídeo de Introdução (YouTube)</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="video_url"
                                    name="video_url"
                                    value="{{ old('video_url') }}"
                                    placeholder="Ex: https://www.youtube.com/watch?v=abcdefghijk"
                                    required
                                >
                            </div>

                            <hr class="my-4">

                            <!-- Módulos e Aulas -->
                            <h3 class="mb-3" style="color: #543e92;">Módulos e Aulas</h3>

                            <div id="modules-container">
                                <!-- Este container será preenchido dinamicamente com JavaScript -->
                                <div class="module-item mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Módulo 1</h5>
                                        <button type="button" class="btn btn-sm btn-danger remove-module" style="display:none;">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Título do Módulo</label>
                                        <input type="text" class="form-control" name="modules[0][title]" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Ordem</label>
                                        <input type="number" class="form-control" name="modules[0][order]" value="1" min="1" required>
                                    </div>

                                    <div class="lessons-container">
                                        <h5 class="mb-3">Aulas</h5>

                                        <div class="lesson-item mb-3 p-2 border rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5>Aula 1</h5>
                                                <button type="button" class="btn btn-sm btn-danger remove-lesson" style="display:none;">
                                                    <i class="bi bi-trash"></i> Remover
                                                </button>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Título da Aula</label>
                                                <input type="text" class="form-control" name="modules[0][lessons][0][title]" required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">URL do Vídeo (YouTube)</label>
                                                <input type="text" class="form-control" name="modules[0][lessons][0][video_url]" required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Ordem</label>
                                                <input type="number" class="form-control" name="modules[0][lessons][0][order]" value="1" min="1" required>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success add-lesson" data-module-index="0">
                                            <i class="bi bi-plus-circle"></i> Adicionar Aula
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mb-4" id="add-module">
                                <i class="bi bi-plus-circle"></i> Adicionar Módulo
                            </button>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">Salvar Curso</button>
                            </div>
                        </form>

                    </div> <!-- FIM bloco branco -->
                </div> <!-- FIM contêiner roxo -->

            </div> <!-- col-md-8 offset-md-2 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- content-wrapper -->

<!-- JavaScript para adicionar módulos e aulas dinamicamente -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let moduleIndex = 0;

    // Adicionar novo módulo
    document.getElementById('add-module').addEventListener('click', function() {
        moduleIndex++;
        const moduleContainer = document.getElementById('modules-container');

        const moduleHtml = `
            <div class="module-item mb-4 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Módulo ${moduleIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-module">
                        <i class="bi bi-trash"></i> Remover
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Título do Módulo</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex}][title]" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordem</label>
                    <input type="number" class="form-control" name="modules[${moduleIndex}][order]" value="${moduleIndex + 1}" min="1" required>
                </div>

                <div class="lessons-container">
                    <h5 class="mb-3">Aulas</h5>

                    <div class="lesson-item mb-3 p-2 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5>Aula 1</h5>
                            <button type="button" class="btn btn-sm btn-danger remove-lesson" style="display:none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Título da Aula</label>
                            <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][0][title]" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">URL do Vídeo (YouTube)</label>
                            <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][0][video_url]" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Ordem</label>
                            <input type="number" class="form-control" name="modules[${moduleIndex}][lessons][0][order]" value="1" min="1" required>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-success add-lesson" data-module-index="${moduleIndex}">
                        <i class="bi bi-plus-circle"></i> Adicionar Aula
                    </button>
                </div>
            </div>
        `;

        moduleContainer.insertAdjacentHTML('beforeend', moduleHtml);
        initializeEventListeners();
    });

    // Função para inicializar os event listeners para os novos elementos
    function initializeEventListeners() {
        // Event listener para adicionar aula
        document.querySelectorAll('.add-lesson').forEach(button => {
            button.removeEventListener('click', addLessonHandler);
            button.addEventListener('click', addLessonHandler);
        });

        // Event listener para remover módulo
        document.querySelectorAll('.remove-module').forEach(button => {
            button.removeEventListener('click', removeModuleHandler);
            button.addEventListener('click', removeModuleHandler);
        });

        // Event listener para remover aula
        document.querySelectorAll('.remove-lesson').forEach(button => {
            button.removeEventListener('click', removeLessonHandler);
            button.addEventListener('click', removeLessonHandler);
        });

        // Mostrar botões de remover lição quando houver mais de uma lição
        updateRemoveLessonButtons();
    }

    // Handler para adicionar aula
    function addLessonHandler() {
        const moduleIndex = this.getAttribute('data-module-index');
        const lessonsContainer = this.previousElementSibling.parentElement;
        const lessonItems = lessonsContainer.querySelectorAll('.lesson-item');
        const lessonIndex = lessonItems.length;

        const lessonHtml = `
            <div class="lesson-item mb-3 p-2 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Aula ${lessonIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-lesson">
                        <i class="bi bi-trash"></i> Remover
                    </button>
                </div>

                <div class="mb-2">
                    <label class="form-label">Título da Aula</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][${lessonIndex}][title]" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">URL do Vídeo (YouTube)</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][${lessonIndex}][video_url]" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Ordem</label>
                    <input type="number" class="form-control" name="modules[${moduleIndex}][lessons][${lessonIndex}][order]" value="${lessonIndex + 1}" min="1" required>
                </div>
            </div>
        `;

        this.insertAdjacentHTML('beforebegin', lessonHtml);
        initializeEventListeners();
    }

    // Handler para remover módulo
    function removeModuleHandler() {
        this.closest('.module-item').remove();
        updateModuleNumbers();
    }

    // Handler para remover aula
    function removeLessonHandler() {
        this.closest('.lesson-item').remove();
        const moduleItem = this.closest('.module-item');
        const lessonItems = moduleItem.querySelectorAll('.lesson-item');

        // Atualizar a numeração das aulas
        lessonItems.forEach((item, index) => {
            item.querySelector('h5').textContent = `Aula ${index + 1}`;

            // Atualizar os nomes dos campos
            const moduleIndex = moduleItem.querySelector('.add-lesson').getAttribute('data-module-index');
            const inputs = item.querySelectorAll('input');

            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/modules\[\d+\]\[lessons\]\[\d+\]/, `modules[${moduleIndex}][lessons][${index}]`);
                input.setAttribute('name', newName);
            });
        });

        updateRemoveLessonButtons();
    }

    // Atualizar a numeração dos módulos
    function updateModuleNumbers() {
        const moduleItems = document.querySelectorAll('.module-item');
        moduleItems.forEach((item, index) => {
            item.querySelector('h5').textContent = `Módulo ${index + 1}`;

            // Atualizar os valores de ordem
            const orderInput = item.querySelector('input[name$="[order]"]');
            if (orderInput && orderInput.value == '') {
                orderInput.value = index + 1;
            }

            // Atualizar os nomes dos campos
            const inputs = item.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/modules\[\d+\]/, `modules[${index}]`);
                input.setAttribute('name', newName);
            });

            // Atualizar o data-module-index do botão de adicionar aula
            const addLessonButton = item.querySelector('.add-lesson');
            addLessonButton.setAttribute('data-module-index', index);
        });

        // Mostrar/esconder botões de remover módulo
        updateRemoveModuleButtons();
    }

    // Atualizar a visibilidade dos botões de remover módulo
    function updateRemoveModuleButtons() {
        const moduleItems = document.querySelectorAll('.module-item');
        moduleItems.forEach(item => {
            const removeButton = item.querySelector('.remove-module');
            if (moduleItems.length > 1) {
                removeButton.style.display = 'block';
            } else {
                removeButton.style.display = 'none';
            }
        });
    }

    // Atualizar a visibilidade dos botões de remover aula
    function updateRemoveLessonButtons() {
        document.querySelectorAll('.module-item').forEach(moduleItem => {
            const lessonItems = moduleItem.querySelectorAll('.lesson-item');
            lessonItems.forEach(item => {
                const removeButton = item.querySelector('.remove-lesson');
                if (lessonItems.length > 1) {
                    removeButton.style.display = 'block';
                } else {
                    removeButton.style.display = 'none';
                }
            });
        });
    }

    // Inicializar event listeners para os elementos existentes
    initializeEventListeners();
});
</script>

@endsection
