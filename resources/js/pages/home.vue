<template>
    <div>
        <div class="bg">
            <div class="container-fluid justify-content-center py-md-4 py-3">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Slider starts here -->
                        <div
                            id="carouselExampleControls"
                            class="carousel slide"
                            data-bs-ride="carousel"
                        >
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img
                                        :src="'images/Coffee.png'"
                                        alt="img"
                                        class="img-fluid scientific"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'images/learncode.png'"
                                        alt="img"
                                        class="img-fluid scientific"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/stop.png'"
                                        alt="img"
                                        class="img-fluid scientific"
                                    />
                                </div>
                            </div>
                            <button
                                class="carousel-control-prev"
                                type="button"
                                data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev"
                            >
                                <span
                                    class="carousel-control-prev-icon"
                                    aria-hidden="true"
                                ></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button
                                class="carousel-control-next"
                                type="button"
                                data-bs-target="#carouselExampleControls"
                                data-bs-slide="next"
                            >
                                <span
                                    class="carousel-control-next-icon"
                                    aria-hidden="true"
                                ></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div
                        class="col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <h1>
                            Welcome to the Research world of Leading University.
                        </h1>

                        <button class="btn px-5 m-3" @click.prevent="logout">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HOME",
    components: {},

    data() {
        return {};
    },

    methods: {
        async logout() {
            const res = await this.callApi("get", "/logout");

            if (res.status == 200) {
                window.location = "/";
            } else {
                this.swr();
            }
        },
    },

    created() {},
};
</script>
