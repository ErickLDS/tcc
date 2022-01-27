<template>
<div class="d-flex flex-column">
    <Menu/>

    <section id="sessao__principal" class="d-flex w-100 justify-content-center">

        <!-- Confirmar Email -->
        <div v-if="!check" id="confirmar__email" class="d-flex flex-column">

            <!-- Confirmar Email - Título -->
            <p class="subtitulo">Primeiro, precisamos confirmar o seu email.</p>

            <!-- Confirmar Email - Subtítulo -->
            <p class="subtitulo__text">Será enviado um email com um código de confirmação.</p>

            <!-- Confirmar Email - Input Email -->
            <div class="base__input">
                <input v-model="email" name="email" type="email" id="input__email">
                <label for="input__email"><i class="icon__left fas fa-at"></i> Email:</label>
            </div>

            <!-- Confirmar Email - Botão enviar -->
            <button @click="confirmarEmail()" class="button btn__padrao btn__confirmar">Enviar <i class="icon__right fas fa-check"></i></button>
        </div>

        <!-- Email Enviado -->
        <div id="email__enviado" v-if="check" class="d-flex flex-column ">

            <!-- Email Enviado - Ilustração -->
            <img class="img" src="/img/ilustracoes/email.svg" alt="Email">

            <!-- Email Enviado - Subtítulo -->
            <p class="subtitulo__text">O Email foi enviado, confira sua caixa de entrada.</p>
        </div>
    </section>

    <Alert ref='alert'/>
    <Copyright/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import Copyright from './components/copyright.vue';
import Alert from './components/alert.vue';

import Ajax from '../mixins/ajax.js';

export default {
    name: "ConfimarEmail",
    data () {
        return {
            email: '',
            check: false
        }
    },
    mixins: [Ajax],
    methods: {

        // Confirma o Email do usuário
        async confirmarEmail () {
            let retorno = await this.ajax({
                url: '/confirmarEmail',
                method: 'post',
                dado: {email: this.email},
                seletorInput: '#confirmar__email',
                loader: '#confirmar__email .button.btn__confirmar'
            });

            if (retorno) {
                this.check = true;
            } else {
                this.check = false;
            }
        }
    },
    components: {
        Menu,
        Copyright,
        Alert
    }
}
</script>