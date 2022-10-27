<template>
    <div class="mt-3 mb-2">
        <!--****** Profile edit for Teacher ******-->
        <template v-if="editModal && isLoading == false">
            <div
                class="profile__info-bottom-border container"
                v-if="
                    profileInfo.userType == 'teacher' ||
                    profileInfo.userType == 'admin'
                "
            >
                <div class="profile-header m-lg-auto" v-if="editData.image">
                    <img
                        :src="`${editData.image}`"
                        class="img-fluid"
                        type="file"
                    />
                    <div class="profile-header-cover" @click="deleteImage()">
                        <i class="lni lni-trash-can"></i>
                    </div>
                </div>

                <div class="mt-3 mb-3">
                    <Upload
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
                        <div class="profile-btn-design">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            Upload Image
                        </div>
                    </Upload>
                </div>

                <div class="plr-1rem">
                    <div class="mb-2">
                        <Input
                            type="text"
                            v-model="editData.name"
                            placeholder="Name"
                        />
                        <span class="text-danger" v-if="errors.name">{{
                            errors.name[0]
                        }}</span>
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
                        <span class="text-danger" v-if="errors.designation">{{
                            errors.designation[0]
                        }}</span>
                    </div>
                    <div class="mb-2">
                        <Select
                            v-model="editData.department"
                            placeholder="Department"
                        >
                            <Option value="CSE">CSE</Option>
                            <Option value="EEE">EEE</Option>
                            <Option value="ARCH">ARCH</Option>
                            <Option value="CE">CE</Option>
                            <Option value="BuA">BuA</Option>
                            <Option value="ENG">ENG</Option>
                        </Select>
                        <span class="text-danger" v-if="errors.department">{{
                            errors.department[0]
                        }}</span>
                    </div>
                    <div class="d-flex mb-2">
                        <button
                            class="profile-btn-design col-6"
                            @click="closeEditModal()"
                        >
                            Cancel
                        </button>
                        <button
                            class="profile-btn-design col-6"
                            @click="save()"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <!--****** Profile edit for Student ******-->
        <template v-if="editModal && isLoading == false">
            <div
                class="profile__info-bottom-border container"
                v-if="profileInfo.userType == 'student'"
            >
                <div class="profile-header m-lg-auto" v-if="editData.image">
                    <img
                        :src="`${editData.image}`"
                        class="img-fluid"
                        type="file"
                    />
                    <div class="profile-header-cover" @click="deleteImage()">
                        <i class="lni lni-trash-can"></i>
                    </div>
                </div>
                <div class="d-flex mt-3 mb-3">
                    <div class="col-6">
                        <Upload
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
                            <div>
                                <i
                                    class="fa-solid fa-cloud-arrow-up profile-btn-design"
                                ></i>
                                Upload Image
                            </div>
                        </Upload>
                    </div>
                    <div class="text-center col-6" @click="deleteImage()">
                        <div>
                            <i class="fa-solid fa-trash"></i>
                            Delete Image
                        </div>
                    </div>
                </div>

                <div class="plr-1rem">
                    <div class="mb-2">
                        <Input
                            type="text"
                            v-model="editData.name"
                            placeholder="Name"
                        />
                        <span class="text-danger" v-if="errors.name">{{
                            errors.name[0]
                        }}</span>
                    </div>
                    <div class="mb-2">
                        <Select
                            v-model="editData.department"
                            placeholder="Department"
                        >
                            <Option value="CSE">CSE</Option>
                            <Option value="EEE">EEE</Option>
                            <Option value="ARCH">ARCH</Option>
                            <Option value="CE">CE</Option>
                            <Option value="BuA">BuA</Option>
                            <Option value="ENG">ENG</Option>
                        </Select>
                        <span class="text-danger" v-if="errors.department">{{
                            errors.department[0]
                        }}</span>
                    </div>
                    <div class="d-flex mb-2">
                        <button
                            class="profile-btn-design col-6"
                            @click="closeEditModal()"
                        >
                            Cancel
                        </button>
                        <button
                            class="profile-btn-design col-6"
                            @click="save()"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!--****** Profile Info ******-->
        <template v-else>
            <div
                class="profile__info-bottom-border container"
                v-if="profileInfo && isLoading == false"
            >
                <div class="profile-header m-lg-auto">
                    <img :src="profileInfo.image" alt="img" class="img-fluid" />
                    <div
                        class="profile-header-cover"
                        @click="showEditModal(profileInfo)"
                        v-if="authUser.id == this.$route.params.id"
                    >
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                <div class="p-3">
                    <div class="d-flex">
                        <h4>
                            {{ profileInfo.name }}
                        </h4>
                        <span
                            v-if="authUser.id == this.$route.params.id"
                            class="btn-edit m-2"
                            @click="showEditModal(profileInfo)"
                        >
                            <i class="fa-solid fa-pen" />
                        </span>
                    </div>
                    <div>
                        <span>{{ profileInfo.designation }} .</span>
                        <span> {{ profileInfo.department }} .</span>
                        <span> Leading University </span>
                    </div>
                    <p>{{ profileInfo.email }}</p>
                </div>
            </div>
        </template>

        <!---******* loader *******--->
        <div
            class="profile__info-bottom-border container mb-2"
            v-if="isLoading == true"
        >
            <div class="profile-header-skeleton m-lg-auto">
                <img
                    :src="'/public/profileImages/download.jpg'"
                    alt="img"
                    class="img-fluid m-auto"
                />
            </div>
            <div class="p-3 profile-info-skeleton">
                <h4 />
                <p />
                <p />
            </div>
        </div>
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

            isAdding: false,
            profileInfo: "",
            editData: {
                image: "",
                name: "",
                designation: "",
                department: "",
                about: "",
                skills: "",
                interests: "",
            },
            index: -1,
            user_id: -1,
            token: "",
            isIconImageNew: false,
            isEditingItem: false,
            errors: [],
        };
    },
    components: {
        ProfileNav,
    },
    methods: {
        async save() {
            // if (this.editData.name.trim() == "")
            //     return this.e("Name is required");
            // if (this.editData.designation.trim() == "")
            //     return this.e("Designation is required");
            // if (this.editData.department.trim() == "")
            //     return this.e("Department is required");
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
                this.reset();
                this.u("Profile has been updated successfully!");
                this.editModal = false;
                // window.location = `/profile/${this.profileInfo.id}`;
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.errors = res.data.errors;
                        // this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(profileInfo) {
            let obj = {
                id: profileInfo.id,
                image: profileInfo.image,
                name: profileInfo.name,
                designation: profileInfo.designation,
                department: profileInfo.department,
            };
            console.log(profileInfo);
            this.editModal = true;
            this.editData = obj;
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
        async deleteImage() {
            let image;
            // for editing....
            // this.isIconImageNew = true;
            image = this.editData.image;
            this.editData.image = "/profileImages/download.jpg";
            this.$refs.editDataUploads.clearFiles();
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
        },
    },

    // to perform "side effects" in reaction to state changes
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
.profile-header {
    width: 200px;
    height: 200px;
    text-align: center;
    line-height: 150px;
    border: 1px solid transparent;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    border-radius: 50%;
}
.profile-header img {
    width: 100%;
    height: 100%;
}
.profile-header-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.profile-header:hover .profile-header-cover {
    display: block;
}
.profile-header-cover i {
    color: #fff;
    font-size: 40px;
    cursor: pointer;
    margin: auto;
}

.profile-header-skeleton {
    width: 200px;
    height: 200px;
    text-align: center;
    line-height: 100px;
    border: 1px solid transparent;
    overflow: hidden;
    background: #a7a7a7;
    border-radius: 50%;
}
.profile-info-skeleton h4 {
    width: 80%;
    height: 20px;
    display: block;
    background-color: #c0c0c0;
    margin: 0.5rem;
}
.profile-info-skeleton p {
    width: 70%;
    height: 14px;
    margin: 0.5rem;
    background-color: #a7a7a7;
}
.profile__info-bottom-border {
    border-radius: 5px;
    border-bottom: 1px solid #dadada;
}
</style>
