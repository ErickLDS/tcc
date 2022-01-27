<template>
<header>
    
    <!-- Menu PC -->
    <div id="menu__pc" class="flex-column">
        <div class="d-flex flex-column">
            <a class="menu__item menu__title" href="/ck10dashboard/">Dashboard</a>
            <a class="menu__item logout" href="/dashboard/logout">Sair<i class="icon__right fas fa-sign-out-alt"></i></a>
        </div>
        <hr>
        <a class="menu__item" href="/ck10dashboard/pedidos">Pedidos</a>
        <a class="menu__item" href="/ck10dashboard/tipossabores">Tipos de Sabores</a>
        <a class="menu__item" href="/ck10dashboard/sabores">Sabores</a>
    </div>

    <!-- Menu Mobile -->
    <div id="menu__mobile">
        <div class="content d-flex flex-row justify-content-between mx-auto">
            <!-- Menu Mobile - Logo -->
            <img onclick="location.href='/'" id="logo" src="/img/logo.svg" alt="Logo">

            <!-- Menu Mobile - Botão abrir -->
            <img id="btn__menu" src="/img/menu.svg" alt="Menu" data-bs-toggle="offcanvas" data-bs-target="#mega__menu">
        </div>

        <!-- Offcanvas Menu Mobile -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mega__menu" aria-labelledby="Menu">

            <!-- Offcanvas Menu Mobile - Cabeçalho -->
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Dashboard</h5>

                <i id="btn__fechar" class="fas fa-chevron-right" data-bs-dismiss="offcanvas" aria-label="Close"></i>
            </div>

            <!-- Offcanvas Menu Mobile - Corpo -->
            <div class="offcanvas-body d-flex flex-column">
                <a class="menu__item logout" href="/dashboard/logout">Sair<i class="icon__right fas fa-sign-out-alt"></i></a>
                <a class="menu__item" href="/ck10dashboard/pedidos">Pedidos</a>
                <a class="menu__item" href="/ck10dashboard/tipossabores">Tipos de Sabores</a>
                <a class="menu__item" href="/ck10dashboard/sabores">Sabores</a>
            </div>
        </div>
    </div>
</header>
</template>

<script>
export default {
    name: "DashboardMenu",
    data () {
        return {
            
        }
    }
}
</script>