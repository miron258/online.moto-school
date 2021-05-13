import axios from "axios";
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let state = {
    loader: false,
    loaderForm: false,
    message: "",
    days: {},
    messageForm: "",
    appointments: [],
    years: {},
    scrollable: false,
    months: {},
    appointment: "",
    ///// Список состояний которые будем хранить глобально в объекте Storage
    page: 1,
    ///// Конец Списка состояний которые будем хранить глобально в объекте Storage
};
let getters = {

    ///// Список состояний которые будем хранить глобально в объекте Storage
    page: state => {
        return state.page
    },
    years: state => {
        return state.years
    },
    days: state => {
        return state.days
    },
    months: state => {
        return state.months
    },
    appointments: state => {
        return state.appointments
    },
    appointment: state => {
        return state.appointment
    },
    message: state => {
        return state.message
    },
    messageForm: state => {
        return state.messageForm
    },
    loader: state => {
        return state.loader
    },
    scrollable: state => {
        return state.scrollable
    },
    loaderForm: state => {
        return state.loaderForm
    }
};
let actions = {

    //// Получить онлайн записи
    'GET_ONLINE_APPOINTMENTS'({commit}, data) {

        console.log("data");
        console.log(data);

        commit('SET_LOADER', true);
        axios.get('/online-appointment', {params: data})
            .then(response => {
                commit('SET_STORE', response);

                console.log(response);

            })
            .catch(err => console.log(err)).finally(() => {
            commit('SET_LOADER', false);
        });
    },

    'GET_APPOINTMENT'({commit}, data) {
        commit('SET_LOADER', true);
        return axios.get('/online-appointment/' + data.id + '/edit', {params: data}).then(
            response => {
                commit('SET_STORE', response);
            }).catch(e => {
        }).finally(() => {
            commit('SET_LOADER', false);
        });
    },

    'DELETE_APPOINTMENT'({commit}, data) {
        commit('SET_LOADER', true);
        return axios.delete('/online-appointment/' + data.id, {params: data})
            .then(response => {
                commit('SET_STORE', response);

            })
            .catch(err => console.log(err)).finally(() => {
            commit('SET_LOADER', false);
        });
    },


    /////Поиск онлайн записей
    SEARCH_ONLINE_APPOINTMENTS({commit}, form) {
        // commit('SET_LOADER', true);
        //
        // console.log("form");
        // console.log(form);
        //
        //
        // axios.post('/admin/products', form)
        //     .then(response => {
        //         commit('SET_STORE', response);
        //
        //     })
        //     .catch(err => console.log(err)) .finally(() => {
        //     commit('SET_LOADER', false);
        // });
    },

};
let mutations = {
    'SET_STORE'(state, response) {

        // console.log("response");
        console.log(response.data);

        state.appointments = response.data.appointments;
        state.appointment = response.data.appointment;
        state.years = response.data.years;
        state.days = response.data.days;
        state.months = response.data.months;
        state.loader = false;
        state.loaderForm = false;
        // state.page = response.data.appointments.current_page;
        state.message = response.data.message;
        state.messageForm = response.data.messageForm;

        console.log(state.appointments);

    },
    'SET_APPOINTMENT'(state, data) {
        state.appointment = data;
    },
    'RESET_APPOINTMENT'(state, value) {
        state.appointment = value;
    },
    'SET_LOADER'(state, status) {
        state.loader = status;
    },
    'SET_LOADER_FORM'(state, status) {
        state.loaderForm = status;
    },
    'SET_SCROLLABLE'(state, status) {
        state.scrollable = status;
    },
};
export const onlineAppointment = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
