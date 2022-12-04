<template>
    <div>
        <div v-if="isLoading == false">
            <section class="container pt-4 pb-4">
                <div class="post-section">
                    <div class="post-menu">
                        <figure>
                            <img :src="details.image" alt="" />
                        </figure>
                        <router-link
                            :to="`/profile/${details.slug}/${details.user_id}`"
                        >
                            <h4 class="header">
                                {{ details.name }}
                            </h4>
                        </router-link>

                        <p>
                            {{ details.designation }}
                            .
                            {{ details.department }}
                        </p>
                        <ul class="post-menu--list">
                            <li class="post-menu--list---item">
                                <a
                                    class="menu-link"
                                    aria-current="page"
                                    v-bind:class="{
                                        active: isPostInfoIndex === 1,
                                    }"
                                    v-on:click="showPostInfo(1)"
                                >
                                    <h4>Overview</h4></a
                                >
                            </li>
                            <li class="post-menu--list---item" v-if="authUser">
                                <a
                                    class="menu-link"
                                    aria-current="page"
                                    v-bind:class="{
                                        active: isPostInfoIndex === 2,
                                    }"
                                    v-on:click="showPostInfo(2)"
                                >
                                    <h4>Comments</h4></a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- post description -->
                    <div class="post-description menu-item">
                        <div class="menu-item-box">
                            <div class="post-details">
                                <h4 class="menu-item--title">
                                    {{ details.title }}
                                </h4>
                                <h5 class="sub-title">
                                    {{ details.type }}
                                </h5>
                                <h5
                                    class="sub-title"
                                    v-if="details.type == 'Conference Paper'"
                                >
                                    Conference: 2021 International Conference on
                                    Science & Contemporary Technologies (ICSCT)
                                </h5>

                                <div
                                    v-if="details.authors != null"
                                    v-for="author in details.authors"
                                >
                                    <h5
                                        class="sub-title"
                                        v-if="
                                            details.authors.length > 1 &&
                                            details.type != 'Project'
                                        "
                                    >
                                        Authors:
                                        <span>
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                v-if="authUser"
                                                >{{ author.name }}</router-link
                                            >
                                            <a v-else>{{ author.name }}</a>
                                        </span>
                                    </h5>
                                    <h5
                                        class="sub-title"
                                        v-else-if="
                                            details.authors.length > 1 &&
                                            details.type == 'Project'
                                        "
                                    >
                                        Team Members:
                                        <span>
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                v-if="authUser"
                                                >{{ author.name }}</router-link
                                            >
                                            <a v-else>{{ author.name }}</a>
                                        </span>
                                    </h5>
                                    <h5
                                        class="sub-title"
                                        v-else-if="
                                            details.authors.length == 1 &&
                                            details.type == 'Project'
                                        "
                                    >
                                        Team Member:
                                        <span>
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                v-if="authUser"
                                                >{{ author.name }}</router-link
                                            >
                                            <a v-else>{{ author.name }}</a>
                                        </span>
                                    </h5>
                                    <h5
                                        class="sub-title"
                                        v-else-if="
                                            details.authors.length == 1 &&
                                            details.type != 'Project'
                                        "
                                    >
                                        Author:
                                        <span>
                                            <router-link
                                                :to="`/profile/${author.slug}/${author.id}`"
                                                class="authors"
                                                v-if="authUser"
                                                >{{ author.name }}</router-link
                                            >
                                            <a v-else>{{ author.name }}</a>
                                        </span>
                                    </h5>
                                </div>

                                <h6>
                                    <!-- {{ details.created_at }} . -->
                                    <a v-if="details.read_count > 1"
                                        >{{ details.read_count }} Reads</a
                                    ><a v-else-if="details.read_count <= 1"
                                        >{{ details.read_count }} Read</a
                                    >
                                    . <a>{{ upVoteCount }} UpVote</a> .
                                    <a>{{ downVoteCount }} DownVote</a>
                                </h6>
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
                            <div class="vote" v-if="authUser">
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
                        </div>

                        <div class="menu-item-box">
                            <div v-if="isPostInfoIndex === 1">
                                <!-- <template v-if="details.abstract">
                                        <div class="card mb-2 p-3">
                                            <i class="lni lni-folder"></i>
                                            Add Your Project
                                        </div>
                                    </template> -->
                                <h4 class="menu-item--title">
                                    {{
                                        details.type != "Project"
                                            ? "Abstract"
                                            : "Description"
                                    }}
                                </h4>

                                <h4 class="sub-title" v-if="details.abstract">
                                    {{ details.abstract }}
                                </h4>
                                <h4 class="sub-title" v-else>
                                    {{
                                        details.type != "Project"
                                            ? "The abstract for this research item is not available."
                                            : "The description for this project is not available."
                                    }}
                                </h4>
                            </div>

                            <div v-if="isPostInfoIndex === 2" class="comment">
                                <h4 class="menu-item--title">Comments</h4>
                                <div class="comment-box">
                                    <img :src="authUser.image" alt="img" />
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
                                    v-for="(item, index) in comments"
                                    :key="index"
                                >
                                    <img :src="item.image" alt="img" />
                                    <div class="comment-section-content">
                                        <div
                                            class="comment-section-content-main"
                                        >
                                            <router-link
                                                :to="`/profile/${item.slug}/${item.user_id}`"
                                            >
                                                {{ item.name }}
                                            </router-link>
                                            <!-- . {{ item.created_at }} -->

                                            <p>
                                                {{ item.comment }}
                                            </p>
                                        </div>
                                        <div
                                            class="comment-section-content-like"
                                        >
                                            <div>
                                                <span>
                                                    <a
                                                        v-on:click="
                                                            CommentLike(index)
                                                        "
                                                        v-bind:class="{
                                                            active:
                                                                item.authUserCommentLike ==
                                                                'yes',
                                                        }"
                                                    >
                                                        Like
                                                    </a>
                                                </span>
                                                <a v-on:click="showReplyBox"
                                                    >Reply</a
                                                >
                                            </div>
                                            <div
                                                v-if="item.comment_like_count"
                                                @click="
                                                    getCommentLikedUser(index)
                                                "
                                            >
                                                {{ item.comment_like_count }}
                                                <i
                                                    class="fa-solid fa-thumbs-up"
                                                ></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="reply"
                                    v-if="showcommentreplies == false"
                                >
                                    <span class="reply-item"
                                        ><i
                                            data-visualcompletion="css-img"
                                            class="x1b0d499 x1d69dk1"
                                            style="
                                                background-image: url('https://static.xx.fbcdn.net/rsrc.php/v3/y6/r/LuI9mMlkMfm.png?_nc_eui2=AeHodVwwG5T1njR17oQGXXcMMyVdDR0OFnwzJV0NHQ4WfDrFp5XeVake6Gk9eA4jRqS77wkkIlDeyGr5Id_cI0_d');
                                                background-position: 0px -672px;
                                                background-size: auto;
                                                width: 16px;
                                                height: 16px;
                                                background-repeat: no-repeat;
                                                display: inline-block;
                                            "
                                        ></i></span
                                    ><span class="reply-item"
                                        ><a
                                            class="reply-item-count"
                                            v-on:click="showCommentReplies"
                                            >4 Replies</a
                                        ></span
                                    >
                                </div>
                                <div class="comment-reply">
                                    <div
                                        class="comment-reply-box"
                                        v-if="showreplybox == true"
                                    >
                                        <img :src="authUser.image" alt="img" />
                                        <textarea
                                            v-model="data.commentReply"
                                            class="form-outline"
                                            placeholder="Add a comment"
                                            ref="textarea"
                                            rows="1"
                                            @focus="resizeTextarea"
                                            @keyup="resizeTextarea"
                                        ></textarea>
                                        <Icon
                                            type="md-send"
                                            @click="addCommentReply(index)"
                                        />
                                    </div>
                                    <div
                                        class="comment-reply-section"
                                        v-if="showcommentreplies == true"
                                        v-for="(item, index) in comments"
                                        :key="index"
                                    >
                                        <img :src="item.image" alt="img" />
                                        <div
                                            class="comment-reply-section-content"
                                        >
                                            <div
                                                class="comment-reply-section-content-main"
                                            >
                                                <router-link
                                                    :to="`/profile/${item.slug}/${item.user_id}`"
                                                >
                                                    {{ item.name }}
                                                </router-link>
                                                <!-- . {{ item.created_at }} -->

                                                <p>
                                                    {{ item.comment }}
                                                </p>
                                            </div>
                                            <div
                                                class="comment-reply-section-content-like"
                                            >
                                                <div>
                                                    <a
                                                        v-on:click="
                                                            CommentLike(index)
                                                        "
                                                        v-bind:class="{
                                                            active:
                                                                item.authUserCommentLike ==
                                                                'yes',
                                                        }"
                                                    >
                                                        Like
                                                    </a>
                                                </div>
                                                <div
                                                    v-if="
                                                        item.comment_like_count
                                                    "
                                                    @click="
                                                        getCommentLikedUser(
                                                            index
                                                        )
                                                    "
                                                >
                                                    {{
                                                        item.comment_like_count
                                                    }}
                                                    <i
                                                        class="fa-solid fa-thumbs-up"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--***************Related Research Section****************-->

                <section class="related-research__section">
                    <div class="container">
                        <div class="section-header">
                            <h2>Related Research</h2>
                        </div>

                        <hooper
                            :settings="hooperTrendingOffer"
                            :wheelControl="false"
                        >
                            <slide>
                                <div class="related_research--section">
                                    <h5>
                                        A Bangla Text-to-Speech System using
                                        Deep Neural Networks
                                    </h5>
                                    <h6>Conference Paper</h6>
                                    <h6>Author: Prithwiraj Bhattacharjee</h6>
                                </div>
                            </slide>
                            <slide>
                                <div class="related_research--section">
                                    <h5>
                                        A Bangla Text-to-Speech System using
                                        Deep Neural Networks
                                    </h5>
                                    <h6>Conference Paper</h6>
                                    <h6>Author: Prithwiraj Bhattacharjee</h6>
                                </div> </slide
                            ><slide>
                                <div class="related_research--section">
                                    <h5>
                                        A Bangla Text-to-Speech System using
                                        Deep Neural Networks
                                    </h5>
                                    <h6>Conference Paper</h6>
                                    <h6>Author: Prithwiraj Bhattacharjee</h6>
                                </div>
                            </slide>
                            <hooper-navigation
                                slot="hooper-addons"
                                class="hooper-relatedResearch_button"
                            ></hooper-navigation>
                        </hooper>
                    </div>
                </section>
            </section>
        </div>

        <!--***** Comment Liked User Modal *****-->
        <Modal
            v-model="commentLikedUserModal"
            title="People Who Liked"
            :mask-closable="true"
            :closable="true"
        >
            <div class="comment-liked" v-for="user in commentLikedUser">
                <img :src="user.image" alt="img" />
                <router-link :to="`/profile/${user.slug}/${user.user_id}`">
                    {{ user.name }}
                </router-link>
            </div>
            <div slot="footer"></div>
        </Modal>

        <div v-if="isLoading == true">
            <h2 class="text-center pt-50">Loading...</h2>
        </div>
    </div>
