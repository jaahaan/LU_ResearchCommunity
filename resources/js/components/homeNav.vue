<template>
    <nav class="navbar navbar-expand navbg text">
        <div class="container-fluid">
            <a class="navbar-brand"
                ><router-link class="nav-link active text" to="/home"
                    ><img
                        :src="'/images/logo.png'"
                        alt="logo"
                        class="img-fluid logo"
                    />
                    Research Community
                </router-link></a
            >

            <a class="navbar-brand d-flex"
                ><router-link
                    class="nav-link text"
                    :to="`/profile/${authUser.id}`"
                    ><i class="fa-solid fa-user"></i
                ></router-link>
            </a>
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
    background: #191919;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.text {
    color: #deb992;
}
.text:hover {
    border-left: 1px solid #deb992 !important;
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
