<template>
    <div>
        <div
            class="navbar-body__mobile--wrapper"
            v-bind:class="{ active: isSidebar }"
        >
            <div class="navbar-body__mobile">
                <div class="navbar-body__mobile--head">
                    <!-- <a href="#"><img src="assets/images/logo.png" alt="Logo" /></a> -->
                    <h5 class="d-inline t-clr__secondary">
                        Add Your Information
                    </h5>
                    <button type="button" v-on:click="hideSidebar()">
                        <i class="lni lni-cross-circle"></i>
                    </button>
                </div>
                <ul class="navbar-body__mobile--body">
                    <li class="nav-item" @click="showAboutModal(profileInfo)">
                        <a class="nav-link">About</a>
                    </li>

                    <li
                        class="nav-item"
                        @click="showEducationModal(profileInfo)"
                    >
                        <a class="nav-link">Education</a>
                    </li>
                    <li class="nav-item" @click="showSkillsModal(profileInfo)">
                        <a class="nav-link">Skills</a>
                    </li>
                    <li
                        class="nav-item"
                        @click="showInterestsModal(profileInfo)"
                    >
                        <a class="nav-link">Interests</a>
                    </li>
                </ul>

                <div class="navbar-body__mobile--head">
                    <!-- <a href="#"><img src="assets/images/logo.png" alt="Logo" /></a> -->
                    <h5 class="d-inline t-clr__secondary">Add Your Research</h5>
                </div>
                <ul class="navbar-body__mobile--body">
                    <li class="nav-item" @click="showAboutModal(profileInfo)">
                        <a class="nav-link">Preprint</a>
                    </li>

                    <li
                        class="nav-item"
                        @click="showEducationModal(profileInfo)"
                    >
                        <a class="nav-link">Conference Paper</a>
                    </li>
                    <li class="nav-item" @click="showSkillsModal(profileInfo)">
                        <a class="nav-link">Presentation</a>
                    </li>
                    <li
                        class="nav-item"
                        @click="showInterestsModal(profileInfo)"
                    >
                        <a class="nav-link">Poster</a>
                    </li>
                    <li
                        class="nav-item"
                        @click="showInterestsModal(profileInfo)"
                    >
                        <a class="nav-link">Project</a>
                    </li>
                    <li
                        class="nav-item"
                        @click="showInterestsModal(profileInfo)"
                    >
                        <a class="nav-link">Others</a>
                    </li>
                </ul>
            </div>
        </div>

        <nav class="navbar navbar-expand justify-content-center navbg mt-15">
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}`"
                            >Profile
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/research`"
                            >Research</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/projects`"
                            >Projects</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text"
                            :to="`/profile/${this.$route.params.id}/followings`"
                            >Followings</router-link
                        >
                    </li>
                </ul>
            </div>
            <div v-if="authUser.id == this.$route.params.id">
                <button class="btn-design" v-on:click="showSidebar()">
                    <i class="fa-solid fa-plus"></i> Add New
                </button>
            </div>
        </nav>

        <!-- profile Section modal -->
        <Modal
            v-model="sectionModal"
            title="Add Section"
            :mask-closable="true"
            :closable="true"
        >
            <div class="list-group">
                <a
                    @click="showAboutModal(profileInfo)"
                    class="list-group-item list-group-item-action"
                    style="border-bottom: 1px solid #34c5d9"
                    >Add About</a
                >
                <a
                    @click="showEducationModal(profileInfo)"
                    class="list-group-item list-group-item-action"
                    style="border-bottom: 1px solid #34c5d9"
                    >Add Education</a
                >
                <a
                    @click="showSkillsModal(profileInfo)"
                    class="list-group-item list-group-item-action"
                    style="border-bottom: 1px solid #34c5d9"
                    >Add Skills</a
                >

                <a
                    @click="showInterestsModal(profileInfo)"
                    class="list-group-item list-group-item-action"
                    style="border-bottom: 1px solid #34c5d9"
                    >Add Interests</a
                >
                <!--
                <a
                    @click="showPublicationsModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Publications</a
                >
                <a
                    @click="showProjectsModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Projects</a
                >
                <a
                    @click="showAwardsModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Honours & Awards</a
                >
                <a
                    @click="showVolunteerModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Volunteer Experience</a
                > -->
            </div>
        </Modal>

        <!-- About modal -->
        <Modal
            v-model="aboutModal"
            title="About"
            :mask-closable="false"
            :closable="true"
        >
            <div class="form-outline">
                <textarea
                    class="form-control"
                    id="textAreaExample1"
                    v-model="editData.about"
                    rows="4"
                    placeholder="Write About You..."
                ></textarea>
            </div>

            <div slot="footer">
                <Button
                    type="primary"
                    @click="saveAbout"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >{{ isAdding ? "Saving.." : "Save" }}</Button
                >
            </div>
        </Modal>

        <!-- Education modal -->
        <Modal
            v-model="educationModal"
            title="Add Education"
            :mask-closable="false"
            :closable="true"
        >
            <div class="mb-2">
                <label>Institute *</label>
                <Input
                    type="text"
                    v-model="educationData.institute"
                    placeholder="Ex: Leading University"
                />
            </div>

            <div class="mb-2">
                <label>Degree</label>
                <Input
                    type="text"
                    v-model="educationData.degree"
                    placeholder="Ex: Bachelor's"
                />
            </div>

            <div class="mb-2">
                <label>Field of study</label>
                <Input
                    type="text"
                    v-model="educationData.fieldOfStudy"
                    placeholder="Ex: Computer Science"
                />
            </div>
            <div class="mb-2">
                <label>Start Date</label>
                <div class="row">
                    <div class="col-6">
                        <Select
                            v-model="educationData.startMonth"
                            placeholder="Month"
                        >
                            <Option value="January">January</Option>
                            <Option value="February">February</Option>
                            <Option value="March">March</Option>
                            <Option value="April">April</Option>
                            <Option value="May">May</Option>
                            <Option value="June">June</Option>
                            <Option value="July">July</Option
                            ><Option value="August">August</Option
                            ><Option value="September">September</Option
                            ><Option value="October">October</Option
                            ><Option value="November">November</Option
                            ><Option value="December">December</Option>
                        </Select>
                    </div>

                    <div class="col-6">
                        <Select
                            v-model="educationData.startYear"
                            placeholder="Year"
                        >
                            <Option value="2022">2022</Option>
                            <Option value="2021">2021</Option>
                            <Option value="2020">2020</Option>
                            <Option value="2019">2019</Option>
                            <Option value="2018">2018</Option>
                            <Option value="2017">2017</Option>
                            <Option value="2016">2016</Option>
                            <Option value="2015">2015</Option>
                            <Option value="2014">2014</Option>
                            <Option value="2013">2013</Option>
                            <Option value="2012">2012</Option>
                            <Option value="2011">2011</Option>
                            <Option value="2010">2010</Option>
                            <Option value="2009">2009</Option>
                            <Option value="2008">2008</Option>
                            <Option value="2007">2007</Option>
                            <Option value="2006">2006</Option>
                            <Option value="2005">2005</Option>
                            <Option value="2004">2004</Option>
                            <Option value="2003">2003</Option>
                            <Option value="2002">2002</Option>
                            <Option value="2001">2001</Option>
                            <Option value="2000">2000</Option>
                        </Select>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label>End Date (or expected)</label>
                <div class="row">
                    <div class="col-6">
                        <Select
                            v-model="educationData.endMonth"
                            placeholder="Month"
                        >
                            <Option value="January">January</Option>
                            <Option value="February">February</Option>
                            <Option value="March">March</Option>
                            <Option value="April">April</Option>
                            <Option value="May">May</Option>
                            <Option value="June">June</Option>
                            <Option value="July">July</Option
                            ><Option value="August">August</Option
                            ><Option value="September">September</Option
                            ><Option value="October">October</Option
                            ><Option value="November">November</Option
                            ><Option value="December">December</Option>
                        </Select>
                    </div>

                    <div class="col-6">
                        <Select
                            v-model="educationData.endYear"
                            placeholder="Year"
                        >
                            <Option value="2030">2030</Option>
                            <Option value="2029">2029</Option>
                            <Option value="2028">2028</Option>
                            <Option value="2027">2027</Option>
                            <Option value="2026">2026</Option>
                            <Option value="2025">2025</Option>
                            <Option value="2024">2024</Option>
                            <Option value="2023">2023</Option>
                            <Option value="2022">2022</Option>
                            <Option value="2021">2021</Option>
                            <Option value="2020">2020</Option>
                            <Option value="2019">2019</Option>
                            <Option value="2018">2018</Option>
                            <Option value="2017">2017</Option>
                            <Option value="2016">2016</Option>
                            <Option value="2015">2015</Option>
                            <Option value="2014">2014</Option>
                            <Option value="2013">2013</Option>
                            <Option value="2012">2012</Option>
                            <Option value="2011">2011</Option>
                            <Option value="2010">2010</Option>
                            <Option value="2009">2009</Option>
                            <Option value="2008">2008</Option>
                            <Option value="2007">2007</Option>
                            <Option value="2006">2006</Option>
                            <Option value="2005">2005</Option>
                            <Option value="2004">2004</Option>
                            <Option value="2003">2003</Option>
                            <Option value="2002">2002</Option>
                            <Option value="2001">2001</Option>
                            <Option value="2000">2000</Option>
                        </Select>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label>Grade</label>
                <Input type="text" v-model="educationData.grade" />
            </div>
            <div class="mb-2">
                <label>Activities</label>
                <div class="form-outline">
                    <textarea
                        class="form-control"
                        id="textAreaExample1"
                        v-model="educationData.activities"
                        rows="4"
                    ></textarea>
                </div>
            </div>
            <div slot="footer">
                <Button
                    type="primary"
                    @click="saveEducation"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >{{ isAdding ? "Saving.." : "Save" }}</Button
                >
            </div>
        </Modal>

        <!-- Skills modal -->
        <Modal
            v-model="skillsModal"
            title="Add Skills"
            :mask-closable="false"
            :closable="true"
        >
            <div class="form-outline">
                <textarea
                    class="form-control"
                    id="textAreaExample1"
                    v-model="editData.skills"
                    rows="4"
                    placeholder="Write Your Skills..."
                ></textarea>
            </div>

            <div slot="footer">
                <Button
                    type="primary"
                    @click="saveSkills"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >{{ isAdding ? "Saving.." : "Save" }}</Button
                >
            </div>
        </Modal>

        <!-- Interests modal -->
        <Modal
            v-model="interestsModal"
            title="Add Interests"
            :mask-closable="false"
            :closable="true"
        >
            <div class="form-outline">
                <textarea
                    class="form-control"
                    id="textAreaExample1"
                    v-model="editData.interests"
                    rows="4"
                    placeholder="Write Your Skills..."
                ></textarea>
            </div>

            <div slot="footer">
                <Button
                    type="primary"
                    @click="saveInterests"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >{{ isAdding ? "Saving.." : "Save" }}</Button
                >
            </div>
        </Modal>
    </div>
</template>
<script>
export default {
    name: "ProfileNav",
    components: {},
    data() {
        return {
            isSidebar: false,
            isLoading: true,
            isAdding: false,
            profileInfo: "",
            data: {
                about: "",
                institute: "",
                Skills: "",
            },
            editData: {
                about: "",
                skills: "",
                interests: "",
            },
            educationData: {
                institute: "",
                degree: "",
                fieldOfStudy: "",
                startMonth: "",
                startYear: "",
                endMonth: "",
                endYear: "",
                grade: "",
                activities: "",
            },
            user_id: -1,
            sectionModal: false,
            aboutModal: false,
            educationModal: false,
            skillsModal: false,
            interestsModal: false,
            publicationsModal: false,
            projectsModal: false,
            awardsModal: false,
            volunteerModal: false,
        };
    },
    methods: {
        showSidebar() {
            this.isSidebar = true;
        },
        hideSidebar() {
            this.isSidebar = false;
        },
        //section modal
        showSectionModal() {
            this.sectionModal = true;
        },

        showAboutModal(profileInfo) {
            // let obj = {
            // 	id : tag.id,
            // 	tagName : tag.tagName
            // }
            this.editData = profileInfo;
            this.aboutModal = true;
            this.isEditingItem = true;
            this.sectionModal = false;
        },

        async saveAbout() {
            if (this.editData.about.trim() == "") return this.e("required");
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/save_about/${this.user_id}`,
                this.editData
            );
            if (res.status === 200) {
                this.profileInfo.about = this.editData.about;
                // this.profileInfo = res.data;
                // this.$router.push(`/profile/${authUser.id}`);
                window.location = `/profile/${authUser.id}`;
                this.reset();
                this.s("About has been updated successfully!");
                this.aboutModal = false;
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

        //education modal
        showEducationModal(profileInfo) {
            this.educationData = profileInfo;
            this.educationModal = true;
            this.sectionModal = false;
        },

        async saveEducation() {
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/save_education/${this.user_id}`,
                this.educationData
            );
            if (res.status === 201) {
                // this.edications.unshift(res.data);
                this.s("Education has been added successfully!");
                this.educationModal = false;
                this.reset();
            } else {
                if (res.status == 422) {
                    if (res.data.errors) {
                        this.e(res.data.errors[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        showSkillsModal(profileInfo) {
            // let obj = {
            // 	id : tag.id,
            // 	tagName : tag.tagName
            // }
            this.editData = profileInfo;
            this.skillsModal = true;
            this.isEditingItem = true;
            this.sectionModal = false;
        },

        async saveSkills() {
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
                this.skillsModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.skills) {
                        this.e(res.data.errors.skills[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        showInterestsModal(profileInfo) {
            // let obj = {
            // 	id : tag.id,
            // 	tagName : tag.tagName
            // }
            this.editData = profileInfo;
            this.interestsModal = true;
            this.isEditingItem = true;
            this.sectionModal = false;
        },

        async saveInterests() {
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
                this.s("Interest has been updated successfully!");
                this.interestsModal = false;
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
            this.isSidebar = false;
        },
    },
    async created() {
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
.navbg {
    background: #5c596d;
}

.text {
    color: #e3e3e3;
}
.text:hover {
    color: #fbf7ff;
    border-bottom: 1px solid #fbf7ff !important;
}

.router-link-exact-active {
    color: #34c5d9 !important;
    border-bottom: 1px solid #34c5d9 !important;
}
</style>
