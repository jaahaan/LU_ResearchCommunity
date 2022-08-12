<template>
    <div>
        <div v-if="$store.state.user">
            <HomeNavbar />
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Navbar from "../components/navbar";
import HomeNavbar from "../components/homeNav";

export default {
    props: ["user"],
    components: {
        Navbar,
        HomeNavbar,
    },
    data() {
        return {};
    },
    methods: {},
    async created() {
        console.log("auth", window.authUser);
        await this.$store.commit("setUpdateUser", window.authUser);
    },
    // async created() {
    //     await this.$store.dispatch("setAuthUser", this.user);
    // },
};
</script>
