<template>
    <div class="container">

        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav">
                        <router-link to="/tasks" class="nav-item nav-link">Tarefas</router-link>
                        <router-link to="/tags" class="nav-item nav-link">Categorias</router-link>
                    </div>
                </div>
            </nav>
        </div>

        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>
    .bg-light {
        background-color: #eae9e9 !important;
    }
    .nav-link:hover {
        background-color: #efefef;
        border-radius: 15%;
    }
    .router-link-active {
        background-color: #efefef;
        border-radius: 15%;
    }
</style>
