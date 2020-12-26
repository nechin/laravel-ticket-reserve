<template>
    <div>
        <h4>Список событий мероприятия #{{ action_id }}</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Дата события</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-if="!loading"
                v-for="(event, index) in events"
            >
                <th scope="row">{{ index }}</th>
                <td>
                    <router-link :to="{ name: 'Event', params: { event_id: event.id } }">
                        {{ event.date }}
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
    name: "Action",
    data() {
        return {
            loading: false,
            events: []
        };
    },
    props: {
        action_id: {
            type: [String, Number],
            default: 0
        }
    },
    created() {
        this.getEvents();
    },
    methods: {
        getEvents() {
            this.loading = true;
            axios
                .get('/api/events/' + this.action_id)
                .then(response => {
                    this.events = response.data.data;
                }).catch(error => {
                    const errorText = error.response.data.message || error.message;
                    alert(errorText);
                }).finally(() => this.loading = false);
        }
    }
}
</script>

<style scoped>

</style>
