export default {
    name: "User",
    data () {
        return {
            csrfToken: document.head.querySelector("[name~=csrf-token][content]").content,
        }
    },
    methods: {

        // Verifica se o usuário está logado
        async verificarLogin() {
            let json = await fetch('/login/check', {
                method: "post",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": this.csrfToken
                }
            });
            return await json.json();
        },

        // Efetua o logout do usuário
        async logout() {
            let json = await fetch('/login/logout', {method: "GET"});
            window.location.href = window.location.href;
            return await json.json();
        }
    }
}