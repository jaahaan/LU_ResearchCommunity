<template>
    <div>
        <div class="profile-bg">
            <div
                class="container-fluid m-auto col-md-8 col-lg-6 justtify-content-center p-3"
                v-if="profileInfo && isLoading == false"
            >
                <div class="row justtify-content-center">
                    <div
                        class="col-md-4 col-sm-12 my-auto justify-content-center"
                    >
                        <div class="demo-upload-list">
                            <img
                                :src="profileInfo.image"
                                alt="img"
                                class="img-fluid profile-img m-auto"
                            />
                            <div class="demo-upload-list-cover">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </div>
                        <!-- <img
                            :src="authUser.image"
                            alt="img"
                            class="img-fluid profile-img m-auto"
                        /> -->
                    </div>
                    <div class="col-md-5 my-auto justify-content-center">
                        <h2 class="pb-3">
                            <span class="mr-2">{{ profileInfo.name }} </span
                            ><button
                                class="btn btn-edit ml-2"
                                @click="showEditModal(profileInfo)"
                                v-if="authUser.id == this.$route.params.id"
                            >
                                <i class="fa-solid fa-pen" />
                            </button>
                        </h2>
                        <p>{{ profileInfo.email }}</p>
                        <p>{{ profileInfo.designation }}</p>
                        <p>Department of {{ profileInfo.department }}</p>
                    </div>
                </div>
                <div class="row" v-if="authUser.id == this.$route.params.id">
                    <button
                        class="btn btn-design col-12 m-2"
                        @click="showSectionModal()"
                    >
                        <i class="fa-solid fa-plus"></i> Add Section
                    </button>
                </div>
            </div>
            <div
                v-if="isLoading == true"
                style="padding: 40px; text-align: center"
            >
                <h1>Content is Loading....</h1>
            </div>
            <div class="row m-1">
                <div class="container-fluid card m-auto navbg">
                    <ProfileNav />
                </div>
            </div>
        </div>

        <!-- profile edit modal -->
        <Modal
            v-model="editModal"
            title="Edit Profile"
            :mask-closable="false"
            :closable="true"
        >
            <div class="mb-2">
                <Upload
                    v-show="isIconImageNew"
                    ref="editDataUploads"
                    type="drag"
                    :headers="{
                        'x-csrf-token': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    }"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :format="['jpg', 'jpeg', 'png']"
                    :max-size="2048"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    action="/api/upload"
                >
                    <div style="padding: 20px 0">
                        <Icon
                            type="ios-cloud-upload"
                            size="52"
                            style="color: #3399ff"
                        ></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list m-auto" v-if="editData.image">
                    <img
                        :src="`${editData.image}`"
                        class="img-fluid"
                        type="file"
                    />
                    <div class="demo-upload-list-cover">
                        <Icon
                            type="ios-trash-outline"
                            @click="deleteImage(false)"
                        ></Icon>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <Input type="text" v-model="editData.name" placeholder="Name" />
            </div>
            <div class="mb-2">
                <Select
                    v-model="editData.designation"
                    placeholder="Designation"
                >
                    <Option value="Head">Head</Option>
                    <Option value="Professor">Professor</Option>
                    <Option value="Associate Professor"
                        >Associate Professor</Option
                    >
                    <Option value="Assistant Professor"
                        >Assistant Professor</Option
                    >
                    <Option value="Lecturer">Lecturer</Option>
                </Select>
            </div>
            <div class="mb-2">
                <Select v-model="editData.department" placeholder="Department">
                    <Option value="CSE">CSE</Option>
                    <Option value="EEE">EEE</Option>
                    <Option value="ARCH">ARCH</Option>
                    <Option value="CE">CE</Option>
                    <Option value="BuA">BuA</Option>
                    <Option value="ENG">ENG</Option>
                </Select>
            </div>
            <div slot="footer">
                <Button type="default" @click="closeEditModal">Close</Button>
                <Button
                    type="primary"
                    @click="save"
                    :disabled="isAdding"
                    :loading="isAdding"
                    >{{ isAdding ? "Saving.." : "Save" }}</Button
                >
            </div>
        </Modal>

        <!-- profile Section modal -->
        <Modal
            v-model="sectionModal"
            title="Add Section"
            :mask-closable="false"
            :closable="true"
        >
            <div class="list-group bg-dark">
                <a
                    @click="showAboutModal(profileInfo)"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add About</a
                >
                <a
                    @click="showEducationModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Education</a
                >
                <a
                    @click="showSkillsModal(profileInfo)"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Skills</a
                >
                <!--
                <a
                    @click="showInterestsModal"
                    class="list-group-item list-group-item-action list-group-item-dark"
                    >Add Interests</a
                >
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
            <div slot="footer"></div>
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
                    v-model="data.institute"
                    placeholder="Ex: Leading University"
                />
            </div>

            <div class="mb-2">
                <label>Degree</label>
                <Input
                    type="text"
                    v-model="data.degree"
                    placeholder="Ex: Bachelor's"
                />
            </div>

            <div class="mb-2">
                <label>Field of study</label>
                <Input
                    type="text"
                    v-model="data.fieldOfStudy"
                    placeholder="Ex: Computer Science"
                />
            </div>
            <div class="mb-2">
                <label>Start Date</label>
                <div class="row">
                    <div class="col-6">
                        <Select v-model="data.startMonth" placeholder="Month">
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
                        <Select v-model="data.startYear" placeholder="Year">
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
                        <Select v-model="data.endMonth" placeholder="Month">
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
                        <Select v-model="data.endYear" placeholder="Year">
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
                <Input type="text" v-model="data.grade" />
            </div>
            <div class="mb-2">
                <label>Activities</label>
                <div class="form-outline">
                    <textarea
                        class="form-control"
                        id="textAreaExample1"
                        v-model="editData.activities"
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
    </div>
