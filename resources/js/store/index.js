import Vue from "vue";

import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        authUser: window.authUser,
        user: false,
        socket: null,
        messages:[],
        userResearch:[],
        userProject:[],
        allGlobalResearch:[],
        globalResearchLoading:true,
        allGlobalPost:[],
        globalPostLoading:true,
        callNotificationOb:null,
        notification: [],
        connection: [],
        authUserConnection: [],
        departmentInfo: [],
        peopleYouMayKnow:[],
        seenCount:0,
        token: '',
        passwordReset: { email: "" , token: ""},
        unauthorizedCredential: { email: "",  password: ""},
        selectedUserInfo: {room_id: "", selectedUserId: "",selectedUserImage:"", selectedUserSlug:"",  selectedUserName: "" },
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
        getToken (state) {
            return state.token
          },
          unauthorizedCredential(state) {
            return state.unauthorizedCredential;
          },
          passwordReset(state) {
            return state.passwordReset;
          },
          
          getSocket (state) {
            return state.socket
          },
          getDepartment (state) {
            return state.departmentInfo
          },
          
          getSeenCount (state) {
            return state.seenCount
          },
          getCallNotificationOb (state) {
            return state.callNotificationOb
          },
          
          getSelectedUserInfo(state) {
            return state.selectedUserInfo;
          },
          
          getConnectionItem (state) {
            return state.connection
          },
          getAuthUserConnection(state) {
            return state.authUserConnection
          },
        
          getNotificationItem (state) {
            return state.notification
          },
          getPeopleYouMayKnow (state) {
            return state.peopleYouMayKnow
          },
        
          getMessages (state) {
            return state.messages
          },
          getUserResearch (state) {
            return state.userResearch
          },
          getUserProject (state) {
            return state.userProject
          },
          getAllGlobalResearch (state) {
            return state.allGlobalResearch
          },
          
          getGlobalResearchLoading (state) {
            return state.globalResearchLoading
          },
        
          getAllGlobalPost (state) {
            return state.allGlobalPost
          },
          getGlobalPostLoading (state) {
            return state.globalPostLoading
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
        setSocket(state, data) {
            state.socket = data
          },
          setToken(state, data) {
            state.token = data
          },
          setDepartmentInfo (state, data) {
            state.departmentInfo = data
          },
          updateSeenCount(state, data) {
            state.seenCount = data
          },
        
          removeConnectionItem (state, i) {
            state.connection.splice(i,1)
          },
         
          updateConnection (state, data) {
            state.connection = data
          },
        
          pushConnection (state, data) {
            state.connection.push(data)
          },
        
          removeAuthUserConnection (state, i) {
            state.authUserConnection.splice(i,1)
          },
         
          updateAuthUserConnection (state, data) {
            state.authUserConnection = data
          },
        
          pushAuthUserConnection (state, data) {
            state.authUserConnection.push(data)
          },
          removeNotificationItem (state, i) {
            state.Notification.splice(i,1)
          },
          
          updateNotification (state, data) {
            state.notification = data
          },
          pushNotification (state, data) {
            state.notification.push(data)
          },
          updatePeopleYouMayKnow (state, data) {
            state.peopleYouMayKnow = data
          },
          setCallNotificationOb (state, data) {
            state.callNotificationOb = data
          },
          setUnauthorizedCredential(state, data)  {
            state.unauthorizedCredential = data;
          },
        
          setSelectedUserInfo(state, data)  {
            state.selectedUserInfo = data;
          },
          setPasswordReset(state, data) {
            state.passwordReset = data;
          },
        
          //user research
          setMessages (state, data) {
            state.messages = data
          },
          
          pushMessages (state, data) {
            state.messages.push(data)
          },
        
          //user research
          setUserResearch (state, data) {
            state.userResearch = data
          },
          
          pushUserResearch (state, data) {
            state.userResearch.push(data)
          },
          //user project
          setUserProject (state, data) {
            state.userProject = data
          },
        
          pushUserProject (state, data) {
            state.userProject.push(data)
          },
        
          //research
          setAllGlobalResearch (state, data) {
            state.allGlobalResearch = data
          },
          setGlobalResearchLoading (state, data) {
            state.globalResearchLoading = data
          },
          pushAllGlobalResearch (state, data) {
            state.allGlobalResearch.push(data)
          },
        
          //post
          setAllGlobalPost (state, data) {
            state.allGlobalPost = data
          },
          setGlobalPostLoading (state, data) {
            state.globalPostLoading = data
          },
          pushAllGlobalPost (state, data) {
            state.allGlobalPost.push(data)
          },
    },

    /*all actions*/
    actions: {
        setAuthUser({ commit }, user) {
            commit("authUser", user);
        },
        setToken ({ commit }, data) {
        commit('setToken', data)
        },
        
        updateConnection ({ commit }, data) {
        commit('updateConnection', data)
        },
        updateAuthUserConnection ({ commit }, data) {
        commit('updateAuthUserConnection', data)
        },
        updateNotification ({ commit }, data) {
        commit('updateNotification', data)
        },
        updatePeopleYouMayKnow({commit}, data){
        commit('updatePeopleYouMayKnow', data)
        },
        updateSeenCount ({ commit }, data) {
        commit('updateSeenCount', data)
        },
        setDepartmentInfo ({ commit }, data) {
        commit('setDepartmentInfo', data)
        },
        setAuthInfo ({ commit }, data) { 
        commit('setAuthInfo', data)
        },
        setSocket ({ commit }, data) { 
        commit('setSocket', data)
        },
    },
});

export default store;
