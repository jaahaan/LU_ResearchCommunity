<template>
    <div>
        <section class="container home">
            <div class="row" v-if="isLoading == false">
                <div class="col-lg-8 research-post m-auto">
                    <!-- post description -->
                    <div class="home-post-section">
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
                                                :to="`/profile/${post.user_slug}/overview`"
                                            >
                                                {{ post.name }}
                                            </router-link>
                                            <!-- . {{ item.created_at }} -->

                                            <p>
                                                {{ post.designation }} .
                                                {{
                                                    post.department
                                                        .department_name
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <h5 class="menu-item--title">
                                        <router-link
                                            :to="`/description/${post.slug}/overview`"
                                            >{{ post.title }}</router-link
                                        >
                                    </h5>
                                    <hooper
                                        :settings="hooperImage"
                                        :wheelControl="false"
                                        v-if="post.images.length > 0"
                                    >
                                        <slide
                                            class="post-image"
                                            v-for="(
                                                image, index
                                            ) in post.images"
                                            :key="index"
                                        >
                                            <img
                                                :src="`${
                                                    http + image.image_name
                                                }`"
                                            />
                                            <div class="post-image-cover">
                                                <i
                                                    class="lni lni-search-alt"
                                                    @click="
                                                        handleView(
                                                            image.image_name,
                                                            index
                                                        )
                                                    "
                                                ></i>
                                            </div>
                                        </slide>

                                        <hooper-navigation
                                            slot="hooper-addons"
                                            class="hooper-relatedResearch_button"
                                        ></hooper-navigation>
                                    </hooper>
                                    <p v-if="post.abstract != null">
                                        {{ post.abstract.substring(0, 190) }}
                                        ...
                                        <router-link
                                            :to="`/description/${post.slug}/overview`"
                                            >See more</router-link
                                        >
                                    </p>
                                    <div class="mt-2 mb-2">
                                        <router-link
                                            :to="`/description/${post.slug}/overview`"
                                            class="main-btn main-btn__type d-inline-block text-center"
                                        >
                                            {{ post.type }}</router-link
                                        >
                                    </div>
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
                                                    :to="`/profile/${author.slug}/overview`"
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
                                                    :to="`/profile/${author.slug}/overview`"
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
                                                    :to="`/profile/${author.slug}/overview`"
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
                                                    :to="`/profile/${author.slug}/overview`"
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
                                                    :to="`/profile/${author.slug}/overview`"
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
                                                    :to="`/profile/${author.slug}/overview`"
                                                    class="authors"
                                                    >{{
                                                        author.name
                                                    }}</router-link
                                                >
                                            </span>
                                        </p>
                                    </div>
                                    <div class="sub-title">
                                        <p>
                                            {{ post.formatedDateTime
                                            }}<span class="dot">.</span
                                            ><a v-if="post.read_count > 1"
                                                >{{ post.read_count }} Reads</a
                                            ><a v-else-if="post.read_count <= 1"
                                                >{{ post.read_count }} Read</a
                                            ><span class="dot">.</span
                                            ><a>{{ post.upVote }} UpVote</a
                                            ><span class="dot">.</span
                                            ><a>{{ post.downVote }} DownVote</a>
                                        </p>
                                    </div>
                                    <div class="footer">
                                        <p>
                                            <a
                                                v-if="
                                                    post.attachment && authUser
                                                "
                                                class="main-btn main-btn__bg px-4"
                                                :href="`http://localhost:8000/api/download_attachment/${post.attachment}`"
                                                >Download
                                                <i class="fa-solid fa-download"
                                            /></a>
                                            <a
                                                class="main-btn main-btn__bg px-5"
                                                :href="`${post.url}`"
                                                v-if="post.url"
                                                target="_blank"
                                            >
                                                Link
                                                <i
                                                    class="fa-solid fa-arrow-up-right-from-square"
                                                ></i>
                                            </a>
                                        </p>
                                        <p>
                                            <a
                                                v-if="post.like_count"
                                                @click="getLikedUser(index)"
                                            >
                                                {{ post.like_count }}
                                            </a>

                                            <a
                                                v-on:click="like(index)"
                                                v-bind:class="{
                                                    active:
                                                        post.authUserLike ==
                                                        'yes',
                                                }"
                                            >
                                                <i
                                                    class="fa-solid fa-thumbs-up"
                                                ></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="loadMoreLoading && !noPostRemaining"
                        class="loader-lg"
                    >
                        <i
                            class="ivu-load-loop ivu-icon ivu-icon-ios-loading"
                        ></i>
                    </div>

                    <!-- <div v-else-if="noResearchRemaining">
            <div style="text-align: center; margin: 30px 0px">
              <h4>No More Research Found...</h4>
            </div>
          </div> -->
                </div>
                <div
                    class="col-lg-4 d-none d-lg-block research-people"
                    id="home"
                >
                    <div class="research-post--item">
                        <h5 class="post-title">People you may know</h5>
                        <ul>
                            <li v-for="(user, index) in peopleYouMayKnow">
                                <div class="content">
                                    <img :src="user.image" alt="img" />
                                    <div>
                                        <router-link
                                            :to="`/profile/${user.slug}/overview`"
                                        >
                                            {{ user.name }}
                                        </router-link>
                                        <p>
                                            {{ user.designation
                                            }}<span class="dot">.</span
                                            >{{
                                                user.department.department_name
                                            }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    class="main-btn main-btn__bg"
                                    v-if="user.status == 'pending'"
                                    @click="ignoreConnection(index)"
                                >
                                    <i
                                        class="fa-solid fa-clock-rotate-left"
                                    ></i>
                                    Pending
                                </button>
                                <button
                                    class="main-btn main-btn__border"
                                    @click="connect(index)"
                                    v-else-if="user.status == 'connect'"
                                >
                                    <i class="fa-solid fa-user-plus"></i>
                                    Connect
                                </button>
                            </li>
                        </ul>
                    </div>
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
                        <router-link :to="`/profile/${user.slug}/overview`">
                            {{ user.name }}
                        </router-link>
                    </div>
                    <div slot="footer"></div>
                </Modal>
                <Modal v-model="visible">
                    <img :src="imgName" v-if="visible" style="width: 100%" />
                    <div slot="footer">Figure: {{ index + 1 }}</div>
                </Modal>
            </div>
            <div v-if="isLoading == true" class="loader-lg">
                <i class="ivu-load-loop ivu-icon ivu-icon-ios-loading"></i>
            </div>
        </section>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import {
    Hooper,
    Slide,
    Progress as HooperProgress,
    Pagination as HooperPagination,
    Navigation as HooperNavigation,
} from "hooper";
import "hooper/dist/hooper.css";
const { io } = require("socket.io-client");

export default {
    middleware: "auth",

    components: {
        Hooper,
        Slide,
        HooperProgress,
        HooperPagination,
        HooperNavigation,
    },
    // Properties returned from data() become reactive state
    // and will be exposed on `this`.
    data() {
        return {
            hooperImage: {
                commentsToShow: 1,
                centerMode: false,
                breakpoints: {
                    768: {
                        centerMode: false,
                        itemsToShow: 2,
                    },
                },
            },
            visible: false,
            imgName: "",
            index: "",
            likedUserModal: false,
            loadMoreLoading: false,
            noPostRemaining: false,
            sendRequest: false,
            page: 1,
            limit: 4,
            users: [],
            likedUser: [],
            url: "",
            user_id: "",
            id: "",
            like_count: 0,
            authUserLike: "",
            page: 1,
            http: "http://localhost:8000/images/",
            socket: null,
        };
    },
    computed: {
        ...mapGetters({
            peopleYouMayKnow: "getPeopleYouMayKnow",
            posts: "getAllGlobalPost",
            isLoading: "getGlobalPostLoading",
        }),
    },
    methods: {
        handleView(item, index) {
            this.imgName = this.http + item;
            this.index = index;
            this.visible = true;
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
                    let notificationObj = {
                        id: this.posts[index].user_id,
                    };
                    this.socket.emit("notification", notificationObj);
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
                    let notificationObj = {
                        id: this.posts[index].user_id,
                    };
                    this.socket.emit("notification", notificationObj);
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
            if (this.posts[index].user_id != this.authUser.id) {
                let obj = {
                    id: this.posts[index].id,
                };
                this.id = this.posts[index].id;
                console.log(this.id);
                if (this.posts[index].authUserLike == "no") {
                    this.posts[index].like_count += 1;
                    this.posts[index].authUserLike = "yes";
                } else {
                    this.posts[index].like_count -= 1;
                    this.posts[index].authUserLike = "no";
                }
                let notificationObj = {
                    id: this.posts[index].user_id,
                };

                const res = await this.callApi("post", "/api/like", obj);
                // if (res.status == 201) {
                this.socket.emit("notification", notificationObj);
                // }
            } else {
                this.i("You can't like your own post!!");
            }
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
        async download(index) {
            this.url = this.posts[index].attachment;
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
            window.history.pushState({}, null, `${this.$route.path}`);
            this.$store.commit("setGlobalPostLoading", true);
            const response = await this.callApi(
                "get",
                `/api/get_all_post?limit=${this.limit}`
            );
            if (response.status == 200) {
                this.$store.commit("setAllGlobalPost", response.data.data);
            } else this.swr();
            this.$store.commit("setGlobalPostLoading", false);
        },
        async loadMore(more) {
            console.log("Load more is calling! length", this.posts.length);

            if (this.noPostRemaining) return;

            this.limit = this.limit + more;
            this.loadMoreLoading = true;
            const res = await this.callApi(
                "get",
                `/api/get_all_post?limit=${this.limit}`
            );
            if (res.status == 200) {
                let prevLength = this.posts.length;
                if (this.posts.length == res.data.data.length) {
                    this.noPostRemaining = true;
                }
                for (let i in res.data.data) {
                    console.log("pushing data");
                    let d = res.data.data[i];
                    if (i >= prevLength) {
                        this.$store.commit("pushAllGlobalPost", d);
                    }
                }
            }
            this.loadMoreLoading = false;
            console.log("Load more is finished! length", this.posts.length);
        },

        async connect(index) {
            console.log("inside connect");
            // this.sendRequest = true;
            this.peopleYouMayKnow[index].status = "pending";
            const res = await this.callApi(
                "post",
                `/api/add_connection?id=${this.peopleYouMayKnow[index].id}`
            );
            let notificationObj = {
                id: this.peopleYouMayKnow[index].id,
            };
            this.socket.emit("notification", notificationObj);
            if (res.status == 201) {
                // this.sendRequest = true;
                this.connection = res.data.data;
            } else {
                this.sendRequest = false;
            }
        },

        async ignoreConnection(index) {
            // console.log(this.connection.user2.id);
            this.peopleYouMayKnow[index].status = "connect";
            const res = await this.callApi(
                "post",
                `/api/ignore_connection?id=${this.connection.id}&user_id=${this.peopleYouMayKnow[index].id}`
            );
            if (res.status == 201) {
                this.sendRequest = false;
            }
        },
    },

    watch: {
        "$route.fullPath": function (newVal, oldVal) {
            // watch it
            console.log("Prop changed: ", newVal, " | was: ", oldVal);
            window.scrollTo(0, 0);

            this.page = this.$route.query.page ? this.$route.query.page : 1;

            this.filterPosts();
        },
    },

    // async asyncData({ app, store, redirect, params }) {
    //   store.commit("setGlobalPostLoading", true);

    //   try {
    //     let [res, res1] = await Promise.all([
    //       app.$axios.get(`/api/get_all_post`),
    //       app.$axios.get(`/api/get_people_you_may_know`),
    //     ]);
    //     store.commit("setAllGlobalPost", res.data.data);
    //     store.commit("setGlobalPostLoading", false);
    //     store.dispatch("updatePeopleYouMayKnow", res1.data.data);
    //     return {};
    //   } catch (error) {
    //     console.log("error from asyncData server");
    //     console.log(error);
    //     return redirect("/");
    //   }
    //   store.commit("setGlobalPostLoading", false);
    // },
    async created() {
        this.page = this.$route.query.page ? this.$route.query.page : 1;
        if (this.authUser) {
            this.$store.commit("setGlobalPostLoading", true);
            const [res, res1] = await Promise.all([
                this.callApi("get", `/api/get_all_post?limit=${this.limit}`),
                this.callApi("get", "/api/get_people_you_may_know"),
            ]);

            if (res.status == 200 && res1.status == 200) {
                this.$store.commit("setAllGlobalPost", res.data.data);
                // this.$store.commit("setGlobalPostLoading", false);
                this.$store.dispatch("updatePeopleYouMayKnow", res1.data.data);
            }
            // else {
            //   this.swr();
            // }
            this.$store.commit("setGlobalPostLoading", false);
        }
    },

    mounted() {
        // document.addEventListener("click", this.hideSearchbar);
        this.socket = io("http://localhost:5000", {
            methods: ["GET", "POST"],
            transports: ["websocket"],
            credentials: true,
        });
        window.onscroll = () => {
            this.bottomOfWindow =
                window.pageYOffset + window.innerHeight >
                document.body.scrollHeight - 100;

            if (this.bottomOfWindow) {
                if (!this.loadMoreLoading) {
                    this.loadMore(4);
                }
            }
        };
    },
    // beforeDestroy() {
    //   document.removeEventListener("click", this.hideSearchbar);
    // },
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
<style lang="scss">
.slide {
    &-enter {
        overflow: hidden;
        max-height: 0;
        &-to {
            max-height: 500px;
            overflow: hidden;
        }
        &-active {
            -moz-transition-duration: 0.5s;
            -webkit-transition-duration: 0.5s;
            -o-transition-duration: 0.5s;
            transition-duration: 0.5s;
            -moz-transition-timing-function: ease-in;
            -webkit-transition-timing-function: ease-in;
            -o-transition-timing-function: ease-in;
            transition-timing-function: ease-in;
        }
    }
    &-leave {
        @extend .slide-enter-to;
        &-to {
            @extend .slide-enter;
        }
        &-active {
            -moz-transition-duration: 0.5s;
            -webkit-transition-duration: 0.5s;
            -o-transition-duration: 0.5s;
            transition-duration: 0.5s;
            -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
            -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
            -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
            transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        }
    }
}
</style>
