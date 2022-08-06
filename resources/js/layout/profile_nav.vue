<template>
    <div>
        <nav class="navbar navbar-expand justify-content-center">
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <router-link class="nav-link text" to="/profile"
                            >Profile
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            to="/profile/research"
                            >Research</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            to="/profile/projects"
                            >Projects</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            to="/profile/followings"
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

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
body {
    font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
</style>

<style scoped>
.profile-bg {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    background-color: #191919;
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
    background: #191919;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.text {
    color: #deb992;
}
.text:hover {
    color: #ffffff;
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
    border-left: 1px solid #fab162 !important;
}
</style>
