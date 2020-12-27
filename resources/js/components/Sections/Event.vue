<template>
    <div>
        <h4>Список мест события #{{ event_id }}</h4>
        <div>
            <!-- Выбор класса по условию "place.position !== 570" осознанный "костыль" для тестового задания -->
            <div
                v-if="!loading"
                v-for="place in places"
                :class="{ flexItem: place.position !== 570 }"
                style="padding: 3px"
            >
                <button
                    v-if="place.is_available"
                    v-on:click="selectPlace(place.id)"
                    type="button"
                    class="btn btn-primary place-button"
                >
                    {{ place.id }}
                </button>
                <button
                    v-else type="button"
                    class="btn btn-secondary disabled place-button"
                >
                    {{ place.id }}
                </button>
            </div>
        </div>

        <!-- Выбранные места просто выводим списком, а не отмечаем визуально. Так проще, хотя менее красиво -->
        <div v-if="selectedPlaces.length > 0">
            Выбранные места: <b>{{ selectedPlaces }}</b>
            <div>
                <button
                    v-on:click="reserve()"
                    type="button"
                    class="btn btn-success"
                >
                    Забронировать
                </button>
                <label>
                    <input v-model="reserve_name" type="text" value="" placeholder="Введите имя">
                </label>
            </div>
        </div>

        <div v-if="reservation_id">
            <b>Номер резерва: {{ reservation_id }}</b>
        </div>

        <div v-if="loading">Загрузка ...</div>
    </div>
</template>

<script>
export default {
    name: "Event",
    data() {
        return {
            loading: false,
            places: [],
            place_ids: [],
            reserve_name: '',
            reservation_id: ''
        };
    },
    props: {
        event_id: {
            type: [String, Number],
            default: 0
        },
    },
    created() {
        this.getPlaces();
    },
    computed: {
        selectedPlaces() {
            // Удаляя дубликаты
            return this.place_ids.filter(function(item, pos, self) {
                return self.indexOf(item) == pos;
            })
        }
    },
    methods: {
        getPlaces() {
            this.loading = true;
            axios
                .get('/api/places/' + this.event_id)
                .then(response => {
                    this.places = response.data.data;
                }).catch(error => {
                    const errorText = error.response.data.message || error.message;
                    alert(errorText);
                }).finally(() => this.loading = false);
        },
        selectPlace(place_id) {
            this.place_ids.push(place_id);
        },
        reserve() {
            if (this.reserve_name !== '') {
                axios
                    .post(
                        '/api/reserve/' + this.event_id,
                        {
                            name: this.reserve_name,
                            places: this.place_ids
                        }
                    )
                    .then(response => {
                        this.reservation_id = response.data.reserve_id;
                    }).catch(error => {
                        const errorText = error.response.data.message || error.message;
                        alert(errorText);
                    });
            } else {
                alert('Введите имя для резерва мест');
            }
        }
    }
}
</script>

<style scoped>
    .flexItem {
        float: left;
    }

    .place-button {
        width: 49px;
    }
</style>
