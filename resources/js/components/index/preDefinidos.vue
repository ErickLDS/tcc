<template>
    <div id="pre__definidos" class="d-flex flex-column flex-nowrap mx-auto">

        <!-- Titulo -->
        <p class="titulo text-center">Ou você prefere comprar churros pré montados?</p>

        <div class="container d-flex flex-column">

            <!-- Subtitulo -->
            <p class="subtitulo">Aqui estão algumas sugestões:</p>
        
            <!-- Cards -->
            <div id="card__preDefinidos" class="container justify-content-center d-flex">
                <CardChurros v-for="(item, index) in churrosPreDefinidos" :key="item"
                :cardChurros="item" 
                :qtdChurros="item.qtd"
                :precoChurros="item.preco"
                :index="index"
                :btnComprar="true"
                @atualizarCarrinho="atualizarCarrinho"
                @alert="alert"
                @alertLimpar="alertLimpar" />
            </div>
        </div>

        <Alert ref="alert"/>
    </div>
</template>

<script>
import CardChurros from '../cardChurros.vue';
import Alert from '../alert.vue';

import Ajax from '../../../mixins/ajax.js';

export default({
    name: "PreDefinidos",
    data () {
        return {
            churrosPreDefinidos: []
        }
    },
    components: {
        CardChurros,
        Alert
    },
    mixins: [Ajax],
    beforeMount () {
        this.getChurros();
    },
    methods: {

        // Gera churros pré-definidos
        async getChurros () {
            let sabores = await this.ajaxGet('/getrandom');
            sabores.forEach((e) => {
                this.churrosPreDefinidos.push({codigo: e.codigo, qtd: 1, nome: e.nome})
            });
        },

        // Atualiza o preço total do carrinho
        atualizarCarrinho () {
            this.$emit("atualizarCarrinho")
        },

        // Adiciona um alert
        alert (conteudo) {
            this.$refs.alert.definirAlert(conteudo);
        },

        // Limpa os alerts
        alertLimpar () {
            this.$refs.alert.limpar();
        }
    }
})
</script>

<style scoped>
#card__preDefinidos .cardChurros__item {
    margin: 0 20px;
    margin-bottom: 40px;
    width: clamp(240px, 100%, 300px);
}
</style>