<template>
    <!-- Copyright -->
    <p id='copyright' class="text-center mb-0">Copyright © {{date}} | Erick Lima. Todos os direitos reservados.</p>
</template>

<style scoped>
#copyright {
    padding: 20px 25px;
    color: #fff;
    margin-top: 60px;
    background-color: #101010;
    font-size: .9em;
    font-weight: 300;
}
</style>

<script>
export default {
    name: "Copyright",
    data () {
        return {
            date: new Date().getFullYear()
        }
    }
}
</script>