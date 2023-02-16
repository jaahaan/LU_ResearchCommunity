<template>
    <div>
        <!-- 1st row -->

        <!-- <div class="bg">
            <div
                class="container-fluid d-flex flex-column justify-content-center align-items-center py-md-4 py-3"
            >
                <hooper :settings="hooperSettings">
                    <slide>
                        <div class="images img1 img-fluid">
                            <h2>Slider 1</h2>
                        </div>
                    </slide>
                    <slide>
                        <div class="images img2 img-fluid">
                            <h2>Slider 2</h2>
                        </div>
                    </slide>
                    <slide>
                        <div class="images img3 img-fluid">
                            <h2>Slider 3</h2>
                        </div>
                    </slide>
                    <slide>
                        <div class="images img4 img-fluid">
                            <h2>Slider 4</h2>
                        </div>
                    </slide>
                    <slide>
                        <div class="images img5 img-fluid">
                            <h2>Slider 5</h2>
                        </div>
                    </slide>
                </hooper>
            </div>
        </div> -->

        <!--*************** Top Banner ***************-->
        <div class="bg">
            <div
                class="container-fluid d-flex flex-column justify-content-center align-items-center py-md-4 py-3"
            >
                <div class="row">
                    <!--*************** Slider ***************-->
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
                                        :src="'/images/view8.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/view1.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/view2.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/view3.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/view4.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        :src="'/images/view5.jpeg'"
                                        alt="img"
                                        class="img-fluid slider"
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
                            research interests of our teachers.
                        </h1>

                        <div class="mt-3">
                            <router-link
                                class="main-btn px-5"
                                style="background: #474554"
                                to="/register"
                                >Join Us</router-link
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--*************** Random ***************-->
        <div class="p-5 bg-card">
            <div class="container-fluid justify-content-center">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h1 class="col-8 _card">
                            Science is a way of thinking much more than it is a
                            body of knowledge.
                        </h1>
                    </div>
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <img
                            :src="'images/pixel.png'"
                            alt="img"
                            class="img-fluid slider h-70"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!--*************** Research Interests Section ***************-->
        <div class="pt-5 pb-5 bg-card">
            <div class="justify-content-around">
                <h5 class="text-center rt-title">
                    Find Your Research Interests
                </h5>
                <hooper :settings="hooperSettings">
                    <slide>
                        <div class="text-center rt m-2">
                            <h1 class="p-3">ENGINEERING</h1>
                        </div>
                    </slide>
                    <slide>
                        <div class="text-center rt m-2">
                            <h1 class="p-3">SCIENCE</h1>
                        </div>
                    </slide>
                    <slide>
                        <div class="text-center rt m-2">
                            <h1 class="p-3">MACHINE LEARNING</h1>
                        </div>
                    </slide>
                    <slide>
                        <div class="text-center rt m-2">
                            <h1 class="p-3">DATA SCIENCE</h1>
                        </div>
                    </slide>
                    <slide>
                        <div class="text-center rt m-2">
                            <h1 class="p-3">AI</h1>
                        </div>
                    </slide>
                </hooper>
            </div>
        </div>

        <!-- <div class="p-5 bg-card">
            <div class="container-fluid justify-content-around">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h5 class="text-center rt-title">
                            Find Your Research Interests
                        </h5>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">ENGINEERING</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">SCIENCE</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">Machine Learning</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">Data Science</a>
                                </div>
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">AI</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3">ANN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!--*************** About ***************-->
        <div>
            <h6
                class="m-3 _card col-9 mx-auto text-center justify-content-center"
            >
                Our mission is to help the students gather knowledge about
                research field and find the research works of our honourable
                teachers that can guide them to find out their own research
                interest.
            </h6>
        </div>

        <!--*************** Random ***************-->
        <div class="p-5 bg-card">
            <div class="container-fluid justify-content-center">
                <div class="row">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center pb-3"
                    >
                        <h1 class="col-8 _card">
                            Connect with our research community to share your
                            thoughts, collaborate with your teachers, colleagues
                            and friends.
                        </h1>
                    </div>

                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <img
                            :src="'images/remote.png'"
                            alt="img"
                            class="img-fluid slider w-50"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!--*************** Footer Section ***************-->
    </div>
</template>

<script>
import bottomContainer from "../components/footer";
import {
    Hooper,
    Slide,
    Progress as HooperProgress,
    Pagination as HooperPagination,
    Navigation as HooperNavigation,
} from "hooper";
import "hooper/dist/hooper.css";
export default {
    name: "index",
    components: {
        Hooper,
        Slide,
        bottomContainer,
    },

    data() {
        return {
            hooperSettings: {
                infiniteScroll: true,
                centerMode: true,
                autoPlay: true,
                playSpeed: 2000,
                breakpoints: {
                    1200: {
                        itemsToShow: 3.5,
                    },

                    995: {
                        itemsToShow: 2,
                    },
                    0: {
                        itemsToShow: 1,
                    },
                },
            },
        };
    },

    methods: {},

    created() {},
};
</script>
<style scoped>
._card {
    display: flex;
    margin: auto;
    padding: 60px 50px;
    justify-content: center;
    background: #474554;
    /* offset-x | offset-y | blur-radius | spread-radius | color */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7);
    border-radius: 5px;
    color: #fbf7ff;
}

.about {
    background-color: #fbf7ff;
    border-radius: 5px;
    width: 100%;
    color: #fbf7ff;
    border: 1px solid #98978b;
}
.about-title {
    font-size: 5rem;
    font-weight: 600;
    line-height: 1rem;
    padding: 50px;
    color: #474554;
}

.bg-card {
    background: url("../../../public/images/white_bg.jpg");
}

.images {
    height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
}
.img1 {
    background: url("/images/Coffee.png");
}
.img2 {
    background: url("/images/Coffee.png");
}
.img3 {
    background: url("/images/Coffee.png");
}
.img4 {
    background: url("/images/Coffee.png");
}
.img5 {
    background: url("/images/Coffee.png");
}

.hooper {
    height: 100%;
}
.slider {
    width: 500px;
    height: 300px;
}
@media (max-width: 768px) {
    .slider {
        margin-bottom: 20px;
    }
}
</style>
