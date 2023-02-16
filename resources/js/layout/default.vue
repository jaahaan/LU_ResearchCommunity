<template>
    <div>
        <div v-if="$store.state.user">
            <Navbar />
            <div
                v-if="
                    $route.name == 'profile-slug-overview' ||
                    $route.name == 'profile-slug-research' ||
                    $route.name == 'profile-slug-project' ||
                    $route.name == 'profile-slug-connection'
                "
            >
                <div class="container-fluid profile-header-bg main">
                    <profileHeader />
                </div>
            </div>
            <div
                v-else-if="
                    $route.name == 'description-slug-overview' ||
                    $route.name == 'description-slug-comments'
                "
                class="main"
            >
                <postHeader />
            </div>
            <div v-else class="main">
                <router-view />
            </div>
        </div>
        <div v-else>
            <Navbar />
            <div
                v-if="
                    $route.name == 'description-slug-overview' ||
                    $route.name == 'description-slug-comments'
                "
                class="main"
            >
                <postHeader />
            </div>
            <router-view class="main" v-else />
            <BottomContainer v-if="isFooterShow == true" />
        </div>
    </div>
</template>

<script>
import Navbar from "../components/navbar";
import profileHeader from "../components/profileHeader";
import ProfileNav from "../components/profileNav";
import BottomContainer from "../components/footer";
import postHeader from "../components/post_header";
const { io } = require("socket.io-client");

export default {
    props: ["user"],
    components: {
        Navbar,
        profileHeader,
        ProfileNav,
        BottomContainer,
        postHeader,
    },
    data() {
        return {
            isHeaderShow: true,
            isFooterShow: true,
        };
    },

    methods: {
        isHeaderShowChange() {
            if (
                this.$route.name == "login" ||
                this.$route.name == "register" ||
                this.$route.name == "index" ||
                this.$route.name == "research" ||
                this.$route.name == "department"
            ) {
                this.isHeaderShow = true;
            } else this.isHeaderShow = false;
        },
        isFooterShowChange() {
            if (
                this.$route.name == "register" ||
                this.$route.name == "login" ||
                this.$route.name == "index"
            ) {
                this.isFooterShow = true;
            } else this.isFooterShow = false;
        },
        async getDepartments() {
            const response = await this.callApi("get", `/api/get_departments`);
            if (response.status == 200) {
                this.$store.commit("setDepartmentInfo", response.data);
            } else this.swr();
        },
    },
    async mounted() {
        const socket = io("http://127.0.0.1:5000", {
            methods: ["GET", "POST"],
            transports: ["websocket"],
            credentials: true,
        });
        this.getDepartments();
        // this.$store.commit("setSocket", socket);
    },
    watch: {
        "$route.name": function (newVal, oldVal) {
            // watch it

            this.isHeaderShowChange();
            this.isFooterShowChange();
        },
    },
    async created() {
        console.log("auth", window.authUser);
        await this.$store.commit("setUpdateUser", window.authUser);
    },
    // async created() {
    //     await this.$store.dispatch("setAuthUser", this.user);
    // },
};
</script>
<style scoped>
/*background-image: linear-gradient(angle, color-stop1, color-stop2);*/

/*.profile-header-bg {
    background: linear-gradient(
        180deg,
        #5c596d 0%,
        #5c596d 80px,
        #fff 80px,
        #fff 100%
    );
}*/
</style>
