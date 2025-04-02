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


    <!-- Colaborar -->
    <div class="container mt-5">
       <br>

       <div class="container py-5 mt-3 mt-md-3">

           <!--
           g → gutter (espaçamento entre as colunas)
           x → eixo x (horizontal)
           gx-2 gx-md-4 gx-lg-5 → Espaçamento entre as colunas em telas pequenas, grandes e médias respectivamente
           EXTRA: gy-2 é adicionado para diminuir o espaçamento entre os testemunhos em telas pequenas, quando os cards fica em cima um do outro.
           -->

           <div class="row gy-2 gx-1 gx-md-2 gx-lg-0">

               <!-- Testemunho 1 -->
               <div class="col-md-4 text-center mb-5">
                   <img src="{{ asset('images/colaborar_1.jpg') }}" class="rounded-circle mb-1 img-fluid testemunho-img mb-4" alt="Aluno 1">
                   <h4 class="mt-2">Compartilhar.</h4>
               </div>

               <!-- Testemunho 2 -->
               <div class="col-md-4 text-center mb-5">
                   <img src="{{ asset('images/colaborar_2.jpg') }}" class="rounded-circle mb-1 img-fluid testemunho-img mb-4" alt="Aluno 2">
                   <h4 class="mt-2">Conectar.</h4>
               </div>

               <!-- Testemunho 3 -->
               <div class="col-md-4 text-center mb-5">
                   <img src="{{ asset('images/colaborar_3.jpg') }}" class="rounded-circle mb-1 img-fluid testemunho-img mb-4" alt="Aluno 3">
                   <h4 class="mt-2">Transformar.</h4>
               </div>

           </div>
       </div>
          <div class="row">
              <div class="col-md-8 offset-md-2">
                  <p class="fs-6 fs-md-5 mb-1 mb-md-0">Ensinar é transformar. Na <b>CESAE Digital - Plataforma de Formação Online em Competências Digitais</b>, acreditamos que o conhecimento deve ser acessível a todos e que a partilha de experiência é essencial para o crescimento profissional. Se tem experiência e paixão pela formação, convidamo-lo a juntar-se a nós e a tornar-se um formador na nossa plataforma. Ao partilhar o seu conhecimento, estará a capacitar profissionais e a contribuir para um mercado de trabalho mais qualificado e competitivo.</p>
                  <br>
                  <p class="fs-6 fs-md-5 mb-5 mb-md-5">A nossa plataforma oferece ferramentas intuitivas que proporcionam uma experiência de aprendizagem dinâmica e sempre adaptada às necessidades dos formandos. A sua experiência pode fazer a diferença na formação de novos talentos. Além disso, fará parte de uma comunidade de especialistas dedicados a impulsionar o conhecimento digital. Junte-se a nós e ajude-nos a construir um futuro mais digital, acessível e inovador!</p>

              </div>
           </div>
       </div>
   </div>




   </div> <!-- FIM DO CONTEÚDO DA PÁGINA COM MARGEM APLICADA -->



   <!-- SUBSCRIÇÃO NA NEWSLETTER -->

   <section class="content-box mt-5 px-5 py-5">
       <div class="container-fluid"> <!-- A classe container-fluid cria um contêiner que ocupa 100% da largura da viewport -->
           <div class="row">


               <div class="col-md-4">
                   <img src="{{ asset('images/colaborar_form.png') }}" class="d-block w-100 img_subscription" alt="">
               </div>


               <!--
               p -> padding
               px -> padding no eixo x (horizontal)
               px-md-5 -> padding no eixo x (horizontal) de 5rem (80px) em telas médias (md = ≥768px)
               px-sm-0 -> padding no eixo x (horizontal) de 0rem (0px) em telas pequenas (sm = ≥576px)
               mb -> margin bottom
               mt -> margin top

               d-flex -> display flex, ativa o Flexbox no elemento
               flex-column -> flex direction column, organiza os elementos filhos verticalmente (em coluna).
               justify-content-center -> centraliza o conteúdo verticalmente dentro da coluna.
               text-center -> alinhamento de texto no centro
               -->

               <div class="col-md-4 d-flex flex-column justify-content-center text-center px-md-5 px-sm-0">
                   <h2 class="fs-2 fs-md-2 fs-lg-1 mb-4 mb-md-3 mt-5"><b>Submeta a sua proposta de formação:</b></h2>
                   <p class="fs-6 fs-md-5">Tem uma ideia inovadora para um curso e gostaria de partilhá-la connosco? Na CESAE Digital, valorizamos o conhecimento e a experiência de especialistas como você. Submeta a sua proposta de formação e torne-se formador na nossa plataforma. Após a submissão, a nossa equipa analisará a viabilidade do curso e entrará em contacto para discutir os próximos passos.</p>
               </div>

               <div class="col-md-4 d-flex flex-column justify-content-center text-center px-md-5 px-sm-0">

                   <form>
                       <!-- Selecionar opção: "Como descobriu a CESAE?"-->
                       <select class="form-select" id="selecao" aria-label="Default select example">
                           <option selected>Como descobriu a CESAE Digital?</option>
                           <option value="5">Pesquisa no Google</option>
                           <option value="6">Recomendação de amigo</option>
                           <option value="7">Evento ou Feira</option>
                           <option value="8">E-mail Marketing</option>
                           <option value="9">Anúncio Online</option>
                           <option value="10">Notícia ou Blog</option>
                           <option value="11">Podcast</option>
                           <option value="14">Publicidade Impressa</option>
                           <option value="1">LinkedIn</option>
                           <option value="2">Instagram</option>
                           <option value="3">Facebook</option>
                           <option value="4">YouTube</option>
                           <option value="15">Outro</option>
                       </select>

                       <!-- Inserir email -->
                       <div class="mb-4 mt-4">
                           <label for="exampleInputEmail1" class="form-label">Endereço de Email:</label>
                           <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                           <div id="emailHelp" class="form-text"><small>Nunca iremos compartilhar seus dados com ninguém.</small>
                           </div>
                         </div>

                        <!-- Inserir proposta de formação -->
                       <div class="mb-4 mt-4">
                           <label for="propostaFormacao" class="form-label proposta">Breve descrição da sua proposta de formação:</label>
                           <textarea class="form-control" id="propostaFormacao" rows="3"></textarea>
                       </div>

                       <button type="submit" class="btn btn-primary mt-md-4 mt-4 btn-send">Enviar</button>
                   </form>

               </div>


           </div>
       </div>
   </section>

@endsection
