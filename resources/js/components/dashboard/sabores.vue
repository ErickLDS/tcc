<template>
<div id="sabores" class="flex-column dashboard__item">

    <!-- Titulo -->
    <p class="titulo">Todos os Sabores</p>

    <p v-if="dashboard.length <= 0" class="subtitulo__text">Nenhum tipo de sabor foi encontrado.</p>

    <!-- Box -->
    <BoxContent v-for="conteudo in dashboard" :key="conteudo" :conteudo="conteudo"
    @openAdicionar='openOffcanvas("sabores__adicionar")'
    @openEditar='openEditar'
    @openExcluir='openExcluir'
    @definirTipo="definirTipo"/>

    <!-- Offcanvas Editar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sabores__editar" aria-labelledby="Editar">
        
        <!-- Offcanvas Editar - Cabeçalho -->
        <div class="offcanvas-header">
            <i @click="closeOffcanvas(), resetarOffcanvas(), this.$refs.alert.limpar()" id="btn__fechar" class="fas fa-chevron-left"></i>
            
            <h5 class="offcanvas-title mx-auto">{{tipo.nome}}</h5>
        </div>

        <!-- Offcanvas Editar - Corpo -->
        <div class="offcanvas-body">

            <!-- Offcanvas Editar - Corpo Subtítulo -->
            <p class="subtitulo">Você pode alterar as informações abaixo:</p>

            <!-- Offcanvas Editar - Input Nome -->
            <div id="editar__nome" class="base__input input__valido">
                <input type="text" name="nome" id="item__nome" v-model="editar.nome" autocomplete="off" autofocus required>
                <label for="item__nome">Nome:</label>
            </div>

            <!-- Offcanvas Editar - Input Adicional -->
            <div id="editar__adicional" class="base__input">
                <input type="text" name="adicional" id="item__adicional" v-model="editar.adicional" autocomplete="off" v-maska="'R$#*!,##'" required>
                <label for="item__adicional"><span>(Opcional)</span> Valor adicional:</label>
            </div>

            <!-- Offcanvas Editar - Botão salvar alterações -->
            <button @click="editarItem()" class="button btn__padrao btn__confirmar align-self-center">Salvar alterações <i class="icon__right fas fa-check"></i></button>
        </div>
    </div>


    <!-- Offcanvas Adicionar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sabores__adicionar" aria-labelledby="Adicionar" data-bs-backdrop="false" data-bs-scroll="true">

        <!-- Offcanvas Adicionar - Cabeçalho -->
        <div class="offcanvas-header">
            <i @click="closeOffcanvas(), resetarOffcanvas(), this.$refs.alert.limpar()" id="btn__fechar" class="fas fa-chevron-left"></i>
            
            <h5 class="offcanvas-title mx-auto">{{tipo.nome}}</h5>
        </div>

        <!-- Offcanvas Adicionar - Corpo -->
        <div class="offcanvas-body">

            <!-- Offcanvas Adicionar - Subtítulo -->
            <p class="subtitulo">Adicionar item:</p>

            <!-- Offcanvas Adicionar - Input Nome -->
            <div id="editar__nome" class="base__input">
                <input type="text" name="nome" id="item__nome" v-model="adicionar.nome" autocomplete="off" autofocus required>
                <label for="item__nome">Nome:</label>
            </div>

            <!-- Offcanvas Adicionar - Input Adicional -->
            <div id="editar__adicional" class="base__input">
                <input type="text" name="adicional" id="item__adicional" v-model="adicionar.adicional" v-maska="'R$#*!,##'" autocomplete="off" required>
                <label for="item__adicional"><span>(Opcional)</span> Valor adicional:</label>
            </div>

            <!-- Offcanvas Adicionar - Botão adicionar -->
            <button @click="adicionarItem()" class="button btn__padrao btn__confirmar align-self-center">Adicionar <i class="icon__right fas fa-check"></i></button>
        </div>
    </div>

    <div class="offcanvas__backdrop"></div>
    <ModelConfirmar ref="modelConfirmar" @modelResposta="modelResposta"/>
    <Alert ref='alert'/>
</div>
</template>

<script>
import BoxContent from './boxContent.vue';

import ModelConfirmar from '../modelConfirmar.vue';
import Alert from '../alert.vue';

