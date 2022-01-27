<template>
    <div class="slider__item opcoes">

        <!-- Slider - Titulo -->
        <p class="subtitulo">{{sabor.nome}} do churros:
            <span v-if="sabor.opcional == 1"><br/>(Opcional)</span>
        </p>

        <div class="d-flex flex-row flex-wrap justify-content-center mb-5">
            <div v-for="item in itens" :key="item" class="opcoes__container">

                <!-- Opção - Nome -->
                <p class="opcoes__item" @click="$emit('adicionarChurros', item, $event.target)" :value="item.id">{{item.nome}}</p>

                <!-- Opção - Tag Adicional -->
                <span @click="$emit('adicionarChurros', item, $event.target)" v-if="item.adicional" class="opcoes__adicional">+R${{item.adicional.toFixed(2).replace('.', ',')}}</span>
                
                <!-- Opção - Botão Excluir -->
                <span v-if="sabor.opcional == 1" @click="this.$emit('opcoesExcluir', item.id)" class="opcoes__excluir">x</span>
            </div>
        </div>

        <!-- Botões de navegação do slider -->
        <button v-if="sabor.opcional == 1" @click="this.$emit('sliderProximo')" id="btn__proximo" class="button btn__padrao mb-4">Próximo <i class="icon__right fas fa-chevron-right"></i></button>
        <button v-if="index > 0" @click="this.$emit('sliderAnterior')" id="btn__voltar" class="button btn__padrao"><i class="icon__left fas fa-chevron-left"></i> Voltar</button>
    </div>
</template>

<script>
import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Sabores",
    data () {
        return {
            itens: Array
        }
    }, 
    mixins: [Ajax],

    // Pega as informações do Banco de Dados
    async beforeMount () {
        this.itens = await this.ajaxGet("/sabores/get/"+this.sabor.id);
    },

    props: {
        sabor: Object,
        index: Number
    }
}
</script>