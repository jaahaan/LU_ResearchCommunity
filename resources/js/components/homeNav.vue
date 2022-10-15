<template>
    <nav class="navbar navbar-expand-lg navbar-dark navbg text">
        <div class="container-fluid">
            <a class="navbar-brand"
                ><router-link class="nav-link active text" to="/home"
                    ><img
                        :src="'/images/logo.png'"
                        alt="logo"
                        class="img-fluid logo"
                    />
                    ResearchCommunity
                </router-link></a
            >

            <a
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span><i class="fa-solid fa-caret-down"></i></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            v-if="authUser.userType == 'admin'"
                            to="/teachers"
                            >Add Teacher</router-link
                        >
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Department
                        </a>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdown"
                        >
                            <li><a class="dropdown-item" href="#">CSE</a></li>
                            <li><a class="dropdown-item" href="#">EEE</a></li>
                            <li><a class="dropdown-item" href="#">CE</a></li>
                            <li><a class="dropdown-item" href="#">ARCH</a></li>
                            <!-- <li><hr class="dropdown-divider"></li> -->
                            <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </li>
                </ul>
                <a class="navbar-brand d-flex"
                    ><div>
                        <form class="form-inline my-2 my-lg-0">
                            <input
                                class="form-control mr-sm-2"
                                type="search"
                                v-model="keyword"
                                placeholder="Search..."
                            />
                            <ul
                                class="search-list card list-group bg-dark"
                                v-if="Users.length > 0 && keyword.length > 0"
                            >
                                <li
                                    class="list-group-item list-group-item-action list-group-item-dark"
                                    v-for="user in Users"
                                    v-if="authUser.id != user.id"
                                    :key="user.id"
                                    v-text="user.name"
                                    @click="getSearchedUser(user)"
                                ></li>
                            </ul>
                        </form>
                    </div>
                </a>
            </div>
            <a class="navbar-item d-flex"
                ><router-link
                    class="nav-link text"
                    :to="`/profile/${authUser.id}`"
                    ><img
                        :src="authUser.image"
                        alt="img"
                        class="img-fluid profile-img m-auto"
                /></router-link>
            </a>
            <a class="navbar-item d-flex">
                <span @click="logout"
                    ><i class="fa-solid fa-right-from-bracket"></i
                ></span>
            </a>
        </div>
        <hr />
    </nav>
</template>

<script>
export default {
    data() {
        return {
            keyword: null,
            Users: [],
            user_id: -1,
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        },
    },
    methods: {
        getSearchedUser(user) {
            //     const res = await this.callApi(
            //     "get",
            //     `/api/get_profile_info/${this.user_id}`
            // );
            this.user_id = user.id;
            this.$router.push(`/profile/${this.user_id}`);
            this.keyword = "";
        },
        getResults() {
            axios
                .get("/api/search", { params: { keyword: this.keyword } })
                .then((res) => (this.Users = res.data))
                .catch((error) => {});
        },

        async logout() {
            const res = await this.callApi("get", "/api/logout");

            if (res.status == 200) {
                this.s(res.data.msg);
                window.location = "/";
                this.$router.go();
                window.location.reload();
            } else {
                this.swr();
            }
        },
    },
};
</script>

<style scoped>
body {
    margin: 0;
    padding: 0;
}

ul {
    list-style-type: none;
}

.search-list {
    position: absolute;
    font-size: 1rem;
}
.search-hover {
}
.profile-img {
    border-radius: 50%;
    width: 40px;
    height: 40px;
}
.navbg {
    background: #474554;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.text {
    color: #a7a7a7;
}

.text:hover {
    color: #fbf7ff;
    border-left: 1px solid #fbf7ff !important;
}

.logo {
    height: 10vh;
    width: 10vh;
}
.router-link-exact-active {
    color: #34c5d9 !important;
    border-left: 1px solid #34c5d9 !important;
}
</style>
