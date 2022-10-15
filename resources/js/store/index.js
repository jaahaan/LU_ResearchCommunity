import Vue from "vue";

import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        authUser: window.authUser,
        user: false,
        passwordReset: { email: "" },
    },

    //Sometimes we may need to compute derived state based on store state,
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

    //The only way to actually change state in a Vuex store is by committing a mutation.
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
