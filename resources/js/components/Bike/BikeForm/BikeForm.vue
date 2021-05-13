<template>
    <div class="container-form-bike">
        <div v-show="loaderForm" class="loader-gif">
            <img src="/img/tpl_img/ajax.gif" class="ajax-loader"/>
        </div>
        <div v-html="messageForm" class="message"></div>
        <form @keydown="form.onKeydown($event)" @submit.prevent="submit" method="post" class="form-create-bike"
              ref="formBike">

            <div v-bind:class="{'has-error' : form.errors.has('name')}" class="form-group form-group-name">
                <label>Название мотоцикла:</label>
                <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" type="text" name="name"
                       class="form-control form-control-name"
                       placeholder="Название мотоцикла">
                <has-error :form="form" field="name"></has-error>
            </div>


            <div v-bind:class="{'has-error' : form.errors.has('position')}" class="form-group form-group-position">
                <label>Позиция:</label>
                <input v-model="form.position" :class="{ 'is-invalid': form.errors.has('position') }" type="number" name="position"
                       class="form-control form-control-position"
                       placeholder="Позиция">
                <has-error :form="form" field="position"></has-error>
            </div>
            <button type="submit" class="btn btn-primary btn-send-form">Сохранить</button>

        </form>

    </div>
</template>

<script>
//Import v-from
import {Form, HasError, AlertError, AlertErrors, AlertSuccess} from 'vform'
import Vuex from 'vuex'
import {createNamespacedHelpers} from 'vuex';
const {mapGetters} = createNamespacedHelpers('bikes');

export default {
    name: "BikeForm",
    //Метод позволяющий следить за  изменением свойств в компоненте
    watch: {},
    props: ['bike'],
    components: {
        Vuex,
        // mapGetters,
        Form,
        HasError,
        AlertError,
        AlertErrors,
        AlertSuccess
    },
    mounted() {

        console.log("this.bike bike form")
        console.log(this.bike)

    },
    computed: {
        ...mapGetters(['bikes', 'loaderForm', 'messageForm']),

    },
    data() {
        return {
            // loader: false,
            // message: null,
            ////Сформированные данные после того как форма была успешно отправлена
            form: new Form({
                name: (this.bike !== undefined)? this.bike.name: "",
                position: (this.bike !== undefined)? this.bike.position: "",
                id: (this.bike !== undefined)? this.bike.id: "",
            })
        }
    },
    methods: {


        submit() {

            if ( this.bike !== undefined ){
                this.$store.commit('bikes/SET_LOADER_FORM', true);


                //Отправляем введенные данные на сервер через библиотеку AXIOS
                this.form.put('/bike/'+this.bike.id)
                    .then(response => {
                        this.status = response.data.success;
                        if (this.status) {
                            //Чистим поля формы после успешной отправки
                            this.form.reset();
                            this.$store.commit('bikes/SET_STORE', response);
                            this.form.name = response.data.bike.name;
                        }
                        console.log(response);


                    }).catch(err => {



                    console.log(err);


                })
                    .finally(()=>{
                        this.$store.commit('bikes/SET_LOADER_FORM', false);
                    });


            } else {

                //Отправляем введенные данные на сервер через библиотеку AXIOS
                this.$store.commit('bikes/SET_LOADER_FORM', true);
                this.form.post('/bike')
                    .then(response => {

                        this.status = response.data.success;


                        if (this.status) {
                            //Чистим поля формы после успешной отправки
                            this.form.reset();
                            this.$store.commit('bikes/SET_STORE', response);
                            // this.$emit('`onAddBike`');

                        }
                        console.log(response);


                    }).catch(err => {



                    console.log(err);


                })
                    .finally(()=>{
                        this.$store.commit('bikes/SET_LOADER_FORM', false);
                    });
            }





        }
    }
}
</script>

<style lang="scss">
.container-form-bike{
    padding: 20px 20px 20px 20px;
}


//@import "resources/sass/desktop/catalog/layouts/form_order_sparts.scss";

</style>
