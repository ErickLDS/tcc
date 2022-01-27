<template>
<div class="cardChurros__item d-flex flex-column">
    <div class="cardChurros__header">

        <!-- Churros - Nome -->
        <p id="cardChurros__title">{{cardChurros.nome}}</p>

        <!-- Churros - Botão Excluir -->
        <button v-if="btnExcluir" @click="$emit('excluirCardChurros', index)" class="button btn__excluir">Excluir</button>
    </div>

    <!-- Churros - Opções -->
    <div v-if="churros.codigo.length > 0 && tipos.length > 0" class="churros__opcoes d-flex flex-row flex-wrap">
        <div v-for="(item, index) in churros.codigo" :key="item" class="cardChurros__content__item">
            <span>{{tipos[index].nome}}:</span>
            <p v-if="item != null">{{item}}</p>
            <p v-if="item == null"><br></p>
        </div>
    </div>

    <div class="cardChurros__body d-flex flex-row justify-content-between">

        <!-- Churros - Preco -->
        <p id="cardChurros__preco">R${{(parseFloat(churros.preco) * parseFloat(qtdChurros)).toFixed(2).replace(".", ",")}}</p>
        
        <!-- Churros - Quantidade -->
        <p v-if="!(definirQtd || btnComprar)" id="cardChurros__qtd">{{cardChurros.quantidade}}</p>

        <!-- Churros - Definir Quantidade -->
        <div v-if="definirQtd" id="cardChurros__definirQtd" class="d-flex flex-row">
            <button @click="$emit('definirQtd', index, 'menos')" class="churros__qtd__menos">-</button>
            <p>{{qtdChurros}}</p>
            <button @click="$emit('definirQtd', index, 'mais')" class="churros__qtd__mais">+</button>
        </div>

        <!-- Churros - Botão comprar -->
        <button v-if="btnComprar" @click="adicionarCarrinho()" class="button btn__small btn__comprar cardChurros__comprar">Adicionar</button>
    </div>
</div>
</template>

<script>
import Ajax from '../../mixins/ajax.js';

export default {
    name: "CardChurros",
    data () {
        return {
            churros: {
                codigo: [],
                preco: 10,
                quantidade: 1
            },

            tipos: []
        }
    },
    mixins: [Ajax],
    async mounted () {

        // Pega os dados recebidos, armazena e formata
        if (this.cardChurros != undefined) {
            let churros = await this.ajaxGet('/getchurros/'+JSON.stringify(this.cardChurros.codigo));
            this.churros.codigo = churros.codigo;
            this.churros.preco = churros.preco;
            this.tipos = await this.ajaxGet('/tiposabores/get/');
        }
    },
    methods: {

        // Adiciona o Churros Pre Definido ao Carrinho
        adicionarCarrinho () {
            let churrosLocal = {codigo: this.cardChurros.codigo, quantidade: 1, nome: this.cardChurros.nome};
            let churrosCount = false;

            if (localStorage.getItem("carrinho")) {
                let carrinho = JSON.parse(localStorage.getItem('carrinho'));

                carrinho.forEach((churros, index) => {
                    if ((churros.codigo).toString() == Object.values(churrosLocal.codigo).toString()) {
                        churrosCount = index;
                    }
                });

                if (churrosCount >= 0 && !(churrosCount === false)) {
                    if (carrinho[churrosCount].quantidade < 10) {
                        carrinho[churrosCount].quantidade++;
                    } else {
                        return;
                    }
                } else {
                    carrinho.push(churrosLocal);
                }
                
                
                localStorage.setItem("carrinho", JSON.stringify(carrinho));
            } else {
                localStorage.setItem("carrinho", JSON.stringify([churrosLocal]));
            }

            this.$emit('alertLimpar');
            this.$emit("alert", {texto: this.cardChurros.nome +" adicionado ao carrinho!", tipo: "sucesso", delay: 3})
            this.$emit("atualizarCarrinho");
        }
    },
    props: {
        cardChurros: Object,
        index: Number,
        qtdChurros: Number,
        btnExcluir: false,
        definirQtd: false,
        btnComprar: false
    }
}
</script>

<style scoped>
.cardChurros__item {
    align-self: center;
    background-color: #fff;
    border: 1px solid #c2c2c2;
    box-shadow: 0px 2px 6px rgb(0 0 0 / 16%);
    border-radius: 10px;
    margin-bottom: 40px;
    width: clamp(240px, 100%, 350px);
}

.cardChurros__header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 20px;
    box-shadow: 0px 3px 6px rgb(0 0 0 / 8%);
    border-radius: 10px;
    margin-bottom: 10px;
}

#cardChurros__title {
    width: 50%;
    align-self: center;
    font-size: 1.1em;
    margin-bottom: 0;
    margin-right: 20px;
    text-transform: capitalize;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.cardChurros__item .btn__excluir {
    font-weight: 400;
    font-size: .9em;
    width: clamp(60px, 50%, 80px);
    padding: 8px 0;
    border-radius: 8px;
    background-image: none;
    background-color: var(--cor-red); 
}

.churros__opcoes {
    justify-content: center;
    padding: 10px;
    min-height: 100px;
}

.cardChurros__content__item {
    width: 45%;
    text-transform: capitalize;
    padding: 5px 10px;
    border-radius: 5px;
    margin: 5px;
    min-height: 34px;
    border: 1px solid #c2c2c2;
    box-shadow: 0px 3px 6px rgb(0 0 0 / 8%);
}

.cardChurros__content__item p {
    font-size: 1em;
    font-weight: 500;
    margin-bottom: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.cardChurros__content__item span {
    font-size: .8em;
    font-weight: 400;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


.cardChurros__body {
    margin-top: 10px;   
    padding: 20px;
    box-shadow: 0px -3px 6px rgb(0 0 0 / 8%);
    border-radius: 10px;
}

.cardChurros__body p {
    margin-bottom: 0;
}

#cardChurros__preco {
    align-self: center;
    color: #001010;
    font-size: 1.3em;
    font-weight: 500;
    margin-bottom: 0;
}

#cardChurros__qtd {
    text-align: center;
    padding: 5px 0;
    background-color: var(--cor-1);
    font-size: 1em;
    color: #fff;
    width: 35px;
    border-radius: 35px 35px 0 35px;
    box-shadow: 0px 2px 6px rgb(0 0 0 / 15%);
}

#cardChurros__definirQtd p {
    font-size: 1.1em;
    align-self: center;
    font-weight: 500;
    margin-bottom: 0;
    padding: 0 12px;
}

#cardChurros__definirQtd button {
    padding: 5px 0;
    background-color: var(--cor-1);
    font-size: 1em;
    color: #fff;
    width: 40px;
    box-shadow: 0px 2px 6px rgb(0 0 0 / 15%);
}

.churros__qtd__menos {
    border-radius: 10px 0 10px 10px;
}

.churros__qtd__mais {
    border-radius: 0 10px 10px 10px;
}

.btn__comprar {
    font-size: 1em;
    width: 50%;
    border-radius: 8px;
    padding: 10px 0;
    background-color: var(--cor-green);
}
</style>