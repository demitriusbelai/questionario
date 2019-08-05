
Vue.component('resposta-item', {
    props: ['resposta', 'wrong', 'correct', 'enabled'],
    template: `<li v-bind:class="{wrong : wrong, correct : correct, enabled : enabled && !wrong && !correct}" v-on:click="$emit('responder')">{{ resposta.resposta }}</li>`,
});
var app = new Vue({
    el: '#main',
    data: {
      pergunta: '',
      multimidia: '',
      respostas: [],
      respostasDadas: [],
      correta: null,
      terminou: false,
      enviando: false,
      carregando: true,
      proxima: false,
      atual: null,
      numTotal: null,
      acertos: null,
      resultado: false,
    },
    created: function() {
        this.carregarPergunta();
    },
    methods: {
        responder: function(id) {
            var app = this;
            if (app.respostasDadas.includes(id) || app.respostasDadas.length > 2) {
                return;
            }
            app.enviando = true;
            $.post({url: 'responder.php', data: {id: id}}).done(function (data) {
                app.enviando = false;
                if (!data.acertou) {
                    app.respostasDadas.push(data.respostas[data.respostas.length -1]);
                } else {
                    app.correta = data.respostas[data.respostas.length -1];
                }
                if (data.acertou || app.respostasDadas.length > 2) {
                    app.proxima = true;
                }
            });
        },
        carregarPergunta: function () {
            var app = this;
            app.carregando = true;
            app.proxima = false;
            $.ajax({url: 'pergunta.php'}).done(function (data) {
                if (data.acertos) {
                    app.acertos = data.acertos;
                    app.numTotal = data.total;
                    app.resultado = true;
                    app.carregando = false;
                    return;
                }
                app.pergunta = data.pergunta;
                app.multimidia = data.multimidia;
                app.correta = null;
                app.respostas = data.respostas;
                app.respostasDadas = data.respostasDadas;
                app.atual = data.atual;
                app.numTotal = data.numTotal;
                app.carregando = false;
            });
        },
        reiniciar: function() {
            var app = this;
            app.acertos = null;
            app.resultado = false;
            app.carregarPergunta();
        },
    },
});
