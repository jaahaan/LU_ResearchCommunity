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
import Navbar from "./navbar";
import HomeNavbar from "./home_nav";

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
        await this.$store.commit("setUpdateUser", this.user);
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
