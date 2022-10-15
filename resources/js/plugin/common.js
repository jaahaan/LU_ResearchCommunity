import { mapGetters } from 'vuex';

export default {
    data(){
        return {

        }
    },

    //A computed property will only re-evaluate when some of its reactive dependencies have changed.
    computed: {
        //The mapGetters helper simply maps store getters to local computed properties:
        ...mapGetters({

            authUser:'authUser',
            isLoggedIn:'isLoggedIn',

        }),
    },

    //a method invocation will always run the function whenever a re-render happens.
    methods: {
        async callApi(method, url, dataObj ){
            try {
              return await axios({
                    method: method,
                    //url: `/api/${url}`,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },

        i(desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        u(desc, title="Updated!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title="Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc='Something went wrong! Please try again.', title="Oops") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
    },
}
