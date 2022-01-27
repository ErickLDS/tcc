<template>
<div class="d-flex flex-column flex-nowrap">
    
    <section id="sessao__principal" class="d-flex flex-column justify-content-center w-100">
        
        <div id="form__login" class="d-flex flex-column align-items-center">
            <p class="titulo">Login</p>

            <!-- Input - Email -->
            <div id="email" class="base__input">
                <input v-model="email" type="email" name="email" id="login__email" autocomplete="off">
                <label for="login__email"><i class="fas fa-at"></i> Email:</label>
            </div>

            <!-- Input - Senha -->
            <div id="senha" class="base__input">
                <input v-model="senha" type="password" name="senha" id="login__senha" autocomplete="off">
                <label for="login__senha"><i class="fas fa-lock"></i> Senha: <i @click="verSenha('#login__senha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
            </div>

            <!-- Botão Enviar -->
            <button @click="logarAdmin()" type="button" class="button btn__padrao btn__enviar mt-5">Logar</button>
        
            <Alert ref="alert" />
        </div>
    </section>

    <Alert ref="alert"/>
    <Copyright/>
</div>
</template>

<script>
import Copyright from './components/copyright.vue';
import Alert from './components/alert.vue';

import Ajax from '../mixins/ajax.js';

export default {
    name: "Login",
    data () {
        return {
            email: '',
            senha: ''
        }
    },
    components: {
        Copyright,
        Alert
    },
    mixins: [Ajax],
    methods: {

        // Efetua o login do admin
        async logarAdmin () {
            let dados = {
                email: this.email,
                senha: this.senha
            }

            let retorno = await this.ajax({
                url: '/dashboard/login/do', 
                method: 'post',
                dado: dados,
                seletorInput: "#form__login",
                loader: '#form__login .button.btn__enviar'
            });

            if (retorno) {
                window.location.href = '/ck10dashboard';
            }
        },

        // Deixa os dados do campo de senha visivel ou escondido
        verSenha(selector, e) {
            let element = document.querySelector(selector);

            if (element.type == "password") {
                element.type = "text";
                e.classList.remove("fa-eye-slash");
                e.classList.add("fa-eye");
            } else {
                element.type = "password";
                e.classList.add("fa-eye-slash");
                e.classList.remove("fa-eye");
            }
        }
    }
}
</script>