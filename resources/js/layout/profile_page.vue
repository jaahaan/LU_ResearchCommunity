<template>
    <div>
        <div class="mt-3">
            <div
                class="container-fluid card m-auto col-md-8 col-lg-6 profile-bg justtify-content-center p-3"
            >
                <div class="row justtify-content-center">
                    <div class="col-md-4 col-sm-12">
                        <img
                            :src="'images/download.jpg'"
                            alt="img"
                            class="img-fluid profile-img m-auto"
                        />
                    </div>
                    <div
                        class="col-md-5 my-auto justify-content-center"
                        v-for="(user, i) in users"
                        :key="i"
                    >
                        <h1>{{ user.name }}</h1>
                        <h5>{{ user.email }}</h5>
                        <h5>{{ user.designation }}</h5>
                        <h5>Department of {{ user.department }}</h5>
                    </div>
                </div>
                <div class="row">
                    <button class="btn profile-btn col-5 m-2">
                        <i class="fa-solid fa-plus"></i> Add Research
                    </button>
                    <button class="btn profile-btn col-5 m-2">
                        <i class="fa-solid fa-plus"></i> Edit Info
                    </button>
                </div>
            </div>

            <div class="row m-3">
                <div
                    class="container-fluid card m-auto col-md-8 col-lg-6 navbg p-3"
                >
                    <ProfileNav />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProfileNav from "./profile_nav";

export default {
    name: "Profile",

    data() {
        return {
            users: [],
        };
    },
    components: {
        ProfileNav,
    },
    methods: {},
    async created() {
        const res = await this.callApi("get", "profile");
        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.swr();
        }
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
