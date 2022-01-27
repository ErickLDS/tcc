<template>
<div class="d-flex flex-column">
    <div id="content" class="d-flex">

        <!-- Menu -->
        <DashboardMenu/>

        <section id="sessao__principal" class="d-flex justify-content-center mx-auto">
            <!-- Pedidos -->
            <Pedidos v-if="this.link == null"/>

            <!-- Sabores -->
            <Sabores v-if="this.link == 'sabores'"/>

            <!-- Tipos de Sabores -->
            <TiposSabores v-if="this.link == 'tipossabores'"/>
        </section>
    </div>

    <Copyright/>
</div>
</template>

<script>
import DashboardMenu from './components/dashboardMenu.vue';
import Copyright from './components/copyright.vue';

import Pedidos from './components/dashboard/pedidos.vue';
import TiposSabores from './components/dashboard/tiposSabores.vue';
import Sabores from './components/dashboard/sabores.vue';

export default {
    name: "Dashboard",
    data () {
        return {
            link: null
        }
    },

    // Gerenciamento de sub rotas
    mounted () { 
        this.link = (window.location.href.split("/"))[4];

        if (!(this.link == 'sabores' || this.link == 'tipossabores')) {
            this.link = null;
        }
    },
    components: {
        Pedidos,
        TiposSabores,
        Sabores,
        DashboardMenu,
        Copyright
    }
}
</script>