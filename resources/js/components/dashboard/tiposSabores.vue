<template>
<div id="sabores" class="flex-column dashboard__item">

    <!-- Titulo -->
    <p class="titulo">Todos os tipos de Sabores</p>

    <!-- Box -->
    <div class="box__item">
        
        <!-- Box - Titulo -->
        <p class="titulo">Tipos de sabores:</p>

        <!-- Box - Item -->
        <div class="base__item" v-for="item in sabores" :key="item">

            <!-- Item - Titulo -->
            <p class="base__item__adicional">{{item.qtd_itens}} Sabores</p>
            <p @click="openEditar(item)" class="base__item__nome">{{item.nome}}</p>
            
            <!-- Item - Botões -->
            <button @click="openEditar(item)" id="btn__editar" class="button base__item__option"><i class="fas fa-eye"></i></button>
            <button @click="openExcluir(item.id, item.nome)" id="btn__excluir" class="button base__item__option"><i class="fas fa-trash"></i></button>
        </div>

        <!-- Box - Botão adicionar -->
        <button @click="openOffcanvas('tipos__adicionar')" id="btn__adicionar" class="button btn__padrao btn__confirmar w-100">Adicionar <i class="icon__right fas fa-plus"></i></button>
    </div>


    <!-- Offcanvas Editar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tipos__editar" aria-labelledby="Editar">
        
        <!-- Offcanvas Editar - Cabeçalho -->
        <div class="offcanvas-header">
            <i @click="closeOffcanvas(), resetarOffcanvas(), this.$refs.alert.limpar()" id="btn__fechar" class="fas fa-chevron-left"></i>
            
            <h5 class="offcanvas-title mx-auto">{{editar.nome}}</h5>
        </div>

        <!-- Offcanvas Editar - Corpo -->
        <div class="offcanvas-body">

            <!-- Offcanvas Editar - Corpo Subtítulo -->
            <p class="subtitulo">Você pode alterar as informações abaixo:</p>

            <div class="checkbox__content mb-4">
                <div>
                    <input v-model="editar.opcional" value="true" class="d-none" type="checkbox" name="editar__opcional" id="editar__opcional">
                    <label for="editar__opcional" class="checkbox__item">Opcional</label>
                </div>
            </div>

            <!-- Offcanvas Editar - Input Nome -->
            <div id="editar__nome" class="base__input input__valido">
                <input type="text" name="nome" id="item__nome" v-model="editar.nome" autocomplete="off" autofocus required>
                <label for="item__nome">Nome:</label>
            </div>

            <!-- Offcanvas Editar - Botão salvar alterações -->
            <button @click="editarItem()" class="button btn__padrao btn__confirmar align-self-center">Salvar alterações <i class="icon__right fas fa-check"></i></button>
        </div>
    </div>


    <!-- Offcanvas Adicionar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tipos__adicionar" aria-labelledby="Adicionar" data-bs-backdrop="false" data-bs-scroll="true">

        <!-- Offcanvas Adicionar - Cabeçalho -->
        <div class="offcanvas-header">
            <i @click="closeOffcanvas(), resetarOffcanvas(), this.$refs.alert.limpar()" id="btn__fechar" class="fas fa-chevron-left"></i>
            
            <h5 class="offcanvas-title mx-auto">Adicionar</h5>
        </div>

        <!-- Offcanvas Adicionar - Corpo -->
        <div class="offcanvas-body">

            <!-- Offcanvas Adicionar - Subtítulo -->
            <p class="subtitulo">Adicionar item:</p>

            <div class="checkbox__content mb-4">
                <div>
                    <input v-model="adicionar.opcional" value="true" class="d-none" type="checkbox" name="adicionar__opcional" id="adicionar__opcional">
                    <label for="adicionar__opcional" class="checkbox__item">Opcional</label>
                </div>
            </div>

            <!-- Offcanvas Adicionar - Input Nome -->
            <div id="editar__nome" class="base__input">
                <input type="text" name="nome" id="item__nome" v-model="adicionar.nome" autocomplete="off" autofocus required>
                <label for="item__nome">Nome:</label>
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
    name: "TiposSabores",
    data () {
        return {
            adicionar: {
                nome: '',
                opcional: false
            },

            editar: {
                id: undefined,
                nome: '',
                opcional: false
            },

            excluir: undefined,

            sabores: []
        }
    },
    mixins: [Offcanvas, Ajax],
    async beforeMount () {
        await this.getSabores();
    },
    methods: {
        
        // Adiciona o item especificado
        async adicionarItem () {
            let retorno = await this.ajax({
                url: '/tiposabores/set',
                method: 'post', 
                dado: this.adicionar, 
                seletorInput: ".offcanvas#tipos__adicionar",
                loader: '.offcanvas#tipos__adicionar .offcanvas-body .button.btn__confirmar'
            });

            if (retorno) {
                this.getSabores();
                this.resetarOffcanvas();
            }
        },

        // Edita o item especificado
        async editarItem () {
            let dados = {
                nome: this.editar.nome,
                opcional: this.editar.opcional
            }

            let retorno = await this.ajax({
                url: '/tiposabores/edit/'+this.editar.id, 
                method: 'post', 
                dado: dados, 
                seletorInput: ".offcanvas#tipos__editar",
                loader: '#tipos__editar .button.btn__confirmar'
            });

            if (retorno) {
                this.getSabores();
                this.resetarOffcanvas();
                this.closeOffcanvas();
            }
        },

        // Exclui o item especificado
        async excluirItem () {
            let retorno = await this.ajax({
                url: '/tiposabores/delete/'+this.excluir, 
                method: 'delete'
            });

            if (retorno) {
                this.getSabores();
            }
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
            this.editar.opcional = false;
            this.editar.nome = '';
            this.editar.id = '';

            this.editar.nome = item.nome;
            this.editar.id = item.id;
            this.editar.opcional = item.opcional;

            this.openOffcanvas("tipos__editar");
        },

        // Define o item a ser excluido e abre o Model
        openExcluir (id, nome) {
            this.excluir = id;
            this.$refs.modelConfirmar.openModel('Você confirma a exclusão do item: ' + nome);
        },

        // Pega os sabores do Banco de Dados
        async getSabores () {
            this.sabores = await this.ajaxGet('/tiposabores/get');
        },

        // Reseta os campos de input presentes no offcanvas e limpa os alerts 
        resetarOffcanvas () {
            this.adicionar.nome = '';
            this.adicionar.opcional = false;

            this.editar.id = undefined;
            this.editar.nome = '';
            this.editar.opcional = false;

            this.excluir = undefined;

            document.querySelectorAll(".offcanvas .base__input input").forEach((element) => {
                element.parentNode.classList.remove("input__erro");
            });
            
            document.querySelectorAll(".offcanvas .filtro__content input").forEach((element) => {
                element.removeAttribute("checked");
            });
        }
    },
    components: {
        BoxContent,
        ModelConfirmar,
        Alert
    }
}
</script>