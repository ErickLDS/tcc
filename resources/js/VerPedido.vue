<template>
<div class="d-flex flex-column">
    <Menu/>

    <section id="sessao__principal" class="d-flex flex-column">
        <div v-if="pedido" id="pedido__info">

            <!-- Pedido - Data -->
            <p id="pedido__data" class="text-center">Pedido feito em:<br/>
            <span>{{new Date(pedido.data).toLocaleDateString()}} - {{new Date(pedido.data).toLocaleTimeString()}}</span></p>

            <div id="pedido__info" class="d-flex flex-row flex-nowrap justify-content-between">
                
                <!-- Pedido - Total -->
                <p id="pedido__total">Total: <br/>
                <span>R${{pedido.total.toFixed(2).replace(".", ",")}}</span></p>

                <!-- Pedido - Status -->
                <div class="pedido__status d-flex flex-column">
                    <p class="status__title text-center">Status:</p>

                    <!-- Status -->
                    <span :style="'background-color: '+pedido.status.cor" class="button info__status">{{pedido.status.nome}}</span>
                </div>
            </div>
        </div>

        <div v-if="pedido" class="d-flex flex-column justify-content-center">
            <!-- Churros -->
            <div id="pedido__churros" class="d-flex flex-column">

                <!-- Churros - Titulo -->
                <p class="subtitulo">Pedido:</p>

                <CardChurros v-for="(item, index) in pedido.churros" :key="item" 
                :precoChurros="item.preco"
                :qtdChurros="item.quantidade"
                :cardChurros="item" 
                :index="index"/>
            </div>

            <!-- Forma de pagamento -->
            <div id="pedido__pagamento" class="d-flex flex-column">

                <!-- Forma de pagamento - Titulo -->
                <p class="subtitulo">Método de pagamento:</p>

                <!-- Forma de pagamento - Observação-->
                <p class="subtitulo__text">O pagamento deve ser efetuado com o motoboy.</p>

                <!-- Forma de pagamento -->
                <div class="pagamento__item d-flex flex-column">
                    
                    <label v-if="pedido.troco" class="button btn__padrao troco"><i :class="'icon__left '"></i> {{pedido.pagamento.nome}}</label>
                    <label v-if="!pedido.troco" class="button btn__padrao"><i :class="'icon__left '+pedido.pagamento.icone"></i> {{pedido.pagamento.nome}}</label>
                    
                    <!-- Input - Troco -->
                    <div v-if="pedido.troco" class="base__input">
                        <input :value='pedido.troco' v-maska="'R$#*!,##'" type="text" readonly>
                        <label>Troco Para:</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback -->
        <div v-if="pedido" id="pedido__feedback" class="d-flex flex-column">

            <!-- Feedback - Titulo -->
            <p class="titulo">Gostou do nosso atendimento?</p>

            <!-- Feedback - Ilustração -->
            <img src="/img/ilustracoes/feedback.svg" alt="Feedback">

            <!-- Feedback - Subtitulo -->
            <p class="subtitulo__text">Então não deixe os seus amigos de fora, compartilhe com eles!</p>
            
            <!-- Feedback - Botões -->
            <div id="redes__sociais" class="d-flex flex-row justify-content-center">
                <i class="redes__sociais__item fab fa-facebook-f" onclick=""></i>
                <i class="redes__sociais__item fab fa-whatsapp" onclick=""></i>
                <i class="redes__sociais__item fab fa-instagram" onclick=""></i>
            </div>
        </div>
    </section>

    <Rodape/>
</div>
</template>

<script>
import CardChurros from './components/cardChurros.vue';
import Menu from './components/menu.vue';
import Rodape from './components/rodape.vue';

import Ajax from '../mixins/ajax.js';

export default {
    name: "VerPedido",
    data () {
        return {
            pedido: false
        }
    },
    mixins: [Ajax],
    async mounted () {
        let id = window.location.href.split("/")[4];
        this.pedido = await this.ajaxGet('/pedido/get/'+id);
    },
    methods: {

        // Pega as informações do pedido através do ID
        getPedido (id) {
            this.pedido = {id: 0, data: "05/10/2021", hora: "15:41", total: 24, status: "em processo", churros: [{"codigo":[1,2,3,4],"preco":10,"qtd":2,"nome":"Churros Kit Kat"}], pagamento: {forma: 0, dinheiro: 15}};
        },
    },
    components: {
        CardChurros,
        Menu,
        Rodape
    }
}
</script>