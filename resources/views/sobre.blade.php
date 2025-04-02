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


 <!-- Sobre nós -->
 <div class="container mt-5">
 <br>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="fs-6 fs-md-5 mb-1 mb-md-0">O <b>CESAE Digital - Plataforma de Formação Online em Competências Digitais </b>é uma plataforma inovadora de formação online gratuita, desenvolvida no âmbito da missão do CESAE Digital – Centro para o Desenvolvimento das Competências Digitais.</p>
            <br>
            <p class="fs-6 fs-md-5 mb-5 mb-md-5">Criada com o propósito de facilitar o acesso ao conhecimento e capacitação digital, visa proporcionar formação qualificada, acessível e flexível para todos aqueles que desejam aprender ou melhorar as suas competências digitais e expandir as suas oportunidades profissionais. Integrada na estratégia global do CESAE Digital, o CESAE Digital eLearning reforça o compromisso com a qualificação, requalificação e empregabilidade, oferecendo cursos online nas seguintes áreas de formação: Development, IT Network, Media Design e People.</p>


            <div class="card mt-3 mb-4">
                <div class="card-body py-3">
                    <h2 class="card-title">Nossa missão:</h2>
                    <p class="card-text">Facilitar o acesso ao conhecimento e capacitação digital, proporcionando formação qualificada, acessível e flexível para todos que desejam aprender ou melhorar suas competências digitais e expandir suas oportunidades profissionais.</p>
                </div>
            </div>

            <br>
            <h3 class="mb-3" style="color: #543e92;">Objetivos:</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item">• Responder às necessidades do mercado através da disponibilização de cursos alinhados com as exigências da economia digital.</li>
                <li class="list-group-item">• Capacitar profissionais com competências digitais essenciais para a sua evolução profissional e empregabilidade.</li>
                <li class="list-group-item">• Apoiar empresas e instituições na qualificação dos seus colaboradores, promovendo a inovação e a competitividade.</li>
                <li class="list-group-item">• Oferecer formação gratuita e acessível, permitindo que qualquer pessoa, independentemente da sua localização ou condição socioeconómica, possa desenvolver novas competências.</li>
            </ul>

            <br>
            <h3 class="mb-3" style="color: #543e92;">O que oferecemos?</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Cursos gratuitos</h5>
                            <p class="card-text">Formação acessível e sem custos para todos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Flexibilidade total</h5>
                            <p class="card-text">Acesso 24/7 aos conteúdos, estude no seu ritmo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Formação de qualidade</h5>
                            <p class="card-text">Conteúdos desenvolvidos por profissionais experientes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Plataforma intuitiva</h5>
                            <p class="card-text">Experiência de aprendizagem dinâmica e interativa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h3 class="mb-3" style="color: #543e92;">Como funciona?</h3>
            <ol class="list-group list-group-numbered mb-4">
                <li class="list-group-item"><b>Explore os cursos</b> – Navegue pelas categorias e escolha os cursos que mais combinam com o seu perfil.
                </li>
                <li class="list-group-item"><b>Inscreva-se gratuitamente </b>– Basta criar uma conta e começar a aprender.</li>
                <li class="list-group-item"><b>Acompanhe o seu progresso </b>– Salve cursos, acompanhe as aulas e conclua as atividades.</li>
            </ol>
            @if (!Auth::check())


            <div class="text-center mt-5 mb-5 md-mb-6">
                <p>Pronto para começar? Explore os cursos e inicie a sua aprendizagem agora mesmo!</p>

                <a class="btn btn-outline-primary my-2 my-sm-0 btn-register" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRegister" aria-controls="#offcanvasRegister">Registar</a>

            </div>
            @endif
        </div>
    </div>
</div>






</div> <!-- FIM DO CONTEÚDO DA PÁGINA COM MARGEM APLICADA -->

@endsection
