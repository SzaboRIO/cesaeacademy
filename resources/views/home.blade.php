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

    <!-- MAIS POPULARES - CARDS CAROULSEL 01 -->

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
    <h2 class="fs-2 fs-md-2 fs-lg-1 mb-3 mb-md-2"><b>Cursos mais populares:</b></h2>
    <p class="fs-6 fs-md-5 mb-1 mb-md-0">Desde habilidades essenciais até temas técnicos, nós apoiamos o seu desenvolvimento profissional.</p>
    <p class="fs-6 fs-md-5 mb-5 mb-md-5">Conheça os cursos mais buscados da CESAE Digital em 2025.</p>

    <!-- Cards Carousel 01 -->
    <!-- (Kitchen sink typed cards) -->
    <!--
    row-cols-* - Quantas colunas por linha em telas pequenas
    row-cols-md-* - Quantas colunas por linha em telas médias
    gx-* - Espaçamento horizontal entre as colunas
    gy-* - Espaçamento vertical entre as colunas
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
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row row-cols-1 gx-3 gy-5 mb-5 mb-md-5">

                    <!-- Card 5 -->
                    <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                        <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        </ul>
                    </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                        <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        </ul>
                    </div>
                    </div>

                    <!-- Card 7 -->
                    <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                        <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        </ul>
                    </div>
                    </div>

                    <!-- Card 8 -->
                    <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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

        <!-- Carousel buttons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCards" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCards" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>


    <!-- ADICIONADOS RECENTEMENTE - CARDS CAROULSEL 02 -->

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
    <h2 class="fs-2 fs-md-2 fs-lg-1 mb-3 mb-md-2"><b>Cursos adicionados recentemente:</b></h2>
    <p class="fs-6 fs-md-5 mb-1 mb-md-0">Que tal explorar os conteúdos mais recentes que irão impulsionar a sua jornada de aprendizado?</p>
    <p class="fs-6 fs-md-5 mb-5 mb-md-5">Te ajudamos a alcançar as suas metas mais rapidamente com novos desafios reais.</p>


    <!-- Cards Carousel 02 -->
    <!-- (Kitchen sink typed cards) -->
    <!--
    row-cols-* - Quantas colunas por linha em telas pequenas
    row-cols-md-* - Quantas colunas por linha em telas médias
    gx-* - Espaçamento horizontal entre as colunas
    gy-* - Espaçamento vertical entre as colunas
    -->

    <!-- Cards Carousel 02 -->
    <div id="carouselExampleCards2" class="carousel slide">
        <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="row row-cols-1 gx-3 gy-5 mb-5 mb-md-5">

                <!-- Card 1 -->
                <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="row row-cols-1 gx-3 gy-5 mb-5 mb-md-5">

                <!-- Card 5 -->
                <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                    <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    </ul>
                </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                    <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    </ul>
                </div>
                </div>

                <!-- Card 7 -->
                <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
                    <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    </ul>
                </div>
                </div>

                <!-- Card 8 -->
                <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('images/card_back_end.jpg') }}" class="card-img-top" alt="Image description">
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

    <!-- Carousel buttons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCards2" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCards2" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    </div>




<!-- TESTEMUNHOS -->

<div class="container py-5 mt-3 mt-md-3">
    <h2 class="text-center mb-5"><b>As conquistas de quem aprendeu e evoluiu:</b></h2>

    <!--
    g → gutter (espaçamento entre as colunas)
    x → eixo x (horizontal)
    gx-2 gx-md-4 gx-lg-5 → Espaçamento entre as colunas em telas pequenas, grandes e médias respectivamente
    EXTRA: gy-2 é adicionado para diminuir o espaçamento entre os testemunhos em telas pequenas, quando os cards fica em cima um do outro.
    -->

    <div class="row gy-2 gx-2 gx-md-4 gx-lg-5">

        <!-- Testemunho 1 -->
        <div class="col-md-4 text-center mb-5">
            <img src="{{ asset('images/testemunhos_1.jpg') }}" class="rounded-circle mb-3 img-fluid testemunho-img" alt="Aluno 1">
            <h4>Gonçalo Mota</h4>
            <p class="text-muted">Engenheiro de Software</p>
            <p>"A Cesae Digital mudou minha carreira! Os cursos são práticos e os instrutores são incríveis. Aprendi muito com o método de ensino dinâmico, e cada aula traz conhecimentos que podem ser aplicados imediatamente no mercado."</p>
        </div>

        <!-- Testemunho 2 -->
        <div class="col-md-4 text-center mb-5">
            <img src="{{ asset('images/testemunhos_2.jpg') }}" class="rounded-circle mb-3 img-fluid testemunho-img" alt="Aluno 2">
            <h4>Maria Santos</h4>
            <p class="text-muted">Designer Gráfica</p>
            <p>"Aprendi muito com os cursos de design da Cesae. Recomendo a todos que querem se destacar na área. As aulas são bem estruturadas, abrangem desde os fundamentos até técnicas avançadas, e me ajudaram a desenvolver um portfólio profissional."</p>
        </div>

        <!-- Testemunho 3 -->
        <div class="col-md-4 text-center mb-5">
            <img src="{{ asset('images/testemunhos_3.jpg') }}" class="rounded-circle mb-3 img-fluid testemunho-img" alt="Aluno 3">
            <h4>Inês Gouveia</h4>
            <p class="text-muted">Analista de Dados</p>
            <p>"Os cursos de análise de Back-end são completos e atualizados. A Cesae Digital é referência no mercado. Com conteúdos alinhados às demandas atuais, eu pude me preparar melhor para desafios reais na área da tecnologia e software."</p>
        </div>

    </div>
</div>



</div> <!-- FIM DO CONTEÚDO DA PÁGINA COM MARGEM APLICADA -->



<!-- SUBSCRIÇÃO NA NEWSLETTER -->

<section class="content-box mt-5 px-5 py-5">

    <div class="container-fluid"> <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
        <div class="row">

            <div class="col-md-6">
                <img src="{{ asset('images/subscription_images.png') }}" class="d-block w-100 img_subscription" alt="">
            </div>

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

            <div class="col-md-6 d-flex flex-column justify-content-center text-center px-md-5 px-sm-0">
                <h2 class="fs-2 fs-md-2 fs-lg-1 mb-4 mb-md-3 mt-5"><b>Receba novidades da CESAE Digital:</b></h2>
                <p class="fs-6 fs-md-5">Subscreva-se à nossa newsletter para receber informações semanais sobre novos cursos, eventos e conteúdos exclusivos.</p>

                <form>
                    <div class="mb-4 mt-4">
                      <label for="exampleInputEmail1" class="form-label">Endereço de Email:</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      <div id="emailHelp" class="form-text"><small>Nunca iremos compartilhar seus dados com ninguém.</small></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-md-4 mt-4 btn-send">Enviar</button>
                  </form>
            </div>

        </div>
    </div>

</section>

@endsection
