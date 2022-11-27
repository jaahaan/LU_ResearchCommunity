<template>
    <div>
        <div v-if="isLoading == false">
            <div class="post">
                <div class="container col-md-9 post-head">
                    <div class="row post-head-main-body">
                        <div class="col-1 m-auto vote">
                            <span @click="upVote">
                                <i
                                    :class="[
                                        authUserVoteCount == 'up'
                                            ? 'fa-solid fa-caret-up upActive'
                                            : 'fa-solid fa-caret-up',
                                        'fa-solid fa-caret-up',
                                    ]"
                                ></i>
                            </span>
                            <h6>{{ avgVoteCount }}</h6>
                            <span @click="downVote">
                                <i
                                    :class="[
                                        authUserVoteCount == 'down'
                                            ? 'fa-solid fa-caret-down downActive'
                                            : 'fa-solid fa-caret-down',
                                        'fa-solid fa-caret-down',
                                    ]"
                                ></i>
                            </span>
                        </div>
                        <div class="col-11">
                            <div>
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
                                <div class="row mb-3">
                                    <div class="d-block my-auto">
                                        <img
                                            :src="details.image"
                                            alt="img"
                                            class="img-fluid profile-img float-start me-2"
                                        />
                                        <div class="float-start">
                                            <h6>
                                                <router-link
                                                    :to="`/profile/${details.slug}/${details.user_id}`"
                                                >
                                                    {{ details.name }}
                                                </router-link>
                                            </h6>
                                            <p>
                                                {{ details.designation }}
                                                .
                                                {{ details.department }}
                                            </p>
                                        </div>
                                        <div class="float-end my-auto">
                                            <a>Follow</a>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-2" />

                                <h3>
                                    {{ details.title }}
                                </h3>
                                <p>
                                    {{ details.type }}
                                </p>
                                <p v-if="details.type == 'Conference Paper'">
                                    Conference: 2021 International Conference on
                                    Science & Contemporary Technologies (ICSCT)
                                </p>

                                <p>
                                    {{ details.created_at }} .
                                    <a v-if="details.read_count > 1"
                                        >{{ details.read_count }} Reads</a
                                    ><a v-else-if="details.read_count <= 1"
                                        >{{ details.read_count }} Read</a
                                    >
                                    . <a>{{ upVoteCount }} UpVote</a> .
                                    <a>{{ downVoteCount }} DownVote</a>
                                </p>
                                <div v-if="details.authors != null">
                                    <p
                                        v-if="
                                            details.authors.length > 1 &&
                                            details.type != 'Project'
                                        "
                                    >
                                        Authors:
                                        <span v-for="author in details.authors">
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                >{{ author.name }}</router-link
                                            >
                                        </span>
                                    </p>
                                    <p
                                        v-else-if="
                                            details.authors.length > 1 &&
                                            details.type == 'Project'
                                        "
                                    >
                                        Team Members:
                                        <span v-for="author in details.authors">
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                >{{ author.name }}</router-link
                                            >
                                        </span>
                                    </p>
                                    <p
                                        v-else-if="
                                            details.authors.length == 1 &&
                                            details.type == 'Project'
                                        "
                                    >
                                        Team Member:
                                        <span v-for="author in details.authors">
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                >{{ author.name }}</router-link
                                            >
                                        </span>
                                    </p>
                                    <p
                                        v-else-if="
                                            details.authors.length == 1 &&
                                            details.type != 'Project'
                                        "
                                    >
                                        Author:
                                        <span v-for="author in details.authors">
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
                                        details.authors != null &&
                                        details.type == 'Project'
                                    "
                                >
                                    <p v-if="details.authors.length > 1">
                                        Team Members:
                                        <span
                                            v-for="author in details.authors"
                                            v-if="details.authors.length"
                                        >
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                >{{ author.name }}</router-link
                                            >
                                        </span>
                                    </p>
                                    <p v-else>
                                        Team Member:
                                        <span
                                            v-for="author in details.authors"
                                            v-if="details.authors.length"
                                        >
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                >{{ author.name }}</router-link
                                            >
                                        </span>
                                    </p>
                                </div>
                                <div class="mt-3">
                                    <button
                                        class="main-btn"
                                        v-if="details.attachment"
                                    >
                                        Download
                                    </button>
                                    <a
                                        :href="`${details.url}`"
                                        v-if="details.url"
                                    >
                                        <button class="main-btn ml-3">
                                            Link
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <!-- <div class="card-footer text-muted p-3">
                                <div class="d-block">
                                    <button class="main-btn mx-2 float-start">
                                        Download
                                    </button>

                                    <button
                                            class="main-btn mx-2 float-start"
                                        >
                                            <router-link
                                                :to="`/post_description/${post.title}/${post.id}`"
                                            >
                                                View
                                            </router-link>
                                        </button>
                                    <a
                                        v-if="details.url != null"
                                        class="main-btn text-center mx-2 float-start"
                                        :href="`${details.url}`"
                                    >
                                        Link
                                    </a>
                                    <a class="mx-2 float-end text-dark">
                                        Share
                                    </a>
                                    <a class="mx-2 float-end text-dark">
                                        Comment
                                    </a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <hr />
                    <section class="tab-section">
                        <div class="section-header__action">
                            <ul class="section-header__action--tab">
                                <li
                                    v-bind:class="{
                                        active: isProductInfoIndex === 1,
                                    }"
                                    v-on:click="showProductInfo(1)"
                                >
                                    Overview
                                </li>
                                <li
                                    v-bind:class="{
                                        active: isProductInfoIndex === 2,
                                    }"
                                    v-on:click="showProductInfo(2)"
                                >
                                    Comments
                                </li>
                                <li
                                    v-on:click="like"
                                    v-bind:class="{
                                        active: details.authUserLike === 'yes',
                                    }"
                                >
                                    <span v-if="details.like_count > 1"
                                        >{{ details.like_count }} Likes
                                    </span>
                                    <span v-if="details.like_count <= 1"
                                        >{{ details.like_count }} Like</span
                                    >
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
            <hr />
            <div class="container mt-3 col-md-9">
                <section class="tab-section">
                    <div class="overview-tab" v-if="isProductInfoIndex === 1">
                        <div class="overview-tab--details">
                            <div class="row">
                                <!-- first Card -->
                                <!--Abstract-->
                                <div class="col-lg-8">
                                    <div
                                        class="card mb-2"
                                        v-if="
                                            details.abstract &&
                                            isLoading == false
                                        "
                                    >
                                        <div class="card-header">
                                            <div class="d-block">
                                                <div class="float-start">
                                                    <h5
                                                        v-if="
                                                            details.type !=
                                                            'Project'
                                                        "
                                                    >
                                                        Abstract
                                                    </h5>
                                                    <h5
                                                        v-else-if="
                                                            details.type ==
                                                            'Project'
                                                        "
                                                    >
                                                        Description
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ details.abstract }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- second Card -->
                                <!-- Related Research -->
                                <div class="col-lg-4">
                                    <!--People you may know-->
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <div class="d-block">
                                                <div class="float-start">
                                                    <h5>Related Research</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Hello</p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            View all researchers
                                            <i
                                                class="fa-solid fa-arrow-right"
                                            ></i>
                                        </div>
                                    </div>
                                    <!-- loader1 -->
                                    <div
                                        class="card mb-3"
                                        v-if="isLoading == true"
                                    >
                                        <div class="card-header">
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
                                                <div
                                                    class="float-end my-auto loader"
                                                >
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
                                                <div
                                                    class="float-end my-auto loader"
                                                >
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
                                                <div
                                                    class="float-end my-auto loader"
                                                >
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
                                </div>
                            </div>
                        </div>
                        <!-- <div
                            class="overview-tab--details container"
                            v-html="details.abstract"
                        ></div> -->
                    </div>
                    <div class="overview-tab" v-if="isProductInfoIndex === 2">
                        <div class="overview-tab--details">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card mb-2">
                                        <h5 class="card-header">Comments</h5>
                                        <div class="card-body">
                                            <div class="comment">
                                                <div class="comment-box">
                                                    <img
                                                        :src="authUser.image"
                                                        alt="img"
                                                    />
                                                    <textarea
                                                        v-model="data.comment"
                                                        class="form-control form-outline"
                                                        placeholder="Add a comment"
                                                        ref="textarea"
                                                        rows="1"
                                                        @focus="resizeTextarea"
                                                        @keyup="resizeTextarea"
                                                        @click="showButton"
                                                    ></textarea>
                                                    <Icon
                                                        type="md-send"
                                                        v-if="showbtn == true"
                                                        @click="addComment"
                                                    />
                                                </div>
                                                <div
                                                    class="comment-section"
                                                    v-for="(
                                                        item, index
                                                    ) in comments"
                                                    :key="index"
                                                >
                                                    <img
                                                        :src="item.image"
                                                        alt="img"
                                                    />
                                                    <div
                                                        class="comment-section-content"
                                                    >
                                                        <div
                                                            class="comment-section-content-main"
                                                        >
                                                            <router-link
                                                                :to="`/profile/${item.slug}/${item.user_id}`"
                                                            >
                                                                {{ item.name }}
                                                            </router-link>
                                                            .
                                                            {{
                                                                item.created_at
                                                            }}

                                                            <p>
                                                                {{
                                                                    item.comment
                                                                }}
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="comment-section-content-like"
                                                        >
                                                            <span>
                                                                <a
                                                                    v-on:click="
                                                                        CommentLike(
                                                                            index
                                                                        )
                                                                    "
                                                                    v-bind:class="{
                                                                        active:
                                                                            item.authUserCommentLike ==
                                                                            'yes',
                                                                    }"
                                                                >
                                                                    <span
                                                                        v-if="
                                                                            item.comment_like_count >
                                                                            1
                                                                        "
                                                                        >{{
                                                                            item.comment_like_count
                                                                        }}
                                                                        Likes</span
                                                                    >
                                                                    <span
                                                                        v-if="
                                                                            item.comment_like_count <=
                                                                            1
                                                                        "
                                                                        >{{
                                                                            item.comment_like_count
                                                                        }}
                                                                        Like</span
                                                                    >
                                                                </a>
                                                            </span>
                                                            <a>Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div
                            class="overview-tab--details container"
                            v-html="details.abstract"
                        ></div> -->
                    </div>
                </section>
            </div>
        </div>
        <div v-if="isLoading == true">
            <h2 class="text-center pt-50">Loading...</h2>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            details: [],
            comments: [],
            post_slug: "",
            post_id: "",
            isProductInfoIndex: 1,
            isLoading: true,
            upVoteCount: 0,
            downVoteCount: 0,
            avgVoteCount: 0,
            authUserVoteCount: "",
            showbtn: false,
            data: {
                comment: "",
            },
            comment_like_count: 0,
            authUserCommentLike: "",
        };
    },
    methods: {
        showProductInfo(index) {
            this.isProductInfoIndex = index;
        },

        async upVote() {
            if (this.details.user_id != this.authUser.id) {
                if (this.authUserVoteCount == "down") {
                    this.upVoteCount += 1;
                    this.avgVoteCount += 1;
                    this.downVoteCount -= 1;
                    this.authUserVoteCount = "up";
                } else if (this.authUserVoteCount == "up") {
                    this.upVoteCount -= 1;
                    this.avgVoteCount -= 1;
                    this.authUserVoteCount = "none";
                } else if (this.authUserVoteCount == "none") {
                    this.upVoteCount += 1;
                    this.avgVoteCount += 1;
                    this.authUserVoteCount = "up";
                }
                let obj = {
                    id: this.details.id,
                    upVote: 1,
                };
                console.log(obj);
                const res = await this.callApi("post", "/api/up_vote", obj);
            }
        },
        async downVote() {
            if (this.details.user_id != this.authUser.id) {
                if (this.authUserVoteCount == "up") {
                    this.upVoteCount -= 1;
                    this.avgVoteCount -= 1;
                    this.downVoteCount += 1;
                    this.authUserVoteCount = "down";
                } else if (this.authUserVoteCount == "down") {
                    this.downVoteCount -= 1;
                    this.avgVoteCount += 1;
                    this.authUserVoteCount = "";
                } else if (this.authUserVoteCount == "none") {
                    this.avgVoteCount -= 1;
                    this.downVoteCount += 1;
                    this.authUserVoteCount = "down";
                }
                let obj = {
                    id: this.details.id,
                    downVote: 1,
                };
                console.log(obj);
                const res = await this.callApi("post", "/api/down_vote", obj);
            }
        },

        async like() {
            // if (this.posts[index].user_id != this.authUser.id) {
            let obj = {
                id: this.details.id,
            };

            const res = await this.callApi("post", "/api/like", obj);
            if (res.status == 201) {
                this.details.like_count += 1;
                this.details.authUserLike = "yes";
            } else {
                this.details.like_count -= 1;
                this.details.authUserLike = "no";
            }
            // }
        },

        async CommentLike(index) {
            // if (this.posts[index].user_id != this.authUser.id) {
            let obj = {
                id: this.comments[index].id,
            };

            const res = await this.callApi("post", "/api/comment_like", obj);
            if (res.status == 201) {
                this.comments[index].comment_like_count += 1;
                this.comments[index].authUserCommentLike = "yes";
            } else {
                this.comments[index].comment_like_count -= 1;
                this.comments[index].authUserCommentLike = "no";
            }
            // }
        },

        async addComment() {
            if (this.data.comment.trim() == "")
                return this.e("Comment field is empty!!!");
            let obj = {
                id: this.details.id,
                comment: this.data.comment,
            };

            var today = new Date();
            var date =
                today.getFullYear() +
                "-" +
                (today.getMonth() + 1) +
                "-" +
                today.getDate();
            var time =
                today.getHours() +
                ":" +
                today.getMinutes() +
                ":" +
                today.getSeconds();
            let data = {
                id: this.details.id,
                comment: this.data.comment,
                image: this.authUser.image,
                name: this.authUser.name,
                created_at: date + " " + time,
                comment_like_count: 0,
            };

            const res = await this.callApi("post", "/api/add_comment", obj);
            if (res.status == 201) {
                this.comments.unshift(data);

                this.data.comment = "";
                this.s(this.data.msg);
            } else {
                this.swr();
            }
        },

        resizeTextarea(e) {
            let area = e.target;
            area.style.height = "auto";
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + "px";
            // this.showbtn = true;
        },
        showButton() {
            this.showbtn = true;
        },
        hideButton() {
            this.showbtn = false;
        },
    },
    async created() {
        // this.token = window.Laravel.csrfToken;
        this.post_slug = this.$route.params.slug;
        console.log(this.post_slug);
        const res = await this.callApi(
            "get",
            `/api/post_details/${this.post_slug}`
        );
        const res1 = await this.callApi(
            "get",
            `/api/get_comments/${this.post_slug}`
        );
        if (res.status == 200) {
            this.details = res.data.data[0];
            this.upVoteCount = this.details.upVote;
            this.downVoteCount = this.details.downVote;
            this.avgVoteCount = this.details.avgVote;
            this.authUserVoteCount = this.details.authUserVote;
            this.post_id = this.details.id;
            const res1 = await this.callApi(
                "post",
                `/api/read/${this.details.id}`
            );
        }
        if (res1.status == 200) {
            this.comments = res1.data.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
    // mounted() {
    //     document.addEventListener("click", this.hideButton);
    // },
    // beforeDestroy() {
    //     document.removeEventListener("click", this.hideButton);
    // },
};
</script>

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
