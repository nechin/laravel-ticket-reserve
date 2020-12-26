<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Мероприятие</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-if="!loading"
                v-for="(action, index) in actions"
            >
                <th scope="row">{{ index }}</th>
                <td>
                    <router-link :to="{ name: 'Action', params: { action_id: action.id } }">
                        {{ action.name }}
                    </router-link>
                </td>
            </tr>
            <tr
                v-if="loading"
            >
                <td colspan="2">Загрузка ...</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Actions",
    data() {
        return {
            loading: false,
            actions: {}
        };
    },
    created() {
        this.getActions();
    },
    methods: {
        getActions() {
            this.loading = true;
            axios
                .get('/api/actions')
                .then(response => {
                    this.actions = response.data.data;
                }).catch(error => {
                    const errorText = error.response.data.message || error.message;
                    alert(errorText);
                }).finally(() => this.loading = false);
        }
    }
}
</script>
