<template>
    <div class="wrapper-modal-bike">

        <modal :name="name"
               :height="height"
               :minWidth=minWidth
               :adaptive="adaptive"
               :classes="classes"
               @closed="close"
               :focusTrap="focusTrap"
               :scrollable="scrollable"
               :draggable="draggable"
               :resizable="resizable"
               :reset="reset"
               :clickToClose="clickToClose">

            <div class="dialog-content">
                <div class="header-modal">
                    <div class="title-modal">Добавление/Редактирование мотоциклов</div>
                    <button @click="$modal.hide('modal-bike')" class="button-close-modal"
                            type="button"></button>
                </div>
                <!--------------- BIKE FORM ------------------->
                <bike-form v-bind:bike="bike"></bike-form>
                <!--------------- END BIKE FORM ------------------->
            </div>

        </modal>

    </div>


</template>

<script>
import Vue from 'vue'
import VModal from 'vue-js-modal'
import 'vue-js-modal/dist/styles.css'
import BikeForm from "../BikeForm/BikeForm";
import Vuex from 'vuex';
import {createNamespacedHelpers} from 'vuex';

const {mapGetters} = createNamespacedHelpers('bikes');
Vue.use(VModal, {dialog: true});


export default {
    name: "ModalBike",
    props: {
        btModalClose: String,
        id: Number
    },
    components: {
        BikeForm,
        VModal,
        Vuex
    },
    mounted() {


    },
    data() {
        return {
            isBtModalClose: this.btModalClose,
            name: "modal-bike", //String required Обязательно для заполнения свойство
            classes: "v-modal-bike", //String | Array
            minWidth: 320,
            scrollable: true, //Boolean
            focusTrap: true, //Boolean
            draggable: true, //Boolean
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
        ...mapGetters(['bikes', 'bike', 'loader', 'message']),
    },
    methods: {
        show() {
            this.$modal.show('modal-bike');
        },
        close() {

            this.$store.commit('bikes/RESET_BIKE', undefined);

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
.v--modal-box.v-modal-bike {
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
