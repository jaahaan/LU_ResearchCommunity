<template>
    <div class="mt-3">
        <!-- about-section starts -->
        <!-- about edit -->
        <template v-if="about_id">
            <div class="card m-auto col-md-8 col-lg-6 mb-3">
                <div class="card-header p-3 card-header-border">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Edit About</h5>
                        </div>
                        <div
                            class="btn-edit text-danger mx-2 float-end"
                            @click="reset()"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        v-model="editData.about"
                        rows="4"
                        placeholder="Write About You..."
                    ></textarea>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-block">
                        <button
                            class="btn btn-design mx-2 float-end"
                            @click="updateAbout()"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                        <button
                            class="btn btn-design mx-2 float-end"
                            @click="deleteAbout(profileInfo)"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- about -->
        <template v-else>
            <div
                class="card m-auto col-md-8 col-lg-6 mb-3"
                v-if="profileInfo.about && isLoading == false"
            >
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>About</h5>
                        </div>
                        <div
                            v-if="authUser.id == this.$route.params.id"
                            class="btn-edit mx-2 float-end"
                            @click="editAbout(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p>{{ profileInfo.about }}</p>
                </div>
            </div>
        </template>
        <!-- about-section ends-->

        <!-- education-section starts -->
        <!-- education edit -->
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
                class="card m-auto col-md-8 col-lg-6 mb-3"
                v-if="educationInfo != '' && isLoading == false"
            >
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Education</h5>
                        </div>
                        <div
                            v-if="authUser.id == this.$route.params.id"
                            class="btn-edit mx-2 float-end"
                            @click="editEducation(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div
                        v-for="(education, index) in educationInfo"
                        :key="index"
                    >
                        <h6>{{ education.institute }}</h6>
                        <div class="space" />
                        <p>
                            {{ education.degree }}, {{ education.fieldOfStudy }}
                        </p>
                        <p v-if="education.endDate">
                            {{ education.startDate }} - {{ education.endDate }}
                        </p>
                        <p v-else>{{ education.startDate }} - Present</p>
                        <hr
                            class="mt-2 mb-2"
                            v-if="educationInfo.length - 1 > index"
                        />
                    </div>
                </div>
            </div>
        </template>
        <!-- education-section ends-->

        <!-- Skills-section starts-->
        <!-- skills edit -->
        <template v-if="skills_id">
            <div class="card m-auto col-md-8 col-lg-6 mb-3">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Edit Skills</h5>
                        </div>
                        <div
                            class="btn-edit text-danger mx-2 float-end"
                            @click="reset()"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        v-model="editData.skills"
                        rows="4"
                        placeholder="Write Your Skills..."
                    ></textarea>
                </div>
                <div class="card-footer text-muted p-3">
                    <div class="d-block">
                        <button
                            class="btn btn-design mx-2 float-end"
                            @click="updateSkills()"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- skills -->
        <template v-else>
            <div
                class="card m-auto col-md-8 col-lg-6 mb-3"
                v-if="profileInfo.skills && isLoading == false"
            >
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Skills</h5>
                        </div>
                        <div
                            v-if="authUser.id == this.$route.params.id"
                            class="btn-edit mx-2 float-end"
                            @click="editSkills(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p>{{ profileInfo.skills }}</p>
                </div>
            </div>
        </template>
        <!-- Skills-section ends-->

        <!-- interests-section starts-->
        <!-- interests edit-->
        <template v-if="interests_id">
            <div class="card m-auto col-md-8 col-lg-6 mb-3">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Edit Interests</h5>
                        </div>
                        <div
                            class="btn-edit text-danger mx-2 float-end"
                            @click="reset()"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        v-model="editData.interests"
                        rows="4"
                        placeholder="Write Your Interests..."
                    ></textarea>
                </div>
                <div class="card-footer text-muted p-3">
                    <div class="d-block">
                        <button
                            class="btn btn-design mx-2 float-end"
                            @click="updateInterests()"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- interests-->
        <template v-else>
            <div
                class="card m-auto col-md-8 col-lg-6 mb-3"
                v-if="profileInfo.interests && isLoading == false"
            >
                <div class="card-header card-header-borderp-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Interests</h5>
                        </div>
                        <div
                            v-if="authUser.id == this.$route.params.id"
                            class="btn-edit mx-2 float-end"
                            @click="editInterests(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </div>
                    </div>
                </div>

                <div class="card-body p-3">
                    <p>{{ profileInfo.interests }}</p>
                </div>
            </div>
        </template>
        <!-- interests-section ends -->

        <!-- loader -->
        <template v-if="isLoading == true">
            <div class="card m-auto col-md-8 col-lg-6 mb-3">
                <div class="card-header p-3">
                    <div class="profile-info-skeleton">
                        <h5 />
                    </div>
                </div>

                <div class="card-body p-3 profile-info-skeleton">
                    <p />
                </div>
            </div>

            <div class="card m-auto col-md-8 col-lg-6 mb-3">
                <div class="card-header p-3">
                    <div class="profile-info-skeleton">
                        <h5 />
                    </div>
                </div>

                <div class="card-body p-3 profile-info-skeleton">
                    <p />
                </div>
            </div>
        </template>
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
            //         if (this.$refs["todo" + th is.todos[index].id]) {
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

        async deleteAbout(profileInfo) {
            if (this.profileInfo.id) {
                const res = await this.callApi(
                    "post",
                    `/api/delete_about/${this.profileInfo.id}`,
                    this.editData
                );

                if (res.status === 200) {
                    this.profileInfo.about = this.editData.about;
                    this.reset();
                    this.s("About has been deleted successfully!");
                } else {
                    this.swe();
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
.card-header-border {
    border-bottom: 1px solid #34c5d9;
}
p {
    color: #333;
}

.profile-info-skeleton h5 {
    width: 60%;
    height: 24px;
    display: block;
    background-color: #c0c0c0;
    margin: 0.25rem;
}
.profile-info-skeleton p {
    width: 95%;
    height: 16px;
    margin: 0.25rem;
    background-color: #c0c0c0;
}
.btn-design {
    background-color: #34c5d9;
    border: none;
    color: #fbf7ff;
    /*TB LR */
    padding: 3px 8px;
}
</style>
