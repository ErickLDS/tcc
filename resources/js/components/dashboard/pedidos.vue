<template>
<div id="pedidos" class="flex-column dashboard__item">

    <!-- Titulo -->
    <p class="titulo">Todos os pedidos</p>

    <!-- Pesquisa por data -->
    <div v-if="pedidos.length > 0 || pesquisa" id="data__pedido" class="d-flex flex-column align-self-center align-items-center">
        
        <!-- Pesquisa - Titulo -->
        <p class="subtitulo">Procurar pedidos pela data:</p>

        <!-- Pesquisa - Observação -->
        <p class="subtitulo__text">OBS: Se o dia for definido como '00' os pedidos vão ser filtrados pelo mês especificado.</p>

        <!-- Pesquisa - Input Data -->
        <div class="base__input">
            <input v-model="dataPedidos" id="input__data" name="data" placeholder="00/00/0000" type="text" v-maska="'##/##/####'">
            <label for="input__data"><i class="icon__left fas fa-calendar"></i> Data:</label>
        </div>
        
        <!-- Pesquisa - Botão Filtrar -->
        <button @click="pesquisaData()" class="button btn__small btn__confirmar">Pesquisar <i class="icon__right fas fa-search"></i></button>
    </div>

    <!-- Aviso - Pedidos -->
    <p v-if="pedidos.length <= 0" class="subtitulo__text">Nenhum pedido foi encontrado.</p>

    <!-- Quantidade de Pedidos -->
    <p v-if="qtdPedidos" class="subtitulo__text mb-5">({{qtdPedidos}}) Resultados encontrados.</p>

    <!-- Pedidos -->
    <div v-for="item in organizarPedidos()" :key="item" class="box__item">

        <!-- Pedidos - Nome do usuário -->
        <div class="box__content me-5">
            <p>Usuário:</p>
            <span style="width: 180px;">{{item.nome}}</span>
        </div>

        <div class="d-flex flex-row flex-wrap">

            <!-- Pedidos - Status -->
            <div class="box__content me-5">
                <p>Status:</p>
                <span :style="'background-color: '+item.status.cor" class="box__content__item status__item">{{item.status.nome}}</span>
            </div>

            <!-- Pedidos - Pagamento -->
            <div class="d-flex flex-row flex-wrap">
                <div class="box__content">
                    <p>Pagamento:</p>
                    <span v-if="item.troco == null" class="box__content__item pagamento__item me-5"><i :class="'icon__left ' + item.pagamento.icone"></i>{{item.pagamento.nome}}</span>
                    <span v-if="item.troco != null" class="box__content__item pagamento__item me-5"><i :class="'icon__left ' + item.pagamento.icone"></i>{{item.pagamento.nome}}: R${{item.troco.toFixed(2).replace('.', ',')}}</span>
                </div>

                <!-- Pedidos - Pagamento Troco -->
                <div v-if="item.troco > 0" class="box__content align-self-end">
                    <p>Troco:</p>
                    <span>R${{(item.troco - item.total).toFixed(2).replace('.', ',')}}</span>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row flex-wrap">

            <!-- Pedidos - Total -->
            <div class="box__content me-5">
                <p>Total:</p>
                <span>R${{item.total.toFixed(2).replace('.', ',')}}</span>
            </div>

            <!-- Pedidos - Data -->
            <div class="box__content">
                <p>Data:</p>
                <span>{{new Date(item.data).toLocaleDateString()}} - {{new Date(item.data).toLocaleTimeString()}}</span>
            </div>
        </div>
        
        <!-- Pedidos - Botão ver tudo -->
        <button @click="openVerMais(item.id)" class="button btn__padrao btn__confirmar w-100 mt-1">Ver o Pedido <i class="icon__right fas fa-chevron-right"></i></button>
    </div>

    <!-- Offcanvas Ver Mais -->
    <div v-if="pedidos.length > 0" class="offcanvas offcanvas-end" tabindex="-1" id="pedido__ver" aria-labelledby="Ver Mais">
        
        <!-- Offcanvas Ver Mais - Cabeçalho -->
        <div class="offcanvas-header">
            <i @click="closeOffcanvas()" id="btn__fechar" class="fas fa-chevron-left"></i>
            
            <h5 class="offcanvas-title mx-auto" style="width: 180px;"><span>Usuário:</span><br>
            {{pedidos[this.verMais].nome}}</h5>
        </div>

        <!-- Offcanvas Ver Mais - Corpo -->
        <div class="offcanvas-body">

            <!-- Offcanvas Ver Mais - Subtítulo -->
            <p class="subtitulo">Informações do pedido:</p>

            <!-- Offcanvas Ver Mais - Status -->
            <div class="box__content me-5">
                <p>Status:</p>
                <div class="d-flex flex-row flex-nowrap">
                    <span :style="'background-color: '+pedidos[this.verMais].status.cor" class="box__content__item status__item">{{pedidos[this.verMais].status.nome}}</span>
                    <span id="btn__definirStatus" class="box__content__item" data-bs-toggle="collapse" data-bs-target="#collapse__definir__status"><i class="fas fa-chevron-down"></i></span>
                </div>

                <div class="collapse" id="collapse__definir__status">
                    <div class="collapse__body d-flex flex-column justify-content-center">
                        <span @click="definirStatus(item.id, pedidos[this.verMais].id)" v-for="item in status" :key="item" :style="'background-color: '+item.cor" class="box__content__item status__item">{{item.nome}}</span>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-row flex-wrap">

                <!-- Offcanvas Ver Mais - Total -->
                <div class="box__content me-5">
                    <p>Total:</p>
                    <span>R${{pedidos[this.verMais].total.toFixed(2).replace('.', ',')}}</span>
                </div>

                <!-- Offcanvas Ver Mais - Data -->
                <div class="box__content">
                    <p>Data:</p>
                    <span>{{new Date(pedidos[this.verMais].data).toLocaleDateString()}} - {{new Date(pedidos[this.verMais].data).toLocaleTimeString()}}</span>
                </div>
            </div>

            <!-- Offcanvas Ver Mais - Pagamento -->
            <div class="d-flex flex-row flex-wrap">
                <div class="box__content me-5">
                    <p>Pagamento:</p>
                    <span v-if="pedidos[this.verMais].troco == null" class="box__content__item pagamento__item me-5"><i :class="'icon__left ' + pedidos[this.verMais].pagamento.icone"></i>{{pedidos[this.verMais].pagamento.nome}}</span>
                    <span v-if="pedidos[this.verMais].troco != null" class="box__content__item pagamento__item me-5"><i :class="'icon__left ' + pedidos[this.verMais].pagamento.icone"></i>{{pedidos[this.verMais].pagamento.nome}}: R${{pedidos[this.verMais].troco.toFixed(2).replace('.', ',')}}</span>
                </div>
                
                <!-- Offcanvas Ver Mais - Pagamento troco -->
                <div v-if="pedidos[this.verMais].troco != null" class="box__content align-self-end">
                    <p>Troco:</p>
                    <span>R${{(pedidos[this.verMais].troco - pedidos[this.verMais].total).toFixed(2).replace('.', ',')}}</span>
                </div>
            </div>

            <!-- Offcanvas Ver Mais - Endereço -->
            <div class="box__content">
                <p>Endereço:</p>
                <span>{{pedidos[this.verMais].endereco}}</span>
            </div>

            <!-- Offcanvas Ver Mais - Observações -->
            <div v-if="pedidos[this.verMais].obs" class="box__content">
                <p>Observações:</p>
                <span>{{pedidos[this.verMais].obs}}</span>
            </div>

            <!-- Offcanvas Ver Mais - Telefone -->
            <div class="box__content">
                <p>Telefone:</p>
                <span>{{pedidos[this.verMais].telefone}}</span>
            </div>

            <!-- Offcanvas Ver Mais - Subtítulo Churros -->
            <p class="subtitulo mt-4">Churros:</p>

            <!-- Offcanvas Ver Mais - Churros -->
            <div class="d-flex flex-column">
                <CardChurros v-for="(item, index) in pedidos[this.verMais].churros" :key="item" 
                :precoChurros="item.preco"
                :qtdChurros="item.quantidade"
                :cardChurros="item" 
                :index="index"/>
            </div>
        </div>
    </div>

    <div class="offcanvas__backdrop"></div>
    <Alert ref="alert"/>
