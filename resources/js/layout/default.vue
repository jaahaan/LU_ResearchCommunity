<template>
    <div>
        <div v-if="$store.state.user">
            <HomeNavbar />
        </div>
        <div v-else>
            <Navbar />
        </div>
        <router-view></router-view>
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

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
body {
    font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
</style>
