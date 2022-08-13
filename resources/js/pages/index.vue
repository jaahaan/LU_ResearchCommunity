<template>
    <div>
        <div class="bg">
            <div
                class="container-fluid d-flex flex-column justify-content-center align-items-center py-md-4 py-3"
            >
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
                                        :src="'images/laptop.jpg'"
                                        alt="img"
                                        class="img-fluid scientific"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'images/code.jpg'"
                                        alt="img"
                                        class="img-fluid scientific"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/Dreams.png'"
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
                            Enrich your knowledge with us and learn about the
                            research interest of our teachers.
                        </h1>

                        <router-link
                            class="nav-link btn btn-design px-5 m-3"
                            to="/register"
                            >Join Us</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 bg-card">
            <div class="container-fluid justify-content-center">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h2 class="col-8 _card">
                            Science is a way of thinking much more than it is a
                            body of knowledge.
                        </h2>
                    </div>
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <img
                            :src="'images/pixel.png'"
                            alt="img"
                            class="img-fluid scientific h-70"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 bg-card">
            <div class="container-fluid justify-content-center">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h5 class="text-center rt-title">
                            Find your Research Interests
                        </h5>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">ENGINEERING</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">SCIENCE</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">Machine Learning</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">Data Science</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">AI</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">ANN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="container-fluid text-center justify-content-center col-md-8 pb-5 about"
        >
            <div>
                <h2 class="title">About Us</h2>
                <h6
                    class="m-3 _card col-9 m-auto text-center justify-content-center"
                >
                    Our mission is to help the students gather knowledge about
                    research field and find the research work of our honourable
                    teachers which can guide them to find out their own research
                    interest.
                </h6>
            </div>
        </div>

        <div class="p-5 bg-card">
            <div class="container-fluid justify-content-center">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h2 class="col-8 _card">
                            Connect with our research community to share your
                            thoughts, collaborate with your teachers, colleagues
                            and friends.
                        </h2>
                    </div>

                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <img
                            :src="'images/remote.png'"
                            alt="img"
                            class="img-fluid scientific w-50"
                        />
                    </div>
                </div>
            </div>
        </div>
        <bottomContainer />
    </div>
</template>

<script>
import bottomContainer from "../components/footer";

export default {
    name: "index",
    components: {
        bottomContainer,
    },

    data() {
        return {};
    },

    methods: {},

    created() {},
};
</script>
<style>
._card {
    display: flex;
    margin: -3px auto;
    padding: 60px 50px;
    justify-content: center;
    background: #fed3ad;
    background-image: url("../../../public/images/bg-noisy.jpg");
    box-shadow: 14px 14px 0 0 rgb(39 51 38 / 30%);
    color: #fed3ad;
}

.about {
    background-color: #62b16f;
    width: 100%;
    color: #faf3d3;
}
.about-title {
    font-size: 3rem;
    font-weight: 900;
    line-height: 1rem;
    color: rgba(250, 243, 211, 0.05);
}
.bg-card {
    background: url("../../../public/images/white_bg.jpg");
}
h1 {
    color: #faf3d3;
}
.bg {
    background: linear-gradient(
        90deg,
        #ffffff 0%,
        #ffffff 30%,
        #181818 30%,
        #181818 100%
    );
}
h2,
h5 {
    color: #273326;
}
.btn-design {
    font-size: 1rem;
    border: 1px solid;
    color: #fab162;
    background-color: #273326;
}
.btn-design-change {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-size: 1rem;
    color: #273326;
    background-color: #fab162;
}
.btn-design:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    color: #273326;
    background-color: #deb992;
    font-size: 1rem;
}
.text-c {
    color: #fab162;
}
.text-c:hover {
    color: #ffffff;
}
.title {
    font-size: 5rem;
    font-weight: 600;
    line-height: 1rem;
    color: #44714a;
    padding: 50px;
}
.rt-title {
    font-size: 3rem;
    font-weight: 900;
    line-height: 3rem;
    color: rgba(68, 113, 74, 0.5);
    margin: 20px;
}
.rt {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    text-decoration: none;
    background-color: #273326;
    border: 1px solid;
    color: #fab162;
    font-size: 13px;
}

@media (max-width: 768px) {
    .bg {
        background: linear-gradient(
            180deg,
            #ffffff 0%,
            #ffffff 30%,
            #181818 30%,
            #181818 100%
        );
    }
    .scientific {
        height: 60vh;
        margin-bottom: 20px;
    }
    .rt-title {
        font-size: 2rem;
    }
}
</style>
