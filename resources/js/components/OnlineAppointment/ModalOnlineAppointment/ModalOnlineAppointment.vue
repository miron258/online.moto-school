<template>
    <modal :name="name"
           :height="height"
           :width=modalWidth
           :adaptive="adaptive"
           :classes="classes"
           @closed="close"
           @beforeOpen="beforeOpen"
           @beforeClose="beforeClose"
           @opened="opened"
           :focusTrap="focusTrap"
           :scrollable="scrollable"
           :draggable="draggable"
           :resizable="resizable"
           :reset="reset"
           :clickToClose="clickToClose">
        <div class="dialog-content">

            <div class="header-modal">
                <div class="title-modal">Добавление/Редактирование онлайн-записи</div>
                <button @click="$modal.hide('modal-online-appointment')" class="button-close-modal"
                        type="button"></button>
            </div>
            <!--------------- ONLINE APPOINTMENT FORM ------------------->
            <online-appointment-form @onUpdateAppointment="hide"
                                     @onAddAppointment="hide"
                                     @onDeleteAppointment="hide"
                                     v-bind:year="year"
                                     v-bind:month="month"
                                     v-bind:appointment="appointment"
                                     :bikes="bikes">
            </online-appointment-form>
            <!--------------- END ONLINE APPOINTMENT FORM ------------------->
        </div>

    </modal>
</template>

<script type="module">
import Vue from "vue";
import VModal from 'vue-js-modal'
import OnlineAppointmentForm from "../OnlineAppointmentForm/OnlineAppointmentForm";

Vue.use(VModal, {dialog: true});
import Vuex from 'vuex';
import {createNamespacedHelpers} from 'vuex';

const {mapGetters} = createNamespacedHelpers('onlineAppointment');
Vue.use(VModal, {dialog: true});
const MODAL_WIDTH = 532

export default {
    name: "ModalOnlineAppointment",
    props: {
        btModalClose: String,
        bikes: Array,
        year: String,
        month: String
    },
    components: {
        OnlineAppointmentForm,
        VModal,
        Vuex
    },
    created() {
        this.modalWidth =
            window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
    },
    mounted() {


    },
    data() {
        return {
            isBtModalClose: this.btModalClose,
            name: "modal-online-appointment", //String required Обязательно для заполнения свойство
            classes: "v-modal-online-appointment", //String | Array
            modalWidth: MODAL_WIDTH,
            scrollable: true, //Boolean
            focusTrap: true, //Boolean
            draggable: false, //Boolean
            resizable: false, //Boolean
            reset: true, //Boolean Resets position and size before showing
            clickToClose: true, //Boolean If set to false, it will not be possible to close modal by clicking on the background or by pressing Esc key.
            maxHeight: "",
            height: "auto",
            styles: "", //String | Array | Object
            adaptive: true
        }
    },
    computed: {
        ...mapGetters(['appointments', 'appointment', 'loader', 'message']),
    },
    methods: {
        show(data) {

            console.log("data");
            console.log(data);

            this.$modal.show('modal-online-appointment', data);


            this.$store.commit('onlineAppointment/SET_APPOINTMENT', data);

        },
        hide() {
            this.$modal.hide('modal-online-appointment');
        },
        close() {
            this.$store.commit('onlineAppointment/RESET_APPOINTMENT', undefined);
        },
        opened(event){

            console.log("event");
            console.log(event);

            let tdTimeLesson = event.target;


            console.log("tdTimeLesson");
            console.log(tdTimeLesson);

            console.log('Opened');
        },

        //Access Events
        beforeOpen(event) {
            console.log('Opening...')
        },
        beforeClose(event) {
            console.log('Closing...')

        }
    }
}
</script>

<style lang="scss">
.v--modal-box.v-modal-online-appointment {
    margin-top: 40px;
    margin-bottom: 40px;
    background: #fff;
    box-shadow: 4px 4px 5px rgba(0, 0, 0, 0.15);

    .dialog-content {

        .header-modal {
            background-color: #3490dc;
            position: relative;
            height: 44px;
            padding-top: 10px;

            .title-modal {
                font-family: Montserrat;
                font-style: normal;
                font-weight: bold;
                font-size: 16px;
                color: #FFFFFF;
                margin: 0 auto;
                text-align: center;
            }

            .button-close-modal {
                background: url('/img/tpl_img/modal_close.png') no-repeat;
                width: 20px;
                height: 20px;
                outline: none;
                border: none;
                position: absolute;
                right: 10px;
                top: 12px;

            }
        }
    }
}

</style>
