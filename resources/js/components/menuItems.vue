<template>
    <div id="menu__content">
        <a v-if="!(this.check)" class="menu__item" href="/">Início</a>
        <a v-if="!(this.check)" class="menu__item" href="/login">Login/Cadastro</a>
        <a v-if="this.check" class="menu__item" href="/minhaconta">Meus Pedidos</a>
        <a v-if="this.check" class="menu__item" href="/minhaconta/perfil">Meu Perfil</a>
        <a class="menu__item" href="/montarchurros">Montar Churros</a>
        <a v-if="this.check" @click="logoutUser()" class="menu__item">Logout</a>
    </div>
</template>

<script>
import User from '../../mixins/user.js';

export default {
    name: "MenuItems",
    data () {
        return {
            
        }
    },
    mixins: [User],
    methods: {

        // Efetua o logout do usuário
        async logoutUser() {
            let retorno = await this.logout();

            if (retorno) {
                this.check = false;
            }
        }
    },
    props: {
        check: Boolean
    }
}
</script>