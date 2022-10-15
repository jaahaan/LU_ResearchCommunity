<template>
    <nav class="navbar navbar-expand navbg d-block">
        <div class="container-fluid">
            <a class="navbar-brand float-start d-flex active navbar-item">
                <a class="nav-link" href="/"
                    ><img
                        :src="'/images/logo.png'"
                        alt="logo"
                        class="img-fluid logo"
                    />
                    <router-link class="lurc mt-5" to="/"
                        ><span class="lurc1">RESEARCH</span
                        ><span class="lurc2">COMMUNITY</span></router-link
                    ></a
                ></a
            >

            <a class="navbar-item d-flex float-end"
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

<script scoped>
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
    background: #474554;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    position: sticky;
    border-bottom: 1px solid #393a35;
}
.text {
    color: #98978b;
}
.text:hover {
    color: #fbf7ff;
    border-bottom: 1px solid #fbf7ff !important;
}
.logo {
    height: 10vh;
    width: 10vh;
}
.router-link-exact-active {
    color: #34c5d9 !important;
    border-bottom: 1px solid #34c5d9 !important;
}

.lurc {
    border: 1px solid #98978b !important;
    padding: 10px;
    height: 15vh;
}
.lurc:hover {
    border: 1px solid #fbf7ff !important;
}

.lurc1 {
    background: #fbf7ff;
    padding: 5px;
    color: #3e3f3a;
}
.lurc2 {
    font-weight: 500px;
    padding: 5px;
    color: #98978b;
}
.lurc2:hover {
    color: #fbf7ff;
}
</style>
