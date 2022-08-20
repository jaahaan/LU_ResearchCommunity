import Vue from "vue";

import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        authUser: window.authUser,
        user: false,
        passwordReset: { email: "" },
    },

    /*All getters*/
    getters: {
        isLoggedIn(state) {
            if (_.isEmpty(state.authUser)) {
                return false;
            } else {
                return true;
            }
        },
        authUser(state) {
            return state.authUser;
        },
        passwordReset(state) {
            return state.passwordReset;
        },
    },

    /*all mutations*/
    mutations: {
        authUser(state, user) {
            state.authUser = user;
        },
        setUpdateUser(state, data) {
            state.user = data;
        },
        setPasswordReset(state, data) {
            state.passwordReset = data;
        },
    },

    /*all actions*/
    actions: {
        setAuthUser({ commit }, user) {
            commit("authUser", user);
        },
    },
});

export default store;
