<template>
    <div>
        <div v-if="$store.state.user">
            <HomeNavbar />
            <!-- <div v-if="$route.name == 'overview' || $route.name == 'comments'">
                <postHeader />
            </div> -->
            <div
                v-if="
                    $route.name == 'profile' ||
                    $route.name == 'publication' ||
                    $route.name == 'projects' ||
                    $route.name == 'posts'
                "
            >
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
import postHeader from "../components/post_header";

export default {
    props: ["user"],
    components: {
        Navbar,
        HomeNavbar,
        profileHeader,
        ProfileNav,
        bottomContainer,
        postHeader,
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
