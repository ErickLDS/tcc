<template>
<div class="d-flex flex-column flex-nowrap">
    <Menu ref="menu"/>

    <section id="sessao__principal">
        
        <!-- Montar Churros -->
        <MontarChurros/>
        
        <!-- Pré Definidos -->
        <PreDefinidos @atualizarCarrinho="atualizarCarrinho"/>
    </section>

    <Rodape/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import MontarChurros from './components/index/montarChurros.vue';
import PreDefinidos from './components/index/preDefinidos.vue';
import Rodape from './components/rodape.vue';

export default ({
    name: "App",
    data () {
        return {
           
        }
    },
    components: {
        Menu,
        Rodape,
        MontarChurros,
        PreDefinidos
    },
    methods: {

        // Atualiza o preço total do carrinho
        atualizarCarrinho () {
            this.$refs.menu.getCarrinho();
        }
    }
})
</script>
