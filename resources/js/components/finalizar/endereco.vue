<template>
    <div id="endereco" class="active slider__item">

        <!-- Titulo do slider -->
        <p class="subtitulo">Informe O Endereço De Entrega:</p>

        <!-- Input - CEP -->
        <div class="base__input">
            <input v-model="dados.cep" name="cep" @change="getEndereco(dados.cep)" type="text" id="input__cep" v-maska="'#####-###'" autofocus required>
            <label for="input__cep"><span>(Opcional)</span> CEP:</label>
        </div>

        <!-- Input - Rua -->
        <div class="base__input">
            <input v-model="dados.rua" name="rua" type="text" id="input__rua" required>
            <label for="input__rua">Rua:</label>
        </div>

        <!-- Input - Bairro -->
        <div class="base__input">
            <input v-model="dados.bairro" name="bairro" type="text" id="input__bairro" required>
            <label for="input__bairro">Bairro:</label>
        </div>

        <!-- Input - Cidade -->
        <div class="base__input">
            <input v-model="dados.cidade" name="cidade" type="text" id="input__cidade" required>
            <label for="input__cidade">Cidade:</label>
        </div>

        <!-- Input - Número Residencial -->
        <div class="base__input">
            <input v-model="dados.num" name="num" type="text" id="input__num" v-maska="'#####'" required>
            <label for="input__num">Nº Residencial:</label>
        </div>

        <!-- Input - Telefone -->
        <div class="base__input">
            <input v-model="dados.telefone" name="telefone" type="text" id="input__tel" v-maska="'(11) ####-####'" required>
            <label for="input__tel">Telefone Fixo:</label>
        </div>

        <!-- Input - Observações -->
        <div class="base__input">
            <input v-model="dados.obs" name="obs" type="text" id="input__obs">
            <label for="input__obs"><span>(Opcional)</span> Observações:</label>
        </div>

        <!-- Slider - Botões -->
        <div id="botoes" class="d-flex flex-column">
            <button @click="this.$emit('btnConfirmar')" id="btn__proximo" class="button btn__padrao">Confirmar <i class="icon__right fas fa-check"></i></button>
        </div>

        <Alert ref="alert"/>
    </div>
</template>

<script>
import Alert from '../alert.vue';

import Ajax from '../../../mixins/ajax.js';

export default {
    name: "Endereco",
    data () {
        return {
            dados: {
                cep: '',
                rua: '',
                bairro: '',
                cidade: '',
                num: '',
                obs: null,
                telefone: ''
            }
        }
    },
    mixins: [Ajax],
    methods: {

        // Envia os dados do formulário após validar
        async getDados () {
            let dados = {
                cep: this.dados.cep.replace("-", ""),
                rua: this.dados.rua,
                bairro: this.dados.bairro,
                cidade: this.dados.cidade,
                num: this.dados.num,
                telefone: this.dados.telefone.replace("-", "").replace("(11)", ""),
                obs: this.dados.obs
            }

            let retorno = await this.ajax({
                url: '/pedido/validar/endereco',
                method: 'post',
                dado: dados,
                seletorInput: '.slider__item#endereco',
                loader: '#endereco #botoes #btn__proximo'
            });

            if (retorno) {
                return dados;
            } else {
                return false;
            }
        },

        // Preenche os campos de endereço automaticamente através do CEP
        async getEndereco (cep) {
            cep = cep.toString().replace("-", "");

            if (cep.length == 8 && !isNaN(cep)) {
                let endereco = await fetch("https://viacep.com.br/ws/"+cep+"/json/", {method: "get"});
                endereco = await endereco.json();

                if (endereco.logradouro && endereco.bairro && endereco.localidade) {
                    this.dados.rua = endereco.logradouro;
                    this.dados.bairro = endereco.bairro;
                    this.dados.cidade = endereco.localidade;
                }
            } else {
                return false;
            }
        }
    },
    components: {
        Alert
    }
}
</script>