<template>
<div class="d-flex flex-column flex-nowrap">
    <Menu/>

    <section id="sessao__principal" class="content-fluid w-100">

        <!-- Cabeçalho -->
        <div id="cabecalho" class="d-flex flex-column flex-nowrap">

            <!-- Cabeçalho - Titulo -->
            <p class="subtitulo">Primeiramente, faça login ou cadastre-se em nosso site.</p>

            <!-- Cabeçalho - Ilustração -->
            <img class="mt-4" src="/img/ilustracoes/login.svg" alt="Login">
        </div>

        <div class="content d-flex flex-column">

            <!-- Tabs - Botões -->
            <div id="tabs__login" class="base__tabs">
                <button @click="tabs('#form__login', $event.target)" id="tabs__login" class="tabs__item active">Login</button>
                <button @click="tabs('#form__cadastro', $event.target)" id="tabs__cadastro" class="tabs__item">Cadastrar</button>
            </div>

            <!-- Tabs - Conteúdo -->
            <div id="formularios">
                <LoginForm @verSenha="verSenha"/>
                <CadastroForm @verSenha="verSenha" @tabs="tabs"/>
                
                <EsqueceuSenha/>
            </div>
        </div>
    </section>

    <Alert ref="alert"/>
    <Copyright/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import Copyright from './components/copyright.vue';
import LoginForm from './components/login/loginForm.vue';
import CadastroForm from './components/login/cadastroForm.vue';
import EsqueceuSenha from './components/login/esqueceuSenha.vue';
import Alert from './components/alert.vue';

export default {
    name: "Login",
    data () {
        return {
            
        }
    },
    components: {
        Menu,
        Copyright,
        LoginForm,
        CadastroForm,
        EsqueceuSenha,
        Alert
    },
    methods: {

        // Alterna entre os tabs
        tabs (selector, e) {
            this.tabsReset('#formularios form', e);

            e.classList.add("active");
            document.querySelector(selector).classList.add('active');
        },

        // Reseta os tabs
        tabsReset (selector) {
            this.$refs.alert.limpar();
            let elements = document.querySelectorAll(selector);
            let tabs__item = document.querySelectorAll("#tabs__login .tabs__item");

            for (let i = 0; i < elements.length; i++) {
                tabs__item[i].classList.remove("active");
                elements[i].classList.remove("active");
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