<template>
    <div>
        <div class="space" />
        <!-- about-section -->
        <template v-if="about_id">
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            >
                <h5>Edit About</h5>
                <div class="space" />
                <textarea
                    class="form-control"
                    v-model="editData.about"
                    rows="4"
                    placeholder="Write About You..."
                ></textarea>
                <div class="d-flex">
                    <button
                        @click="updateAbout()"
                        class="btn btn-sm text-success"
                    >
                        <i class="fa-solid fa-square-check"></i>
                    </button>
                    <button class="btn btn-sm text-danger" @click="reset()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </template>
        <template v-else>
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
                v-if="profileInfo.about && isLoading == false"
            >
                <div class="d-flex">
                    <h5>About</h5>
                    <div
                        class="d-flex float-right"
                        v-if="authUser.id == this.$route.params.id"
                    >
                        <button
                            class="btn btn-edit mx-2"
                            @click="editAbout(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </button>
                    </div>
                </div>

                <hr class="mt-2 mb-2" />

                <p>{{ profileInfo.about }}</p>
            </div>
        </template>
        <div class="space" />

        <!-- education-section -->
        <!-- <template v-if="about_id">
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            >
                <h5>Edit About</h5>
                <div class="space" />
                <textarea
                    class="form-control"
                    v-model="editData.about"
                    rows="4"
                    placeholder="Write About You..."
                ></textarea>
                <div class="d-flex">
                    <button
                        @click="updateAbout()"
                        class="btn btn-sm text-success"
                    >
                        <i class="fa-solid fa-square-check"></i>
                    </button>
                    <button class="btn btn-sm text-danger" @click="reset()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </template> -->
        <template>
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
                v-if="educationInfo != '' && isLoading == false"
            >
                <div class="d-flex">
                    <h5>Education</h5>
                    <div
                        class="d-flex float-right"
                        v-if="authUser.id == this.$route.params.id"
                    >
                        <button
                            class="btn btn-edit mx-2"
                            @click="editEducation(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </button>
                    </div>
                </div>

                <div v-for="(education, index) in educationInfo" :key="index">
                    <hr class="mt-2 mb-2" />
                    <h6>{{ education.institute }}</h6>
                    <div class="space" />
                    <p>{{ education.degree }}, {{ education.fieldOfStudy }}</p>
                    <p v-if="education.endDate">
                        {{ education.startDate }} - {{ education.endDate }}
                    </p>
                    <p v-else>{{ education.startDate }} - Present</p>
                </div>
            </div>
        </template>
        <div class="space" />

        <!-- Skills-section -->
        <template v-if="skills_id">
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            >
                <h5>Edit Skills</h5>
                <div class="space" />

                <textarea
                    class="form-control"
                    v-model="editData.skills"
                    rows="4"
                    placeholder="Write Your Skills..."
                ></textarea>
                <div class="d-flex">
                    <button
                        @click="updateSkills()"
                        class="btn btn-sm text-success"
                    >
                        <i class="fa-solid fa-square-check"></i>
                    </button>
                    <button class="btn btn-sm text-danger" @click="reset()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </template>
        <template v-else>
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
                v-if="profileInfo.skills && isLoading == false"
            >
                <div class="d-flex">
                    <h5>Skills</h5>
                    <div
                        class="d-flex float-right"
                        v-if="authUser.id == this.$route.params.id"
                    >
                        <button
                            class="btn btn-edit mx-2"
                            @click="editSkills(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </button>
                    </div>
                </div>
                <hr class="mt-2 mb-2" />
                <p>{{ profileInfo.skills }}</p>
            </div>
        </template>
        <div class="space" />

        <!-- interests-section -->
        <template v-if="interests_id">
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
            >
                <h5>Edit Interests</h5>
                <div class="space" />
                <textarea
                    class="form-control"
                    v-model="editData.interests"
                    rows="4"
                    placeholder="Write Your Interests..."
                ></textarea>
                <div class="d-flex">
                    <button
                        @click="updateInterests()"
                        class="btn btn-sm text-success"
                    >
                        <i class="fa-solid fa-square-check"></i>
                    </button>
                    <button class="btn btn-sm text-danger" @click="reset()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </template>
        <template v-else>
            <div
                class="container-fluid card card-bg m-auto col-md-8 col-lg-6 justtify-content-center p-4 m-3"
                v-if="profileInfo.interests && isLoading == false"
            >
                <div class="d-flex">
                    <h5>Interests</h5>
                    <div
                        class="d-flex float-right"
                        v-if="authUser.id == this.$route.params.id"
                    >
                        <button
                            class="btn btn-edit mx-2"
                            @click="editInterests(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </button>
                    </div>
                </div>
                <hr class="mt-2 mb-2" />

                <p>{{ profileInfo.interests }}</p>
            </div>
        </template>
        <div class="space" />

        <div v-if="isLoading == true" style="padding: 40px; text-align: center">
            <h5>Content is Loading....</h5>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: true,
            profileInfo: "",
            educationInfo: "",
            editData: {
                image: "",
                name: "",
                designation: "",
                department: "",
                about: "",
                skills: "",
                interests: "",
                id: "",
            },
            user_id: -1,
            about_id: "",
            skills_id: "",
            interests_id: "",
        };
    },

    methods: {
        editAbout(profileInfo) {
            this.reset();
            this.editData.about = profileInfo.about;
            this.editData.id = profileInfo.id;
            this.about_id = profileInfo.id;
            // this.editData.skills = "";
            // this.editData.interests = "";

            // if (this.profileInfo) {
            //     this.$nextTick(() => {
            //         if (this.$refs["todo" + this.todos[index].id]) {
            //             this.$refs["todo" + this.todos[index].id][0].focus();
            //         }
            //     });
            // }
        },
        async updateAbout() {
            if (this.editData.about.trim() == "") return this.e("required");
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/save_about/${this.user_id}`,
                this.editData
            );
            if (res.status === 200) {
                this.profileInfo.about = this.editData.about;
                this.reset();
                this.s("About has been updated successfully!");
            } else {
                if (res.status == 422) {
                    if (res.data.errors.about) {
                        this.e(res.data.errors.about[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        editSkills(profileInfo) {
            this.reset();
            this.editData.skills = profileInfo.skills;
            this.editData.id = profileInfo.id;
            this.skills_id = profileInfo.id;
            this.editData.about = "";
            this.editData.interests = "";

            // if (this.profileInfo) {
            //     this.$nextTick(() => {
            //         if (this.$refs["todo" + this.todos[index].id]) {
            //             this.$refs["todo" + this.todos[index].id][0].focus();
            //         }
            //     });
            // }
        },
        async updateSkills() {
            if (this.editData.skills.trim() == "") return this.e("required");
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/save_skills/${this.user_id}`,
                this.editData
            );
            if (res.status === 200) {
                this.profileInfo.skills = this.editData.skills;
                this.reset();
                this.s("Skills has been updated successfully!");
            } else {
                if (res.status == 422) {
                    if (res.data.errors.about) {
                        this.e(res.data.errors.about[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        editInterests(profileInfo) {
            this.reset();
            this.editData.interests = profileInfo.interests;
            this.editData.id = profileInfo.id;
            this.interests_id = profileInfo.id;
            this.editData.about = "";
            this.editData.skills = "";

            // if (this.profileInfo) {
            //     this.$nextTick(() => {
            //         if (this.$refs["todo" + this.todos[index].id]) {
            //             this.$refs["todo" + this.todos[index].id][0].focus();
            //         }
            //     });
            // }
        },
        async updateInterests() {
            if (this.editData.interests.trim() == "") return this.e("required");
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/save_interests/${this.user_id}`,
                this.editData
            );
            if (res.status === 200) {
                this.profileInfo.interests = this.editData.interests;
                this.reset();
                this.s("Interests has been updated successfully!");
            } else {
                if (res.status == 422) {
                    if (res.data.errors.interests) {
                        this.e(res.data.errors.interests[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async reset() {
            this.user_id = "";
            this.editData.about = "";
            this.about_id = "";
            this.editData.skills = "";
            this.skills_id = "";
            this.editData.interests = "";
            this.interests_id = "";

            this.token = window.Laravel.csrfToken;

            this.user_id = this.$route.params.id;
            const resU = await this.callApi(
                "get",
                `/api/get_profile_info/${this.user_id}`
            );
            const resE = await this.callApi(
                "get",
                `/api/get_education/${this.user_id}`
            );
            if (resU.status == 200) {
                this.profileInfo = resU.data;
            }
            if (resE.status == 200) {
                this.educationInfo = resE.data;
            } else {
                this.swr();
            }
            this.isLoading = false;
        },
    },
    watch: {
        "$route.params"(oldValue, newValue) {
            if (oldValue != newValue) {
                console.log("route is changing!");
                this.reset();
            }
        },
    },
    async created() {
        this.token = window.Laravel.csrfToken;

        this.user_id = this.$route.params.id;
        const resU = await this.callApi(
            "get",
            `/api/get_profile_info/${this.user_id}`
        );
        const resE = await this.callApi(
            "get",
            `/api/get_education/${this.user_id}`
        );
        if (resU.status == 200) {
            this.profileInfo = resU.data;
        }
        if (resE.status == 200) {
            this.educationInfo = resE.data;
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
}
.space {
    margin: 5px;
}
hr {
    background: #3a4660;
    color: #3a4660;
}

p {
    color: #333;
}
.btn-edit {
    color: rgb(167, 167, 167);
}
.btn-edit:hover {
    color: #000000;
}
</style>
