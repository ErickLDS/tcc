<template>
<div class="d-flex flex-column">
    <Menu/>

    <section id="sessao__principal" class="content-fluid">

        <!-- Churros -->
        <div id="churros" class="d-flex flex-column flex-nowrap">
            <Churros v-for="(item, index) in churros" :key="item" 
            :churros="item" 
            :index="index" 
            :qtd="churros.length"
            :tipos="sabores"
            @openModel="this.$refs.modelConfirmar.openModel('Você confirma a exclusão do item: '+(index+1)+'º Churros', index)"
            @editarChurros="editarChurros"
            @definirQtd="definirQtd"/>
        </div>

        <!-- Slider -->
        <div id="conteudo" class="container d-flex flex-column px-0">
            
            <!-- Sliders -->
            <div id="slider" class="d-flex justify-content-center">
                <Sabores v-for="(item, index) in sabores" :key="item"
                :sabor="item"
                :index="index"
                @opcoesExcluir="opcoesExcluir"
                @adicionarChurros='adicionarChurros'
                @sliderProximo="sliderProximo"
                @sliderAnterior="sliderAnterior"/>

                <Confirmar :total="this.total"
                @montarMais="montarMais"
                @confirmarChurros="confirmarChurros"
                @sliderAnterior="sliderAnterior"/>
            </div>
        </div>
    </section>

    
    <Alert ref="alert"/>
    <ModelConfirmar ref="modelConfirmar" @modelResposta="modelResposta"/>
    <Copyright/>
</div>
</template>

<script>
import Menu from './components/menu.vue';
import Copyright from './components/copyright.vue';

import Sabores from './components/montarChurros/sabores.vue';

import Confirmar from './components/montarChurros/confirmar.vue';
import Churros from './components/montarChurros/churros.vue';

import ModelConfirmar from './components/modelConfirmar.vue';
import Alert from './components/alert.vue';

import Ajax from '../mixins/ajax.js';
import Sliders from '../mixins/sliders.js';

