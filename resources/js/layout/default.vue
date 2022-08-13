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
    position: relative;
    font-family: "Styrenea web", sans-serif;
    font-size: 15px;
    line-height: 24px;
}

*,
::after,
::before {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.home__carousel {
    position: relative;
    padding: 100px 0;
    margin-bottom: 100px;
}
section {
    display: block;
}

div {
    display: block;
}
.btn-edit {
    color: rgb(167, 167, 167);
    border: none;
}
.btn-edit:hover {
    color: #ffffff;
}
@media (max-width: 767px) {
    .home__carousel {
        padding: 30px 0 30px 0;
        margin: 50px 0 100px 0;
    }
    .title {
        font-size: 4rem;
    }
}
</style>
