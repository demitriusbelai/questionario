<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Questionário</title>
  </head>
  <body>
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="navbar-brand mx-auto" href="#">Questionário</div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">%username%</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout"><ion-icon name="log-out"></ion-icon> Sair</a>
                </li>
            </ul>
        </div>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target=".navbar-collapse"><ion-icon name="menu"></ion-icon></button>
      </nav>
    </header>
    <main id="main" role="main">
      <div class="container-fluid" v-show="!resultado">
        <h1 class="jumbotron-heading">Questão {{ atual }}/{{ numTotal }}</h1>
        <div class="row">
          <div class="col-sm">
            {{ pergunta }}
          </div>
          <div class="col-sm" id="multimidia" v-html="multimidia">
          </div>
          <div id="respostas" class="col-sm">
            <ol type="a" class="respostas" v-bind:class="{desativado : respostasDadas.length > 2 || correta != null}">
              <resposta-item v-for="resposta in respostas" v-bind:resposta="resposta" v-bind:key="resposta.id" v-on:responder="responder(resposta.id)" v-bind:wrong="respostasDadas.includes(resposta.id)" v-bind:correct="resposta.id == correta" v-bind:enabled="respostasDadas.length < 3 && correta == null"></resposta-item>
            </ol>
            <div id="enviando" v-show="enviando">
              <div class="spinner spinner-border text-secondary" style="width: 10rem; height: 10rem; margin: auto" role="status">
                <span class="sr-only">Enviando...</span>
              </div>
            </div>
            <div v-show="proxima">
              <button type="button" class="btn btn-primary" v-on:click="carregarPergunta">Próxima<ion-icon name="play" v-pre></ion-icon></button>
            </div>
          </div>
        </div>
      </div>
      <div id="resultado" class="container-fluid" v-show="resultado">
        <h1 class="jumbotron-heading">Resultado {{ acertos }}/{{ numTotal }}</h1>
        <button type="button" class="btn btn-primary" v-on:click="reiniciar">Reiniciar<ion-icon name="refresh" v-pre></ion-icon></button>
      </div>
      <div id="loading" v-show="carregando">
        <div class="spinner spinner-border text-secondary" style="width: 10rem; height: 10rem; margin: auto" role="status">
          <span class="sr-only">Carregando...</span>
        </div>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>