export default {
    name: "MontarChurros",
    data () {
        return {
            sabores: [],
            frete: 2,
            churros: [{codigo: [0,0,0,0], preco: 10, qtd: 1, nome: ""}],
            total: 10,
            churrosAtual: 0
        }
    },
    mixins: [Ajax, Sliders],
    components: {
        Menu,
        Copyright,
        Sabores,
        Confirmar,
        Churros,
        ModelConfirmar,
        Alert
    },
    async mounted() {
        await this.getSabores();
        await this.atualizarChurros();
        await this.getSliders();
        document.querySelector('#slider').scrollIntoView();
    },
    methods: {

        // Botão confirmar pedido
        async confirmarChurros (rota) {
            let countChurros;
            await this.churros.map(async (e, index) => {
                countChurros = await e.codigo.filter((item) => {
                    return item != 0;
                });

                if (countChurros.length < 1) {
                    if (this.churros.length <= 1) {
                        this.$refs.alert.definirAlert({
                            texto: "Você tem que escolher pelo menos uma das opções.",
                            tipo: "erro",
                            delay: 4
                        });
                    } else {
                        this.excluirChurros(index);
                    }
                }
            });
            
            if (countChurros.length >= 1) {
                if (!localStorage.getItem("carrinho")) {
                    localStorage.getItem("carrinho");
                    localStorage.setItem("carrinho", JSON.stringify([]));
                }

                let carrinhoLocal = JSON.parse(localStorage.getItem("carrinho"));
                
                this.churros.forEach((churros) => {
                    let churrosLocal = {codigo: [undefined, undefined, undefined, undefined], quantidade: undefined, nome: ''};

                    churros.codigo.forEach((opcao, i) => {
                        if (opcao != 0) {
                            churrosLocal.nome = "Churros "+opcao.nome;
                        }
                        churrosLocal.codigo[i] = opcao.id
                    });

                    churrosLocal.quantidade = churros.qtd;

                    carrinhoLocal.push(churrosLocal);
                });

                localStorage.setItem('carrinho', JSON.stringify(carrinhoLocal));

                window.location.href = rota;
            }
        },

        // Adiciona as opções escolhidas ao churros atual
        adicionarChurros (item) {
            this.churros[this.churrosAtual].codigo[this.sliderAtual] = (item);
            this.opcoesAtualizar();
            this.sliderProximo();
            this.calcularPreco();
        },

        // Muda o foco para o churros especificado
        editarChurros (index) {
            this.resetarSliders();
            this.churrosAtual = index;
            this.opcoesAtualizar();
            this.atualizarChurros();
            this.sliderAtual = 0;
            this.sliders[0].classList.add("active");
            document.querySelector('#slider').scrollIntoView();
        },

        // Adiciona mais um churros
        async montarMais () {
            await this.churros.push({codigo: [0,0,0,0], preco: 10, qtd: 1, nome: ""});

            this.resetarSliders();
            this.churrosAtual++;
            this.atualizarChurros();
            this.sliderAtual = 0;
            this.sliders[0].classList.add("active");
            this.opcoesAtualizar();
            document.querySelector('#slider').scrollIntoView();
        },

        // Exclui o churros especificado
        excluirChurros (index) {
            if (this.churros.length > 1) {
                if (this.sliderAtual < (this.sliders.length-1) && this.churrosAtual == index) {
                    this.sliderAtual = this.sliders.length-1;
                }
                
                this.churrosAtual = this.churros.length-2;
                this.churros.splice(index, 1);

                this.atualizarChurros();
                this.calcularPreco();
                this.resetarSliders();
                this.sliders[this.sliderAtual].classList.add("active");
            }
        },

        // Recebe o index do churros e a resposta do model
        modelResposta (resposta, index) {
            if (resposta) {
                this.excluirChurros(index);
            }
            this.$refs.modelConfirmar.closeModel();
        },

        // Define a quantidade do churros especificado
        definirQtd (index, tipo) {
            if (tipo == 'mais') {
                if (this.churros[index].qtd < 10) {
                    this.churros[index].qtd++;
                }
            } else if (tipo == 'menos') {
                if (this.churros[index].qtd > 1) {
                    this.churros[index].qtd -= 1;
                }
            }
            this.calcularPreco();
        },

        // Calcula o preço dos churros
        calcularPreco () {
            this.total = 0;

            this.churros.forEach((e, index) => {
                this.churros[index].preco = 10;
                e.codigo.forEach((sabor) => {
                    if (sabor.adicional != null) {
                        this.churros[index].preco += sabor.adicional;
                    }
                });
                this.total += e.preco * e.qtd;
            });

            this.total += 2;
        },

        // Atualiza os estilo dos churros
        atualizarChurros () {
            let elementos = document.querySelectorAll(".churros__item");

            elementos.forEach((e) => {
                e.classList.remove("selected");
            });

            elementos[this.churrosAtual].classList.add("selected");
        },

        // Atualiza as opções de sabores selecionadas
        opcoesAtualizar () {
            let elementos = document.querySelectorAll(".opcoes__item.selected");
            elementos.forEach((e) => {
                e.classList.remove("selected");
            });

            this.churros[this.churrosAtual].codigo.forEach((e) => {
                if (e) {
                    document.querySelector(".opcoes__item[value='"+e.id+"']").classList.add("selected")
                }
            });

            this.calcularPreco();
        },

        // Exclui uma opção de sabor especificada
        opcoesExcluir () {
            this.churros[this.churrosAtual].codigo[this.sliderAtual] = 0;
            this.opcoesAtualizar();
        },

        // Pega os sabores no Banco de Dados
        async getSabores () {
            this.sabores = await this.ajaxGet('/tiposabores/get');
            this.sabores = this.sabores.filter((e) => e.qtd_itens > 0);
        },
    }
}
</script>