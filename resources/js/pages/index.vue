<template>
    <div>
        <div class="bg">
            <div
                class="container-fluid d-flex flex-column justify-content-center align-items-center py-md-4 py-3"
            >
                <div class="row">
                    <div class="col-md-6" data-aos="fade-in">
                        <img
                            :src="'images/science.jpg'"
                            alt="img"
                            class="img-fluid scientific"
                        />
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
        <div>
            <div class="container-fluid justify-content-center py-md-4">
                <div class="row mt-3">
                    <div
                        class="col-12 col-md-6 my-md-auto text-center justify-content-center"
                    >
                        <h2>
                            Science is a way of thinking much more than it is a
                            body of knowledge.
                        </h2>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="container-fluid mt-3">
                            <h5 class="text-center">Research Topics</h5>
                            <div class="row justify-content-center">
                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">ENGINEERING</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">COMPUTER SCIENCE</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">METHMATICS</a>
                                </div>

                                <div
                                    class="col-sm-4 col-md-4 m-2 card text-center rt"
                                >
                                    <a class="p-3 text">SOCIAL SCIENCE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-3" />
        <div class="container-fluid text-center col-md-8">
            <div class="about">
                <h2>About Us</h2>
                <h6 class="m-3">
                    Our mission is to help the students gather knowledge about
                    research field and find the research work of our honourable
                    teachers which can guide them to find out their own research
                    interest.
                </h6>

                <h5>
                    Connect with our research community to share your thoughts,
                    collaborate with your teachers, colleagues and friends.
                </h5>
            </div>
        </div>

        <div class="container-fluid justify-content-center py-md-4 py-3 footer">
            <div class="row">
                <div class="col-md-6">
                    <h4>Contact Us</h4>
                    <br />
                    <address>
                        Leading University<br />
                        Ragibnagar, South Surma, Sylhet-3112
                    </address>
                    <p>Phone: 01313084499.</p>
                </div>
                <div class="col-md-6 text-end text-light">
                    <a class="icon" href="www.lus.ac.bd"
                        ><i class="fa-brands fa-google"></i
                    ></a>
                    <a
                        class="icon"
                        href="https://www.facebook.com/leadinguniversity2001/"
                        ><i class="fa-brands fa-facebook"></i
                    ></a>
                    <a
                        class="icon"
                        href="https://www.youtube.com/channel/UC3UkVH9fhmQQCKSzQAMRwWA"
                        ><i class="fa-brands fa-youtube"></i
                    ></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index",
    components: {},

    data() {
        return {};
    },

    methods: {},

    created() {},
};
</script>
<style>
.scientific {
    height: 75vh;
}
.bg {
    background: linear-gradient(
        90deg,
        #ffffff 0%,
        #ffffff 30%,
        #191919 30%,
        #191919 100%
    );
}
h1 {
    color: #fab162;
}
h2,
h5 {
    color: #373a36;
}
.btn-design {
    font-size: 1rem;
    border: 1px solid;
    color: #fab162;
    background-color: #191919;
}
.btn-design-change {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-size: 1rem;
    color: #191919;
    background-color: #fab162;
}
.btn-design:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    color: #191919;
    background-color: #deb992;
    font-size: 1rem;
}
.text-c {
    color: #fab162;
}
.text-c:hover {
    color: #ffffff;
}
.footer {
    background-color: #191919;
    color: #fab162;
    margin-top: 20px;
    padding: 20px;
}
.rt {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    text-decoration: none;
    background-color: #191919;
    border: 1px solid;
    color: #fab162;
}
.icon {
    padding: 10px;
    color: #fab162;
}
.icon:hover {
    color: #ffffff;
}
@media (max-width: 768px) {
    .bg {
        background: linear-gradient(
            180deg,
            #ffffff 0%,
            #ffffff 30%,
            #191919 30%,
            #191919 100%
        );
    }
    .scientific {
        height: 60vh;
        margin-bottom: 20px;
    }
}
</style>
