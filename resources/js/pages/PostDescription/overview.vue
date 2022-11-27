<template>
    <div class="container mt-3 col-md-9">
        <section class="tab-section">
            <div class="overview-tab">
                <div class="overview-tab--details">
                    <div class="row">
                        <!-- first Card -->
                        <!--Abstract-->
                        <div class="col-lg-8">
                            <div
                                class="card mb-2"
                                v-if="abstract.abstract && isLoading == false"
                            >
                                <div class="card-header">
                                    <div class="d-block">
                                        <div class="float-start">
                                            <h5
                                                v-if="
                                                    abstract.type != 'Project'
                                                "
                                            >
                                                Abstract
                                            </h5>
                                            <h5
                                                v-else-if="
                                                    abstract.type == 'Project'
                                                "
                                            >
                                                Description
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{{ abstract.abstract }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- second Card -->
                        <!-- Related Research -->
                        <div class="col-lg-4">
                            <!--People you may know-->
                            <div class="card mb-2" v-if="isLoading == false">
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
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                            <!-- loader1 -->
                            <div class="card mb-3" v-if="isLoading == true">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            abstract: [],
            post_slug: "",
            post_id: "",
            isLoading: true,
        };
    },
    methods: {},
    async created() {
        // this.token = window.Laravel.csrfToken;
        this.post_slug = this.$route.params.slug;
        isLoading = true;
        console.log(this.post_slug);
        const res = await this.callApi(
            "get",
            `/api/post_abstract/${this.post_slug}`
        );
        if (res.status == 200) {
            this.abstract = res.data.data[0];
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>
