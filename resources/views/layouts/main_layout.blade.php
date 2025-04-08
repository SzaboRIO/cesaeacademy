<!DOCTYPE html>
<html lang="pt">


<!-- HEAD -->

<head>

    <title>CESAE Digital Online Courses</title>
    <meta charset="UTF-8">
    <meta name="author" content="Thiago Oliveira, Pedro Bento, Ana Vale, Gonçalo Rio">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- META TAG VIEWPORT (inserir para responsividade) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para o Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

</head>

<!-- BODY-->

<body>

    <!-- BARRA DE NAVEGAÇÃO-->

    <!--
    'navbar': barra de navegação
    'navbar-expand-lg': expande a navbar em telas grandes (≥ 1024px)
    'custom-navbar': classe personalizada para estilos adicionais
    'px-3 py-2': padding para telas pequenas
    'px-lg-5 py-lg-4': aumenta o padding para telas grandes (≥ 1024px)
    'd-flex': classe no Bootstrap usada p/ transformar o contêiner (ex: uma div) em um contêiner flexível que permite mais controle de alinhamento, distribuição e direção dos itens dentro dele, usando as propriedades do Flexbox.
    -->
    <nav class="navbar navbar-expand-lg custom-navbar d-flex px-2 py-1 px-lg-4 py-lg-1">
        <div class="container-fluid">

            <!-- Logo responsivo -->
            <!-- href="/" redireciona para a própria home -->
            <!-- img-fluid do Bootstrap garante que o logo se ajuste automaticamente ao tamanho da tela -->
            <!-- mais precisamente, classe img-fluid do Bootstrap aplica max-width: 100% e height: auto -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo_alternativo.png') }}" alt="Logo CESAE Digital" class="img-fluid logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Search bar -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control-search mr-sm-2 search-type" type="search" placeholder="O que deseja aprender?" aria-label="Buscar">
                <button class="btn btn-outline-success my-2 my-sm-0 btn-search" type="submit">Procurar</button>
            </form>

            <!-- Links da barra de navegação -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <!--
                ms-auto → é uma classe utilitária do Bootstrap que aplica uma margem automática à esquerda de um elemento.
                gap → Define um pequeno espaçamento padrão entre os itens.
                -->
                <ul class="navbar-nav gap-1 gap-md-1 gap-lg-1 ms-auto">

                    <!-- Link de sobre -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Sobre</a>
                    </li>

                    <!-- Dropdown de áreas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cursos
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('courses.index') }}">&nbsp;&nbsp;&nbsp;Todos&nbsp;&nbsp;&nbsp;</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="delopment.html">&nbsp;&nbsp;&nbsp;Development&nbsp;&nbsp;&nbsp;</a></li>
                        <li><a class="dropdown-item" href="itnetwork.html">&nbsp;&nbsp;&nbsp;IT Network&nbsp;&nbsp;&nbsp;</a></li>
                        <li><a class="dropdown-item" href="mediadesign.html">&nbsp;&nbsp;&nbsp;Media Design&nbsp;&nbsp;&nbsp;</a></li>
                        <li><a class="dropdown-item" href="people.html">&nbsp;&nbsp;&nbsp;People&nbsp;&nbsp;&nbsp;</a></li>
                        </ul>
                    </li>

                    <!-- Link de Colaborar -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('collaborate') }}">Colaborar</a>
                    </li>

                    @if (Auth::user())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Área Pessoal</a>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->isAluno() || Auth::user()->isFormador())
                                <li><a class="dropdown-item" href="{{ route('perfil') }}">&nbsp;&nbsp;&nbsp;Perfil&nbsp;&nbsp;&nbsp;</a></li>
                                @endif
                                @if (Auth::user()->isAluno())
                                <li><a class="dropdown-item" href="{{ route('aluno.courses') }}">&nbsp;&nbsp;&nbsp;Cursos em andamento&nbsp;&nbsp;&nbsp;</a></li>
                                <li><a class="dropdown-item" href="{{ route('aluno.completed') }}">&nbsp;&nbsp;&nbsp;Cursos concluídos&nbsp;&nbsp;&nbsp;</a></li>
                                <li><a class="dropdown-item" href="{{ route('aluno.favorites') }}">&nbsp;&nbsp;&nbsp;Cursos favoritos&nbsp;&nbsp;&nbsp;</a></li>
                                @endif
                                @if (Auth::user()->isFormador())
                                <li><a class="dropdown-item" href="{{ route('formador.courses') }}">&nbsp;&nbsp;&nbsp;Meus cursos&nbsp;&nbsp;&nbsp;</a></li>
                                @endif
                                @if (Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.users') }}">&nbsp;&nbsp;&nbsp;Gestão de Utilizadores&nbsp;&nbsp;&nbsp;</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.courses') }}">&nbsp;&nbsp;&nbsp;Gestão de Cursos&nbsp;&nbsp;&nbsp;</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">Logout</button>
                            </form>
                        </li>
                    @else
                            <!-- Link de Login -->
                        <!--
                        - offcanvas: componente do Bootstrap que exibe conteúdo oculto fora da tela, geralmente em uma barra lateral, que aparece ao interagir com um botão ou outro gatilho.
                        - data-bs-toggle="offcanvas": define que o botão vai ativar o offcanvas
                        - data-bs-target="#offcanvasLogin": especifica o ID do offcanvas a ser aberto
                        - aria-controls="offcanvasLogin">: vincula o botão ao offcanvas com esse ID
                        -->
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">Login</a>
                        </li>
                            <!-- Botão de Registo -->
                        <!--
                        - O botão vira um link em telas menores (para não ficar esquisito).
                        - Para isso usamos d-none e d-lg-none.
                        - d-none e d-lg-none são classes do Bootstrap usadas para controlar a visibilidade de elementos com base no tamanho da tela.

                        - d-none: oculta o elemento em todos os tamanhos de tela.
                        - d-lg-block: Faz o elemento reaparecer como um bloco (display: block;) em telas grandes (lg) ou maiores (≥992px).

                        - offcanvas: componente do Bootstrap que exibe conteúdo oculto fora da tela, geralmente em uma barra lateral, que aparece ao interagir com um botão ou outro gatilho.
                        - data-bs-toggle="offcanvas": define que o botão vai ativar o offcanvas
                        - data-bs-target="##offcanvasRegister": especifica o ID do offcanvas a ser aberto
                        - aria-controls="#offcanvasRegister">: vincula o botão ao offcanvas com esse ID
                        -->
                        <li class="nav-item d-none d-lg-block">
                            <a class="btn btn-outline-primary my-2 my-sm-0 btn-register" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRegister" aria-controls="#offcanvasRegister">Registar</a>
                        </li>


                    <!-- Link de Registo (para telas pequenas) -->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRegister" aria-controls="#offcanvasRegister">Registar</a>
                    </li>
                    @endif

                </ul>

            </div>
        </div>
    </nav>

    <!-- Toast notification for session messages (mantenha este bloco em algum lugar visível na página) -->
    @if (session('success') || session('error'))
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
        <div id="myToast"
            class="toast align-items-center show text-white border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-autohide="true"
            data-bs-delay="3000"
            style="background-color: #36236a; text-align: center; border-radius: 8px; font-size: 1rem;">
            <div class="toast-body p-3">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('myToast');
            if (toastEl) {
                new bootstrap.Toast(toastEl).show();
            }
        });
    </script>
    @endif

    <!-- OFFCANVAS DE LOGIN, REGISTO E RECUPERAÇÃO DE PASSWORD -->

    <!-- Offcanvas para Login -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasLogin" aria-labelledby="offcanvasLoginLabel">
        <div class="offcanvas-header mb-4">
            <h5 class="offcanvas-title mt-5" id="offcanvasLoginLabel">Fazer login:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Formulário de Login -->
            <h5 class="mb-4">Insira os seus dados:</h5>
            <form method="POST" action="{{route('login.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Digite o seu e-mail" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Digite a sua password" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="remember" /> Lembrar-me
                </div>
                <br>
                <button type="submit" class="btn btn-offcanvas">Entrar</button>
            </form>
            <br>
            <button class="btn btn-offcanvas-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRecover" aria-controls="offcanvasRecover">Recuperar password</button>
            <br>
            <hr>
            <button class="btn btn-offcanvas-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRegister" aria-controls="offcanvasRegister">Ainda não tem conta? Registe-se</button>
        </div>
    </div>

    <!-- Offcanvas para Registro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRegister" aria-labelledby="offcanvasRegisterLabel">
        <div class="offcanvas-header mb-4">
            <h5 class="offcanvas-title mt-5" id="offcanvasRegisterLabel">Fazer registo:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Formulário de Registro -->
            <h5 class="mb-2">Insira os seus dados:</h5>
            <br>
            <form method="POST" action="{{route('register.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="registerEmail" placeholder="Digite o seu e-mail" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Digite a sua password" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="registerConfirmPassword" class="form-label">Confirmar password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="registerConfirmPassword" placeholder="Confirme a sua password" required>
                    @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-offcanvas">Registar</button>
            </form>
            <br>
            <p class="warning mt-4">Ao registar confirma que aceita os <a class="warning-link" href="https://www.cesaedigital.pt/fldrSite/pages/termsAndConditions.aspx">Termos e Condições</a> e a <a class="warning-link" href="https://www.cesaedigital.pt/fldrSite/pages/privacyPolicy.aspx">Política de Privacidade</a> da CESAE Digital. Está com problemas para entrar? Experimente visitar a nossa página de <a class="warning-link" href="https://www.cesaedigital.pt/fldrSite/pages/faqs.aspx">Perguntas Frequentes</a>.</p>
            <hr>
            <button class="btn btn-offcanvas-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">Já tem conta? Faça login</button>
        </div>
    </div>

    <!-- Offcanvas para Recuperação de password -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRecover" aria-labelledby="offcanvasRecoverLabel">
        <div class="offcanvas-header mb-4">
            <h5 class="offcanvas-title mt-5" id="offcanvasRecoverLabel">Recuperar password:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Formulário de Recuperação de password -->
            <h5 class="mb-4">Insira os seus dados:</h5>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="recoverEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="recoverEmail" placeholder="Digite o seu e-mail" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-offcanvas">Recuperar</button>
            </form>
            <br>
            <hr>
            <button class="btn btn-offcanvas-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRegister" aria-controls="offcanvasRegister">Ainda não tem conta? Registe-se</button>
        </div>
    </div>

    <!-- AQUI entra o conteúdo dinâmico de cada página -->
    @yield('content')


    <!-- FOOTER -->

    <footer class="footer text-center py-5 px-5">
    <!--
    py → padding do eixo y (padding vertical) do footer todo.
    py-5 → py-5 aplica um padding vertical de 3rem (3rem = 48 pixels).

    py-0 -> 0rem (0px)
    py-1 -> 0.25rem (4px)
    py-2 -> 0.5rem (8px)
    py-3 -> 1rem (16px)
    py-4 -> 1.5rem (24px)
    py-5 -> 3rem (48px)
    -->

        <div class="container-fluid"> <!-- container-fluid faz ocupar toda a largura (width) da tela. -->
            <div class="row">

                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 footer-text">© 2025 CESAE Digital. Todos os direitos reservados.</p>
                    <br>
                    <p class="mt-1 footer-links">
                        <a href="https://www.cesaedigital.pt/fldrSite/pages/cookies.aspx" class="footer-link">Política de Cookies</a> |
                        <a href="https://www.cesaedigital.pt/fldrSite/pages/privacyPolicy.aspx" class="footer-link">Política de Privacidade</a> |
                        <a href="https://www.cesaedigital.pt/fldrSite/pages/personalDataPolicy.aspx" class="footer-link">Política de Dados Pessoais</a> |
                        <a href="https://www.cesaedigital.pt/fldrSite/pages/termsAndConditions.aspx" class="footer-link">Termos & Condições</a> |
                        <a href="https://www.livroreclamacoes.pt/Inicio/" class="footer-link">Livro de Reclamações</a> |
                        <a href="https://www.cniacc.pt/pt/" class="footer-link">Resolução de Litígios</a> |
                        <a href="#" class="footer-link">Contactos</a>
                    </p>
                </div>

                <!--
                text-center: alinha o texto ao centro em telas menores.
                text-md-start: Alinha o texto à esquerda (início) em telas médias ou maiores
                -->

                <!-- Ícones de redes sociais -->
                <div class="col-md-6 text-center text-md-end mt-4 mt-md-5">
                    <!-- Linkedin -->
                    <a href="https://www.linkedin.com/school/cesae-digital/posts/?feedView=all"><img src="{{ asset('images/icon_linkedin.png') }}" class="social-icon" alt="LinkedIn"></a>
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/cesae.digital/"><img src="{{ asset('images/icon_instagram.png') }}" class="social-icon" alt="Instagram"></a>
                    <!-- Youtube -->
                    <a href="https://www.youtube.com/@cesaedigital"><img src="{{ asset('images/icon_youtube.png') }}" class="social-icon" alt="YouTube"></a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/CesaeDigital"><img src="{{ asset('images/icon_facebook.png') }}" class="social-icon" alt="Facebook"></a>
                </div>

            </div>
        </div>

    </footer>


    <!-- Link para o arquivo JS -->
    <script src="{{ asset('js\scripts.js') }}"></script>

</body>
</html>
