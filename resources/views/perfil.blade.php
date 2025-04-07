@extends('layouts.main_layout')

@section('content')

<div class="barra-roxa">
    <h1>Meu Perfil</h1>
    <p>Aqui pode alterar as suas informações pessoais.</p>
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

@if (session('success'))
    <!-- Container centralizado -->
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">

        <!-- Toast sem cabeçalho, texto centralizado, cor roxa -->
        <div id="myToast"
             class="toast align-items-center show text-white border-0"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-bs-autohide="true"
             data-bs-delay="3000"
             style="
                 background-color: #36236a;
                 text-align: center;
                 border-radius: 8px;
                 font-size: 1rem;
             ">

            <div class="toast-body p-3">
                {{ session('success') }}
            </div>
        </div>
    </div>

    <!-- Script para inicializar o Toast -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myToastEl = document.getElementById('myToast');
            if (myToastEl) {
                var toast = new bootstrap.Toast(myToastEl);
                toast.show(); // dispara o auto-hide
            }
        });
    </script>
@endif




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

                        <h3 class="mb-3" style="color: #543e92;">Dados Pessoais</h3>

                        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">Nome</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="firstname"
                                        name="firstname"
                                        value="{{ old('firstname', Auth::user()->firstname) }}"
                                        required
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Sobrenome</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="lastname"
                                        name="lastname"
                                        value="{{ old('lastname', Auth::user()->lastname) }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="profession" class="form-label">Profissão</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profession"
                                    name="profession"
                                    value="{{ old('profession', Auth::user()->profession) }}"
                                >
                            </div>

                            @if (Auth::user()->isFormador())
                                <div class="mb-3">
                                    <label for="biography" class="form-label">Biografia</label>
                                    <textarea
                                        class="form-control"
                                        id="biography"
                                        name="biography"
                                        rows="4"
                                        >{{ old('biography', Auth::user()->biography) }}
                                    </textarea>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <img style="width: 50px; height:50px"
                                     src="{{ Auth::user()->avatar
                                             ? asset('storage/' . Auth::user()->avatar)
                                             : asset('images/nophoto.jpg')
                                          }}"
                                     alt="Foto de Perfil">

                                <label for="avatar" class="form-label">
                                    Foto de Perfil (Ignorar se não deseja alterar)
                                </label>

                                <input
                                    type="file"
                                    accept="image/*"
                                    name="avatar"
                                    class="form-control"
                                    id="avatar"
                                >
                            </div>

                            <h5 class="mb-3">Alterar Password</h5>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Atual</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="current_password"
                                    name="current_password"
                                >
                                <div class="form-text">
                                    Preencha apenas se desejar alterar a sua password.
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Nova Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        Confirmar Nova Password
                                    </label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                    >
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-outline-primary my-2 my-sm-0 btn-register">Guardar</button>
                            </div>
                        </form>

                    </div> <!-- FIM bloco branco -->
                </div> <!-- FIM contêiner roxo -->

            </div> <!-- col-md-8 offset-md-2 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- content-wrapper --> <!-- fim .content-wrapper -->

@endsection
