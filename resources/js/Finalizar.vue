<template>
<div class="d-flex flex-column">
    <Menu @atualizarPreco="atualizarPreco"/>

    <section id="sessao__principal">
        <div id="conteudo" class="container d-flex flex-column">

            <!-- Total do pedido -->
            <p id="total" class="text-center">Total <span id='frete'>(com frete)</span>: <br/><span id="preco">R${{(pedido.total.toFixed(2).replace(".", ","))}}</span></p>

            <!-- Sliders -->
            <div id="slider" class="d-flex align-self-center">

                <!-- Slider - Endereço -->
                <Endereco ref="enderecoForm"
                @btnConfirmar="btnConfirmar"/>

                <!-- Slider - Pagamento -->
                <Pagamento ref="formaPagamento" :total="pedido.total"
                @btnConfirmar="btnConfirmar" @sliderAnterior="sliderAnterior"/>
            </div>
        </div>
    </section>

    <Alert ref="alert"/>
    <Copyright/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import Copyright from './components/copyright.vue';
import Endereco from './components/finalizar/endereco.vue';
import Pagamento from './components/finalizar/pagamento.vue';

import Alert from './components/alert.vue';

import Ajax from '../mixins/ajax.js';
import Sliders from '../mixins/sliders.js';

export default {
    name: "Finalizar",
    data () {
        return {
            pedido: {
                endereco: Object,
                formaPagamento: Object,
                churros: Array,
                total: 0
            }
        }
    },
    mixins: [Ajax, Sliders],
    components: {
        Menu,
        Copyright,
        Endereco,
        Pagamento,
        Alert
    },

    // Redireciona o usuário caso o carrinho esteja vazio. Pega as informações do carrinho.
    beforeMount () {
        if (localStorage.getItem('carrinho')) {
            this.pedido.churros = JSON.parse(localStorage.getItem('carrinho'));
            this.atualizarPreco();
        } else {
            window.location.href = "/";
        }
    },
    mounted () {
        this.getSliders();
    },
    methods: {

        // Efetua o pedido
        async efetuarPedido () {
            let dados = {
                valor_final: this.pedido.total,
                troco: this.pedido.formaPagamento.troco,
                id_forma_pagamento: this.pedido.formaPagamento.id,
                cep: this.pedido.endereco.cep,
                rua: this.pedido.endereco.rua,
                bairro: this.pedido.endereco.bairro,
                cidade: this.pedido.endereco.cidade,
                num: this.pedido.endereco.num,
                telefone: this.pedido.endereco.telefone,
                obs: this.pedido.endereco.obs,
                churros: this.pedido.churros
            }

            let retorno = await this.ajax({
                url: '/pedido/set',
                method: "post",
                dado: dados
            });

            if (retorno) {
                localStorage.removeItem("carrinho");
                window.location.href = "/minhaconta/pedidos";
            }
        },

        // Ações do botão confirmar
        async btnConfirmar () {

            // Slider - Endereço
            if (this.sliderAtual == 0) {
                if (this.pedido.endereco = await this.$refs.enderecoForm.getDados()) {
                    this.sliderProximo();
                }

            // Slider - Pagamento
            } else if (this.sliderAtual == 1) {
                if (this.pedido.formaPagamento = await this.$refs.formaPagamento.getDados()) {
                    this.efetuarPedido();
                }
            }
        },

        // Atualiza o Preço do pedido
        async atualizarPreco () {
            this.pedido.churros = JSON.parse(localStorage.getItem('carrinho'));
            this.pedido.total = await this.ajaxGet('/getpreco/'+JSON.stringify(this.pedido.churros));
        }
    }
}
</script>