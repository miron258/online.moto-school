<template>
    <div class="container-form-appointment">
        <div v-show="loaderForm" class="loader-gif">
            <img src="/img/tpl_img/ajax.gif" class="ajax-loader"/>
        </div>
        <div v-html="messageForm" class="message"></div>
        <form @keydown="form.onKeydown($event)" @submit.prevent="submit" method="post" class="form-create-appointment"
              ref="formBike">

            <div v-bind:class="{'has-error' : form.errors.has('text')}" class="form-group form-group-text">
                <label>Данные клиента:</label>
                <textarea v-model="form.text" :class="{ 'is-invalid': form.errors.has('text') }" name="text"
                          class="form-control form-control-text"
                          placeholder="Данные клиента"></textarea>
                <has-error :form="form" field="text"></has-error>
            </div>

            <div v-bind:class="{'has-error' : form.errors.has('phone')}" class="form-group form-group-phone">
                <label>Номер телефона:</label>
                <masked-input mask="(\+1) (111) 111-11-11" v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" type="tel" name="phone"
                          class="form-control form-control-text"
                          placeholder="Номер телефона"/>
                <has-error :form="form" field="phone"></has-error>
            </div>

            <div v-bind:class="{'has-error' : form.errors.has('status')}" class="form-group">
                <label for="FormControlSelectStatus">Статус:</label>
                <select :class="{ 'is-invalid': form.errors.has('status') }" v-model="form.status"
                        class="form-control" id="FormControlSelectStatus">
                    <option value="0" selected>В обработке</option>
                    <option value="1">Пришел</option>
                    <option value="2">Не пришел</option>
                </select>
                <has-error :form="form" field="status"></has-error>
            </div>

            <p style="color: red"><b>Поля доступные для просмотра</b></p>

            <div v-bind:class="{'has-error' : form.errors.has('date_record')}"
                 class="form-group form-group-date-record">
                <label>Дата записи:</label>
                <VueCtkDateTimePicker :disabled="true" :class="{ 'is-invalid': form.errors.has('date_record') }"
                                      label="Выберите дату онлайн-записи" :only-date=true :no-header=true
                                      format="YYYY-MM-DD" v-model="form.date_record"/>
                <has-error :form="form" field="date_record"></has-error>
            </div>

            <div v-bind:class="{'has-error' : form.errors.has('time_from')}" class="form-group form-group-time-from">
                <label style="display: block">Время записи от/до:</label>
                <vue-timepicker :disabled="true"
                    auto-scroll
                    :hour-range="[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]"
                    :minute-range="[0]"
                    :minute-interval="10"
                    :class="{ 'is-invalid': form.errors.has('time_from') }" placeholder="Начало урока"
                    v-model="form.time_from" format="HH:mm">
                    <template v-slot:icon>
                        <i class="far fa-clock"></i>
                    </template>
                </vue-timepicker>
                <has-error :form="form" field="time_from"></has-error>
            </div>


            <div  v-bind:class="{'has-error' : form.errors.has('time_to')}" class="form-group form-group-time-to">
                <vue-timepicker
                    :disabled="true"
                    auto-scroll
                    :hour-range="[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]"
                    :minute-range="[0]"
                    :minute-interval="10"
                    :class="{ 'is-invalid': form.errors.has('time_to') }"
                    placeholder="Конец урока" v-model="form.time_to" format="HH:mm">
                    <template v-slot:icon>
                        <i class="far fa-clock"></i>
                    </template>
                </vue-timepicker>
                <has-error :form="form" field="time_to"></has-error>
            </div>

            <div v-bind:class="{'has-error' : form.errors.has('bike_id')}" class="form-group">
                <label for="FormControlSelectBike">Выберите мотоцикл:</label>
                <select :disabled="true" :class="{ 'is-invalid': form.errors.has('bike_id') }" v-model="form.bike_id"
                        class="form-control" id="FormControlSelectBike">
                    <option :value="bike.id" v-for="(bike, index) in bikes" v-text="bike.name"></option>
                </select>
                <has-error :form="form" field="bike_id"></has-error>
            </div>

            <input type="hidden" v-model="form.year">
            <input type="hidden" v-model="form.month">
            <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary btn-send-form">Сохранить</button>
            <button v-if="form.text !==''" style="margin-left: 10px;" @click="deleteAppointment(appointment.id)" class="btn btn-danger btn-send-form float-right">Удалить</button>
            </div>
        </form>

    </div>
</template>

<script>
//Import v-from
import {Form, HasError, AlertError, AlertErrors, AlertSuccess} from 'vform'
import MaskedInput from 'vue-masked-input'
import {TheMask, mask} from 'vue-the-mask'

