<template>
    <nav class="navbar navbar-expand navbg text">
        <div class="container-fluid">
            <a class="navbar-brand"
                ><router-link class="nav-link active text" to="/"
                    ><img
                        :src="'/images/logo.png'"
                        alt="logo"
                        class="img-fluid logo"
                    />
                    Research Community
                </router-link></a
            >

            <a class="navbar-item d-flex"
                ><router-link class="nav-link text" to="/login"
                    >Login</router-link
                >
                <router-link class="nav-link text" to="/register"
                    >Register</router-link
                ></a
            >
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
};
</script>

<style scoped>
body {
    margin: 0;
    padding: 0;
}
.navbg {
    background: #3a4660;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.text {
    color: #a7a7a7;
}
.text:hover {
    color: #deb992;
    border-left: 1px solid #a7a7a7 !important;
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
    color: #c9af98 !important;
    border-left: 2px solid #c9af98 !important;
}
</style>
