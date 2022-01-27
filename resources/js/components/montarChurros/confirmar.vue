<template>
    <div class="slider__item">

        <!-- Slider - Titulo -->
        <p class="subtitulo">Verifique se as suas escolhas estão corretas:</p>

        <!-- Total do pedido -->
        <p id="total" class="text-center">Total <span id='frete'>(com frete)</span>: <br/><span id="preco">R${{total.toFixed(2).replace(".", ",")}}</span></p>

        <!-- Card montar mais um churros -->
        <div id="confirmarOpcoes" class="d-flex flex-column align-self-center">
            <img src="/img/ilustracoes/confirmar.svg" alt="Confirmar">
            <p>Quer aproveitar a criatividade e montar mais um churros?</p>

            <!-- Botão adicionar mais um churros -->
            <button @click="$emit('montarMais')" class="button btn__padrao">Montar Mais +</button>
        </div>

        <!-- Botão adicionar ao carrinho -->
        <button @click="this.$emit('confirmarChurros', '/')" class="button btn__padrao mb-4">Adicionar ao Carrinho <i class="icon__right fas fa-cart-plus"></i></button>
        
        <!-- Botão comprar -->
        <button @click="this.$emit('confirmarChurros', '/pedido')" class="button btn__padrao btn__confirmar mb-5">Comprar <i class="icon__right fas fa-check"></i></button>
        
        <!-- Botão voltar para o slider anterior -->
        <button @click="this.$emit('sliderAnterior')" id="btn__voltar" class="button btn__padrao"><i class="icon__left fas fa-chevron-left"></i> Voltar</button>
    </div>
</template>

<script>
export default {
    name: "Confirmar",
    data () {
        return {

        }
    },
    props: {
        total: Number
    }
}
</script>