<template>
<div class="d-flex flex-column">
    <Menu/>

    <section id="sessao__principal" class="d-flex w-100 justify-content-center">

        <!-- Redefinir Senha -->
        <div id="nova__senha" class="d-flex flex-column">

            <!-- Redefinir Senha - Título -->
            <p class="subtitulo">Pronto! Agora você pode redefinir sua senha.</p>

            <!-- Redefinir Senha - Input Senha -->
            <div id="senha" class="base__input">
                <input v-model="senha" type="password" name="password" id="input__senha" autocomplete="off" required>
                <label for="input__senha"><i class="fas fa-lock"></i> Senha: <i @click="verSenha('#input__senha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
            </div>

            <!-- Redefinir Senha - Input Confirmar Senha -->
            <div id="confirmar__senha" class="base__input">
                <input v-model="confirmarSenha" type="password" name="password_confirmation" id="input__confirmarSenha" autocomplete="off" required>
                <label for="input__confirmarSenha"><i class="fas fa-lock"></i> Confirmar Senha: <i @click="verSenha('#input__confirmarSenha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
            </div>

            <!-- Redefinir Senha - Botão enviar -->
            <button @click="redefinirSenha()" class="button btn__padrao btn__confirmar">Redefinir <i class="icon__right fas fa-check"></i></button>
        </div>
    </section>

    <Alert ref="alert"/>
    <Copyright/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import Copyright from './components/copyright.vue';
import Alert from './components/alert.vue';

import Ajax from '../mixins/ajax.js';

export default {
    name: "RedefinirSenha",
    data () {
        return {
            senha: '',
            confirmarSenha: ''
        }
    },
    mixins: [Ajax],
    methods: {

        // Define a nova senha do usuário
        async redefinirSenha() {
            let dados = {
                email: (window.location.href.split('/'))[5],
                password: this.senha,
                password_confirmation: this.confirmarSenha,
                token: (window.location.href.split('/'))[4]
            }

            let retorno = await this.ajax({
                url: '/novasenha',
                method: 'post',
                dado: dados,
                seletorInput: '#nova__senha',
                loader: '#nova__senha .button.btn__confirmar'
            })

            if (retorno) {
                window.location.href = '/login';
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
    },
    components: {
        Menu,
        Copyright,
        Alert
    }
}
</script>