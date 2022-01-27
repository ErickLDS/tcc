<template>
    <form id="form__cadastro" class="flex-column">

        <!-- Input - Nome -->
        <div id="nome" class="base__input">
            <input v-model="nome" type="text" name="nome" id="cadastro__nome" autocomplete="off" required>
            <label for="cadastro__nome"><i class="fas fa-user"></i> Nome:</label>
        </div>

        <!-- Input - Email -->
        <div id="email" class="base__input">
            <input v-model="email" type="email" name="email" id="cadastro__email" autocomplete="off" required>
            <label for="cadastro__email"><i class="fas fa-at"></i> Email:</label>
        </div>

        <!-- Input - Senha -->
        <div id="senha" class="base__input">
            <input v-model="senha" type="password" name="senha" id="cadastro__senha" autocomplete="off" required>
            <label for="cadastro__senha"><i class="fas fa-lock"></i> Senha: <i @click="$emit('verSenha', '#cadastro__senha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
        </div>

        <!-- Input - Confirmar Senha -->
        <div id="confirmar__senha" class="base__input">
            <input v-model="confirmarSenha" type="password" name="senha_confirmation" id="cadastro__confirmarSenha" autocomplete="off" required>
            <label for="cadastro__confirmarSenha"><i class="fas fa-lock"></i> Confirmar Senha: <i @click="$emit('verSenha', '#cadastro__confirmarSenha', $event.target)" class="base__verSenha fas fa-eye-slash" title="Ver Senha"></i></label>
        </div>

        <!-- Termos e condições -->
        <div id="termos" class="base__check">
            <input v-model="check" type="checkbox" name="termos" id="cadastro__termos">
            <label for="cadastro__termos">Eu li e concordo com os <a href="/politicas">Termos e Condições.</a></label>
        </div>

        <!-- Botão enviar -->
        <button @click.prevent="cadastrarUsuario()" type="button" class="button btn__padrao btn__enviar">Cadastrar</button>

        <Alert ref="alert" />
    </form>
</template>

<script>
import Ajax from "../../../mixins/ajax.js";

import Alert from '../alert.vue';

export default {
    name: "CadastroForm",
    data () {
        return {
            nome: '',
            email: '',
            senha: '',
            confirmarSenha: '',
            check: false
        }
    },
    mixins: [Ajax],
    methods: {

        // Efetua o cadastramento do usuário
        async cadastrarUsuario () {
            let dados = {
                nome: this.nome,
                email: this.email,
                senha: this.senha,
                senha_confirmation: this.confirmarSenha
            }

            if (this.check) {
                let retorno = await this.ajax({
                    url: '/login/set', 
                    method: 'post',
                    dado: dados,
                    seletorInput: "form#form__cadastro",
                    loader: '#form__cadastro .button.btn__enviar'
                });

                if (retorno) {
                    this.nome = '';
                    this.email = '';
                    this.senha = '';
                    this.confirmarSenha = '';
                    window.location.href = '/minhaconta';
                }
            } else {
                this.$refs.alert.definirAlert({texto: "Você precisa concordar com os termos e condições para utilizar nosso site.",
                tipo: "erro",
                delay: 4});
            }
        }
    },
    components: {
        Alert
    }
}
</script>