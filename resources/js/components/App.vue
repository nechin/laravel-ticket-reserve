<template>
    <div>
        <div class="row justify-content-center pt-2">
            <router-link :to="{ name: 'Actions' }">
                <strong>Главная страница</strong>
            </router-link>
        </div>

        <div class="pt-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>
