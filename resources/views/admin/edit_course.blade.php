@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Editar Curso</h1>
    <p>Aqui pode editar o curso, incluindo módulos e aulas.</p>
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

                        <!--
                            Formulário de edição: note que usamos:
                            - route('courses.update', $course->id)
                            - @method('PUT') para enviar como PUT
                            - Os campos preenchidos com os valores atuais do curso.
                            - O mesmo estilo e comentários da create.blade.php, para manter consistência.
                        -->
                        <form action="{{ route('course.update.admin', $course->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Status (para admin only) -->
                            @if (Auth::user()->isAdmin())
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select form-select-purple" id="status" name="status">
                                        <option value="">Selecione o status</option>
                                        <option value="pendente" {{ $course->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="aprovado" {{ $course->status == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ $course->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
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
                                    value="{{ old('title', $course->title) }}"
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
                                >{{ old('description', $course->description) }}</textarea>
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
                                >{{ old('objectives', $course->objectives) }}</textarea>
                            </div>

                            <!-- Nível -->
                            <div class="mb-3">
                                <label for="level" class="form-label">Nível</label>
                                <select class="form-select form-select-purple" id="level" name="level" required>
                                    <option value="">Selecione o nível</option>
                                    <option value="Iniciante" {{ old('level', $course->level) == 'Iniciante' ? 'selected' : '' }}>Iniciante</option>
                                    <option value="Intermédio" {{ old('level', $course->level) == 'Intermédio' ? 'selected' : '' }}>Intermédio</option>
                                    <option value="Avançado" {{ old('level', $course->level) == 'Avançado' ? 'selected' : '' }}>Avançado</option>
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
                                    value="{{ old('duration', $course->duration) }}"
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
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tags -->
                            @php
                                // Mantemos a mesma lógica de converter JSON de tags em string separada por vírgulas
                                // assim como na create.blade.php
                                if(old('tags')) {
                                    $tagsString = old('tags');
                                } else {
                                    $tagsArray = json_decode($course->tags, true) ?? [];
                                    $tagsString = implode(',', $tagsArray);
                                }
                            @endphp
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags (separadas por vírgulas)</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tags"
                                    name="tags"
                                    value="{{ $tagsString }}"
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
                                >
                                <!-- Mostra a imagem atual, se existir -->
                                @if($course->image)
                                    <div class="mt-2">
                                        <strong>Imagem atual:</strong>
                                        <br>
                                        <img src="{{ asset('storage/'.$course->image) }}"
                                             alt="Imagem do Curso"
                                             style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>

                            <!-- Vídeo de Introdução -->
                            <div class="mb-3">
                                <label for="video_url" class="form-label">URL do Vídeo de Introdução (YouTube)</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="video_url"
                                    name="video_url"
                                    value="{{ old('video_url', $course->video_url) }}"
                                    placeholder="Ex: https://www.youtube.com/watch?v=abcdefghijk"
                                    required
                                >
                            </div>

                            <hr class="my-4">

                            <!-- Módulos e Aulas -->
                            <h3 class="mb-3" style="color: #543e92;">Módulos e Aulas</h3>

                            <!--
                                Mantemos a estrutura de "modules-container",
                                mas agora precisamos exibir os módulos e aulas já existentes do curso.
                                A lógica de "add/remove" via JavaScript continua a mesma da create.blade.php,
                                mas cada item inicia preenchido com o valor do BD.
                            -->
                            <div id="modules-container">
                                <!-- Se o curso já tiver módulos, iteramos -->
                                @foreach($course->modules as $mIndex => $module)
                                    <div class="module-item mb-4 p-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5>Módulo {{ $mIndex + 1 }}</h5>
                                            <button type="button" class="btn btn-sm btn-danger remove-module" style="{{ count($course->modules) > 1 ? '' : 'display:none;' }}">
                                                <i class="bi bi-trash"></i> Remover
                                            </button>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Título do Módulo</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="modules[{{ $mIndex }}][title]"
                                                   value="{{ old("modules.$mIndex.title", $module->title) }}"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ordem</label>
                                            <input type="number"
                                                   class="form-control"
                                                   name="modules[{{ $mIndex }}][order]"
                                                   value="{{ old("modules.$mIndex.order", $module->order) }}"
                                                   min="1"
                                                   required>
                                        </div>

                                        <div class="lessons-container">
                                            <h5 class="mb-3">Aulas</h5>

                                            <!-- Iterar as aulas deste módulo -->
                                            @foreach($module->lessons as $lIndex => $lesson)
                                                <div class="lesson-item mb-3 p-2 border rounded">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h5>Aula {{ $lIndex + 1 }}</h5>
                                                        <button type="button"
                                                                class="btn btn-sm btn-danger remove-lesson"
                                                                style="{{ count($module->lessons) > 1 ? '' : 'display:none;' }}">
                                                            <i class="bi bi-trash"></i> Remover
                                                        </button>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label">Título da Aula</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               name="modules[{{ $mIndex }}][lessons][{{ $lIndex }}][title]"
                                                               value="{{ old("modules.$mIndex.lessons.$lIndex.title", $lesson->title) }}"
                                                               required>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label">URL do Vídeo (YouTube)</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               name="modules[{{ $mIndex }}][lessons][{{ $lIndex }}][video_url]"
                                                               value="{{ old("modules.$mIndex.lessons.$lIndex.video_url", $lesson->video_url) }}"
                                                               required>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label">Ordem</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               name="modules[{{ $mIndex }}][lessons][{{ $lIndex }}][order]"
                                                               value="{{ old("modules.$mIndex.lessons.$lIndex.order", $lesson->order) }}"
                                                               min="1"
                                                               required>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Botão para adicionar aula neste módulo -->
                                            <button type="button"
                                                    class="btn btn-sm btn-success add-lesson"
                                                    data-module-index="{{ $mIndex }}">
                                                <i class="bi bi-plus-circle"></i> Adicionar Aula
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Se não houver nenhum módulo, ou se $course->modules estiver vazio -->
                                @if($course->modules->count() == 0)
                                    <!-- Podemos inserir um bloco inicial igual ao da create -->
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
                                @endif
                            </div>

                            <button type="button" class="btn btn-primary mb-4" id="add-module">
                                <i class="bi bi-plus-circle"></i> Adicionar Módulo
                            </button>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">Salvar Alterações</button>
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
/*
    Mantemos a mesma lógica da create.blade.php,
    só que agora precisamos considerar que:
    - Podemos ter módulos/aulas já carregados.
    - Precisamos renumerar quando removemos.
*/

document.addEventListener('DOMContentLoaded', function() {
    // Identifica quantos módulos já existem no HTML (carregados do BD)
    let moduleIndex = document.querySelectorAll('.module-item').length;

    // Botão para adicionar novo módulo
    document.getElementById('add-module').addEventListener('click', function() {
        moduleIndex++;
        const moduleContainer = document.getElementById('modules-container');

        const moduleHtml = `
            <div class="module-item mb-4 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Módulo ${moduleIndex}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-module">
                        <i class="bi bi-trash"></i> Remover
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Título do Módulo</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex - 1}][title]" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordem</label>
                    <input type="number" class="form-control" name="modules[${moduleIndex - 1}][order]" value="${moduleIndex}" min="1" required>
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
                            <input type="text" class="form-control" name="modules[${moduleIndex - 1}][lessons][0][title]" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">URL do Vídeo (YouTube)</label>
                            <input type="text" class="form-control" name="modules[${moduleIndex - 1}][lessons][0][video_url]" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Ordem</label>
                            <input type="number" class="form-control" name="modules[${moduleIndex - 1}][lessons][0][order]" value="1" min="1" required>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-success add-lesson" data-module-index="${moduleIndex - 1}">
                        <i class="bi bi-plus-circle"></i> Adicionar Aula
                    </button>
                </div>
            </div>
        `;

        moduleContainer.insertAdjacentHTML('beforeend', moduleHtml);
        initializeEventListeners();
    });

    function initializeEventListeners() {
        document.querySelectorAll('.remove-module').forEach(btn => {
            btn.removeEventListener('click', removeModuleHandler);
            btn.addEventListener('click', removeModuleHandler);
        });

        document.querySelectorAll('.remove-lesson').forEach(btn => {
            btn.removeEventListener('click', removeLessonHandler);
            btn.addEventListener('click', removeLessonHandler);
        });

        document.querySelectorAll('.add-lesson').forEach(btn => {
            btn.removeEventListener('click', addLessonHandler);
            btn.addEventListener('click', addLessonHandler);
        });

        updateRemoveModuleButtons();
        updateRemoveLessonButtons();
    }

    function removeModuleHandler() {
        this.closest('.module-item').remove();
        updateModuleNumbers();
    }

    function removeLessonHandler() {
        const lessonItem = this.closest('.lesson-item');
        lessonItem.remove();
        updateLessonNumbers();
    }

    function addLessonHandler() {
        const moduleIndex = this.getAttribute('data-module-index');
        const lessonsContainer = this.closest('.lessons-container');
        const lessonItems = lessonsContainer.querySelectorAll('.lesson-item');
        const newLessonIndex = lessonItems.length;

        const lessonHtml = `
            <div class="lesson-item mb-3 p-2 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Aula ${newLessonIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-lesson">
                        <i class="bi bi-trash"></i> Remover
                    </button>
                </div>

                <div class="mb-2">
                    <label class="form-label">Título da Aula</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][${newLessonIndex}][title]" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">URL do Vídeo (YouTube)</label>
                    <input type="text" class="form-control" name="modules[${moduleIndex}][lessons][${newLessonIndex}][video_url]" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Ordem</label>
                    <input type="number" class="form-control" name="modules[${moduleIndex}][lessons][${newLessonIndex}][order]" value="${newLessonIndex + 1}" min="1" required>
                </div>
            </div>
        `;

        this.insertAdjacentHTML('beforebegin', lessonHtml);
        initializeEventListeners();
    }

    function updateModuleNumbers() {
        const moduleItems = document.querySelectorAll('.module-item');
        moduleItems.forEach((modItem, idx) => {
            // Atualiza o texto "Módulo X"
            const titleElem = modItem.querySelector('h5');
            if (titleElem) {
                titleElem.textContent = `Módulo ${idx + 1}`;
            }
            // Ajustar nomes dos inputs (modules[idx]...)
            const allInputs = modItem.querySelectorAll('input, textarea, select');
            allInputs.forEach(input => {
                const oldName = input.getAttribute('name');
                const newName = oldName.replace(/modules\[\d+\]/, `modules[${idx}]`);
                input.setAttribute('name', newName);
            });
            // Ajustar data-module-index no botão .add-lesson
            const addLessonBtn = modItem.querySelector('.add-lesson');
            if (addLessonBtn) {
                addLessonBtn.setAttribute('data-module-index', idx);
            }
        });
        updateRemoveModuleButtons();
        updateLessonNumbers();
    }

    function updateLessonNumbers() {
        const moduleItems = document.querySelectorAll('.module-item');
        moduleItems.forEach((modItem, mIdx) => {
            const lessonItems = modItem.querySelectorAll('.lesson-item');
            lessonItems.forEach((lessonItem, lIdx) => {
                // Ajustar "Aula X"
                const h5 = lessonItem.querySelector('h5');
                if (h5) {
                    h5.textContent = `Aula ${lIdx + 1}`;
                }
                // Ajustar names: modules[mIdx][lessons][lIdx]...
                const allInputs = lessonItem.querySelectorAll('input');
                allInputs.forEach(input => {
                    const oldName = input.getAttribute('name');
                    const newName = oldName.replace(/modules\[\d+\]\[lessons\]\[\d+\]/, `modules[${mIdx}][lessons][${lIdx}]`);
                    input.setAttribute('name', newName);
                });
            });
        });
        updateRemoveLessonButtons();
    }

    function updateRemoveModuleButtons() {
        const moduleItems = document.querySelectorAll('.module-item');
        moduleItems.forEach(item => {
            const removeBtn = item.querySelector('.remove-module');
            if (moduleItems.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    function updateRemoveLessonButtons() {
        document.querySelectorAll('.module-item').forEach(modItem => {
            const lessonItems = modItem.querySelectorAll('.lesson-item');
            lessonItems.forEach(lesson => {
                const removeBtn = lesson.querySelector('.remove-lesson');
                if (lessonItems.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        });
    }

    // Inicialização inicial dos event listeners
    initializeEventListeners();
});
</script>

@endsection
