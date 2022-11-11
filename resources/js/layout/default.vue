<template>
    <div>
        <div v-if="$store.state.user">
            <div
                v-if="
                    $route.name == 'profile' ||
                    $route.name == 'publication' ||
                    $route.name == 'projects' ||
                    $route.name == 'posts'
                "
            >
                <HomeNavbar />
                <div class="container-fluid profile-header-bg">
                    <div class="container col-md-8 m-auto">
                        <div class="row">
                            <!-- first Card -->
                            <!--Suggested research-->
                            <div class="col-lg-5">
                                <profileHeader />
                            </div>

                            <!-- second Card -->
                            <div class="col-lg-7">
                                <ProfileNav />
                                <router-view />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <HomeNavbar />
                <router-view />
            </div>
        </div>
        <div v-else>
            <Navbar />
            <router-view />
            <bottomContainer />
        </div>
    </div>
</template>

<script>
import HomeNavbar from "../components/homeNav";
import Navbar from "../components/navbar";
import profileHeader from "../components/profileHeader";
import ProfileNav from "../components/profileNav";
import bottomContainer from "../components/footer";

export default {
    props: ["user"],
    components: {
        Navbar,
        HomeNavbar,
        profileHeader,
        ProfileNav,
        bottomContainer,
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
<style scoped>
.profile-header-bg {
    /*background-image: linear-gradient(angle, color-stop1, color-stop2);*/
    background: linear-gradient(
        180deg,
        #5c596d 0%,
        #5c596d 80px,
        #fff 80px,
        #fff 100%
    );
}
</style>
