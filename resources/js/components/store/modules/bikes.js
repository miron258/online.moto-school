import axios from "axios";
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let state = {
    loader: false,
    loaderForm:false,
    message: "",
    messageForm: "",
    bike: "",
    bikes: {},
};
let getters = {

    bikes: state => {
        return state.bikes
    },
    bike: state => {
        return state.bike
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
    loaderForm: state => {
        return state.loaderForm
    }
};
let actions = {

    //// Получить мотоциклы
    'GET_BIKES'({commit}) {
        commit('SET_LOADER', true);
        axios.get('/bike')
            .then(response => {
                commit('SET_STORE', response);

                console.log(response);

            })
            .catch(err => console.log(err)).finally(() => {
            commit('SET_LOADER', false);
        });
    },
    'GET_BIKE'({commit}, id) {
        commit('SET_LOADER', true);
        return axios.get('/bike/' + id + '/edit').then(
            response => {
                commit('SET_STORE', response);

                // console.log("this.$root.$refs");
                // console.log(Vue.$root.$refs);


            }).catch(e => {
        }).finally(() => {
            commit('SET_LOADER',false);
        });
    },
    'DELETE_BIKE'({commit}, id) {
        commit('SET_LOADER', true);
        axios.delete('/bike/' + id)
            .then(response => {
                commit('SET_STORE', response);

            })
            .catch(err => console.log(err)).finally(() => {
            commit('SET_LOADER', false);
        });
    },

};
let mutations = {
    'SET_STORE'(state, response) {
        state.bikes = response.data.bikes;
        state.bike = response.data.bike;
        state.messageForm = response.data.messageForm;
        state.loader = false;
        state.loaderForm = false;
        state.message = response.data.message;
    },
    'RESET_BIKE'(state, value) {
        state.bike = value;
    },
    'SET_LOADER'(state, status) {
        state.loader = status;
    },
    'SET_LOADER_FORM'(state, status) {
        state.loaderForm = status;
    },
};
export const bikes = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
