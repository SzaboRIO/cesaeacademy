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

                        <div class="d-flex gap-3 course-icon align-items-center">
                            <!-- COMPARTILHAR -->
                            <button type="button" class="btn p-0 border-0 share-button" id="shareButton">
                                <i class="bi bi-share-fill fs-4" style="color: inherit;"></i>
                            </button>

                            <!-- FAVORITAR -->
                            @if(Auth::check())
                            <form action="{{ route('course.toggle-favorite', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn p-0 border-0 share-button">
                                    <i class="bi {{ isset($isFavorite) && $isFavorite ? 'bi-heart-fill' : 'bi-heart' }} fs-4" style="color: inherit;"></i>
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="btn p-0 border-0 share-button">
                                <i class="bi bi-heart fs-4" style="color: inherit;"></i>
                            </a>
                            @endif

                            <!-- INSCREVER-SE -->
                            @if (!isset($enrollment))
                                <form action="{{ route('enroll', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="fs-6 fs-md-2 py-1 subscribe">Inscreva-se</button>
                                </form>
                            @else
                                <span class="badge bg-success fs-6 fs-md-2 py-1 subscribe" style="color: #e2c8e4 !important;">Inscrito</span>
                            @endif
                        </div>
                    </h2>

                    <!-- Barra de Progresso do Curso (só aparece se estiver matriculado) -->
                    @if (isset($enrollment) && isset($progressPercentage))
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span>O seu progresso neste curso:</span>
                                <span>{{ $progressPercentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            @if ($enrollment->completed_at)
                                <div class="mt-2">
                                    <i class=" bi bi-trophy-fill"></i> Parabéns! Você concluiu este curso em
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

                        @php
                            // Certifique-se de que a variável $averageRating existe e é um número (por exemplo, 4.5)
                            $fullStars = floor($averageRating);              // Número de estrelas totalmente preenchidas
                            $halfStar  = ($averageRating - $fullStars) >= 0.5 ? 1 : 0; // Se a fração for 0.5 ou maior, mostra meia estrela
                            $emptyStars = 5 - $fullStars - $halfStar;          // O restante serão as estrelas vazias
                        @endphp

                        <!-- Estrelas preenchidas -->
                        @for ($i = 0; $i < $fullStars; $i++)
                        <i class="bi bi-star-fill"></i>
                        @endfor

                        <!-- Meia estrela, se aplicável -->
                        @if ($halfStar)
                            <i class="bi bi-star-half"></i>
                        @endif

                        <!-- Estrelas vazias -->
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="bi bi-star"></i>
                        @endfor

                        <!-- Exibir também o valor numérico -->
                        <span class="rating-text">{{ $averageRating }}/5</span>
                    </div>

                    <!-- Descrições -->
                    <ul class="ps-2"> <!-- ps -> padding start (lado esquerdo)-->
                        <li class="fs-6 fs-md-5 mb-1">
                            Formador: {{ $course->user->firstname }} {{ $course->user->lastname }}
                        </li>
                        <li class="fs-6 fs-md-5 mb-1">
                            Nível: {{ $course->level }}
                        </li>
                        <li class="fs-6 fs-md-5 mb-1">
                            Duração: {{ $course->duration }}h
                        </li>
                        <li class="fs-6 fs-md-5 mb-1">
                            Última atualização: {{ $course->updated_at->format('d/m/Y') }}
                        </li>
                        <li class="fs-6 fs-md-5 mb-1">
                            {{ $course->favorites_count ?? $course->favorites->count() }} alunos favoritaram este curso.
                        </li>
                        <li class="fs-6 fs-md-5 mb-0">
                            Área: {{ $course->category->area }}
                        </li>
                    </ul>
                    <br>
                    <!-- Tags -->
                    <p class="fs-6 fs-md-5 tags">
                        <i class="bi bi-tags-fill me-2"></i>Tags:&nbsp;&nbsp;
                        <small>
                            @php
                                // Decodifica as tags do curso (assumindo que estão armazenadas como JSON)
                                $tags = json_decode($course->tags, true);
                            @endphp

                            @if($tags && count($tags))
                                @foreach($tags as $index => $tag)
                                    <a href="#{{ strtolower($tag) }}">#{{ $tag }}</a>@if(!$loop->last), @endif
                                @endforeach
                            @else
                                Sem tags.
                            @endif
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
                                <img src="{{ asset('storage/' . $course->user->avatar) }}"
                                    class="rounded-circle mb-3 img-fluid testemunho-img"
                                    alt="{{ $course->user->firstname }} {{ $course->user->lastname }}">
                            </div>
                            <div class="col-md-4 text-left mb-5">

                                <!-- Nome completo dinâmico -->
                                <h4>{{ $course->user->firstname }} {{ $course->user->lastname }}</h4>

                                <!-- Profissão dinâmico; -->
                                <p class="text-muted mb-4">{{ $course->user->profession }}</p>

                                <ul class="ps-3"> <!-- ps -> padding start (lado esquerdo)-->
                                    <li class="fs-6 fs-md-5 mb-1">
                                        Nº de Cursos: {{ $approvedCoursesCount }}
                                    </li>
                                    <li class="fs-6 fs-md-5 mb-1">
                                        Nº de Alunos: {{ $totalEnrolled }}
                                    </li>
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
                                                                    <form action="{{ route('enroll', $course->id) }}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        <button type="submit"
                                                                                class="btn btn-sm btn-outline-primary2 px-3">
                                                                            Inscreva&#8209;se
                                                                        </button>
                                                                    </form>
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
                                        @forelse($reviews as $review)
                                            <!-- Review {{ $loop->iteration }} -->
                                            <div class="review-item py-3 border-bottom border-light">
                                                <div class="fw-bold fs-5">
                                                    {{ $review->user->firstname }} {{ $review->user->lastname }}
                                                </div>
                                                <small class="text-util">{{ $review->created_at->format('d/m/Y') }}</small>
                                                <p class="mt-4 mb-2 line-clamp comment">
                                                    {{ $review->comment }}
                                                </p>

                                                <div class="star-rating mb-3">
                                                    @php
                                                        // Calcular a quantidade de estrelas cheias, meia estrela e vazias para o rating
                                                        $fullStars = floor($review->rating);
                                                        $halfStar  = ($review->rating - $fullStars) >= 0.5 ? 1 : 0;
                                                        $emptyStars = 5 - $fullStars - $halfStar;
                                                    @endphp

                                                    <!-- Estrelas estáticas (dinâmicas agora) -->
                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                    @if($halfStar)
                                                        <i class="bi bi-star-half"></i>
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="bi bi-star"></i>
                                                    @endfor
                                                    <!-- Mostra a média de todas as avaliações recebidas até o momento (ex: "4.5/5") -->
                                                    <span class="ms-2">{{ $review->rating }}/5</span>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="mb-0">Nenhuma avaliação ainda.</p>
                                        @endforelse

                                        <!-- Controles de Navegação Personalizados -->
                                        <div class="d-flex justify-content-center align-items-center py-3">
                                            <span class="text-light me-3">Ver mais reviews</span>
                                            <!-- Botão para ir à página anterior -->
                                            @if($reviews->currentPage() > 1)
                                                <a href="{{ $reviews->previousPageUrl() }}" class="nav-arrow me-2">
                                                    <i class="bi bi-arrow-left-circle fs-4"></i>
                                                </a>
                                            @else
                                                <!-- Desabilita o botão se não houver página anterior -->
                                                <a href="#" class="nav-arrow me-2 disabled">
                                                    <i class="bi bi-arrow-left-circle fs-4"></i>
                                                </a>
                                            @endif

                                            <!-- Botão para ir à próxima página -->
                                            @if($reviews->hasMorePages())
                                                <a href="{{ $reviews->nextPageUrl() }}" class="nav-arrow">
                                                    <i class="bi bi-arrow-right-circle fs-4"></i>
                                                </a>
                                            @else
                                                <!-- Desabilita o botão se não houver página seguinte -->
                                                <a href="#" class="nav-arrow disabled">
                                                    <i class="bi bi-arrow-right-circle fs-4"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Box de Adicionar Review -->
                                    @if(isset($enrollment) && $enrollment->completed_at)
                                        <form action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-2 mt-4">
                                                <label for="propostaFormacao" class="form-label review">Submete a sua review:</label>
                                                <textarea class="form-control" id="propostaFormacao" name="comment" rows="1"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary mb-4 mt-md-2 mt-1 btn-send btn-review">Enviar</button>

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
                                            </div>
                                            <input type="hidden" name="rating" id="ratingValue" value="0">
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        </form>
                                    @else
                                        <p class="mb-0 mt-3">Só pode enviar uma avaliação se tiver concluído o curso.</p>
                                    @endif
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
                    <b>Também se poderá interessar por:</b>
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
                                @foreach($suggestedCourses as $course)
                                    <!-- Card {{ $loop->iteration }} -->
                                    <div class="col-md-3">
                                        <!-- Envolver o card com link para tornar o card clicável -->
                                        <a href="{{ route('courses.showBySlug', $course->slug) }}" style="text-decoration: none; color: inherit;">
                                            <div class="card h-100">
                                                <!-- Imagem do curso dinâmica -->
                                                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top w-100 img-fluid" alt="{{ $course->title }}"
                                                    style="object-fit: cover; height: 180px;">
                                                <div class="card-body">
                                                    <!-- Título do curso -->
                                                    <h5 class="card-title">{{ $course->title }}</h5>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <!-- Exemplo de item dinâmico -->
                                                    <li class="list-group-item">Área: {{ $course->category->area ?? 'N/D' }}</li>
                                                    <li class="list-group-item">Nível: {{ $course->level }}</li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
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
                    @if (isset($enrollment))
                        <form id="completeForm" action="{{ route('student.complete-lesson') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lesson_id" id="completeFormLessonId">
                            <input type="hidden" name="enrollment_id" id="completeFormEnrollmentId">
                            <button type="submit" class="btn btn-sm btn-outline-primary2" id="markAsCompletedBtn">
                                Marcar como concluído
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        // Review e Rating
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona todas as estrelas dentro do container de rating que possuem o atributo data-value.
            const stars = document.querySelectorAll('.star-rating i[data-value]');
            const ratingValueInput = document.getElementById('ratingValue');
            const ratingText = document.querySelector('.star-rating .rating-text');
            let currentRating = 0; // Valor inicial de rating

            // Função para atualizar a aparência das estrelas com base na nota atual
            function updateStars(rating) {
                stars.forEach(star => {
                    // Converte o valor do data-value para número
                    let val = parseInt(star.getAttribute('data-value'), 10);
                    if (val <= rating) {
                        // Se o valor da estrela é menor ou igual à nota, exibe estrela preenchida
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                    } else {
                        // Caso contrário, exibe a estrela vazia
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                    }
                });
                // Atualiza o texto que mostra a nota
                ratingText.textContent = rating + '/5';
            }

            // Quando o usuário clica em uma estrela, atualiza o rating
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    currentRating = parseInt(this.getAttribute('data-value'), 10);
                    ratingValueInput.value = currentRating;
                    updateStars(currentRating);
                });
            });

            // Impede o envio do formulário se nenhuma estrela for selecionada
            const reviewForm = document.querySelector('form[action="{{ route('reviews.store') }}"]');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    if (ratingValueInput.value === '0' || ratingValueInput.value === '') {
                        e.preventDefault();
                        alert('Por favor, selecione uma nota (estrelas) antes de enviar.');
                    }
                });
            }
        });

        // Botão de mostrar mais/menos para a biografia
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

        document.addEventListener('DOMContentLoaded', function() {
            const shareButton = document.getElementById('shareButton');

            if (shareButton) {
                shareButton.addEventListener('click', async () => {
                    try {
                        // Verifica se a API de compartilhamento está disponível
                        if (navigator.share) {
                            await navigator.share({
                                title: '{{ $course->title }}',
                                text: 'Confira este curso no CESAE Digital: {{ $course->title }}',
                                url: window.location.href
                            });
                        } else {
                            // Alternativa para navegadores que não suportam a API
                            // Copiar URL para a área de transferência
                            navigator.clipboard.writeText(window.location.href);
                            alert('Link copiado para a área de transferência!');
                        }
                    } catch (error) {
                        console.error('Erro ao compartilhar:', error);
                    }
                });
            }
        });
    </script>

@endsection
