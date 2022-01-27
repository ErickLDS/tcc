<template>
<footer id="rodape" class="w-100">
    <div class="container d-flex">

        <!-- Estrutura do site -->
        <div id="estrutura__site" class="rodape__item">
            <p class="subtitulo">Estrutura do Site:</p>
            <a href="/">Início</a>
            <a href="/login">Login/Cadastro</a>
            <a href="/minhaconta">Minha Conta</a>
            <a href="/minhaconta/pedidos">Meus Pedidos</a>
            <a href="/montarchurros">Montar Churros</a>
            <a href="/politicas">Políticas de Privacidade</a>
        </div>
        
        <!-- Redes Sociais -->
        <div id="redes__sociais" class="rodape__item ">
            <p class="subtitulo">Redes Sociais:</p>
            <div class="content d-flex flex-row">
                <i class="fab fa-facebook"></i>
                <i class="fab fa-whatsapp"></i>
                <i class="fab fa-instagram"></i>
            </div>
        </div>

        <!-- Contato -->
        <div id="contato" class="rodape__item">
            <p class="subtitulo mb-4">Contato:</p>
            <p class="contato__item mb-1">Email: email@gmail.com</p>
            <p class="contato__item mb-1">Telefone: (11) 9999-9999</p>
            <p class="contato__item mb-1">Celular: (11) 99999-9999</p>
        </div>
    </div>

    <Copyright/>
</footer>
</template>

<style scoped>
#rodape {
    padding: 90px 0 0 0;
    background-color: #161616;
}

#rodape .container {
    padding: 0 60px;
    color: #fff;
    min-width: 200px;
    max-width: 1200px;
    flex-direction: column;
    justify-content: space-around;
}

#rodape .subtitulo {
    font-size: 1.3em;
    border-color: var(--cor-2);
    color: #fff;
    margin-bottom: 30px;
}

.rodape__item {
    display: flex;
    flex-direction: column;
    margin-bottom: 80px;
}


#estrutura__site a {
    font-weight: 300;
    color: #fff;
    font-size: 1.2em;
    margin-bottom: 5px;
}

#estrutura__site a:hover {
    color: #0496ff;
}


#redes__sociais i {
    font-size: 2.5em;
    margin-right: 35px;
    cursor: pointer;
    color: #fff;
}


.contato__item {
    font-size: 1.2em;
    font-weight: 300;
}

@media screen and (min-width: 800px) {
    #rodape .container {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .rodape__item {
        margin-bottom: 0px;
        align-self: flex-start;
    }
}
</style>

<script>
import Copyright from './copyright.vue';

export default {
    name: "Rodape",
    data () {
        return {
            
        }
    },
    components: {
        Copyright
    }
}
</script>