</template>

<script>
import {
    Hooper,
    Slide,
    Progress as HooperProgress,
    Pagination as HooperPagination,
    Navigation as HooperNavigation,
} from "hooper";
import "hooper/dist/hooper.css";
export default {
    components: {
        Hooper,
        Slide,
        HooperProgress,
        HooperPagination,
        HooperNavigation,
    },
    data() {
        return {
            details: [],
            comments: [],
            commentReplies: [],
            commentLikedUser: [],
            post_slug: "",
            post_id: "",
            isPostInfoIndex: 1,
            isLoading: true,
            upVoteCount: 0,
            downVoteCount: 0,
            avgVoteCount: 0,
            authUserVoteCount: "",
            showbtn: false,
            showreplybox: false,
            showcommentreplies: false,
            data: {
                comment: "",
                commentReply: "",
            },
            comment_like_count: 0,
            authUserCommentLike: "",
            commentLikedUserModal: false,
            hooperTrendingOffer: {
                itemsToShow: 1,
                centerMode: false,
                breakpoints: {
                    768: {
                        centerMode: false,
                        itemsToShow: 2,
                    },
                },
            },
        };
    },
    methods: {
        showPostInfo(index) {
            this.isPostInfoIndex = index;
        },

        async upVote() {
            if (
                this.authUser.userType == "teacher" ||
                this.authUser.userType == "admin"
            ) {
                if (this.details.user_id != this.authUser.id) {
                    let upVoteCount1 = parseInt(this.upVoteCount, 10);
                    let avgVoteCount1 = parseInt(this.avgVoteCount, 10);
                    let downVoteCount1 = parseInt(this.downVoteCount, 10);
                    let obj = {
                        id: this.details.id,
                        upVote: 1,
                    };
                    console.log(obj);
                    const res = await this.callApi("post", "/api/up_vote", obj);
                    if (res.status == 200) {
                        this.upVoteCount = upVoteCount1 - 1;
                        this.avgVoteCount = upVoteCount1 - 1 - downVoteCount1;
                        this.authUserVoteCount = "";
                    }
                    if (res.status == 201) {
                        this.upVoteCount = upVoteCount1 + 1;
                        this.avgVoteCount =
                            upVoteCount1 + 1 - (downVoteCount1 - 1);
                        this.downVoteCount = downVoteCount1 - 1;
                        this.authUserVoteCount = "up";
                    }
                    if (res.status == 202) {
                        this.upVoteCount = upVoteCount1 + 1;
                        this.avgVoteCount = upVoteCount1 + 1 - downVoteCount1;
                        this.authUserVoteCount = "up";
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
        async downVote() {
            if (
                this.authUser.userType == "teacher" ||
                this.authUser.userType == "admin"
            ) {
                if (this.details.user_id != this.authUser.id) {
                    let upVoteCount1 = parseInt(this.upVoteCount, 10);
                    let avgVoteCount1 = parseInt(this.avgVoteCount, 10);
                    let downVoteCount1 = parseInt(this.downVoteCount, 10);

                    let obj = {
                        id: this.details.id,
                        // user_id: authUser.id,
                        downVote: 1,
                    };
                    console.log(obj);
                    const res = await this.callApi(
                        "post",
                        "/api/down_vote",
                        obj
                    );
                    if (res.status == 200) {
                        this.avgVoteCount = upVoteCount1 - (downVoteCount1 - 1);
                        this.downVoteCount = downVoteCount1 - 1;
                        this.authUserVoteCount = "";
                    }
                    if (res.status == 201) {
                        this.upVoteCount = upVoteCount1 - 1;
                        this.downVoteCount = downVoteCount1 + 1;
                        this.avgVoteCount =
                            upVoteCount1 - 1 - (downVoteCount1 + 1);
                        this.authUserVoteCount = "down";
                    }

                    if (res.status == 202) {
                        this.avgVoteCount = upVoteCount1 - (downVoteCount1 + 1);
                        this.downVoteCount = downVoteCount1 + 1;
                        this.authUserVoteCount = "down";
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

        async addComment() {
            if (this.data.comment.trim() == "")
                return this.e("Comment field is empty!!!");
            let obj = {
                id: this.details.id,
                comment: this.data.comment,
            };

            // var today = new Date();
            // var date =
            //     today.getFullYear() +
            //     "-" +
            //     (today.getMonth() + 1) +
            //     "-" +
            //     today.getDate();
            // var time =
            //     today.getHours() +
            //     ":" +
            //     today.getMinutes() +
            //     ":" +
            //     today.getSeconds();
            let data = {
                id: this.details.id,
                user_id: this.authUser.id,
                comment: this.data.comment,
                image: this.authUser.image,
                name: this.authUser.name,
                // created_at: date + " " + time,
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

        async addCommentReply(index) {
            if (this.data.commentReply.trim() == "")
                return this.e("Field is empty!!!");
            let obj = {
                post_id: this.details.id,
                comment_id: this.comments[index].id,
                commentReply: this.data.commentReply,
            };
            let data = {
                id: this.details.id,
                user_id: this.authUser.id,
                commentReply: this.data.commentReply,
                image: this.authUser.image,
                name: this.authUser.name,
                // comment_like_count: 0,
            };

            const res = await this.callApi(
                "post",
                "/api/add_comment_reply",
                obj
            );
            if (res.status == 201) {
                this.commentReplies.unshift(data);

                this.data.commentReply = "";
                this.s(this.data.msg);
            } else {
                this.swr();
            }
        },

        async CommentLike(index) {
            if (this.comments[index].user_id != this.authUser.id) {
                let obj = {
                    id: this.comments[index].id,
                };

                const res = await this.callApi(
                    "post",
                    "/api/comment_like",
                    obj
                );
                if (res.status == 201) {
                    this.comments[index].comment_like_count += 1;
                    this.comments[index].authUserCommentLike = "yes";
                } else {
                    this.comments[index].comment_like_count -= 1;
                    this.comments[index].authUserCommentLike = "no";
                }
            } else {
                this.i("You can't like your own comment");
            }
        },
        async getCommentLikedUser(index) {
            let obj = {
                id: this.comments[index].id,
            };
            console.log(this.comments[index].id);
            const res = await this.callApi(
                "get",
                `/api/get_comment_liked_user?id=${this.comments[index].id}`
            );
            if (res.status == 200) {
                this.commentLikedUser = res.data.data;
                this.commentLikedUserModal = true;
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
        showReplyBox() {
            this.showreplybox = true;
        },
        showCommentReplies() {
            this.showcommentreplies = true;
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
        if (authUser) {
            const res1 = await this.callApi(
                "get",
                `/api/get_comments/${this.post_slug}`
            );
            if (res1.status == 200) {
                this.comments = res1.data.data;
            }
        }
        if (res.status == 200) {
            this.details = res.data.data[0];
            this.upVoteCount = this.details.upVote;
            this.downVoteCount = this.details.downVote;
            this.avgVoteCount = this.details.avgVote;
            this.authUserVoteCount = this.details.authUserVote;
            this.post_id = this.details.id;
            if (this.authUser) {
                const res1 = await this.callApi(
                    "post",
                    `/api/read/${this.details.id}`
                );
            }
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
