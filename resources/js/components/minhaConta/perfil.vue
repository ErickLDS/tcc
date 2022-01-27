<template>
    <div id="perfil" class="tabs__content__item">

        <!-- Ilustração -->
        <img class="align-self-center" src="/img/ilustracoes/perfil.svg" alt="Perfil">

        <!-- Titulo -->
        <p class="subtitulo__text">Veja e altere as informações da sua conta.</p>

        <!-- Input - Nome -->
        <div id="nome" class="base__input">
            <input v-model="nome" type="text" name="nome" id="perfil__nome" autocomplete="on" required>
            <label for="perfil__nome"><i class="fas fa-user-alt"></i> Nome:</label>
        </div>

        <!-- Input - Email -->
        <div id="email" class="base__input">
            <input v-model="email" type="email" name="email" id="perfil__email" autocomplete="off" required>
            <label for="perfil__email"><i class="fas fa-at"></i> Email:</label>
        </div>

        <!-- Botão Enviar -->
        <button @click="salvarAlteracoes()" id="btn__salvar" class="button btn__padrao">Salvar Alterações</button>

        <EsqueceuSenha/>

        <Alert ref="alert"/>
    </div>
</template>

<script>
import Alert from '../alert.vue';
import EsqueceuSenha from '../login/esqueceuSenha.vue';

import Ajax from '../../../mixins/ajax.js';
import User from '../../../mixins/user.js';

export default {
    name: "Perfil",
    data () {
        return {
            nome: "",
            email: ""
        }
    },
    mixins: [Ajax, User],
    async mounted () {
        let retorno = await this.verificarLogin();

        if (retorno) {
            this.nome = retorno.nome;
            this.email = retorno.email;
        }
    },
    methods: {

        // Salva os dados alterados no banco de dados
        async salvarAlteracoes () {
            let dados = {
                nome: this.nome,
                email: this.email
            }

            await this.ajax({
                url: '/login/edit',
                method: 'post',
                dado: dados,
                seletorInput: "#perfil",
                loader: '#btn__salvar'
            });
        },
        
        // Mensagem de erro
        alert (texto) {
            this.$refs.alert.definirAlert({texto: texto, tipo: "erro"});
        },
    },
    components: {
        Alert,
        EsqueceuSenha
    }
}
</script>