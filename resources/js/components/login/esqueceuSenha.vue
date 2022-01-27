<template>
    <div id="esqueceu__senha" class="d-flex flex-column flex-nowrap align-self-center w-100">

        <!-- Titulo -->
        <p class="text-center">Esqueceu sua senha?</p>

        <!-- Botão -->
        <button onclick="window.location.href='/redefinirsenha'" type="button" class="button align-self-center">Redefinir senha</button>
    </div>
</template>

<style scoped>
#esqueceu__senha {
    margin-top: 60px;
}

#esqueceu__senha p {
    color: var(--cor-texto);
    font-size: 1.2em;
    font-weight: 400;
}

#esqueceu__senha button{
    padding: 10px 0;
    width: clamp(180px, 80%, 240px);
    color: var(--cor-texto);
    background-color: transparent;
    font-size: 1.1em;
    border: 2px solid var(--cor-texto);
    box-shadow: none;
}
</style>

<script>
export default {
    name: "EsqueceuSenha",
    data () {
        return {

        }
    }
}
</script>