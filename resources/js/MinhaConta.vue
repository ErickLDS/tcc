<template>
<div class="d-flex flex-column">
    <Menu/>

    <section id="sessao__principal" class="d-flex flex-column w-100">

        <div class="content d-flex flex-column">
            <!-- Tabs -->
            <div id="tabs" class="base__tabs">
                <button @click="tabs('#pedidos', $event.target)" id="tabs__pedidos" class="tabs__item active">Pedidos</button>
                <button @click="tabs('#perfil', $event.target)" id="tabs__perfil" class="tabs__item">Perfil</button>
            </div>

            <!-- Formulário -->
            <div id="tabs__content">
                <Pedidos/>
                <Perfil/>
            </div>
        </div>
    </section>

    <Rodape/>
</div>
</template>

<script>
import Perfil from './components/minhaConta/perfil.vue';
import Pedidos from './components/minhaConta/pedidos.vue';
import Menu from './components/menu.vue';
import Rodape from './components/rodape.vue';

export default {
    name: "MinhaConta",
    data () {
        return {
            
        }
    },
    components: {
        Perfil,
        Pedidos,
        Menu,
        Rodape
    },
    mounted () {
        if ((window.location.href.split("/").splice(4,1))[0] == 'perfil') {
            this.tabs("#perfil", document.querySelector("#tabs__perfil"));
        }
    },
    methods: {
        
        // Alterna entre os tabs
        tabs (selector, e) {
            this.tabsReset('#tabs__content .tabs__content__item', e);

            e.classList.add("active");
            document.querySelector(selector).classList.add('active');
        },

        // Reseta os tabs
        tabsReset (selector) {
            let elements = document.querySelectorAll(selector);
            let tabs__item = document.querySelectorAll("#tabs .tabs__item");

            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.remove("active");
            }

            for (let i = 0; i < tabs__item.length; i++) {
                tabs__item[i].classList.remove("active");
            }
        },
    }
}
</script>