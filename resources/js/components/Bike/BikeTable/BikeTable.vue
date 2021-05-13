<template>
    <div class="wrapper-table-bikes">
        <div class="message" v-html="message"></div>
        <div v-show="loader" class="loader-gif">
            <img src="/img/tpl_img/ajax.gif" class="ajax-loader"/>
        </div>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Название</td>
                <td>Позиция</td>
                <td>Дата создания</td>
                <td></td>
                <td></td>
            </tr>
            </thead>


            <tbody>
            <tr v-for="(bike, index) in bikes">
                <td v-text="bike.id">

                </td>
                <td v-text="bike.name"></td>
                <td v-text="bike.position"></td>
                <td v-text="bike.created_at"></td>

                <td>
                    <button v-on:click="editBike(bike.id)" class="btn btn-primary btn-sm">
                        <i class="far fa-edit mr-2"></i>Редактировать
                    </button>
                </td>

                <td>
                    <button v-on:click="deleteBike(bike.id)" type='submit' class="btn btn-danger btn-sm">
                        <i class="fas fa-trash mr-2"></i>Удалить
                    </button>
                </td>

            </tr>

            </tbody>

        </table>


    </div>


</template>

<script>
import Vuex from 'vuex';
import axios from "axios";
import {createNamespacedHelpers} from 'vuex';
const {mapGetters} = createNamespacedHelpers('bikes');

export default {
    name: "BikeTable",
    // props:['bikesList'],
    components: {
        Vuex,
        axios
    },
    mounted() {

        this.getBikes();

    },
    data() {
        return {}
    },
    computed: {
        ...mapGetters(['bikes', 'bike', 'loader', 'message']),
    },
    methods: {

        ///Удаление мотоцикла
        deleteBike(id) {
            let isDelete = confirm("Вы действительно хотите удалить мотоцикл?");
            if (isDelete) {
                this.$store.dispatch('bikes/DELETE_BIKE', id);
            }
        },
        //Редактирование мотоцикла
        async editBike(id) {
            await this.$store.dispatch('bikes/GET_BIKE', id);
            this.$root.$refs.modalBike.show()

        },
        //Получить все мотоциклы
        getBikes() {
            this.$store.dispatch('bikes/GET_BIKES');
        },
    }
}
</script>

<style lang="scss">
.wrapper-table-bikes {
    position: relative;

}
</style>
