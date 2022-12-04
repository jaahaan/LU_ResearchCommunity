<template>
    <div>
        <div v-if="isLoading == false">
            <section class="container pt-4 pb-4 col-lg-8">
                <div class="home-post-section">
                    <!-- post description -->
                    <div class="post-description menu-item">
                        <div
                            class="menu-item-box"
                            v-for="(post, index) in posts"
                            :key="index"
                            v-if="posts.length"
                        >
                            <div class="vote">
                                <span @click="upVote(index)">
                                    <i
                                        :class="[
                                            post.authUserVote == 'up'
                                                ? 'fa-solid fa-caret-up upActive'
                                                : 'fa-solid fa-caret-up',
                                            'fa-solid fa-caret-up',
                                        ]"
                                    ></i>
                                </span>
                                <h6>{{ post.avgVote }}</h6>
                                <span @click="downVote(index)">
                                    <i
                                        :class="[
                                            post.authUserVote == 'down'
                                                ? 'fa-solid fa-caret-down downActive'
                                                : 'fa-solid fa-caret-down',
                                            'fa-solid fa-caret-down',
                                        ]"
                                    ></i>
                                </span>
                            </div>
                            <div class="post-details">
                                <div class="header">
                                    <img :src="post.image" alt="img" />
                                    <div class="header-content">
                                        <router-link
                                            :to="`/profile/${post.slug}/${post.user_id}`"
                                        >
                                            {{ post.name }}
                                        </router-link>
                                        <!-- . {{ item.created_at }} -->

                                        <p>
                                            {{ post.designation }} .
                                            {{ post.department }}
                                        </p>
                                    </div>
                                </div>
                                <h5 class="menu-item--title">
                                    {{ post.title }}
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
                                    <router-link
                                        :to="`/description/${post.slug}`"
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
                                <div class="sub-title">
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
                                    <a
                                        v-if="post.like_count"
                                        @click="getLikedUser(index)"
                                    >
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
                                            Like
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

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

        <!-- <Modal
            v-model="likedUserModal"
            title="People Who Liked"
            :mask-closable="true"
            :closable="true"
            :variant="hidden"
        >
            <div class="comment-liked" v-for="user in likedUser">
                <img :src="user.image" alt="img" />
                <router-link :to="`/profile/${user.slug}/${user.user_id}`">
                    {{ user.name }}
                </router-link>
            </div>
        </Modal> -->

        <div v-if="isLoading == true">
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
            likedUserModal: false,
            isLoading: true,
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
