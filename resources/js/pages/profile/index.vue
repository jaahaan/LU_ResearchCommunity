<template>
    <div>
        <profileHeader />
        <hr class="m-1" />
        <!-- about-section -->
        <div
            class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            v-if="profileInfo.about && isLoading == false"
        >
            <div class="d-flex">
                <h1>About</h1>
                <div
                    class="d-flex float-right"
                    v-if="authUser.id == this.$route.params.id"
                >
                    <button class="btn btn-edit mx-2">
                        <i class="fa-solid fa-pen" />
                    </button>
                </div>
                <!-- <div class="d-flex">
                <h1>Edit About</h1>
                <div class="form-outline">
                    <textarea
                        class="form-control"
                        id="textAreaExample1"
                        v-model="editData.about"
                        rows="4"
                        placeholder="Write About You..."
                    ></textarea>
                </div>
            </div> -->
            </div>

            <hr class="m-2" />
            <p>{{ profileInfo.about }}</p>
        </div>

        <hr class="m-1" />

        <!-- Skills-section -->
        <div
            class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            v-if="profileInfo.skills && isLoading == false"
        >
            <div class="d-flex">
                <h1>Skills</h1>
                <div
                    class="d-flex float-right"
                    v-if="authUser.id == this.$route.params.id"
                >
                    <button class="btn btn-edit mx-2">
                        <i class="fa-solid fa-pen" />
                    </button>
                </div>
            </div>
            <hr class="m-2" />
            <p>{{ profileInfo.skills }}</p>
        </div>

        <div v-if="isLoading == true" style="padding: 40px; text-align: center">
            <h1>Content is Loading....</h1>
        </div>
    </div>
</template>

<script>
import profileHeader from "../../components/profileHeader.vue";
export default {
    components: {
        profileHeader,
    },
    data() {
        return {
            isLoading: true,
            profileInfo: "",
        };
    },

    async created() {
        this.token = window.Laravel.csrfToken;

        this.user_id = this.$route.params.id;
        const res = await this.callApi(
            "get",
            `/api/get_profile_info/${this.user_id}`
        );

        if (res.status == 200) {
            this.profileInfo = res.data;
        } else {
            this.swr();
        }
        this.isLoading = false;
    },
};
</script>

<style scoped>
.card-bg {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.7), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    background: #191919;
}
p {
    color: rgb(167, 167, 167);
}
.btn-edit {
    color: rgb(167, 167, 167);
}
.btn-edit:hover {
    color: #ffffff;
}
</style>
