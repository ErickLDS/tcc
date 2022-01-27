export default {
    name: 'Ajax',
    data () {
        return {
            csrfToken: document.head.querySelector("[name~=csrf-token][content]").content,
        }
    },
    methods: {

        // Requisições de operações, envia dados e retorna true ou false
        async ajax (content) {
            let anterior;
            if (content.loader) {
                anterior = document.querySelector(content.loader).innerHTML;
                document.querySelector(content.loader).innerHTML = '<i class="spinner fas fa-spinner"></i>';
            }

            let json = await fetch(content.url, {
                method: content.method,
                body: JSON.stringify(content.dado),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": this.csrfToken
                }
            });

            let resposta = await json.json();

            if (await content.loader) {
                document.querySelector(content.loader).innerHTML = anterior;
            }

            if (resposta.sucesso === 0) {    
                return;
            }

            this.$refs.alert.limpar();

            if (resposta.mensagens) {
                let mensagens = Object.values(resposta.mensagens);
                if (resposta.sucesso == true) {
                    mensagens.forEach((e) => {
                        this.$refs.alert.definirAlert({
                            texto: e[0],
                            tipo: "sucesso",
                            delay: 4
                        });
                    });
                } else if (resposta.sucesso === false) {                
                    mensagens.forEach((e) => {
                        this.$refs.alert.definirAlert({
                            texto: e[0],
                            tipo: "erro"
                        });
                    });
                }
            }
            

            if (resposta.campos) {
                let campos = Object.keys(resposta.mensagens);
                this.retornoComCampos(campos, content.seletorInput);
            }

            return resposta.sucesso;
        },

        // Requisição para pegar determinado valor a partir de uma rota get
        async ajaxGet (url) {
            let json = await fetch(url, {method: "get"});
            return await json.json();
        },

        // A partir dos campos retornados pela requisição, é feita a atualização do front-end
        retornoComCampos (campos, selector) {
            let elementos = document.querySelectorAll(selector+" .base__input input");
            
            elementos.forEach((e) => {
                if (campos.indexOf(e.name) >= 0) {
                    e.parentNode.classList.add('input__erro');
                } else {
                    e.parentNode.classList.remove('input__erro');
                }
            });
        }
    }
}