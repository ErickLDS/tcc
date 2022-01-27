<template>
<div class="churros__item">
    <div class="churros__header d-flex flex-row justify-content-between">

        <!-- Churros - Nome -->
        <p @click="$emit('editarChurros', index)" class="churros__title">Churros {{definirNome()}}</p>

        <!-- Churros - Botão Excluir -->
        <button v-if="qtd > 1" @click="$emit('openModel')" class="button btn__excluir">Excluir</button>
    </div>
    
    <!-- Churros - Opções -->
    <div @click="$emit('editarChurros', index)" v-if="churros.codigo.length > 0 && tipos.length > 0" class="churros__content d-flex flex-row flex-wrap justify-content-center">
        <div v-for="(item, index) in churros.codigo" :key="item" class="churros__content__item">
            <span v-if="tipos[index]">{{tipos[index].nome}}:</span>
            <p v-if="item.nome != null">{{item.nome}}</p>
            <p v-if="item.nome == null"><br></p>
        </div>
    </div>

    <div class="churros__body d-flex flex-row justify-content-between">

        <!-- Churros - Preço -->
        <p class="churros__preco align-self-center">R${{(churros.preco * churros.qtd).toFixed(2).replace(".", ",")}}</p>
        
        <!-- Churros - Definir Quantidade -->
        <div class="churros__qtd d-flex flex-row">
            <button @click="$emit('definirQtd', index, 'menos')" class="churros__qtd__menos">-</button>
            <p>{{churros.qtd}}</p>
            <button @click="$emit('definirQtd', index, 'mais')" class="churros__qtd__mais">+</button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Churros",
    data () {
        return {
            
        }
    },
    props: {
        churros: Object,
        tipos: Array,
        index: Number,
        qtd: Number
    },
    methods: {

        // Define o nome do churros dinamicamente
        definirNome () {
            let nome;
            this.churros.codigo.forEach((e) => {
                if (e.nome != undefined) {
                    nome = e.nome;
                }
            });
            return nome;
        }
    }
}
</script>