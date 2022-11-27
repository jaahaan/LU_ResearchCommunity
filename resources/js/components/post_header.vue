<template>
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
                            Conference: 2021 International Conference on Science
                            & Contemporary Technologies (ICSCT)
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
                            <button class="main-btn">Download</button>
                            <button class="main-btn ml-3">Link</button>
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
            <!-- <section class="tab-section">
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
                                    likeActive: details.authUserLike === 'yes',
                                }"
                            >
                                <span v-if="details.like_count > 1"
                                    >{{ details.like_count }} Likes</span
                                >
                                <span v-if="details.like_count <= 1"
                                    >{{ details.like_count }} Like</span
                                >
                            </li>
                        </ul>
                    </div>
                </section> -->
            <section class="tab-section">
                <div class="section-header__action">
                    <ul class="section-header__action--tab">
                        <li>
                            <router-link
                                :to="`/description/${this.$route.params.slug}`"
                            >
                                Overview
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="`/description/${this.$route.params.slug}/comments`"
                            >
                                Comments
                            </router-link>
                        </li>
                        <li
                            v-on:click="like"
                            v-bind:class="{
                                likeActive: details.authUserLike === 'yes',
                            }"
                        >
                            <span v-if="details.like_count > 1"
                                >{{ details.like_count }} Likes</span
                            >
                            <span v-if="details.like_count <= 1"
                                >{{ details.like_count }} Like</span
                            >
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            details: [],
            post_slug: "",
            post_id: "",
            isProductInfoIndex: 1,
            isLoading: true,
            upVoteCount: 0,
            downVoteCount: 0,
            avgVoteCount: 0,
            authUserVoteCount: "",
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
    },
    async created() {
        // this.token = window.Laravel.csrfToken;
        this.post_slug = this.$route.params.slug;
        console.log(this.post_slug);
        const res = await this.callApi(
            "get",
            `/api/post_details/${this.post_slug}`
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
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>
