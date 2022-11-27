<template>
    <div class="mt-2">
        <!--****** Add Research box ******-->

        <template
            v-if="
                isLoading == false &&
                showResearchForm == false &&
                researches == ''
            "
        >
            <div
                class="card mb-2 p-3"
                v-if="authUser.id == this.$route.params.id"
            >
                <button class="add_new_card" v-on:click="showForm()">
                    <i class="lni lni-folder"></i> Add Your Research
                </button>
            </div>
        </template>

        <!--****** Add Research form ******-->
        <template v-if="showResearchForm == true">
            <div class="card mb-2">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Add Research</h5>
                        </div>
                        <div
                            class="btn-edit text-danger mx-2 float-end"
                            @click="reset"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label>Publication Type *</label>
                        <Select v-model="data.type" placeholder="Select Type">
                            <Option value="Article">Article</Option>
                            <Option value="Conference Paper"
                                >Conference Paper</Option
                            >
                            <Option value="Data">Data</Option>
                            <Option value="Research">Research</Option>
                            <Option value="Presentation">Presentation</Option>
                            <Option value="Preprint">Preprint</Option>
                            <Option value="Poster">Poster</Option>
                        </Select>
                        <span class="text-danger" v-if="errors.type">{{
                            errors.type[0]
                        }}</span>
                    </div>

                    <div v-if="data.type == 'Conference Paper'">
                        <div
                            class="mb-2"
                            v-if="data.type == 'Conference Paper'"
                        >
                            <label>Conference *</label>
                            <Input
                                type="text"
                                v-model="data.conference"
                                placeholder="Conference"
                            />
                            <span
                                class="text-danger"
                                v-if="errors.conference"
                                >{{ errors.conference[0] }}</span
                            >
                        </div>
                        <div
                            class="mb-2"
                            v-if="data.type == 'Conference Paper'"
                        >
                            <label>Publication Date</label>
                            <input
                                type="month"
                                v-model="data.publication_date"
                                placeholder="Publication Date"
                                class="d-block w-100 p-1"
                            />
                            <span
                                class="text-danger"
                                v-if="errors.start_date"
                                >{{ errors.start_date[0] }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>Title *</label>
                        <Input
                            type="text"
                            v-model="data.title"
                            placeholder="Research Title"
                        />
                        <span class="text-danger" v-if="errors.title">{{
                            errors.title[0]
                        }}</span>
                    </div>

                    <div class="mb-2">
                        <label>Abstract</label>
                        <textarea
                            class="form-control form-outline"
                            v-model="data.abstract"
                            rows="4"
                        ></textarea>
                        <span class="text-danger" v-if="errors.abstract">{{
                            errors.abstract[0]
                        }}</span>
                    </div>

                    <div class="mb-2">
                        <label>Authors</label>

                        <Select
                            filterable
                            multiple
                            placeholder="Select Authors"
                            v-model="data.author_id"
                        >
                            <Option
                                v-for="(user, index) in users"
                                :value="user.id"
                                :key="index"
                                >{{ user.name }}</Option
                            >
                        </Select>
                    </div>
                    <div class="mb-2">
                        <label>Affiliation</label>
                        <Input
                            type="text"
                            placeholder="Affiliation"
                            v-model="data.affiliation"
                        />
                        <span class="text-danger" v-if="errors.affiliation">{{
                            errors.affiliation[0]
                        }}</span>
                    </div>
                    <div class="mb-2">
                        <label>URL</label>
                        <Input
                            type="url"
                            v-model="data.url"
                            placeholder="URL"
                        />
                        <span class="text-danger" v-if="errors.url">{{
                            errors.url[0]
                        }}</span>
                    </div>
                    <div class="mb-2">
                        <label>Attachment</label>
                        <Upload
                            :headers="{
                                'x-csrf-token': token,
                                'X-Requested-With': 'XMLHttpRequest',
                            }"
                            ref="upload"
                            :multiple="true"
                            :show-upload-list="true"
                            :on-success="handleSuccess"
                            :format="[
                                'jpg',
                                'jpeg',
                                'png',
                                'pdf',
                                'docx',
                                'txt',
                                'mp4',
                                'mp3',
                                'zip',
                            ]"
                            :max-size="21048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            :on-remove="deleteAttachment"
                            type="drag"
                            action="/api/upload_attachment"
                        >
                            <div class="profile-main-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                Upload Attachment
                            </div>
                        </Upload>
                        <div v-if="this.attachmentName" class="attachmentName">
                            <span class="c-pointer">{{
                                this.attachmentName
                            }}</span>
                            <span @click="deleteAttachment"
                                ><i class="lni lni-trash-can c-pointer"></i
                            ></span>
                        </div>
                        <span class="text-danger" v-if="errors.url">{{
                            errors.url[0]
                        }}</span>
                    </div>
                </div>
                <div class="card-footer text-muted p-3">
                    <div class="d-block">
                        <button
                            class="profile-main-btn mx-2 float-end"
                            @click="save"
                        >
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                        <button
                            class="profile-main-btn mx-2 float-end"
                            @click="reset()"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!--**** Researches ****-->
        <template
            v-if="
                researches != '' &&
                isLoading == false &&
                showResearchForm == false
            "
        >
            <div class="card">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Researches</h5>
                        </div>
                        <div
                            v-if="authUser.id == route_id && editData.id == ''"
                            class="btn-edit mx-2 float-end"
                            @click="showForm()"
                        >
                            <i class="lni lni-plus"></i>
                        </div>
                    </div>
                </div>
                <div v-for="(research, index) in researches" :key="index">
                    <div class="card-body">
                        <div>
                            <div class="project-header">
                                <h4>{{ project.title }}</h4>
                                <div
                                    v-if="authUser.id == project.user_id"
                                    class="btn-edit mx-2"
                                    @click="editProject(index)"
                                >
                                    <i class="lni lni-pencil"></i>
                                </div>
                            </div>

                            <p v-if="project.end_date">
                                {{ project.start_date.toLocaleString("short") }}
                                - {{ project.end_date }}
                            </p>
                            <p v-else>{{ project.start_date }} - Present</p>
                            <div class="project-link-box">
                                <h6>{{ project.project_type }}</h6>
                                <a
                                    v-if="project.project_url != null"
                                    class="project-link-btn"
                                    :href="`${project.project_url}`"
                                >
                                    Project Link
                                </a>
                            </div>
                            <p>
                                {{ project.project_description }}
                            </p>

                            <hr
                                class="mt-4"
                                v-if="researches.length - 1 > index"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!--**** loader ****-->
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            showResearchForm: false,
            isLoading: true,
            errors: [],
            researches: [],
            users: [],
            user_id: -1,
            route_id: this.$route.params.id,

            data: {
                type: "",
                conference: "",
                conference_date: "",
                title: "",
                author_id: [],
                attachment: "",
                abstract: "",
                url: "",
                images: [],
                pdf: "",
            },
            editData: {
                user_id: "",
                type: "",
                conference: "",
                conference_date: "",
                title: "",
                author_id: [],
                attachment: "",
                abstract: "",
                start_date: "",
                end_date: "",
                url: "",
                images: [],
                pdf: "",
                id: "",
                index: "",
            },
            isEditingItem: false,
            attachmentName: "",
        };
    },
    methods: {
        clearErrorMessage() {
            this.errors = [];
        },
        async deleteAttachment() {
            let attachment = this.attachmentName;
            this.$refs.upload.clearFiles();
            this.attachmentName = "";
            this.data.attachment = "";

            const res = await this.callApi("post", "/api/delete_attachment", {
                Name: attachment,
            });
            if (res.status != 200) {
                this.data.attachment = attachment;
                this.swr();
            }
        },
        handleSuccess(res, file) {
            // res = `/attachments/${res}`;
            // res1 = `${res}`;
            this.$refs.upload.clearFiles();
            // if (this.isEditingItem) {
            //     console.log("inside");
            //     return (this.data.attachments = res);
            // }
            // console.log(res);
            // this.data.attachment = `\\attachments\\${res}`;
            console.log(this.data.attachment);
            this.data.attachment = `${res}`;

            this.attachmentName = `${res}`;
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
        showForm() {
            this.showResearchForm = true;
        },
        async reset() {
            this.showResearchForm = false;
            this.editData.id = "";
            this.user_id = this.$route.params.id;
            this.data = {
                type: "",
                conference: "",
                conference_date: "",
                title: "",
                author_id: [],
                attachment: "",
                abstract: "",
                url: "",
                images: [],
                pdf: "",
            };
            // const res = await this.callApi(
            //     "get",
            //     `/api/get_research/${this.user_id}`
            // );
            // if (res.status == 200) {
            //     this.researches = res.data;
            //     this.errors = [];
            // } else {
            //     this.swr();
            // }

            this.isLoading = false;
        },

        async save() {
            // if (this.data.project_name.trim() == "")
            //     return this.e("Project Name is required");
            // if (this.data.project_type.trim() == "")
            //     return this.e("Project type is required");
            // if (this.data.start_date.trim() == "")
            //     return this.e("Start date is required");

            this.user_id = this.$route.params.id;
            console.log(this.user_id);
            const res = await this.callApi(
                "post",
                `/api/save_post/${this.user_id}`,
                this.data
            );
            this.isLoading = true;
            if (res.status === 200) {
                this.s(res.data.msg);
                // this.msg = res.data.msg;
                this.reset();
                this.clearErrorMessage();
            } else {
                if (res.status == 422) {
                    console.log(this.$route.params.id);

                    for (let i in res.data.errors) {
                        this.errors = res.data.errors;
                    }
                } else {
                    this.swr();
                }
            }
            this.isLoading = false;
        },

        edit(index) {
            if (this.projects[index].id) {
                this.editData.user_id = this.projects[index].user_id;
                this.editData.project_name = this.projects[index].project_name;
                this.editData.project_type = this.projects[index].project_type;
                this.editData.start_date = this.projects[index].start_date;
                this.editData.end_date = this.projects[index].end_date;
                this.editData.project_url = this.projects[index].project_url;
                this.editData.project_description =
                    this.projects[index].project_description;
                this.editData.id = this.projects[index].id;
                this.editData.index = index;
                this.$nextTick(() => {
                    if (this.$refs["projectName" + this.projects[index].id]) {
                        this.$refs[
                            "projectName" + this.projects[index].id
                        ][0].focus();
                    }
                });
            }
        },

        async update() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.designation.trim() == "")
            //     return this.e("Designation is required");
            // if (this.data.department.trim() == "")
            //     return this.e("Department is required");
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                "/api/update_post",
                this.editData
            );

            if (res.status === 200) {
                this.msg = res.data.msg;
                this.reset();
                this.errors = [];
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
            this.isLoading = false;
        },
        async delete() {
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                `/api/delete_post/${this.editData.id}`
            );

            if (res.status === 200) {
                this.s(res.data.msg);
                this.reset();
            } else {
                this.swr();
            }
            this.isLoading = false;
        },
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        this.user_id = this.$route.params.id;

        const res = await this.callApi("get", `/api/get_post/${this.user_id}`);
        const resUser = await this.callApi("get", `/api/get_all_user`);
        if (resUser.status == 200) {
            this.users = resUser.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>
