<template>
    <div>
        <div v-if="!$store.state.user">
            <Navbar />
        </div>
        <router-view />
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

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

/*sm (>=576px), md (>=768px), lg (>=992px) or xl (>=1200px)*/

body {
    font-family: Verdana, sans-serif;
    font-size: 15px;
    line-height: 24px;
    color: #3e3f3a;
    background-color: #fff;
}
html {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
.bg {
    /*background-image: linear-gradient(angle, color-stop1, color-stop2);*/
    background: linear-gradient(
        90deg,
        #ffffff 0%,
        #ffffff 30%,
        #98978b 30%,
        #98978b 100%
    );
}
* {
    margin: 0;
    padding: 0;
    /*padding and border are included in the width and height*/
    box-sizing: border-box;
}
h6,
h5 {
    color: #3e3f3a;
}

.btn-design {
    border: 1px solid;
    background: none;
    color: #eee;
}
.btn-design:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7);
    color: #34c5d9;
}
.btn-design-change {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7);
    color: #34c5d9;
    background-color: #444253;
}

.btn-edit {
    color: #a7a7a7;
    border: none;
    cursor: pointer;
}
.btn-edit:hover {
    color: #5a606d;
}

.title {
    font-size: 5rem;
    font-weight: 600;
    /*property specifies the height of a line.*/
    line-height: 1rem;
    color: #98978b;
    padding: 50px;
}

.rt-title {
    font-size: 3rem;
    font-weight: 900;
    line-height: 3rem;
    color: #474554;
    margin: 20px;
}

.rt {
    /* offset-x | offset-y | blur-radius | spread-radius | color */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7);
    text-decoration: none;
    background-color: #474554;
    border: 1px solid #98978b;
    color: #fbf7ff;
    border-radius: 5px;
}

@media (max-width: 768px) {
    .bg {
        height: 100vh;
        background: linear-gradient(
            180deg,
            #ffffff 0%,
            #ffffff 30%,
            #98978b 30%,
            #98978b 100%
        );
    }
    .rt-title {
        font-size: 2rem;
    }
    .rt {
        font-size: 0.75rem;
    }
}
</style>
