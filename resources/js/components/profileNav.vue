<template>
    <div>
        <nav class="navbar navbar-expand justify-content-center navbg">
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
.navbg {
    background: #3a4660;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.profile-btn {
}
h5 {
    color: #2f394e;
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

.text {
    color: #a7a7a7;
}
.text:hover {
    color: #deb992;
    border-left: 1px solid #a7a7a7 !important;
}

.logo {
    height: 10vh;
    width: 10vh;
}
.router-link-exact-active {
    color: #c9af98 !important;
    border-left: 2px solid #c9af98 !important;
}
</style>
