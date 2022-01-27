<template>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div class="toast-container">
        <div v-for="item in formatarAlerts()" :key="item" :class="'toast show '+item.tipo" role="alert" aria-live="assertive">

            <!-- Alert -->
            <div class="d-flex justify-content-between">

                <!-- Alert -- Texto -->
                <div class="toast-body">{{item.texto}}</div>

                <!-- Alert -- Botão Fechar -->
                <i v-if="!item.delay" @click="deletarAlert(item.id)" class="toast__btnFechar fas fa-times"></i>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>
.toast-container {
    width: clamp(100px, 70%, 350px);
    float: right;
    z-index: 9999;
}

.toast {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    animation: slide__down 500ms ease;
    align-items: center;
    padding: 0 5px;
    box-shadow: 0 0 15px rgb(0 0 0 / 20%);
}

.toast.erro {
    background-color: var(--cor-red);
}

.toast.sucesso {
    background-color: var(--cor-green);
}

.toast-body {
    color: #fff;
    text-transform: capitalize;
    font-size: 1.1em;
    padding: 20px 15px;
}

.toast__btnFechar {
    cursor: pointer;
    padding: 20px;
    width: 20%;
    text-align: end;
    align-self: center;
    font-size: 1.4em;
    color: #fff;
}

@media screen and (min-width: 400px) {
    .toast-container {
        width: clamp(100px, 90%, 350px);   
    }
}
</style>

<script>
export default {
    name: "Alert",
    data () {
        return {
            alerts: [],
        }
    },
    methods: {

        // Formata o Array de alerts para apresenta-los no Front-End
        formatarAlerts () {
            let alerts = this.alerts.slice(0,2).reverse();
            alerts.forEach((item, index) => {
                item.id = (alerts.length-1)-index;
                if (item.delay) { this.delay(item); }
            });
            return alerts;
        },

        // Defini o Array de Alerts
        definirAlert (content) {
            if (this.alerts[0]) {
                if (this.verificarAlerts(content) == 0) {
                    this.alerts.push(content);
                }
            } else { this.alerts.push(content); }
        },

        // Deleta os Alerts
        deletarAlert (index) {
            this.alerts.splice(index, 1);
        },

        // Deleta os Alerts depois do tempo definido
        delay (item) {
            setTimeout(() => {
                let index = this.alerts.indexOf(item);
                if (index >= 0) { this.deletarAlert(item.id); }
            }, item.delay*1000);
        },

        // Limpa um alert especifico ou todos os alerts
        limpar (item = undefined) {
            if (item) {
                this.alerts.forEach((e, index) => {
                    if (e.texto == item) {this.deletarAlert(index)}
                });
            } else {
                this.alerts = [];
            }
        },

        // Verifica se já existe alerts com o mesmo texto
        verificarAlerts (item) {
            let i = 0;
            this.alerts.forEach((e) => {
                if (e.texto == item.texto) { i++; }
            });
            return i;
        }
    }
}
</script>