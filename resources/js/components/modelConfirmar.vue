<template>
<div v-if="status" class="model__confirmar">
    <div class="model__content d-flex flex-column justify-content-center">

        <!-- Título -->
        <p class="model__text">{{texto}}</p>

        <!-- Botões -->
        <div class="model__botoes d-flex flex-row justify-cotent-between">

            <!-- Sim -->
            <button @click="modelResposta(true)" id="btn__modelSim" class="button btn__small">Sim <i class="icon__right fas fa-check"></i></button>
            
            <!-- Não -->
            <button @click="modelResposta(false)" id="btn__modelNao" class="button btn__small">Não <i class="icon__right fas fa-times"></i></button>
        </div>
    </div>
</div>
</template>

<style scoped>
.model__confirmar {
    position: fixed;
    height: 100vh;
    width: 100vw;
    left: 0;
    top: 0;
    background-color: rgb(0 0 0 / 70%);
    z-index: 999;
    display: flex;
    justify-content: center;
}

.model__content {
    width: clamp(190px, 90%, 350px);
    padding: 20px;
    border-radius: 10px;
    background-color: var(--cor-fundo);
    top: 0;
    align-self: center;
    box-shadow: 0px 2px 6px rgb(0 0 0 / 10%);
}

.model__text {
    text-align: center;
    font-size: 1.3em;
    margin-bottom: 30px;
    font-weight: 400;
    text-transform: capitalize;
}

.model__botoes button {
    font-size: 1em;
}

#btn__modelSim {
    background-color: var(--cor-green);
    margin-right: 15px;
}

#btn__modelNao {
    background-color: var(--cor-red);
    margin-left: 15px;
}
</style>

<script>
export default {
    name: "ModelConfirmar",
    data () {
        return {
            texto: String,
            status: false,
            index: Number
        }
    },
    methods: {

        // Retorna a opção escolhida
        modelResposta (resposta) {
            this.$emit('modelResposta', resposta, this.index);
        },

        // Abre o Model
        openModel (texto, index = false) {
            this.index = index;
            this.texto = texto;
            this.status = true;
        },

        // Fecha o Model
        closeModel () {
            this.status = false; 
        }
    }
}
</script>