</div>
</template>

<script>
import CardChurros from '../cardChurros.vue';
import Alert from '../alert.vue';

import Offcanvas from '../../../mixins/offcanvas.js';
import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Pedidos",
    data () {
        return {
            pesquisa: false,
            dataPedidos: '',
            verMais: 0,
            pedidos: [],
            pedidosOrganizados: [],
            qtdPedidos: false,
            status: []
        }
    },
    mixins: [Ajax, Offcanvas],
    async mounted () {
        this.getPedidos();
        this.status = await this.ajaxGet('/pedido/status/get');
    },
    methods: {

        // Pega todos os pedidos do banco
        async getPedidos () {
            let retorno = await this.ajaxGet('/ck10dashboard/pedidos/get');
            this.pedidos = retorno.pedidos;
            this.qtdPedidos = retorno.quantidade;
        },

        // Abre o offcanvas ver mais
        openVerMais (id) {
            this.pedidos.forEach((item, index) => {
                if (item.id == id) {
                    this.verMais = index;
                }
            });

            this.openOffcanvas('pedido__ver')
        },

        // Atualiza o status do pedido
        async definirStatus (status, id) {
            let dados = {
                id: id,
                id_status: status
            }

            let retorno = await this.ajax({
                url: '/pedido/status/set',
                method: 'post',
                dado: dados
            });

            if (retorno) {
                this.closeOffcanvas();
                this.getPedidos();
            }
        },

        // Filtra os pedidos a partir de uma data definida
        async pesquisaData () {
            if (this.dataPedidos.length > 1) {
                let dados = this.dataPedidos.split('/');
                dados.length = 3;

                dados.forEach((e, index) => {
                    if (isNaN(e) || e.length < 1) {
                        dados[index] = undefined;
                    }
                });

                let retorno = await this.ajaxGet('/ck10dashboard/pedidos/get/'+dados[0]+'/'+dados[1]+'/'+dados[2]);
                this.pedidos = retorno.pedidos;
                this.qtdPedidos = retorno.quantidade;
                this.pesquisa = true;
            } else {
                this.getPedidos();
            }
        },

        // Organiza os pedidos por os mais recentes
        organizarPedidos () {
            return this.pedidos.sort((a, b) => {
                if (new Date(a.data).getTime() < new Date(b.data).getTime()) { return 1 }
                if (new Date(a.data).getTime() > new Date(b.data).getTime()) { return -1 }
            });
        },
    },
    components: {
        CardChurros,
        Alert
    }
}
</script>