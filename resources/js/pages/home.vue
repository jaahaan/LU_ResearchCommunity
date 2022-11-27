<template>
    <section class="post__section">
        <div class="container mt-3 col-md-10">
            <div class="row">
                <!-- first Card -->
                <!--Suggested research-->
                <div class="col-lg-8">
                    <div
                        class="row"
                        v-for="(post, index) in posts"
                        :key="index"
                        v-if="posts.length"
                    >
                        <div class="col-1 m-auto vote">
                            <i
                                @click="upVote(index)"
                                :class="[
                                    post.authUserVote == 'up'
                                        ? 'fa-solid fa-caret-up upActive'
                                        : 'fa-solid fa-caret-up',
                                    'fa-solid fa-caret-up',
                                ]"
                            ></i>
                            <h6>{{ post.avgVote }}</h6>
                            <i
                                @click="downVote(index)"
                                :class="[
                                    post.authUserVote == 'down'
                                        ? 'fa-solid fa-caret-down downActive'
                                        : 'fa-solid fa-caret-down',
                                    'fa-solid fa-caret-down',
                                ]"
                            ></i>
                        </div>
                        <div class="col-11">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-block m-auto">
                                        <img
                                            :src="post.image"
                                            alt="img"
                                            class="img-fluid profile-img float-start me-2"
                                        />
                                        <div class="float-start">
                                            <h6>
                                                <router-link
                                                    :to="`/profile/${post.user_slug}/${post.user_id}`"
                                                >
                                                    {{ post.name }}
                                                </router-link>
                                            </h6>
                                            <p>
                                                {{ post.designation }}
                                                .
                                                {{ post.department }}
                                            </p>
                                        </div>
                                        <div
                                            v-if="post.user_id != authUser.id"
                                            class="btn-edit mx-2 float-end"
                                            @click="reset()"
                                        >
                                            <a>Follow</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="d-block">
                                        <img
                                            :src="'images/blockchain.jpg'"
                                            alt="img"
                                            class="img-fluid home-img"
                                        /><img
                                            :src="'images/java-oops.png'"
                                            alt="img"
                                            class="img-fluid home-img"
                                        /><img
                                            :src="'images/success.jpg'"
                                            alt="img"
                                            class="img-fluid home-img"
                                        />
                                    </div> -->
                                    <!-- <div class="row mb-3">
                                        <div class="d-block my-auto">
                                            <img
                                                :src="post.image"
                                                alt="img"
                                                class="img-fluid profile-img float-start me-2"
                                            />
                                            <div class="float-start">
                                                <h6>
                                                    <router-link
                                                        :to="`/profile/${post.user_slug}/${post.user_id}`"
                                                    >
                                                        {{ post.name }}
                                                    </router-link>
                                                </h6>
                                                <p>
                                                    {{ post.designation }}
                                                    .
                                                    {{ post.department }}
                                                </p>
                                            </div>
                                            <div class="float-end my-auto">
                                                <a>Follow</a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <h3>
                                        {{ post.title }}
                                    </h3>
                                    <p v-if="post.abstract != null">
                                        {{ post.abstract.substring(0, 190) }}
                                        ...
                                        <router-link
                                            :to="`/description/${post.slug}`"
                                            >See more</router-link
                                        >
                                    </p>

                                    <div class="mt-2 mb-2">
                                        <router-link
                                            :to="`/description/${post.slug}`"
                                            class="main-btn main-btn__border d-inline-block text-center"
                                        >
                                            {{ post.type }}</router-link
                                        >
                                    </div>
                                    <p>
                                        {{ post.created_at }}
                                        .
                                        <a v-if="post.read_count > 1"
                                            >{{ post.read_count }} Reads</a
                                        ><a v-else-if="post.read_count <= 1"
                                            >{{ post.read_count }} Read</a
                                        >
                                        . <a>{{ post.upVote }} UpVote</a> .
                                        <a>{{ post.downVote }} DownVote</a>
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
                                            <span
                                                v-for="author in post.authors"
                                            >
                                                <router-link
                                                    :to="`/profile/${author.slug}/${author.id}`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
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
                                            <span
                                                v-for="author in post.authors"
                                            >
                                                <router-link
                                                    :to="`/profile/${author.slug}/${author.id}`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
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
                                            <span
                                                v-for="author in post.authors"
                                            >
                                                <router-link
                                                    :to="`/profile/${author.slug}/${author.id}`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
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
                                            <span
                                                v-for="author in post.authors"
                                            >
                                                <router-link
                                                    :to="`/profile/${author.slug}/${author.id}`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
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
                                        <p
                                            v-if="post.authors.length > 1"
                                            class="mt-2"
                                        >
                                            Team Members:
                                            <span
                                                v-for="author in post.authors"
                                                v-if="post.authors.length"
                                            >
                                                <router-link
                                                    :to="`/profile/${author.slug}/${author.id}`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
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
                                                    >{{
                                                        author.name
                                                    }}</router-link
                                                >
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="card-footer text-muted">
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

                                        <a
                                            :href="`${post.url}`"
                                            v-if="post.url"
                                        >
                                            Link
                                        </a>
                                    </span>
                                    <span>
                                        <a
                                            v-on:click="like(index)"
                                            v-bind:class="{
                                                active:
                                                    post.authUserLike == 'yes',
                                            }"
                                        >
                                            <span v-if="post.like_count > 1"
                                                >{{
                                                    post.like_count
                                                }}
                                                Likes</span
                                            >
                                            <span v-if="post.like_count <= 1"
                                                >{{
                                                    post.like_count
                                                }}
                                                Like</span
                                            >
                                        </a>
                                        <!-- <a
                                            ><img
                                                src="https://img.icons8.com/small/16/null/topic--v1.png"
                                            />
                                            <router-link
                                                :to="`/description/${post.slug}`"
                                                >Comment</router-link
                                            >
                                        </a> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="isLoading == true">
                        <h2 class="text-center pt-50">Loading...</h2>
                    </div>
                </div>

                <!-- second Card -->
                <div class="col-lg-4">
                    <!-- <div class="shop-searchBy--radio">
                        <h4 class="shop-head">Department</h4>
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
                    </div> -->
                    <!--People you may know-->
                    <div
                        class="card mb-3"
                        v-if="users != '' && isLoading == false"
                    >
                        <div class="card-header">
                            <div class="d-block">
                                <div class="float-start">
                                    <h6>People you may know</h6>
                                </div>
                                <div
                                    class="btn-edit float-end"
                                    @click="reset()"
                                >
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                        <div
                            v-for="(user, index) in users"
                            v-if="authUser.id != user.id && index < 4"
                            :key="index"
                        >
                            <div
                                class="card-body"
                                v-if="authUser.id != user.id"
                            >
                                <div class="d-block my-auto">
                                    <img
                                        :src="user.image"
                                        alt="img"
                                        class="img-fluid profile-img float-start me-2"
                                    />
                                    <div class="float-start">
                                        <h6 @click="getUser(user)">
                                            {{ user.name }}
                                        </h6>
                                        <p>
                                            {{ user.designation }} .
                                            {{ user.department }}
                                        </p>
                                    </div>
                                    <div class="float-end my-auto">
                                        <a>Follow</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-muted text-center">
                            <div class="d-block">
                                <a class="mx-2 text-dark">
                                    View all researchers
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- People with similar skills -->
                    <div
                        class="card mb-3"
                        v-if="users != '' && isLoading == false"
                    >
                        <div class="card-header">
                            <div class="d-block pb-4">
                                <div class="float-start">
                                    <h6>People with similar skills</h6>
                                </div>
                                <div
                                    class="btn-edit mx-2 float-end"
                                    @click="reset()"
                                >
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                        <div
                            v-for="(user, index) in users"
                            v-if="authUser.id != user.id && index < 4"
                            :key="index"
                        >
                            <div class="card-body">
                                <div class="d-block my-auto">
                                    <img
                                        :src="user.image"
                                        alt="img"
                                        class="img-fluid profile-img float-start me-2"
                                    />
                                    <div class="float-start">
                                        <h6 @click="getUser(user)">
                                            {{ user.name }}
                                        </h6>
                                        <p>
                                            {{ user.designation }} .
                                            {{ user.department }}
                                        </p>
                                    </div>
                                    <div class="float-end my-auto">
                                        <a>Follow</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center">
                            <div class="d-block">
                                <a class="mx-2 text-dark">
                                    View all related researchers
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- loader1 -->
                    <div class="card mb-3" v-if="isLoading == true">
                        <div class="card-header p-3">
                            <div class="loader">
                                <h6 />
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div
                            class="card-footer text-muted d-block text-center p-3"
                        >
                            <div class="loader">
                                <h6 />
                            </div>
                        </div>
                    </div>

                    <!-- loader2 -->
                    <div class="card mb-3" v-if="isLoading == true">
                        <div class="card-header p-3">
                            <div class="loader">
                                <h6 />
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div class="m-2">
                            <div class="d-block my-auto">
                                <img
                                    :src="'/public/profileImages/download.jpg'"
                                    alt="img"
                                    class="img-fluid float-start me-2 image-loader"
                                />
                                <div class="float-start loader">
                                    <h6 />
                                    <p class="d-inline-block" />

                                    <p class="d-inline-block" />
                                </div>
                                <div class="float-end my-auto loader">
                                    <p />
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-muted text-center p-3">
                            <div class="d-block text-center loader">
                                <h6 />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            isLoading: true,
            users: [],
            posts: [],
            departments: [],
            url: "",
            user_id: "",
            id: "",
            like_count: 0,
            authUserLike: "",
            filter: {
                department: "",
                search: "",
                default: "",
            },
        };
    },
    methods: {
        getUser(user) {
            this.user_id = user.id;
            this.user_slug = user.slug;

            this.$router.push(`/profile/${this.user_slug}/${this.user_id}`);
            this.keyword = "";
        },
        async upVote(index) {
            if (this.posts[index].user_id != this.authUser.id) {
                let obj = {
                    id: this.posts[index].id,
                    upVote: 1,
                };
                console.log(obj);
                const res = await this.callApi("post", "/api/up_vote", obj);
                if (this.res.status == 200) {
                    this.posts[index].upVote -= 1;
                    this.posts[index].avgVote -= 1;
                    this.posts[index].authUserVote = "none";
                } else if (this.res.status == 201) {
                    this.posts[index].upVote += 1;
                    this.posts[index].avgVote += 1;
                    this.posts[index].authUserVote = "up";
                } else if (this.res.data == "deleted down") {
                    this.posts[index].upVote += 1;
                    this.posts[index].avgVote += 1;
                    this.posts[index].downVote -= 1;
                    this.posts[index].authUserVote = "up";
                }
            }
        },
        async downVote(index) {
            if (this.posts[index].user_id != this.authUser.id) {
                let obj = {
                    id: this.posts[index].id,
                    downVote: 1,
                };
                console.log(obj);
                const res = await this.callApi("post", "/api/down_vote", obj);
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

        async filterPosts() {
            this.isLoading = true;
            const response = await this.callApi("get", `/api/get_all_post`);
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
        // await this.filterPosts();
        const [resPosts, resDepartments, resUsers] = await Promise.all([
            this.callApi("get", `/api/get_all_post`),
            this.callApi("get", "/api/get_departments"),
            this.callApi("get", "/api/get_all_user"),
        ]);
        if (
            resPosts.status == 200 &&
            resDepartments.status == 200 &&
            resUsers.status == 200
        ) {
            this.posts = resPosts.data.data;
            this.departments = resDepartments.data;
            this.users = resUsers.data;
        } else this.e("Oops!", "Something went wrong, please try again!");
        this.isLoading = false;
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
