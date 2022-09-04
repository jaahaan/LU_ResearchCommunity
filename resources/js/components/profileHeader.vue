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
                    </div>
                    <div class="col-md-5 my-auto justify-content-center">
                        <h5 class="pb-3">
                            <span class="mr-2">{{ profileInfo.name }} </span
                            ><button
                                class="btn btn-edit ml-2"
                                @click="showEditModal(profileInfo)"
                                v-if="authUser.id == this.$route.params.id"
                            >
                                <i class="fa-solid fa-pen" />
                            </button>
                        </h5>
                        <p>{{ profileInfo.email }}</p>
                        <p>{{ profileInfo.designation }}</p>
                        <p>Department of {{ profileInfo.department }}</p>
                    </div>
                </div>
            </div>
            <div
                v-if="isLoading == true"
                style="padding: 40px; text-align: center"
            >
                <h1>Content is Loading....</h1>
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
                this.reset();
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
            let obj = {
                id: profileInfo.id,
                image: profileInfo.image,
                name: profileInfo.name,
                designation: profileInfo.designation,
                department: profileInfo.department,
            };
            console.log(profileInfo);
            this.editData = obj;
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
.profile-bg {
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
