<template>
    <form id="form__login" class="active flex-column">

        <!-- Input - Email -->
        <div id="email" class="base__input">
            <input v-model="email" type="email" name="email" id="login__email" autocomplete="off" required>
            <label for="login__email"><i class="fas fa-at"></i> Email:</label>
        </div>

        <!-- Input - Senha -->
        <div id="senha" class="base__input">
            <input v-model="senha" type="password" name="senha" id="login__senha" autocomplete="off" required>
            <label for="login__senha"><i class="fas fa-lock"></i> Senha: <i @click="$emit('verSenha', '#login__senha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
        </div>

        <!-- Checkbox - Lembre-se de mim -->
        <div id="lembre-se" class="base__check">
            <input v-model="check" type="checkbox" name="lembre-se" id="login__lembre-se">
            <label for="login__lembre-se">Lembre-se de mim</label>
        </div>

        <!-- Botão Enviar -->
        <button @click.prevent="logarUsuario()" type="button" class="button btn__padrao btn__enviar">Logar</button>
    
        <Alert ref="alert" />
    </form>
</template>

<script>
import Ajax from "../../../mixins/ajax.js";

import Alert from '../alert.vue';

export default {
    name: "LoginForm",
    data () {
        return {
            senha: '',
            email: '',
            check: false
        }
    },
    mixins: [Ajax],
    methods: {

        // Efetua o login do usuário
        async logarUsuario () {
            let dados = {
                email: this.email,
                senha: this.senha,
                remember: this.check
            }

            let retorno = await this.ajax({
                url: '/login/do', 
                method: 'post',
                dado: dados,
                seletorInput: "form#form__login",
                loader: '#form__login .button.btn__enviar'
            });

            if (retorno) {
                window.location.href = '/minhaconta';
            }
        }
    },

    components: {
        Alert
    }
}
</script>