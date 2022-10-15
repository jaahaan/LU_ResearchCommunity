<template>
    <div>
        <div v-if="$store.state.user">
            <HomeNavbar />

            <div
                v-if="
                    $route.name == 'profile' ||
                    $route.name == 'research' ||
                    $route.name == 'projects' ||
                    $route.name == 'followings'
                "
            >
                <profileHeader />
                <ProfileNav />
            </div>

            <router-view />
        </div>
    </div>
</template>

<script>
import Navbar from "../components/navbar";
import HomeNavbar from "../components/homeNav";
import profileHeader from "../components/profileHeader";
import ProfileNav from "../components/profileNav";

export default {
    props: ["user"],
    components: {
        Navbar,
        HomeNavbar,
        profileHeader,
        ProfileNav,
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