import Offcanvas from '../../../mixins/offcanvas.js';
import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Sabores",
    data () {
        return {
            tipo: {
                id: undefined,
                nome: ''
            },

            adicionar: {
                nome: '',
                adicional: '',
            },

            editar: {
                id: undefined,
                nome: '',
                adicional: '',
            },

            excluir: undefined,

            dashboard: [],
        }
    },
    mixins: [Offcanvas, Ajax],
    async beforeMount () {
        await this.getSabores();
        this.resetarItens();
    },
    methods: {
        
        // Adiciona o item especificado
        async adicionarItem () {

            this.adicionar.adicional = this.formatarAdicional(this.adicionar.adicional);

            let retorno = await this.ajax({
                url: '/sabores/set/'+this.tipo.id,
                method: 'post', 
                dado: this.adicionar, 
                seletorInput: ".offcanvas#sabores__adicionar",
                loader: '#sabores__adicionar .button.btn__confirmar'
            });

            if (retorno) {
                this.resetarOffcanvas();
                this.resetarItens(this.tipo.id);
            }
        },

        // Edita o item especificado
        async editarItem () {
            this.editar.adicional = this.formatarAdicional(this.editar.adicional);

            let retorno = await this.ajax({
                url: '/sabores/edit/'+this.editar.id, 
                method: 'post', 
                dado: this.editar, 
                seletorInput: ".offcanvas#sabores__editar",
                loader: '#sabores__editar .button.btn__confirmar'
            });

            if (retorno) {
                this.resetarItens(this.tipo.id);
                this.resetarOffcanvas();
                this.closeOffcanvas();
            }
        },

        // Exclui o item especificado
        async excluirItem () {
            let retorno = await this.ajax({
                url: '/sabores/delete/'+this.excluir, 
                method: 'delete'
            });

            if (retorno) { 
                this.resetarItens(this.tipo.id);
            }
        },

        definirTipo (id, tipo) {
            this.tipo.id = id;
            this.tipo.nome = tipo
        },

        // Obtêm a resposta do Model de confirmação e exclui o item especificado
        modelResposta (resposta) {
            if (resposta) {
                this.excluirItem();
            }
            this.$refs.modelConfirmar.closeModel();
        },

        // Define o item a ser editado e abre o Offcanvas
        openEditar (item) {
            this.editar.adicional = '';
            this.editar.nome = '';
            this.editar.id = '';

            this.editar.nome = item.nome;
            this.editar.id = item.id;

            if (item.adicional) {
                this.editar.adicional = parseFloat(item.adicional).toFixed(2).replace(".", ",");
            }

            this.openOffcanvas("sabores__editar");
        },

        // Define o item a ser excluido e abre o Model
        openExcluir (id, nome) {
            this.excluir = id;

            this.$refs.modelConfirmar.openModel('Você confirma a exclusão do item: ' + nome);
        },

        // Pega os sabores do Banco de Dados
        async getSabores () {
            this.dashboard = await this.ajaxGet('/tiposabores/get');
        },

        // Reseta todos os dados apresentados, ou especificos
        async resetarItens (id = false) {
            if (!(id)) {
                this.dashboard.forEach(async (e, index) => {
                    this.dashboard[index].itens = await this.ajaxGet('/sabores/get/'+e.id);
                });
            } else {
                this.dashboard.forEach(async (e, index) => {
                    if (e.id == id) {
                        this.dashboard[index].itens = await this.ajaxGet('/sabores/get/'+this.dashboard[index].id);
                    }
                });
            }
        },

        // Reseta os campos de input presentes no offcanvas e limpa os alerts 
        resetarOffcanvas () {
            this.adicionar.nome = '';
            this.adicionar.adicional = '';

            this.editar.id = undefined;
            this.editar.nome = '';
            this.editar.adicional = '';

            this.excluir = undefined;

            document.querySelectorAll(".offcanvas .base__input input").forEach((element) => {
                element.parentNode.classList.remove("input__erro");
            });
        },

        // Formata o preço para o Banco de Dados
        formatarAdicional (dado) {
            if (dado) {
                dado = dado.replace('R$', '').replace(',', '.');
            } else {
                dado = null;
            }
            return dado;
        }
    },
    components: {
        BoxContent,
        ModelConfirmar,
        Alert
    }
}
</script>