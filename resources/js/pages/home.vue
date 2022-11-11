<template>
    <section class="post__section">
        <div class="container mt-3 col-md-10">
            <div class="row">
                <!-- first Card -->
                <!--Suggested research-->
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-1 m-auto vote">
                            <i class="fa-solid fa-caret-up"></i>
                            <h6 class="text-cenyter">239</h6>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <div class="col-11">
                            <div class="card mb-3">
                                <div class="card-header p-3">
                                    <div class="d-block">
                                        <div class="float-start">
                                            <h6>
                                                Suggested research based on your
                                                interests
                                            </h6>
                                        </div>
                                        <div
                                            class="btn-edit mx-2 float-end"
                                            @click="reset()"
                                        >
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-block">
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
                                    </div>
                                    <a
                                        ><b
                                            >FitViz: A Personal Informatics Tool
                                            for Self-management of Rheumatoid
                                            Arthritis</b
                                        ></a
                                    >
                                    <div class="mt-2 mb-2">
                                        <a
                                            class="btn alert-dark d-inline-block"
                                        >
                                            Conference Paper</a
                                        >
                                    </div>
                                    <p>
                                        May 2017 . <a>356 Reads</a> .
                                        <a>239 upVote</a> .
                                        <a>24 downVote</a>
                                    </p>
                                    <p>Author Name</p>
                                </div>

                                <div class="card-footer text-muted p-3">
                                    <div class="d-block">
                                        <button
                                            class="btn main-btn mx-2 float-start"
                                        >
                                            Download
                                        </button>

                                        <a class="mx-2 float-start text-dark">
                                            Save
                                        </a>
                                        <a class="mx-2 float-end text-dark">
                                            Share
                                        </a>
                                        <a class="mx-2 float-end text-dark">
                                            Comment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- second Card -->
                <div class="col-lg-4">
                    <!--People you may know-->
                    <div
                        class="people-you-may-know-card mb-3"
                        v-if="users != '' && isLoading == false"
                    >
                        <div class="card-header">
                            <div class="d-block pb-4">
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
                            v-if="authUser.id != user.id"
                            :key="index"
                            class="mb-5"
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
                                            <!-- The most basic form of data binding is text interpolation using the "Mustache" syntax -->
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
                        class="people-you-may-know-card mb-3"
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
                            v-if="authUser.id != user.id"
                            :key="index"
                            class="mb-5"
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
    components: {},
    // Properties returned from data() become reactive state
    // and will be exposed on `this`.
    data() {
        return {
            isLoading: true,
            users: "",
        };
    },
    methods: {
        getUser(user) {
            this.user_id = user.id;
            this.user_slug = user.slug;

            this.$router.push(`/profile/${this.user_slug}/${this.user_id}`);
            this.keyword = "";
        },
    },

    //Called after the instance has finished processing all state-related options.
    async created() {
        this.token = window.Laravel.csrfToken;

        // this.user_id = this.$route.params.id;
        const res = await this.callApi("get", `/api/get_all_user`);
        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>
<style scoped>
.home-img {
    width: 9.5rem;
    height: 5.5rem;
    margin-bottom: 0.5rem;
    margin-left: 0.5rem;
}
h6:hover {
    cursor: pointer;
    color: #000;
}

.main-btn {
    color: #3a4660;
    /*TB LR */
    padding: 3px 5px;
}

.profile-img {
    border-radius: 50%;
    width: 40px;
    height: 40px;
}
.vote i {
    font-size: 3rem;
    color: #3a4660;
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
    background-color: #c0c0c0;
}
.loader p {
    width: 50px;
    height: 15px;
    background-color: #a7a7a7;
}

.people-you-may-know-card {
    border: 1px solid #dadada;
    border-radius: 4px;
}
.card-header {
    padding: 1rem;
}
.card-footer {
    padding: 1rem;
}
</style>
