<template>
    <div>
        <section class="container research" v-if="isDataLoading == false">
            <div class="row">
                <div class="col-lg-2 research-searchBy d-none d-lg-block">
                    <div class="research-searchBy--radio">
                        <h4 class="research-head">Departments</h4>
                        <div
                            class="form-check"
                            v-for="(department, index) in departments"
                            :key="index"
                        >
                            <input
                                class="form-check-input"
                                type="radio"
                                name="flexRadioDefault"
                                id="flexRadioDefault1"
                                :value="department.id"
                                v-model="filter.department"
                                @change="filterPosts"
                            />
                            <label
                                class="form-check-label"
                                for="flexRadioDefault1"
                            >
                                {{ department.department_name }}
                            </label>
                        </div>
                    </div>

                    <!-- <div class="research-searchBy--tag">
                        <h4 class="research-head">Choose Tag</h4>
                        <div class="research-searchBy--tag---list">
                            <div
                                class="tag-item"
                                v-for="(department, index) in departments"
                                :key="index"
                                @click="addToFilterTag(department)"
                            >
                                <span>{{ department.department_name }}</span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="col-lg-10 research-post">
                    <div class="research-post--display">
                        <div class="research-post--display--icon">
                            <button
                                v-on:click="showSearchbar()"
                                ref="searchBoxSource"
                            >
                                <i class="lni lni-search-alt"> </i>
                            </button>
                        </div>

                        <div
                            class="research-post--display--body d-none d-lg-block"
                            v-if="isSearchbar == false"
                        >
                            <p v-if="isLoading == false && posts.length < 21">
                                Showing {{ posts.length }} of
                                {{ posts.length }} results
                            </p>
                            <p v-else-if="isLoading == false && posts.length">
                                Showing 5 of {{ posts.length }} results
                            </p>
                        </div>

                        <!-- ****SearchBox**** -->
                        <div
                            class="research-post--display--body research-search"
                            v-bind:class="{ active: isSearchbar }"
                            ref="searchBox"
                        >
                            <div class="research-search-input">
                                <!-- <Input
                                    search
                                    placeholder="Enter something..."
                                    :remote-method="searchPost"
                                    v-model="filter.search"
                                /> -->
                                <input
                                    type="search"
                                    placeholder="Search..."
                                    v-model="search"
                                    v-on:keyup="filterPosts"
                                />
                                <button type="button" class="search-button">
                                    <i class="lni lni-search-alt"></i>
                                </button>
                            </div>

                            <div class="research-search-cancel">
                                <button
                                    type="button"
                                    class="cancel-button"
                                    v-on:click="cancelSearchBar"
                                >
                                    <i>
                                        <i class="lni lni-close"></i>
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div class="research-post--display--default">
                            <div v-if="isSearchbar == false" class="mx-3">
                                <Dropdown trigger="hover">
                                    <span
                                        ><span v-if="search == ''"> Type </span>
                                        <span else>{{ search }}</span></span
                                    >
                                    <i class="lni lni-chevron-down"></i>
                                    <DropdownMenu slot="list">
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch('Article')
                                                "
                                                >Article</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch(
                                                        'Conference Paper'
                                                    )
                                                "
                                                >Conference Paper</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch('Data')
                                                "
                                                >Data</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch(
                                                        'Resaerch'
                                                    )
                                                "
                                                >Resaerch</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch('Project')
                                                "
                                                >Project</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch(
                                                        'Presentation'
                                                    )
                                                "
                                                >Presentation</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    addToFilterSearch(
                                                        'Preprint'
                                                    )
                                                "
                                                >Preprint</span
                                            ></DropdownItem
                                        >
                                    </DropdownMenu>
                                </Dropdown>
                            </div>
                            <div class="d-lg-none" v-if="isSearchbar == false">
                                <Dropdown trigger="hover">
                                    <span
                                        ><span v-if="departmentName == ''">
                                            Departments
                                        </span>
                                        <span else>{{
                                            departmentName
                                        }}</span></span
                                    >
                                    <i class="lni lni-chevron-down"></i>
                                    <!-- <span >category</span> -->
                                    <DropdownMenu slot="list">
                                        <div
                                            v-for="(
                                                department, index
                                            ) in departments"
                                            :key="index"
                                        >
                                            <DropdownItem
                                                ><span
                                                    @click="
                                                        addToFilterDepartment(
                                                            department
                                                        )
                                                    "
                                                >
                                                    {{
                                                        department.department_name
                                                    }}</span
                                                ></DropdownItem
                                            >
                                        </div>
                                    </DropdownMenu>
                                </Dropdown>
                            </div>
                            <div v-if="isSearchbar == false" class="mx-3">
                                <Dropdown trigger="hover">
                                    <!-- <span >sort by</span> -->
                                    <span>
                                        <span v-if="filter.default == 'id'">
                                            Newest
                                        </span>
                                        <span
                                            v-else-if="
                                                filter.default == 'title' &&
                                                filter.order == 'asc'
                                            "
                                        >
                                            Ascending [A-Z]
                                        </span>
                                        <span
                                            v-else-if="
                                                filter.default == 'title' &&
                                                filter.order == 'desc'
                                            "
                                        >
                                            Descending [Z-A]
                                        </span>
                                        <span v-else>Default Sort</span>
                                    </span>
                                    <i class="lni lni-chevron-down"></i>
                                    <DropdownMenu slot="list">
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    removeFromSelectedFilterAll
                                                "
                                                >Default Sort</span
                                            ></DropdownItem
                                        >

                                        <DropdownItem
                                            ><span
                                                @click="
                                                    sortData(['id', 'desc'])
                                                "
                                                >Newest</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    sortData(['title', 'asc'])
                                                "
                                                >Ascending [A-Z]</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                @click="
                                                    sortData(['title', 'desc'])
                                                "
                                                >Descending [Z-A]</span
                                            ></DropdownItem
                                        >
                                        <DropdownItem
                                            ><span
                                                >Top Research</span
                                            ></DropdownItem
                                        >
                                    </DropdownMenu>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                    <!-- post description -->
                    <div v-if="isLoading == false && posts.length">
                        <div
                            class="research-post--item"
                            v-for="(post, index) in posts"
                            :key="index"
                        >
                            <h5 class="post-title">
                                <router-link
                                    :to="`/description/${post.slug}`"
                                    >{{ post.title }}</router-link
                                >
                            </h5>
                            <div class="mt-2 mb-2">
                                <router-link
                                    :to="`/description/${post.slug}`"
                                    class="main-btn main-btn__border d-inline-block text-center"
                                >
                                    {{ post.type }}</router-link
                                >
                            </div>
                            <p v-if="post.abstract != null">
                                {{ post.abstract.substring(0, 190) }}
                                ...
                                <router-link :to="`/description/${post.slug}`"
                                    >See more</router-link
                                >
                            </p>

                            <div v-if="post.authors.length">
                                <p
                                    v-if="
                                        post.authors.length > 1 &&
                                        post.type != 'Project'
                                    "
                                    class="mt-2"
                                >
                                    Authors:
                                    <span v-for="author in post.authors">
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                                <p
                                    v-else-if="
                                        post.authors.length > 1 &&
                                        post.type == 'Project'
                                    "
                                    class="mt-2"
                                >
                                    Team Members:
                                    <span v-for="author in post.authors">
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                                <p
                                    class="mt-2"
                                    v-else-if="
                                        post.authors.length == 1 &&
                                        post.type == 'Project'
                                    "
                                >
                                    Team Member:
                                    <span v-for="author in post.authors">
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                                <p
                                    class="mt-2"
                                    v-else-if="
                                        post.authors.length == 1 &&
                                        post.type != 'Project'
                                    "
                                >
                                    Author:
                                    <span v-for="author in post.authors">
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                            </div>
                            <div
                                v-else-if="
                                    post.authors.length &&
                                    post.type == 'Project'
                                "
                            >
                                <p v-if="post.authors.length > 1" class="mt-2">
                                    Team Members:
                                    <span
                                        v-for="author in post.authors"
                                        v-if="post.authors.length"
                                    >
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                                <p class="mt-2" v-else>
                                    Team Member:
                                    <span
                                        v-for="author in post.authors"
                                        v-if="post.authors.length"
                                    >
                                        <router-link
                                            :to="`/profile/${author.slug}/${author.id}`"
                                            class="authors"
                                            >{{ author.name }}</router-link
                                        >
                                    </span>
                                </p>
                            </div>
                            <div class="post-sub-title">
                                <p>
                                    {{ post.created_at }}
                                    .
                                    <a v-if="post.read_count > 1"
                                        >{{ post.read_count }} Reads</a
                                    ><a v-else-if="post.read_count <= 1"
                                        >{{ post.read_count }} Read</a
                                    >
                                    .
                                    <a>{{ post.upVote }} UpVote</a>
                                    .
                                    <a>{{ post.downVote }} DownVote</a>
                                </p>
                                <a
                                    v-if="post.like_count && authUser"
                                    @click="getLikedUser(index)"
                                >
                                    {{ post.like_count }}
                                    <i class="fa-solid fa-thumbs-up"></i>
                                </a>
                                <a v-else-if="post.like_count">
                                    {{ post.like_count }}
                                    <i class="fa-solid fa-thumbs-up"></i>
                                </a>
                            </div>
                            <div class="footer">
                                <span>
                                    <button class="main-btn main-btn__bg">
                                        Download
                                    </button>

                                    <!-- <button
                                class="main-btn mx-2 float-start"
                            >
                                <router-link
                                    :to="`/post_description/${post.title}/${post.id}`"
                                >
                                    View
                                </router-link>
                            </button> -->

                                    <a :href="`${post.url}`" v-if="post.url">
                                        Link
                                    </a>
                                </span>
                                <span>
                                    <a
                                        v-on:click="like(index)"
                                        v-bind:class="{
                                            active: post.authUserLike == 'yes',
                                        }"
                                        v-if="authUser"
                                    >
                                        Like
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- <div
                        v-else-if="isLoading == true"
                        style="text-align: center; margin: 20px"
                    >
                        <h3>Pasts Loading...</h3>
                    </div> -->
                    <div v-else-if="isLoading == false && posts.length == 0">
                        <h2 class="text-center pt-50">No Data Found!!</h2>
                    </div>
                    <div v-if="isLoading == true">
                        <div class="research-post--skeleton">
                            <div class="post-title-skeleton">
                                <p></p>
                            </div>
                            <div class="post-sub-title-skeleton">
                                <p></p>
                            </div>
                            <div class="footer">
                                <a> </a>
                                <a> </a>
                            </div>
                        </div>
                        <div class="research-post--skeleton">
                            <div class="post-title-skeleton">
                                <p></p>
                            </div>
                            <div class="post-sub-title-skeleton">
                                <p></p>
                            </div>
                            <div class="footer">
                                <a> </a>
                                <a> </a>
                            </div>
                        </div>
                        <div class="research-post--skeleton">
                            <div class="post-title-skeleton">
                                <p></p>
                            </div>
                            <div class="post-sub-title-skeleton">
                                <p></p>
                            </div>
                            <div class="footer">
                                <a> </a>
                                <a> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--***** Liked User Modal *****-->
        <Modal
            v-model="likedUserModal"
            title="People Who Liked"
            :mask-closable="true"
            :closable="true"
        >
            <div class="comment-liked" v-for="user in likedUser">
                <img :src="user.image" alt="img" />
                <router-link :to="`/profile/${user.slug}/${user.user_id}`">
                    {{ user.name }}
                </router-link>
            </div>
            <div slot="footer"></div>
        </Modal>
        <div v-if="isDataLoading == true">
            <h2 class="text-center pt-50">Loading...</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: "HOME",
    components: {
        return: {},
    },
    // Properties returned from data() become reactive state
    // and will be exposed on `this`.
    data() {
        return {
            isSearchbar: false,
            isFilter: false,
            mobileDropdownIndex: -1,
            likedUserModal: false,
            isLoading: false,
            isDataLoading: true,
            users: [],
            posts: [],
            departments: [],
            likedUser: [],
            url: "",
            user_id: "",
            id: "",
            like_count: 0,
            authUserLike: "",
            filter: {
                department: "",
                default: "",
                order: "",
            },
            search: "",
            departmentName: "",
            type: "",
        };
    },
    // watch: {
    //     // search(after, before) {
    //     //     this.filterPosts();
    //     // },
    // },
    // computed: {
    //     isAllFilterClear() {
    //         let flag = true;
    //         if (this.filter.department.length > 0) flag = false;
    //         if (this.filter.default.length > 0) flag = false;
    //         if (this.filter.order.length > 0) flag = false;
    //         return flag;
    //     },
    // },
    methods: {
        showSearchbar() {
            this.isSearchbar = true;
        },
        cancelSearchBar() {
            this.isSearchbar = false;
            this.search = "";

            // this.removeFromSelectedFilterAll();
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
        mobileMenuDropdown(index) {
            if (this.mobileDropdownIndex === index) {
                this.mobileDropdownIndex = -1;
            } else {
                this.mobileDropdownIndex = index;
            }
        },

        async upVote(index) {
            if (
                this.authUser.userType == "teacher" ||
                this.authUser.userType == "admin"
            ) {
                if (this.posts[index].user_id != this.authUser.id) {
                    let upVoteCount1 = parseInt(this.posts[index].upVote, 10);
                    let avgVoteCount1 = parseInt(this.posts[index].avgVote, 10);
                    let downVoteCount1 = parseInt(
                        this.posts[index].downVote,
                        10
                    );
                    let obj = {
                        id: this.posts[index].id,
                        upVote: 1,
                    };
                    console.log(obj);
                    const res = await this.callApi("post", "/api/up_vote", obj);
                    if (res.status == 200) {
                        this.posts[index].upVote = upVoteCount1 - 1;
                        this.posts[index].avgVote =
                            upVoteCount1 - 1 - downVoteCount1;
                        this.posts[index].authUserVote = "";
                    }
                    if (res.status == 201) {
                        this.posts[index].upVote = upVoteCount1 + 1;
                        this.posts[index].avgVote =
                            upVoteCount1 + 1 - (downVoteCount1 - 1);
                        this.posts[index].downVote = downVoteCount1 - 1;
                        this.posts[index].authUserVote = "up";
                    }
                    if (res.status == 202) {
                        this.posts[index].upVote = upVoteCount1 + 1;
                        this.posts[index].avgVote =
                            upVoteCount1 + 1 - downVoteCount1;
                        this.posts[index].authUserVote = "up";
                    }
                } else {
                    this.i("You can't vote your own post!");
                }
            } else {
                this.i(
                    "Thanks for the feedback! You are not eligible to cast a vote, but your feedback has been recorded."
                );
            }
        },

        async downVote(index) {
            if (
                this.authUser.userType == "teacher" ||
                this.authUser.userType == "admin"
            ) {
                if (this.posts[index].user_id != this.authUser.id) {
                    let upVoteCount1 = parseInt(this.posts[index].upVote, 10);
                    let avgVoteCount1 = parseInt(this.posts[index].avgVote, 10);
                    let downVoteCount1 = parseInt(
                        this.posts[index].downVote,
                        10
                    );

                    let obj = {
                        id: this.posts[index].id,
                        downVote: 1,
                    };
                    console.log(obj);
                    const res = await this.callApi(
                        "post",
                        "/api/down_vote",
                        obj
                    );
                    if (res.status == 200) {
                        this.posts[index].avgVote =
                            upVoteCount1 - (downVoteCount1 - 1);
                        this.posts[index].downVote = downVoteCount1 - 1;
                        this.posts[index].authUserVote = "";
                    }
                    if (res.status == 201) {
                        this.posts[index].upVote = upVoteCount1 - 1;
                        this.posts[index].downVote = downVoteCount1 + 1;
                        this.posts[index].avgVote =
                            upVoteCount1 - 1 - (downVoteCount1 + 1);
                        this.posts[index].authUserVote = "down";
                    }

                    if (res.status == 202) {
                        this.posts[index].avgVote =
                            upVoteCount1 - (downVoteCount1 + 1);
                        this.posts[index].downVote = downVoteCount1 + 1;
                        this.posts[index].authUserVote = "down";
                    }
                } else {
                    this.i("You can't vote your own post!");
                }
            } else {
                this.i(
                    "Thanks for the feedback! You are not eligible to cast a vote, but your feedback has been recorded."
                );
            }
        },

        async like(index) {
            // if (this.posts[index].user_id != this.authUser.id) {
            let obj = {
                id: this.posts[index].id,
            };
            this.id = this.posts[index].id;
            console.log(this.id);
            const res = await this.callApi("post", "/api/like", obj);
            if (res.status == 201) {
                this.posts[index].like_count += 1;
                this.posts[index].authUserLike = "yes";
            } else {
                this.posts[index].like_count -= 1;
                this.posts[index].authUserLike = "no";
            }
            // }
        },

        async getLikedUser(index) {
            let obj = {
                id: this.posts[index].id,
            };
            console.log(this.posts[index].id);
            const res = await this.callApi(
                "get",
                `/api/get_liked_user?id=${this.posts[index].id}`
            );
            if (res.status == 200) {
                this.likedUser = res.data.data;
                this.likedUserModal = true;
            } else {
                this.swr();
            }
        },
        async download(post) {
            this.url = post.attachment;
            console.log(this.url);
            const res = await this.callApi(
                "get",
                `/api/download_attachment/${this.url}`
            );
        },
        async view(post) {
            this.id = post.id;
            console.log(this.id);
            const res = await this.callApi(
                "get",
                `/api/view_attachment/${this.id}`
            );
            if (res.status == 200) {
                this.s(res.data.msg);
            }
        },
        // async searchPost(query) {
        //     this.isLoading = true;
        //     console.log(query);

        //     // const response = await this.callApi("get", `/api/get_all_research`);
        //     const response = await this.callApi(
        //         "get",
        //         `/api/get_all_research?search=${query}`
        //     );
        //     if (response.status == 200) {
        //         this.posts = response.data.data;
        //     } else this.swr();
        //     this.isLoading = false;
        // },

        sortData(key) {
            this.filter.default = key[0];
            this.filter.order = key[1];
            this.filterPosts();
        },
        addToFilterDepartment(department) {
            this.filter.department = department.id;
            this.departmentName = department.department_name;
            this.filterPosts();
        },
        addToFilterSearch(index) {
            this.search = index;
            this.filterPosts();
        },
        removeFromSelectedFilterAll() {
            this.filter.department = "";
            this.filter.default = "";
            this.filter.order = "";
            this.search = "";
            this.departmentName = "";
            this.filterPosts();
        },
        async filterPosts() {
            this.isLoading = true;
            // const response = await this.callApi("get", `/api/get_all_research`);
            const response = await this.callApi(
                "get",
                `/api/get_all_research?department=${this.filter.department}&search=${this.search}&default=${this.filter.default}&order=${this.filter.order}`
            );
            if (response.status == 200) {
                this.posts = response.data.data;
            } else this.swr();
            this.isLoading = false;
        },
        async filterDefault(d) {
            this.isLoading = true;
            // const response = await this.callApi("get", `/api/get_all_research`);
            const response = await this.callApi(
                "get",
                `/api/get_all_research?default=${d}`
            );
            if (response.status == 200) {
                this.posts = response.data.data;
            } else this.swr();
            this.isLoading = false;
        },
        async reset() {
            const res2 = await this.callApi("get", `/api/get_all_post`);
            if (res2.status == 200) {
                this.posts = res2.data;
            } else {
                this.swr();
            }
        },
    },

    //Called after the instance has finished processing all state-related options.
    // async created() {
    //     this.token = window.Laravel.csrfToken;

    //     const res1 = await this.callApi("get", "/api/get_all_user");

    //     const res2 = await this.callApi("get", `/api/get_all_post`);
    //     if (res1.status == 200) {
    //         this.users = res1.data;
    //     }
    //     if (res2.status == 200) {
    //         this.posts = res2.data.data;
    //         this.like_count = this.posts.like_count;
    //     } else {
    //         this.swr();
    //     }

    //     this.isLoading = false;
    // },
    async created() {
        await this.filterPosts();
        const [resPosts, resDepartments] = await Promise.all([
            this.callApi(
                "get",
                `/api/get_all_research?department=${this.filter.department}&search=${this.search}&default=${this.filter.default}`
            ),
            this.callApi("get", "/api/get_departments"),
        ]);
        if (resPosts.status == 200 && resDepartments.status == 200) {
            this.posts = resPosts.data.data;
            this.departments = resDepartments.data.data;
        } else this.e("Oops!", "Something went wrong, please try again!");
        this.isDataLoading = false;
    },
};
</script>
<style scoped>
h6:hover {
    cursor: pointer;
    color: #000;
}

.image-loader {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 100px;
    border: 1px solid transparent;
    overflow: hidden;
    background: #a7a7a7;
    margin-right: 2px;
}

.loader h6 {
    width: 160px;
    height: 15px;
    margin-bottom: 5px;
    background-color: #c0c0c0;
}
.loader p {
    width: 50px;
    height: 15px;
    background-color: #a7a7a7;
}
</style>
