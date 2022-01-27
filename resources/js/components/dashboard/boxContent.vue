<template>
<div :id="conteudo.nome" class="box__item">
    
    <!-- Box - Titulo -->
    <p class="titulo">{{conteudo.nome}}:</p>

    <!-- Box - Item -->
    <div class="base__item" v-for="item in conteudo.itens" :key="item">

        <!-- Item - Titulo -->
        <p v-if="item.adicional" class="base__item__adicional">+R${{item.adicional.toFixed(2).replace(".", ",")}}</p>
        <p @click="this.$emit('openEditar', item), this.$emit('definirTipo', conteudo.id, conteudo.nome)" class="base__item__nome">{{item.nome}}</p>
        
        <!-- Item - Botões -->
        <button @click="this.$emit('openEditar', item), this.$emit('definirTipo', conteudo.id, conteudo.nome)" id="btn__editar" class="button base__item__option"><i class="fas fa-eye"></i></button>
        <button @click="this.$emit('openExcluir', item.id, item.nome), this.$emit('definirTipo', conteudo.id, conteudo.nome)" id="btn__excluir" class="button base__item__option"><i class="fas fa-trash"></i></button>
    </div>

    <!-- Box - Botão adicionar -->
    <button @click="this.$emit('openAdicionar'), this.$emit('definirTipo', conteudo.id, conteudo.nome)" id="btn__adicionar" class="button btn__padrao btn__confirmar w-100">Adicionar <i class="icon__right fas fa-plus"></i></button>
</div>
</template>

<script>
export default {
    name: "BoxContent",
    data () {
        return {

        }
    },
    props: {
        conteudo: Object
    }
}
</script>