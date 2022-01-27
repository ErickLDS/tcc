<template>
    <div id="pedidos" class="tabs__content__item active">

        <!-- Ilustração -->
        <img class="align-self-center" src="/img/ilustracoes/pedidos.svg" alt="Pedidos">

        <!-- Titulo -->
        <p v-if="pedidos.length > 0" class="subtitulo__text">Veja todos os seus pedidos.</p>

        <p v-if="pedidos.length <= 0" class="subtitulo__text">Nenhum pedido foi efetuado.</p>
        <button v-if="pedidos.length <= 0" onclick="window.location.href='/montarchurros'" class="button btn__padrao">Montar Churros</button>

        <!-- Pedidos -->
        <div @click="verPedido(item.id)" v-for="item in organizarPedidos()" :key="item" class="pedidos__content">
            
            <!-- Pedido - Data -->
            <p class="pedido__data">Pedido feito em:<br/>
            <span>{{new Date(item.data).toLocaleDateString()}} - {{new Date(item.data).toLocaleTimeString()}}</span></p>

            <div class="d-flex flex-row justify-content-between">

                <!-- Pedido - Total -->
                <p class="pedido__total">Total: <br/>
                <span>R${{item.total.toFixed(2).replace(".", ",")}}</span></p>
                
                <!-- Pedido - Status -->
                <div class="pedido__status d-flex flex-column">
                    <p class="status__title">Status:</p>

                    <!-- Entregue -->
                    <span :style="'background-color: '+item.status.cor" class="button info__status">{{item.status.nome}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Pedidos",
    data () {
        return {
            pedidos: []
        }
    },
    mixins: [Ajax],
    async beforeMount () {
        this.pedidos = await this.ajaxGet('/pedido/get/all');
    },
    methods: {

        // Organiza a forma de apresentar os pedidos
        organizarPedidos () {
            let pedidosOrganizados;

            pedidosOrganizados = this.pedidos.sort((a,b) => {
                if (new Date(a.data).getTime() < new Date(b.data).getTime()) { return 1 }
                if (new Date(a.data).getTime() > new Date(b.data).getTime()) { return -1 }
            });

            return pedidosOrganizados;
        },

        // Redireciona o usuário para a página do pedido especificado
        verPedido (id) {
            window.location.href = '/pedido/'+id;
        },

        // Formata a data do pedido
        formatarData (data, hora) {
            let tipoHora = hora.split(":");

            if (parseFloat(tipoHora[0]) > 12) {
                if (!(parseFloat(tipoHora[0]) == 12)) {
                    hora = (parseFloat(tipoHora[0]) % 12) + ":" + tipoHora[1];
                }
                
                tipoHora = " pm";
            } else {
                tipoHora = " am";
            }

            let dataFormatada = data.toString().split("/").reverse().join("/") + " " + hora + tipoHora;
            return new Date(dataFormatada).getTime();
        }
    }
}
</script>