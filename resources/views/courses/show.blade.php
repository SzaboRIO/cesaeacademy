@extends('layouts.main_layout')

@section('content')

    <!-- PLAYER + DESCRIÇÃO -->

    <section class="content-box px-sm-3 px-md-5 py-5">

        <div class="container-fluid">
            <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
            <div class="row">


                <!-- Vídeo responsivo 16:9 -->

                <!--
                A opção .ratio do Bootstrap ajusta automaticamente a altura dos elementos <iframe>, <video>, <embed>, etc.
                Ele faz isso mantendo uma proporção específica, como 16:9, 4:3, 1:1, 21:9, sem precisar de CSS personalizado.
                -->
                <!-- Vídeo responsivo 16:9 -->
                <div class="col-md-6">
                    <div class="ratio ratio-16x9">
                        @php
                            // Extrair o ID do vídeo da URL do YouTube
                            $videoUrl = $course->video_url;
                            $videoId = '';

                            // Verificar se contém "watch?v="
                            if (strpos($videoUrl, 'watch?v=') !== false) {
                                // Formato: https://www.youtube.com/watch?v=VIDEO_ID
                                $parts = parse_url($videoUrl);
                                parse_str($parts['query'], $query);
                                $videoId = $query['v'] ?? '';
                            }
                            // Verificar se é um formato curto
                            elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                // Formato: https://youtu.be/VIDEO_ID
                                $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                            }
                            // Se já for apenas o ID
                            else {
                                $videoId = $videoUrl;
                            }
                        @endphp

                        <iframe
                            src="https://www.youtube.com/embed/{{ $videoId }}?controls=0&modestbranding=1&rel=0&disablekb=1&fs=0"
                            frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <!-- Área Descritiva -->

                <!--
                p -> padding
                px -> padding no eixo x (horizontal)
                px-md-5 -> padding no eixo x (horizontal) de 5rem (80px) em telas médias (md = ≥768px)
                px-sm-0 -> padding no eixo x (horizontal) de 0rem (0px) em telas pequenas (sm = ≥576px)
                ps -> padding start (esquerda)
                pe -> padding end (direita)

                d-flex -> display flex, ativa o Flexbox no elemento
                Flexbox -> modelo de layout no CSS que facilita o alinhamento e distribuição de espaço entre itens dentro de um contêiner.Permite que os itens se ajustem automaticamente para preencher o espaço disponível de forma eficiente e responsiva.
                "d-flex" sozinho já define flex-direction: row (fileira) (que é o padrão do Flexbox), ou seja, diz respeito a um alinhamento horizontal sempre.
                flex-column -> flex direction column, organiza os elementos filhos verticalmente (em coluna). É preciso inserir isso na frente de d-flex sozinho para que ele faça um alinhamento vertical (column) ao invés do padrão horizontal (row).
                justify-content-center -> centraliza o conteúdo verticalmente dentro da coluna.
                text-center -> alinhamento de texto no centro
                -->

                <div class="col-md-6 d-flex flex-column justify-content-center text-start px-md-5 custom-sm-padding">

                    <!-- Título do curso -->
                    <h2 class="fs-2 fs-md-2 fs-lg-1 mt-5 mt-md-2 mb-4 mb-md-3 d-flex align-items-center gap-4">
                        <b>{{ $course->title }}</b>


                        <!-- Outras opções: Compartilhar + Adicionar + Favoritar -->

                        <!--
                        Inserir ícones Bootstrap:
                        "bi" representa o prefixo para os ícones do Bootstrap
                        "bi-name" representa o nome do ícone desejado.
                        Exemplos com diferentes tamanhos:
                        <i class="bi bi-house fs-1"></i>   ->   Ícone maior
                        <i class="bi bi-phone fs-3"></i>   ->   Ícone médio
                        <i class="bi bi-person fs-6"></i>  ->   Ícone pequeno

                        Aceda à lista de icones em: https://icons.getbootstrap.com/ para escolher um ícone.
                        Não esqueça de inserir o link do Bootstrap Icons no <header> do HTML!

                        "gap" adiciona espaçamento entre os itens filhos de um contêiner flexível. Vai de 1 até 5.
                        -->

                        <div class="d-flex gap-3 course-icon">
                            <!-- COMPARTILHAR -->
                            <i class="bi bi-share-fill fs-4"></i>

                            <!-- FAVORITAR -->
                            @if (Auth::check() && !isset($enrollment))
                                <form action="{{ route('course.toggle-favorite', $course->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn p-0 border-0">
                                        <i class="bi {{ $isFavorite ?? false ? 'bi-heart-fill' : 'bi-heart' }} fs-4"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- INSCREVER-SE -->
                            @if (!isset($enrollment))
                                <form action="{{ route('enroll', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="fs-6 fs-md-2 py-1 subscribe">Inscreva-se</button>
                                </form>
                            @else
                                <span class="badge bg-success fs-6 fs-md-2 py-1">Inscrito</span>
                            @endif
                        </div>
                    </h2>

                    <!-- Barra de Progresso do Curso (só aparece se estiver matriculado) -->
                    @if (isset($enrollment) && isset($progressPercentage))
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>Seu progresso no curso:</span>
                                <span>{{ $progressPercentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            @if ($enrollment->completed_at)
                                <div class="text-success mt-2">
                                    <i class="bi bi-trophy-fill"></i> Parabéns! Você concluiu este curso em
                                    {{ $enrollment->completed_at->format('d/m/Y') }}.
                                </div>
                            @endif
                        </div>
                    @endif


                    <!-- Rating (Estrelas 0-5.0)-->

                    <!--
                    Classe lead no Bootstrap é usada para estilizar um parágrafo, tornando-o mais destacado, geralmente com uma fonte maior e mais espaçada.
                    "bi" representa o prefixo para os ícones do Bootstrap
                    "bi-name" representa o nome do ícone desejado.

                    <span> é um elemento inline do HTML usado para agrupar e estilizar pequenos trechos de texto ou conteúdo dentro de uma linha, sem quebrar o fluxo (ou seja, sem ter que dar quebra de linha para ser inserido).
                    "data-value" é um atributo usado p/ armazenar informações extras no elemento (como um ID, valor numérico, etc.).
                    Serve para, por exemplo, identificar que 1 estrela (ícone) tem o valor "1" (em um sistema de avaliação de 1 a 5).
                    data-value pode ser acessado via JavaScript ou CSS para criar interações (ex.: mudar cor ao clicar).
                    -->
                    <div class="star-rating lead mb-3">

                        <!-- Estrelas clicáveis -->
                        <i class="bi bi-star" data-value="1"></i>
                        <i class="bi bi-star" data-value="2"></i>
                        <i class="bi bi-star" data-value="3"></i>
                        <i class="bi bi-star" data-value="4"></i>
                        <i class="bi bi-star" data-value="5"></i>

                        <!-- Mostra a média de todas as avaliações recebidas até o momento (ex: "4.5/5") -->
                        <span class="rating-text">4.5/5</span>

                    </div>


                    <!-- Descrições -->
                    <ul class="ps-2"> <!-- ps -> padding start (lado esquerdo)-->
                        <li class="fs-6 fs-md-5 mb-1">Formador(es): João Silva</li>
                        <li class="fs-6 fs-md-5 mb-1">Nível: Intermediário</li>
                        <li class="fs-6 fs-md-5 mb-1">Duração: 70h</li>
                        <li class="fs-6 fs-md-5 mb-1">Última atualização: 02/02/2025</li>
                        <li class="fs-6 fs-md-5 mb-1">180 alunos favoritaram este curso.</li>
                        <li class="fs-6 fs-md-5 mb-0">Área: Development</li>
                    </ul>


                    <!-- Tags -->
                    <p class="fs-6 fs-md-5 tags">
                        <i class="bi bi-tags-fill me-2"></i>Tags:&nbsp;&nbsp;
                        <small>
                            <a href="#software">#software</a>,
                            <a href="#developer">#developer</a>,
                            <a href="#php">#php</a>,
                            <a href="#laravel">#laravel</a>,
                            <a href="#java">#java</a>,
                            <a href="#javascript">#javascript</a>,
                            <a href="#react">#react</a>,
                            <a href="#uml">#uml</a>,
                            <a href="#designpatterns">#designpatterns</a>,
                            <a href="#algoritmia">#algoritmia</a>,
                            <a href="#basesdedados">#basesdedados</a>,
                            <a href="#sql">#sql</a>,
                            <a href="#html">#html</a>,
                            <a href="#css">#css</a>
                        </small>
                    </p>

                </div>



            </div>
        </div>

    </section>




    <!-- INÍCIO DO CONTEÚDO DA PÁGINA COM MARGENS -->

    <!--
        Esta div envolve o conteúdo principal e aplica margens responsivas nas laterais:
        - mx-3: Aplica uma margem horizontal de 16px (valor padrão do Bootstrap) em todos os tamanhos de tela.
        - mx-md-4: Aplica uma margem horizontal de 24px (valor padrão do Bootstrap) em telas médias (largura mínima de 768px) e maiores.
        - m significa "margin" (margem).
        - x significa "eixo X" ou "horizontal" (esquerda e direita).
        - md = médio, sm = small, lg = large.
    -->

    <div class="content-wrapper mx-4 mx-md-5">



        <!-- DESCRIÇÃO EXTENSA E OBJETIVOS GERAIS -->

        <div class="container-fluid">
            <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
            <div class="row align-items-start">

                <!--
                p -> padding
                px -> padding no eixo x (horizontal)
                px-md-5 -> padding no eixo x (horizontal) de 5rem (80px) em telas médias (md = ≥768px)
                px-sm-0 -> padding no eixo x (horizontal) de 0rem (0px) em telas pequenas (sm = ≥576px)

                d-flex -> display flex, ativa o Flexbox no elemento
                flex-column -> flex direction column, organiza os elementos filhos verticalmente (em coluna).
                justify-content-center -> centraliza o conteúdo verticalmente dentro da coluna.
                -->

                <div class="col-md-6 d-flex flex-column justify-content-center text-start px-md-5 px-sm-0">

                    <!-- Descrição -->
                    <h2 class="fs-2 fs-md-2 fs-lg-1 mb-4 mb-md-3 mt-5">
                        <i class="bi bi-info-circle me-2"></i>
                        <b>Descrição:</b>
                        <!-- bi bi-info-circle -> ícone de informação-->
                        <!-- me -> margin end, para separar um pouco o ícone do título-->
                        <!-- OBS: apesar de usarmos a tag <i>, esta é a forma correta e semântica de inserir ícones de web fonts (como Bootstrap Icons), e não tem relação com itálico nesse contexto.-->
                    </h2>
                    <p class="fs-6 fs-md-5">{{ $course->description }}</p>


                    <!-- Objetivos Gerais:-->
                    <h2 class="fs-2 fs-md-2 fs-lg-1 mb-4 mb-md-3 mt-5">
                        <i class="bi bi-bullseye me-2"></i>
                        <b>Objetivos Gerais:</b>
                        <!-- bi bi-info-circle -> ícone de informação-->
                        <!-- me -> margin end, para separar um pouco o ícone do título-->
                        <!-- OBS: apesar de usarmos a tag <i>, esta é a forma correta e semântica de inserir ícones de web fonts (como Bootstrap Icons), e não tem relação com itálico nesse contexto.-->
                    </h2>
                    <p class="fs-6 fs-md-5 mb-5">{{ $course->objectives }}</p>

                </div>

                <!-- FORMADOR: -->

                <div class="col-md-6">
                    <div class="container py-5 mt-3 mt-md-3">
                        <h2 class="text-left mb-5">
                            <i class="bi bi-person-circle me-2"></i>
                            <b>Sobre o formador:</b>
                            <!-- bi bi-info-circle -> ícone de informação-->
                            <!-- me -> margin end, para separar um pouco o ícone do título-->
                            <!-- OBS: apesar de usarmos a tag <i>, esta é a forma correta e semântica de inserir ícones de web fonts (como Bootstrap Icons), e não tem relação com itálico nesse contexto.-->
                        </h2>

                        <!--
                        g → gutter (espaçamento entre as colunas)
                        x → eixo x (horizontal)
                        gx-2 gx-md-4 gx-lg-5 → Espaçamento entre as colunas em telas pequenas, grandes e médias respectivamente
                        EXTRA: gy-2 é adicionado para diminuir o espaçamento entre os testemunhos em telas pequenas, quando os cards fica em cima um do outro.
                        -->

                        <div class="row">


                            <!-- Detalhes do formador -->
                            <div class="col-md-4 text-left mb-1">
                                <img src="{{ asset('storage/'.$course->user->avatar) }}"
                                    class="rounded-circle mb-3 img-fluid testemunho-img"
                                    alt="{{ $course->user->firstname }} {{ $course->user->lastname }}">
                            </div>
                            <div class="col-md-4 text-left mb-5">

                                <!-- Nome completo dinâmico -->
                                <h4>{{ $course->user->firstname }} {{ $course->user->lastname }}</h4>

                                <!-- Profissão dinâmico; -->
                                <p class="text-muted mb-4">{{ $course->user->profession }}</p>

                                <ul class="ps-3"> <!-- ps -> padding start (lado esquerdo)-->
                                    <li class="fs-6 fs-md-5 mb-1">Nº de Cursos: 03</li>
                                    <li class="fs-6 fs-md-5 mb-1">Nº de Alunos: 123</li>
                                </ul>

                            </div>

                            <div class="col-md-12 text-left mb-5">
                                <p class="fs-6 fs-md-5 mb-0 collapsed-text" id="biographyParagraph">
                                    {{ $course->user->biography }}
                                </p>
                                <a href="#" class="btn-teacher d-inline-block mt-2" id="toggleBiographyBtn">
                                    Mostrar mais <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>

                        </div>



                    </div>
                </div>




                <!-- ACCORDION COM AULAS E MÓDULOS -->

                <section class="px-5 py-1">

                    <div class="container-fluid">
                        <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
                        <div class="row">


                            <!-- Lista de Módulos-->
                            <div class="content-box box-videos col-md-6">
                                <div class="container mt-5">
                                    <div class="accordion" id="modulosAccordion">

                                        @if ($course->modules->count() > 0)
                                            @foreach ($course->modules as $index => $module)
                                                <!-- Módulo {{ $index + 1 }} -->
                                                <div class="accordion-item border mb-2">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#modulo{{ $module->id }}">
                                                            <i class="bi bi-play-circle me-2"></i> Módulo
                                                            {{ $index + 1 }} - {{ $module->title }}
                                                        </button>
                                                    </h2>
                                                    <div id="modulo{{ $module->id }}"
                                                        class="accordion-collapse collapse"
                                                        data-bs-parent="#modulosAccordion">
                                                        <div class="accordion-body">
                                                            @foreach ($module->lessons as $lesson)
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                                    <div>
                                                                        <i
                                                                            class="bi bi-play-circle-fill text-primary me-2"></i>
                                                                        <span>{{ $lesson->title }}</span>

                                                                        @if (isset($completedLessons) && in_array($lesson->id, $completedLessons))
                                                                            <i class="bi bi-check-circle-fill text-success ms-2"
                                                                                title="Aula concluída"></i>
                                                                        @endif
                                                                    </div>

                                                                    @if (isset($enrollment))
                                                                        <a href="#"
                                                                            class="btn btn-sm btn-outline-primary ver-video"
                                                                            data-lesson-id="{{ $lesson->id }}"
                                                                            data-enrollment-id="{{ $enrollment->id }}"
                                                                            data-title="{{ $lesson->title }}"
                                                                            data-video="{{ $lesson->getYoutubeVideoId() }}">
                                                                            Ver
                                                                        </a>
                                                                    @else
                                                                        <button class="btn btn-sm btn-outline-secondary"
                                                                            disabled>Inscreva-se</button>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">
                                                Este curso ainda não possui módulos.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- LISTA DE REVIEWS -->


                            <div class="content-box box-reviews col-md-6 ps-lg-4">
                                <div class="container mt-4">

                                    <!-- Lista de Reviews -->
                                    <div class="reviews-list mb-4">

                                        <!-- Review 1 -->
                                        <div class="review-item py-3 border-bottom border-light">
                                            <div class="fw-bold fs-5">Carlos S. Ribeiro</div>
                                            <small class="text-util">22/01/2024</small>
                                            <p class="mt-4 mb-2 line-clamp comment">O curso do João Silva mudou minha
                                                carreira! Consegui minha primeira vaga como desenvolvedora júnior graças aos
                                                conhecimentos adquiridos aqui. 🦊</p>

                                            <div class="star-rating mb-3">

                                                <!-- Estrelas estáticas (4.7/5) -->
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <span class="ms-2">4.7/5</span>

                                            </div>
                                        </div>


                                        <!-- Review 2 -->
                                        <div class="review-item py-3 border-bottom border-light">
                                            <div class="fw-bold fs-5">Maria Fernandes</div>
                                            <small class="text-util">17/07/2024</small>
                                            <p class="mt-4 mb-2 line-clamp comment">Conteúdo muito bem estruturado. Como
                                                iniciante em programação, eu consegui acompanhar tudo sem dificuldades. 😄
                                            </p>


                                            <div class="star-rating mb-3">

                                                <!-- Estrelas estáticas (4.2/5) -->
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <span class="ms-2">4.2/5</span>

                                            </div>
                                        </div>

                                        <!-- Controles de Navegação -->
                                        <div class="d-flex justify-content-center align-items-center py-3">
                                            <span class="text-light me-3">Ver mais reviews</span>
                                            <a href="#" class="nav-arrow me-2">
                                                <i class="bi bi-arrow-left-circle fs-4"></i>
                                            </a>
                                            <a href="#" class="nav-arrow">
                                                <i class="bi bi-arrow-right-circle fs-4"></i>
                                            </a>
                                        </div>
                                    </div>


                                    <!-- Box de Adicionar Review -->
                                    <form>
                                        <div class="mb-2 mt-4">
                                            <label for="propostaFormacao" class="form-label review">Submete a sua
                                                review:</label>
                                            <textarea class="form-control" id="propostaFormacao" rows="1"></textarea>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-primary mb-4 mt-md-2 mt-1 btn-send btn-review">Enviar</button>

                                        <!-- Rating (Estrelas 0-5.0)-->

                                        <!--
                                Classe lead no Bootstrap é usada para estilizar um parágrafo, tornando-o mais destacado, geralmente com uma fonte maior e mais espaçada.
                                "bi" representa o prefixo para os ícones do Bootstrap
                                "bi-name" representa o nome do ícone desejado.

                                <span> é um elemento inline do HTML usado para agrupar e estilizar pequenos trechos de texto ou conteúdo dentro de uma linha, sem quebrar o fluxo (ou seja, sem ter que dar quebra de linha para ser inserido).
                                "data-value" é um atributo usado p/ armazenar informações extras no elemento (como um ID, valor numérico, etc.).
                                Serve para, por exemplo, identificar que 1 estrela (ícone) tem o valor "1" (em um sistema de avaliação de 1 a 5).
                                data-value pode ser acessado via JavaScript ou CSS para criar interações (ex.: mudar cor ao clicar).
                                -->
                                        <div class="star-rating lead mb-3 d-flex justify-content-start align-items-center">

                                            <!-- Estrelas clicáveis -->
                                            <i class="bi bi-star" data-value="1"></i>
                                            <i class="bi bi-star" data-value="2"></i>
                                            <i class="bi bi-star" data-value="3"></i>
                                            <i class="bi bi-star" data-value="4"></i>
                                            <i class="bi bi-star" data-value="5"></i>

                                            <!-- Mostra a média de todas as avaliações recebidas até o momento (ex: "4.5/5") -->
                                            <span class="rating-text">0/5</span>

                                        </div>
                                    </form>

                                </div>
                            </div>


                        </div>
                    </div>
                </section>



                <!-- CURSOS SUGERIDOS -->

                <!--
            fs → font-size.
            fs-2 → Define o tamanho da fonte como nível 2 (grande) para telas pequenas (padrão).
            fs-md-2 → Mantém o mesmo tamanho (fs-2) para telas médias (md = ≥768px).
            fs-lg-1 → Reduz o tamanho da fonte para nível 1 (maior) em telas grandes (lg = ≥992px).
            fs-6 → Define o tamanho da fonte como nível 6 (pequeno) para telas pequenas (padrão).
            fs-md-5 → Aumenta a fonte para nível 5 (um pouco maior) em telas médias (md = ≥768px).

            fs-1 = Fonte muito grande
            fs-2 = Um pouco menor
            fs-3 = Médio
            fs-4 = Um pouco menor
            fs-5 = Pequeno
            fs-6 = Muito pequeno

            Breakpoints disponíveis:
            fs-sm-*	≥ 576px
            fs-md-*	≥ 768px
            fs-lg-*	≥ 992px
            fs-xl-*	≥ 1200px
            fs-xxl-* ≥ 1400px

            mb → é uma abreviação para margin-bottom
            mb-0: Margem inferior de 0 (sem margem).
            mb-1: Margem inferior pequena (0.25rem).
            mb-2: Margem inferior um pouco maior (0.5rem).
            mb-3: Margem intermediária (1rem).
            mb-4: Margem grande (1.5rem).
            mb-5: Margem muito grande (3rem).
            mb-auto: Margem automática (usada para alinhamento).
            obs: 1rem = 16px

            mt → é uma abreviação para margin-top.
        -->

                <br>
                <h2 class="fs-2 fs-md-2 fs-lg-1 mt-md-5 md-sm-4 mb-md-4 mb-sm-3">
                    <b>Você também poderá se interessar por:</b>
                </h2>

                <!-- Cards Carousel 01 -->
                <!-- (Kitchen sink typed cards) -->
                <!--
        row-cols-* - Quantas colunas por linha em telas pequenas
        row-cols-md-* - Quantas colunas por linha em telas médias
        gx-* - Espaçamento horizontal entre as colunas
        gy-* - Espaçamento vertical entre as colunas


        fs → font-size.
        fs-2 → Define o tamanho da fonte como nível 2 (grande) para telas pequenas (padrão).
        fs-md-2 → Mantém o mesmo tamanho (fs-2) para telas médias (md = ≥768px).
        fs-lg-1 → Reduz o tamanho da fonte para nível 1 (maior) em telas grandes (lg = ≥992px).
        fs-6 → Define o tamanho da fonte como nível 6 (pequeno) para telas pequenas (padrão).
        fs-md-5 → Aumenta a fonte para nível 5 (um pouco maior) em telas médias (md = ≥768px).

        fs-1 = Fonte muito grande
        fs-2 = Um pouco menor
        fs-3 = Médio
        fs-4 = Um pouco menor
        fs-5 = Pequeno
        fs-6 = Muito pequeno

        Breakpoints disponíveis:
        fs-sm-*	≥ 576px
        fs-md-*	≥ 768px
        fs-lg-*	≥ 992px
        fs-xl-*	≥ 1200px
        fs-xxl-* ≥ 1400px

        mb → é uma abreviação para margin-bottom
        mb-0: Margem inferior de 0 (sem margem).
        mb-1: Margem inferior pequena (0.25rem).
        mb-2: Margem inferior um pouco maior (0.5rem).
        mb-3: Margem intermediária (1rem).
        mb-4: Margem grande (1.5rem).
        mb-5: Margem muito grande (3rem).
        mb-auto: Margem automática (usada para alinhamento).
        obs: 1rem = 16px
        -->

                <!-- Cards Carousel 01 -->
                <div id="carouselExampleCards" class="carousel slide">
                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row row-cols-1 gx-3 gy-5 mb-5 mb-md-5">

                                <!-- Card 1 -->
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="assets/card_back_end.jpg" class="card-img-top" alt="Image description">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Card 2 -->
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="assets/card_back_end.jpg" class="card-img-top" alt="Image description">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="assets/card_back_end.jpg" class="card-img-top" alt="Image description">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Card 4 -->
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="assets/card_back_end.jpg" class="card-img-top" alt="Image description">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br><br>




            </div>
        </div>
    </div> <!-- FIM DO CONTEÚDO DA PÁGINA COM MARGEM APLICADA -->



    <!-- FULLSCREEN MODAL (EXIBIÇÃO DOS VIDEOS) -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-purple text-white">
                    <h5 class="modal-title" id="videoModalTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="ratio ratio-16x9">
                        <div id="videoFrame" src="" allowfullscreen></div>
                    </div>
                    <input type="hidden" id="currentLessonId" value="">
                    <input type="hidden" id="currentEnrollmentId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    @if (isset($enrollment))
                        <form id="completeForm" action="{{ route('student.complete-lesson') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lesson_id" id="completeFormLessonId">
                            <input type="hidden" name="enrollment_id" id="completeFormEnrollmentId">
                            <button type="submit" class="btn btn-success" id="markAsCompletedBtn">
                                Marcar como concluído
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toggleBiographyBtn');
            const paragraph = document.getElementById('biographyParagraph');

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                paragraph.classList.toggle('collapsed-text');
                if (paragraph.classList.contains('collapsed-text')) {
                    btn.innerHTML = 'Mostrar mais <i class="bi bi-chevron-down"></i>';
                } else {
                    btn.innerHTML = 'Mostrar menos <i class="bi bi-chevron-up"></i>';
                }
            });
        });
        // Variável para o player do YouTube
        var player;

        var pendingVideoData = null;

        function onYouTubeIframeAPIReady() {

            if (pendingVideoData) {

                createPlayer(pendingVideoData);
                pendingVideoData = null;
            }
        }

        function createPlayer(videoData) {
            console.log("Criando player para o videoId:", videoData.videoId);
            if (player) {
                player.destroy();
            }
            player = new YT.Player('videoFrame', {
                height: '100%',
                width: '100%',
                videoId: videoData.videoId,
                playerVars: {
                    'autoplay': 1,
                    'rel': 0
                },
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Carrega a API do YouTube
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            // Manipulador de clique para os botões "Ver vídeo"
            document.querySelectorAll('.ver-video').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    var videoData = {
                        videoId: this.dataset.video,
                        title: this.dataset.title,
                        lessonId: this.dataset.lessonId,
                        enrollmentId: this.dataset.enrollmentId
                    };


                    // Atualiza o título do modal e os inputs ocultos ...
                    document.getElementById('videoModalTitle').textContent = videoData.title;
                    document.getElementById('currentLessonId').value = videoData.lessonId;
                    document.getElementById('currentEnrollmentId').value = videoData.enrollmentId;
                    document.getElementById('completeFormLessonId').value = videoData.lessonId;
                    document.getElementById('completeFormEnrollmentId').value = videoData
                        .enrollmentId;

                    // Se a API já estiver carregada, crie o player; caso contrário, armazene os dados para criação quando a API estiver pronta
                    if (window.YT && YT.Player) {
                        console.log("Video data:", videoData);
                        createPlayer(videoData);
                    } else {
                        pendingVideoData = videoData;
                    }

                    var videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
                    videoModal.show();
                });
            });

            // Manipulador do fechamento do modal
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
                if (player && typeof player.stopVideo === 'function') {
                    player.stopVideo();
                }
            });


            // Manipulador do botão "Marcar como concluído"
            document.getElementById('markAsCompletedBtn')?.addEventListener('click', function() {
                document.getElementById('completeForm').submit();
            });
        });

        // Função chamada quando o estado do player muda
        function onPlayerStateChange(event) {
            // Estado 0 significa que o vídeo terminou
            if (event.data === 0) {
                // Marcar automaticamente como concluído
                document.getElementById('completeForm').submit();
            }
        }
    </script>

@endsection
