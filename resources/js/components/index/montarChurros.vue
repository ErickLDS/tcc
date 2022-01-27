<template>
    <div id="montar__churros" class="d-flex flex-column flex-nowrap mx-auto">

        <!-- Titulo -->
        <p class="titulo text-center">Está afim de novas experiências?</p>

        <div class="content-fluid d-flex">

            <!-- Ilustração -->
            <img class="align-self-center" src="/img/ilustracoes/montarChurros.svg" alt="Montar Churros">
            
            <div class="container d-flex flex-column">

                <!-- Subtitulo -->
                <p class="subtitulo">Monte o seu próprio churros de acordo com o que seu gosto mandar!</p>
                
                <!-- Botão -->
                <button onclick="window.location.href = '/montarchurros'" class="button btn__padrao">Montar Churros</button>
            </div>
        </div>
    </div>
</template>

<script>
export default({
    name: "MontarChurros",
    data () {
        return {

        }
    }
})
</script>
