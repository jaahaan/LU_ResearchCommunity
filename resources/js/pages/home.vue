<template>
    <div>
        <div class="bg">
            <div class="container-fluid justify-content-center py-md-4 py-3">
                <div class="row">
                    <div class="col-md-6">
                        <img
                            :src="'images/stop.png'"
                            alt="img"
                            class="img-fluid scientific"
                        />
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
            const res = await this.callApi("get", "logout");

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
<style scoped>
.scientific {
    height: 75vh;
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
h1 {
    color: #fab162;
}
h2,
h5 {
    color: #191919;
}
.btn {
    font-size: 1rem;
    border: 1px solid;
    color: #fab162;
}
.btn:hover {
    font-size: 1rem;
    border: 1px solid;
    color: #ffffff;
}
.text {
    color: #fab162;
}
.text:hover {
    color: #ffffff;
}
.footer {
    background-color: #191919;
    color: #fab162;
    margin-top: 20px;
    padding: 20px;
}
.rt {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
