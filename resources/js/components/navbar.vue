<template>
    <header>
        <div
            class="navbar-mobile--wrapper d-lg-none"
            v-bind:class="{ active: isSidebar }"
        >
            <div class="navbar-mobile">
                <div class="navbar-mobile--head">
                    <router-link class="header-brand" to="/">
                        <img src="/images/logo.png" alt="Brand" />
                        <span class="lurc"
                            ><span class="lurc1">RESEARCH</span
                            ><span class="lurc2">COMMUNITY</span>
                        </span>
                    </router-link>
                    <button type="button" v-on:click="hideSidebar()">
                        <i>
                            <img
                                src="https://img.icons8.com/external-becris-lineal-becris/64/000000/external-cancel-mintab-for-ios-becris-lineal-becris.png"
                            />
                        </i>
                    </button>
                </div>
                <ul class="navbar-mobile--body">
                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            aria-current="page"
                            to="/home"
                            >Home</router-link
                        >
                    </li>

                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            aria-current="page"
                            to="/research"
                            >Research</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            aria-current="page"
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
                            Departments
                        </a>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdown"
                        >
                            <li>
                                <a class="dropdown-item" href="#">CSE</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">EEE</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">ARCH</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">BuA</a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg">
            <div class="container header-content">
                <div class="navbar-item">
                    <router-link class="navbar-brand" to="/">
                        <!-- <img src="/images/logo.png" alt="Brand" /> -->
                        <span class="lurc"
                            ><span class="lurc1">RESEARCH</span
                            ><span class="lurc2">COMMUNITY</span>
                        </span>
                    </router-link>
                    <!-- <router-link class="navbar-brand" to="/">
                        <img src="/images/logo.png" alt="Brand" />
                        <span class="lurc"
                            ><span class="lurc1">RESEARCH</span
                            ><span class="lurc2">COMMUNITY</span>
                        </span>
                    </router-link> -->
                </div>
                <div class="navbar-item navbar-body d-none d-lg-block">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link
                                class="nav-link active"
                                aria-current="page"
                                to="/"
                                >Home</router-link
                            >
                        </li>

                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                aria-current="page"
                                to="/research"
                                >Research</router-link
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
                                Departments
                            </a>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdown"
                            >
                                <li>
                                    <a class="dropdown-item" href="#">CSE</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">EEE</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">ARCH</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">BuA</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Something else here</a
                                    >
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="navbar-item">
                    <ul class="navbar-item__right">
                        <li>
                            <router-link class="nav-link" to="/login"
                                >Login</router-link
                            >
                        </li>
                        <li>
                            <router-link class="nav-link" to="/register"
                                >Register</router-link
                            >
                        </li>
                        <li>
                            <button v-on:click="showSidebar()">
                                <i class="d-lg-none"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="25"
                                        height="25"
                                        fill="currentColor"
                                        class="bi bi-list"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                                        />
                                    </svg>
                                </i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- <nav class="navbar navbar-expand navbg d-block">
        <div class="container">
            <a class="navbar-brand float-start d-flex active navbar-item">
                <a class="nav-link">
                    <router-link class="lurc" to="/"
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
    </nav> -->
</template>

<script scoped>
export default {
    data() {
        return {
            isSidebar: false,
            isSearchbar: false,
            mobileDropdownIndex: -1,

            keyword: null,
            Users: [],
            user_id: -1,
        };
    },
    methods: {
        showSidebar() {
            this.isSidebar = true;
        },
        hideSidebar() {
            this.isSidebar = false;
        },
        showSearchbar() {
            this.isSearchbar = true;
        },
        hideSearchbar(e) {
            if (this.isSearchbar) {
                let target = e.target;
                var container = this.$refs.searchBox;
                var source = this.$refs.searchBoxSource;

                if (!source.contains(target) && !container.contains(target)) {
                    this.isSearchbar = false;
                    this.keyword = "";
                }
            }
        },
        cancelSearchBar() {
            this.isSearchbar = false;
            this.keyword = "";
        },
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

    mounted() {
        document.addEventListener("click", this.hideSearchbar);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.hideSearchbar);
    },
};
</script>

<style scoped></style>
