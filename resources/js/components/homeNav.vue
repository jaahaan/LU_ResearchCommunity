<template>
    <div>
        <header>
            <div
                class="navbar-mobile--wrapper d-lg-none"
                v-bind:class="{ active: isSidebar }"
            >
                <div class="navbar-mobile">
                    <div class="navbar-mobile--head">
                        <img src="/images/logo.png" alt="Brand" />
                        <span class="lurc"
                            ><span class="lurc1">RESEARCH</span
                            ><span class="lurc2">COMMUNITY</span>
                        </span>
                        <button type="button" v-on:click="hideSidebar()">
                            <i class="lni lni-cross-circle"></i>
                        </button>
                    </div>
                    <ul class="navbar-mobile--body">
                        <li class="nav-item">
                            <router-link
                                class="nav-link active"
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

            <!-- ****notification**** -->

            <div
                class="navbar-notification--wrapper"
                v-bind:class="{ active: isNotification }"
            >
                <div class="navbar-notification">
                    <div class="navbar-notification--head">
                        <h4>Notification</h4>
                        <button type="button" v-on:click="hideNotification()">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="navbar-notification--body">
                        <i class="lni lni-alarm"></i>
                        <p>Notification Is Empty</p>
                    </div>
                </div>
            </div>
            <!-- ****SearchBox**** -->
            <div
                class="navbar-search"
                v-bind:class="{ active: isSearchbar }"
                ref="searchBox"
            >
                <div class="navbar-search-input">
                    <input
                        type="search"
                        placeholder="Search..."
                        v-model="keyword"
                    />
                    <button type="button" class="search-button">
                        <i class="lni lni-search-alt"></i>
                    </button>
                </div>

                <div class="navbar-search-cancel">
                    <button
                        type="button"
                        class="cancel-button"
                        v-on:click="cancelSearchBar()"
                    >
                        <i>
                            <i class="lni lni-close"></i>
                        </i>
                    </button>
                </div>
                <div class="navbar-search-result">
                    <ul
                        class="search-list card list-group bg-dark w-100 c-pointer"
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
                </div>
            </div>

            <nav class="navbar navbar-expand-lg">
                <div class="container header-content">
                    <div class="navbar-item navbar-itemLogo">
                        <a class="navbar-brand">
                            <!-- <img src="/assets/images/logo.png" alt="Brand" /> -->
                            <router-link class="lurc" to="/home"
                                ><span class="lurc1">RESEARCH</span
                                ><span class="lurc2">COMMUNITY</span>
                            </router-link>
                        </a>
                    </div>
                    <div class="navbar-item navbar-body d-none d-lg-block">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link
                                    class="nav-link active"
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
                                        <a class="dropdown-item" href="#"
                                            >CSE</a
                                        >
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >EEE</a
                                        >
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >ARCH</a
                                        >
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >BuA</a
                                        >
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
                        <ul class="navbar-item__action">
                            <li
                                v-on:click="showSearchbar()"
                                ref="searchBoxSource"
                            >
                                <i class="lni lni-search-alt"> </i>
                            </li>
                            <li>
                                <div v-on:click="showNotification()">
                                    <i class="lni lni-alarm"></i>
                                    <span class="navbar-action__badge">3</span>
                                </div>
                            </li>
                            <!-- <li><i class="lni lni-alarm"></i></li> -->
                            <li>
                                <router-link
                                    :to="`/profile/${authUser.slug}/${authUser.id}`"
                                    ><img
                                        :src="authUser.image"
                                        alt="img"
                                        class="img-fluid nav-profile-img m-auto"
                                /></router-link>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSidebar: false,
            isSearchbar: false,
            isNotification: false,
            isFilter: false,
            mobileDropdownIndex: -1,

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
                }
            }
        },
        showNotification() {
            this.isNotification = true;
        },
        hideNotification() {
            this.isNotification = false;
        },
        showFilter() {
            this.isFilter = true;
        },
        hideFilter() {
            this.isFilter = false;
        },

        mobileMenuDropdown(index) {
            if (this.mobileDropdownIndex === index) {
                this.mobileDropdownIndex = -1;
            } else {
                this.mobileDropdownIndex = index;
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
            this.$router.push(`/profile/${this.user.slug}${this.user_id}`);
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

    mounted() {
        document.addEventListener("click", this.hideSearchbar);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.hideSearchbar);
    },
};
</script>

<style scoped>
.search-list {
    position: absolute;
    font-size: 1rem;
}
.search-hover {
}
.nav-profile-img {
    border-radius: 50%;
    width: 30px;
    height: 30px;
}
</style>