</template>
<script>
import ProfileNav from "./profileNav";

export default {
    name: "Profile",

    data() {
        return {
            isLoading: true,
            data: {
                image: "",
                name: "",
                designation: "",
                department: "",

                about: "",

                //education
                institute: "",

                Skills: "",
            },
            editModal: false,
            sectionModal: false,
            aboutModal: false,
            educationModal: false,
            skillsModal: false,
            interestsModal: false,
            publicationsModal: false,
            projectsModal: false,
            awardsModal: false,
            volunteerModal: false,

            isAdding: false,
            profileInfo: "",
            editData: {
                image: "",
                name: "",
                designation: "",
                department: "",
                about: "",
                skills: "",
            },
            index: -1,
            user_id: -1,
            token: "",
            isIconImageNew: false,
            isEditingItem: false,
        };
    },
    components: {
        ProfileNav,
    },
    methods: {
        async save() {
            if (this.editData.name.trim() == "")
                return this.e("Name is required");
            if (this.editData.designation.trim() == "")
                return this.e("Designation is required");
            if (this.editData.department.trim() == "")
                return this.e("Department is required");
            this.user_id = this.$route.params.id;
            const res = await this.callApi(
                "post",
                `/api/edit_profile/${this.user_id}`,
                this.editData
            );
            if (res.status === 200) {
                this.profileInfo.name = this.editData.name;
                this.profileInfo.designation = this.editData.designation;
                this.profileInfo.department = this.editData.department;
                this.s("Profile has been edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.image) {
                        this.e(res.data.errors.image[0]);
                    }
                    if (res.data.errors.name) {
                        this.e(res.data.errors.name[0]);
                    }
                    if (res.data.errors.designation) {
                        this.e(res.data.errors.designation[0]);
                    }
                    if (res.data.errors.department) {
                        this.e(res.data.errors.department[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(profileInfo) {
            // let obj = {
            // 	id : tag.id,
            // 	tagName : tag.tagName
            // }
            console.log(profileInfo);
            this.editData = profileInfo;
            this.editModal = true;
            this.isEditingItem = true;
        },
        handleSuccess(res, file) {
            res = `/profileImages/${res}`;
            if (this.isEditingItem) {
                console.log("inside");
                return (this.editData.image = res);
            }
            console.log(res);
            this.data.image = res;
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong!"
                }`,
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png.",
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M.",
            });
        },
        async deleteImage(isAdd = true) {
            let image;
            if (!isAdd) {
                // for editing....
                this.isIconImageNew = true;
                image = this.editData.image;
                this.editData.image =
                    "../../../public/profileImages/download.jpg";
                this.$refs.editDataUploads.clearFiles();
            }
            const res = await this.callApi("post", "/api/delete_image", {
                imageName: image,
            });
            if (res.status != 200) {
                this.data.image = image;
                this.swr();
            }
        },
        closeEditModal() {
            this.isEditingItem = false;
            this.editModal = false;
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
                this.profileInfo.bio = this.editData.about;
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
        showEducationModal() {
            this.educationModal = true;
            this.sectionModal = false;
        },

        async saveEducation() {
            if (this.data.institute.trim() == "")
                return this.e("Institute name is required");

            const res = await this.callApi(
                "post",
                "/api/add_education",
                this.data
            );
            if (res.status === 201) {
                console.log(res.data);
                this.edications.unshift(res.data);
                this.s("Education has been added successfully!");
                this.educationModal = false;
                this.data.institute = "";
                this.data.degree = "";
                this.data.fieldOfStudy = "";
                this.data.startMonth = "";
                this.data.startYear = "";
                this.data.endMonth = "";
                this.data.endYear = "";
                this.data.grade = "";
                this.data.activities = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0]);
                    }
                    if (res.data.errors.iconImage) {
                        this.e(res.data.errors.iconImage[0]);
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
                this.profileInfo.bio = this.editData.skills;
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

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
body {
    font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
}
</style>

<style scoped>
.profile-bg {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    background: #c9af98;
}
.navbg {
    background: #3a4660;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
h5 {
    color: #1c2230;
}

.text {
    color: #845007;
}
.text:hover {
    color: #ffffff;
}
.text:active {
    color: #fab162;
}
.text:after {
    color: #fab162;
}
.logo {
    height: 10vh;
    width: 10vh;
}
.image_thumb {
    width: 240px;
}
.demo-upload-list {
    width: 150px;
    height: 150px;
    text-align: center;
    line-height: 100px;
    border: 1px solid transparent;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
    border-radius: 50%;
}
.demo-upload-list img {
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
.demo-upload-list-cover i {
    color: #fff;
    font-size: 40px;
    cursor: pointer;
    margin: auto;
}
</style>