// Main JS (in UMD format)
import VueTimepicker from 'vue2-timepicker'
// CSS
import 'vue2-timepicker/dist/VueTimepicker.css'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import Vuex from 'vuex'
import {createNamespacedHelpers} from 'vuex';

const {mapGetters} = createNamespacedHelpers('onlineAppointment');

export default {
    name: "OnlineAppointmentForm",
    //Метод позволяющий следить за  изменением свойств в компоненте
    watch: {},
    props: ['appointment', 'bikes', 'year', 'month'],
    components: {
        Vuex,
        TheMask,
        mask,
        MaskedInput,
        VueTimepicker,
        VueCtkDateTimePicker,
        Form,
        HasError,
        AlertError,
        AlertErrors,
        AlertSuccess
    },
    mounted() {


    },
    computed: {
        ...mapGetters(['appointments', 'years', 'months', 'loaderForm', 'messageForm']),

    },
    data() {
        return {
            ////Сформированные данные после того как форма была успешно отправлена
            form: new Form({
                text: (this.appointment !== undefined) ? this.appointment.text : "",
                bike_id: (this.appointment !== undefined) ? this.appointment.bike_id : "",
                status: (this.appointment !== undefined) ? this.appointment.status : "",
                phone: (this.appointment !== undefined) ? this.appointment.phone : "",
                time_from: (this.appointment !== undefined) ? this.appointment.time_from : "",
                time_to: (this.appointment !== undefined) ? this.appointment.time_to : "",
                date_record: (this.appointment !== undefined) ? this.appointment.date_record : "",
                year: this.year,
                month: this.month
            })
        }
    },
    methods: {
        async deleteAppointment(id){
            let isDelete = confirm("Вы действительно хотите удалить онлайн запись?");
            if (isDelete) {
                let curYear = this.year;
                let cyrMonth = this.month;
                await this.$store.dispatch('onlineAppointment/DELETE_APPOINTMENT', {
                    'year': curYear,
                    'id': id,
                    'month': cyrMonth
                });
                this.$store.commit('onlineAppointment/SET_SCROLLABLE', false);
                this.$root.$emit('onDeleteAppointmentRoot', {});
                this.$emit('onDeleteAppointment', {});
            }
        },
        submit() {

            // console.log("this.appointment");
            // console.log(this.appointment);


            if (this.appointment.id !== '') {

                this.$store.commit('onlineAppointment/SET_LOADER_FORM', true);

                //Отправляем введенные данные на сервер через библиотеку AXIOS
                this.form.put('/online-appointment/' + this.appointment.id)
                    .then(response => {
                        let success = response.data.success;
                        if (success) {
                            //Чистим поля формы после успешной отправки
                            this.form.reset();
                            this.$store.commit('onlineAppointment/SET_STORE', response);
                            this.$store.commit('onlineAppointment/SET_SCROLLABLE', false);

                            this.form.text = response.data.appointment.text;
                            this.form.date_record = response.data.appointment.date_record;

                            this.form.phone = response.data.appointment.phone
                            this.form.status = response.data.appointment.status;
                            this.form.time_from = response.data.appointment.time_from;
                            this.form.time_to = response.data.appointment.time_to;
                            this.form.bike_id = response.data.appointment.bike_id;

                            this.$root.$emit('onUpdateAppointmentRoot', {});
                            this.$emit('onUpdateAppointment', {});
                        }


                    }).catch(err => {


                    console.log(err);


                })
                    .finally(()=>{
                        this.$store.commit('onlineAppointment/SET_LOADER_FORM', false);
                    });


            } else {
                this.$store.commit('onlineAppointment/SET_LOADER_FORM', true);
                //Отправляем введенные данные на сервер через библиотеку AXIOS
                this.form.post('/online-appointment')
                    .then(response => {
                        let success = response.data.success;

                        if (success) {
                            //Чистим поля формы после успешной отправки
                            this.form.reset();
                            this.$store.commit('onlineAppointment/SET_STORE', response);
                            this.$store.commit('onlineAppointment/SET_SCROLLABLE', false);
                            // this.$emit('`onAddBike`');
                            this.$root.$emit('onAddAppointmentRoot', {});
                            this.$emit('onAddAppointment', {});
                        }
                        console.log(response);


                    }).catch(err => {


                    console.log(err);


                })
                    .finally(()=>{
                        this.$store.commit('onlineAppointment/SET_LOADER_FORM', false);
                    });
            }


        }
    }
}
</script>

<style lang="scss">
.container-form-appointment{
    padding: 20px 20px 20px 20px;
}

//@import "resources/sass/desktop/catalog/layouts/form_order_sparts.scss";

</style>
