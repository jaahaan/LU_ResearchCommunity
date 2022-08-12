<template>
    <div>
        <nav class="navbar navbar-expand justify-content-center">
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}`"
                            >Profile
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/research`"
                            >Research</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/projects`"
                            >Projects</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/followings`"
                            >Followings</router-link
                        >
                    </li>
                </ul>
            </div>
        </nav>

        <router-view />
    </div>
</template>
<script>
export default {
    name: "ProfileNav",
    components: {},
    data() {
        return {};
    },
    methods: {},
    async created() {
        await this.$store.dispatch("setAuthUser", window.authUser);
    },
};
</script>
<style scoped>
.profile-bg {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    background-color: #273326;
}
.profile-btn {
}
h5 {
    color: #fab162;
}
.profile-btn {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-size: 1rem;
    color: #fab162;
    border: 1px solid #fab162;
}
.profile-btn:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    color: #191919;
    background-color: #fab162;
    font-size: 1rem;
}
.navbg {
    background: #273326;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.text {
    color: #deb992;
}
.text:hover {
    border-bottom: 1px solid #deb992 !important;
}
.text:active {
    color: #fab162;
}
.text:after {
    color: #fab162;
}
.logo {
    height: 10vh;
    width: 10vh;
}
.router-link-exact-active {
    color: #fab162 !important;
    border-bottom: 1px solid #fab162 !important;
}
</style>
