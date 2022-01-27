<template>
    <div id="pagamento" class="slider__item">

        <!-- Titulo do slider -->
        <p class="subtitulo">Escolha O Método De Pagamento:</p>

        <!-- Observação -->
        <p class="subtitulo__text text-center">OBS: O pagamento deve ser efetuado com o motoboy.</p>

        <!-- Formas de Pagamento -->
        <div v-for="item in formaPagamento" :key="item" :id="item.nome" class="pagamento__item d-flex flex-column">
            <input v-model="dados.forma" :id="'pagamento__'+item.nome+item.id" :value="item.id" name="forma_pagamento" type="radio" class="d-none">
            
            <label v-if="item.troco" :for="'pagamento__'+item.nome+item.id" class="button btn__padrao troco"><i :class="'icon__left '+item.icone"></i> {{item.nome}}</label>
            <label @click="this.dados.troco = null" v-if="!item.troco" :for="'pagamento__'+item.nome+item.id" class="button btn__padrao"><i :class="'icon__left '+item.icone"></i> {{item.nome}}</label>
            
            <!-- Input - Troco -->
            <div v-if="item.troco" class="base__input">
                <input v-model="dados.troco" type="text" v-maska="'R$#*!,##'">
                <label for="input__dinheiro">Troco Para:</label>
            </div>
        </div>
    
        <!-- Slider - Botões -->
        <div id="botoes" class="d-flex flex-column">
            <button @click="this.$emit('btnConfirmar')" id="btn__proximo" class="button btn__padrao">Confirmar <i class="icon__right fas fa-check"></i></button>
            <button @click="this.$emit('sliderAnterior')" id="btn__voltar" class="button btn__padrao"><i class="icon__left fas fa-chevron-left"></i> Voltar</button>
        </div>

        <Alert ref="alert" />
    </div>
</template>

<script>
import Alert from '../alert.vue';

import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Pagamento",
    data () {
        return {
            formaPagamento: [],
            dados: {
                forma: undefined,
                troco: ' '
            }
        }
    },
    mixins: [Ajax],
    async mounted () {
        this.formaPagamento = await this.ajaxGet("/pedido/formapagamento/get");
    },
    methods: {

        // Envia os dados após validar
        async getDados () {
            let dados = {
                id: this.dados.forma,
                troco: this.dados.troco,
                total: this.total
            }

            if (dados.troco != null) {
                dados.troco = parseFloat(this.dados.troco.replace('R$', '')).toFixed(2).replace(',', '.')
            }

            let retorno = await this.ajax({
                url: '/pedido/validar/pagamento',
                method: 'post',
                dado: dados,
                seletorInput: '.slider__item#pagamento',
                loader: '#pagamento #botoes #btn__proximo'
            });

            if (retorno) {
                return dados;
            } else {
                return false;
            }
        }
    },
    props: {
        total: Number
    },
    components: {
        Alert
    }
}
</script>