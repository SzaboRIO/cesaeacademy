@extends('layouts.main_layout')

@section('content')

<!-- PLAYER + DESCRIÇÃO -->

<section class="content-box px-sm-3 px-md-5 py-5">

    <div class="container-fluid"> <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
        <div class="row">


            <!-- Vídeo responsivo 16:9 -->

            <!--
            A opção .ratio do Bootstrap ajusta automaticamente a altura dos elementos <iframe>, <video>, <embed>, etc.
            Ele faz isso mantendo uma proporção específica, como 16:9, 4:3, 1:1, 21:9, sem precisar de CSS personalizado.
            -->
            <div class="col-md-6">
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.youtube.com/embed/dzrNLxvEuP4?controls=0&modestbranding=1&rel=0&disablekb=1&fs=0"
                        frameborder="0"
                        allowfullscreen>
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
                    <b>Software Developer</b>


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

                        <!-- ADICIONA À LISTA -->
                        <i class="bi bi-plus-square fs-4"></i>

                        <!-- FAVORITAR -->
                        <i class="bi bi-heart fs-4" id="heart-icon"></i>
                    </div>

                </h2>


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

    <div class="container-fluid"> <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
        <div class="row">

            <!--
            p -> padding
            px -> padding no eixo x (horizontal)
            px-md-5 -> padding no eixo x (horizontal) de 5rem (80px) em telas médias (md = ≥768px)
            px-sm-0 -> padding no eixo x (horizontal) de 0rem (0px) em telas pequenas (sm = ≥576px)

            d-flex -> display flex, ativa o Flexbox no elemento
            flex-column -> flex direction column, organiza os elementos filhos verticalmente (em coluna).
            justify-content-center -> centraliza o conteúdo verticalmente dentro da coluna.
            text-center -> alinhamento de texto no centro
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
                <p class="fs-6 fs-md-5">Sabias que um software developer pode trabalhar em/e para qualquer parte do mundo? Sabias que a profissão de software developer é uma das profissões com maior taxa de empregabilidade e salários competitivos? Esta formação pretende promover a requalificação profissional de jovens e adultos e capacitar profissionais para o domínio técnico especializado em temáticas relacionadas com a programação e desenvolvimento de plataformas web e mobile, gestão de bases de dados e engenharia de software.</p>


                <!-- Objetivos Gerais:-->
                <h2 class="fs-2 fs-md-2 fs-lg-1 mb-4 mb-md-3 mt-5">
                    <i class="bi bi-bullseye me-2"></i>
                    <b>Objetivos Gerais:</b>
                    <!-- bi bi-info-circle -> ícone de informação-->
                    <!-- me -> margin end, para separar um pouco o ícone do título-->
                    <!-- OBS: apesar de usarmos a tag <i>, esta é a forma correta e semântica de inserir ícones de web fonts (como Bootstrap Icons), e não tem relação com itálico nesse contexto.-->
                </h2>
                <p class="fs-6 fs-md-5 mb-5">Dotar os formandos de conhecimentos teóricos e competências técnicas necessários para ingressar no mercado de trabalho numa atividade profissional ligada à Programação Web e Mobile: definição de arquiteturas de software e bases de dados, desenvolvimento de plataformas web client-side e server-side, criação e manutenção de aplicações mobile, gestão de projetos em metodologias waterfall e agile.</p>

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
                        <div class="col-md-4 text-left mb-5">
                            <img src="assets/formador.jpg" class="rounded-circle mb-3 img-fluid testemunho-img" alt="Aluno 2">
                        </div>
                        <div class="col-md-4 text-left mb-5">

                            <h4>João Silva</h4>

                            <p class="text-muted mb-4">Desenvolvedor Back-End</p>

                            <ul class="ps-3"> <!-- ps -> padding start (lado esquerdo)-->
                                <li class="fs-6 fs-md-5 mb-1">Nº de Cursos: 03</li>
                                <li class="fs-6 fs-md-5 mb-1">Nº de Alunos: 123</li>
                                <li class="fs-6 fs-md-5 mb-0">Idioma: Português</li>
                            </ul>

                        </div>
                        <div class="col-md-12 text-left mb-5">
                            <!-- Texto à mostra -->
                            <p>João Silva é um programador back-end português de 35 anos, especializado em Java e C#. Com mais de uma década de experiência, trabalhou em diversos projetos, desde aplicações empresariais a sistemas de grande escala. Sempre gostou de resolver problemas complexos e otimizar código, garantindo que as soluções sejam eficientes e bem estruturadas. Com o tempo, percebeu que também tinha gosto pelo ensino e decidiu partilhar o seu conhecimento como formador na área de Software Development. Nas suas aulas, procura ir além da teoria, trazendo exemplos práticos do dia a dia de um programador e mostrando como as boas práticas fazem a diferença no desenvolvimento de software."</p>

                            <!-- Texto oculto -->
                            <div class="collapse" id="hiddenText">
                                <p>João acredita que a programação não se resume apenas a escrever código, mas sim a pensar de forma lógica e estruturada para resolver problemas do mundo real. No seu percurso como formador, tem ajudado alunos a desenvolverem não só competências técnicas, mas também uma mentalidade analítica e crítica, essencial para qualquer programador.</p>
                            </div>
                        </div>

                        <!-- Botão simples que alterna -->
                        <button class="btn btn-link p-0 text-primary" data-bs-toggle="collapse" data-bs-target="#hiddenText">
                            Mostrar mais
                        </button>


                    </div>
                </div>

            </div>



        </div>
    </div>




    <!-- ACCORDION COM AULAS E MÓDULOS -->

    <section class="mt-5 px-5 py-5">

        <div class="container-fluid"> <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
            <div class="row">


                <!-- Lista de Módulos-->

                <div class="content-box box-videos col-md-6">
                    <div class="container mt-5">
                        <div class="accordion" id="modulosAccordion">

                            <!-- Módulo 1 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo1">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 1 - Engenharia de Software
                                    </button>
                                </h2>
                                <div id="modulo1" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Fundamentos da Engenharia de Software</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Fundamentos da Engenharia de Software" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Modelos de Desenvolvimento de Software</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Modelos de Desenvolvimento de Software" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Princípios de Qualidade e Manutenção de Software</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Princípios de Qualidade e Manutenção de Software" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 2 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo2">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 2 - Conceitos de Bases de Dados
                                    </button>
                                </h2>
                                <div id="modulo2" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Introdução a Bases de Dados e Modelagem</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Introdução a Bases de Dados e Modelagem" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Normalização e Integridade dos Dados</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Normalizaçã o e Integridade dos Dados" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Sistemas de Gestão de Bases de Dados</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Sistemas de Gestão de Bases de Dados" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 3 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo3">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 3 - Programação em SQL
                                    </button>
                                </h2>
                                <div id="modulo3" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Comandos Básicos e Consultas em SQL</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Comandos Básicos e Consultas em SQL" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Manipulação de Dados e Funções Agregadas</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Manipulação de Dados e Funções Agregadas" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Stored Procedures e Triggers</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Stored Procedures e Triggers" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 4 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo4">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 4 - Programação e Algoritmia
                                    </button>
                                </h2>
                                <div id="modulo4" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Estruturas de Controle e Dados</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Estruturas de Controle e Dados" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Introdução a Algoritmos e Pseudocódigo</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Introdução a Algoritmos e Pseudocódigo" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Recursão e Complexidade Algorítmica</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Recursão e Complexidade Algorítmica" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 5 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo5">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 5 - Programação de Computadores
                                    </button>
                                </h2>
                                <div id="modulo5" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Estruturas de Dados e Variáveis</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Estruturas de Dados e Variáveis" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Controle de Fluxo e Estruturas Condicionais</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Controle de Fluxo e Estruturas Condicionais" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Entrada, Saída e Manipulação de Ficheiros</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Entrada, Saída e Manipulação de Ficheiros" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 6 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo6">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 6 - Programação de Computadores Orientada a Objetos
                                    </button>
                                </h2>
                                <div id="modulo6" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Princípios da Programação Orientada a Objetos</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Princípios da Programação Orientada a Objetos" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Herança, Polimorfismo e Encapsulamento</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Herança, Polimorfismo e Encapsulamento" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Classes, Objetos e Métodos</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Classes, Objetos e Métodos" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 7 -->
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo7">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 7 - Programação para a WEB (Client-side)
                                    </button>
                                </h2>
                                <div id="modulo7" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Fundamentos de HTML, CSS e JavaScript</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Fundamentos de HTML, CSS e JavaScript" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Manipulação do DOM e Eventos</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Manipulação do DOM e Eventos" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Frameworks e Bibliotecas Front-end</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Frameworks e Bibliotecas Front-end" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo 8 -->
                            <div class="accordion-item border mb-5">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modulo8">
                                        <i class="bi bi-play-circle me-2"></i> Módulo 8 - Integração de Sistemas de Informação
                                    </button>
                                </h2>
                                <div id="modulo8" class="accordion-collapse collapse" data-bs-parent="#modulosAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Arquitetura e Comunicação entre Sistemas</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Arquitetura e Comunicação entre Sistemas" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>APIs e Serviços Web</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="APIs e Serviços Web" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                <span>Segurança e Boas Práticas na Integração</span>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ver-video" data-title="Segurança e Boas Práticas na Integração" data-video="dzrNLxvEuP4">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- ADICIONAR ALGO AQUI ....... -->
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




</div> <!-- FIM DO CONTEÚDO DA PÁGINA COM MARGEM APLICADA -->




<!-- FULLSCREEN MODAL (EXIBIÇÃO DOS VIDEOS) -->

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-purple text-white">
        <h5 class="modal-title" id="videoModalTitle"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="ratio ratio-16x9">
          <iframe id="videoFrame" src="" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
