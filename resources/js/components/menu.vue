<template>
<header>
    <div id="menu">
        <div class="content d-flex flex-row justify-content-between mx-auto">

            <!-- Botão do Carrinho - Mobile -->
            <div class="btn__carrinho" alt="Carrinho" data-bs-toggle="offcanvas" data-bs-target="#carrinho__content">
                <i class="fas fa-shopping-cart"></i>
                <p v-if="churrosCarrinho" id="btnCarrinho__qtd">{{churrosCarrinho.length}}</p>
                <p v-if="!churrosCarrinho" id="btnCarrinho__qtd">0</p>
            </div>

            <!-- Logo -->
            <img onclick="location.href='/'" id="logo" src="/img/logo.svg" alt="Logo">

            <!-- Botão do Menu - Mobile -->
            <img id="btn__menu" src="/img/menu.svg" alt="Menu" data-bs-toggle="offcanvas" data-bs-target="#mega__menu">
            
            <!-- Menu - Desktop -->
            <div id="menu__pc">

                <!-- Botão do Carrinho - Desktop -->
                <div class="btn__carrinho" alt="Carrinho" data-bs-toggle="offcanvas" data-bs-target="#carrinho__content">
                    <i class="fas fa-shopping-cart"></i>
                    <p v-if="churrosCarrinho" id="btnCarrinho__qtd">{{churrosCarrinho.length}}</p>
                    <p v-if="!churrosCarrinho" id="btnCarrinho__qtd">0</p>
                </div>

                <MenuItems :check="check"/>
            </div>
        </div>
    </div>

    <!-- Mega Menu - Mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mega__menu" aria-labelledby="Menu">

        <!-- Mega Menu - Cabeçalho -->
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Olá, {{user}}!</h5>
            <i id="btn__fechar" class="fas fa-chevron-right" data-bs-dismiss="offcanvas" aria-label="Close"></i>
        </div>

        <!-- Mega Menu - Corpo -->
        <div class="offcanvas-body">
            <MenuItems :check="check"/>
        </div>
    </div>

    <!-- Carrinho -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="carrinho__content" aria-labelledby="Carrinho">

        <!-- Carrinho - Cabeçalho -->
        <div class="offcanvas-header">
            <i id="btn__fechar" class="fas fa-chevron-left" data-bs-dismiss="offcanvas" aria-label="Close"></i>
            <h5 class="offcanvas-title">Carrinho</h5>
        </div>

        <!-- Carrinho - Corpo -->
        <div class="offcanvas-body">
            <div id="carrinho__churros" class="d-flex flex-column flex-nowrap">

                <!-- Carrinho - Aviso -->
                <p id="carrinho__aviso" v-if="!churrosCarrinho" class="mb-5 text-center">Nenhum churros foi adicionado ao carrinho.</p>
                
                <!-- Carrinho - Churros -->
                <CardChurros v-for="(item, index) in churrosCarrinho" :key="item" 
                :cardChurros="item" 
                :qtdChurros="item.quantidade"
                :precoChurros="item.preco"
                :index="index"
                :btnExcluir="true"
                :definirQtd="true"
                @excluirCardChurros="excluirCardChurros"
                @definirQtd="definirQtd" />
                
                <!-- Carrinho - Total -->
                <p v-if="churrosCarrinho" id="total" class="mt-4 text-center">Total <span id='frete'>(com frete)</span>: <br/><span id="preco">R${{totalCarrinho.toFixed(2).replace('.', ',')}}</span></p>
                
                <!-- Carrinho - Botões -->
                <button onclick="window.location.href = '/pedido'" v-if="churrosCarrinho" class="button btn__padrao btnFinalizar">Finalizar Pedido</button>
                <button onclick="window.location.href = '/montarchurros'" v-if="!churrosCarrinho" class="button btn__padrao">Montar Churros</button>
            </div>
        </div>
    </div>
</header>
</template>

<script>
import MenuItems from './menuItems.vue';
import CardChurros from './cardChurros.vue';

import Ajax from '../../mixins/ajax.js';
import User from '../../mixins/user.js';

export default ({
    name: "Menu",
    data () {
        return {
            churrosCarrinho: false,
            totalCarrinho: 0,
            user: 'Usuário',
            check: false
        }
    },
    components: {
        MenuItems,
        CardChurros
    },
    beforeMount () {
        this.getCarrinho();
        this.checkLogin();
    },
    mixins: [Ajax, User],
    methods: {

        // Pega os dados do Carrinho
        getCarrinho () {
            if (localStorage.getItem("carrinho")) {
                this.churrosCarrinho = JSON.parse(localStorage.getItem("carrinho"));

                this.atualizarPreco();
            }
        },

        // Aumenta ou diminui a quantidade do churros
        definirQtd (index, tipo) {
            switch (tipo) {
                case "mais":
                    if (this.churrosCarrinho[index].quantidade < 10) {
                        this.churrosCarrinho[index].quantidade++; 
                    }
                break;

                case "menos":
                    if (this.churrosCarrinho[index].quantidade > 1) {
                        this.churrosCarrinho[index].quantidade -= 1; 
                    }
                break;
            }

            localStorage.setItem('carrinho', JSON.stringify(this.churrosCarrinho));

            this.atualizarPreco();
        },

        // Atualiza o preço total do pedido
        async atualizarPreco () {
            this.totalCarrinho = await this.ajaxGet('/getpreco/'+JSON.stringify(this.churrosCarrinho));
        
            if (window.location.href.search('/pedido') >= 0) {
                this.$emit('atualizarPreco');
            }
        },

        // Exclui um item do carrinho pelo index
        async excluirCardChurros (index) {
            await this.churrosCarrinho.splice(index,1);

            if (this.churrosCarrinho.length <= 0) {
                localStorage.removeItem('carrinho');
                this.churrosCarrinho = false;

                if (window.location.href.search('/pedido') >= 0) {
                    window.location.href = "/";
                }
            } else {
                localStorage.setItem('carrinho', JSON.stringify(this.churrosCarrinho));

                this.atualizarPreco();
            }
        },

        async checkLogin () {
            let retorno = await this.verificarLogin();

            if (retorno) {
                this.check = true;
                this.user = retorno.nome;
            } else {
                this.check = false;
                this.user = 'Usuário'; 
            }
        }
    }
})
</script>
