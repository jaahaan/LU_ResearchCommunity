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
                    ResearchCommunity
                </router-link></a
            >

            <a class="navbar-brand d-flex"
                ><div>
                    <form class="form-inline my-2 my-lg-0">
                        <input
                            class="form-control mr-sm-2"
                            type="search"
                            v-model="keyword"
                            placeholder="Search..."
                        />
                        <ul v-if="Users.length > 0 && keyword.length > 0">
                            <li
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

            <a class="navbar-brand d-flex"
                ><router-link
                    class="nav-link text"
                    :to="`/profile/${authUser.id}`"
                    ><img
                        :src="authUser.image"
                        alt="img"
                        class="img-fluid profile-img m-auto"
                /></router-link>
            </a>
        </div>
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
    display: relative;
}
.profile-img {
    border-radius: 50%;
    width: 40px;
    height: 40px;
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
    border-left: 1px solid #c9af98 !important;
}
</style>
