<template>
    <div class="mt-2">
        <!--****** Add Project box ******-->

        <template
            v-if="
                isLoading == false && showProjectForm == false && projects == ''
            "
        >
            <div
                class="card mb-2 p-3"
                v-if="authUser.id == this.$route.params.id"
            >
                <button class="add_new_card" v-on:click="showForm()">
                    <i class="lni lni-folder"></i> Add Your Project
                </button>
            </div>
        </template>

        <!--****** Add Project form ******-->
        <template v-if="showProjectForm == true">
            <div class="card mb-2">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Add Project</h5>
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
                    <div class="mb-2">
                        <label>Project Name *</label>
                        <Input
                            type="text"
                            v-model="data.title"
                            placeholder="Project Name"
                        />
                        <span class="text-danger" v-if="errors.title">{{
                            errors.title[0]
                        }}</span>
                    </div>
                    <div class="mb-2">
                        <label>Description</label>
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
                        <label>Team Member</label>

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
                        <label>Project URL</label>
                        <Input
                            type="url"
                            v-model="data.url"
                            placeholder="Project URL"
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
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-6">
                                <label>Start Date</label>
                                <input
                                    type="month"
                                    v-model="data.start_date"
                                    placeholder="Start Date"
                                    class="d-block w-100 p-1"
                                />
                                <span
                                    class="text-danger"
                                    v-if="errors.start_date"
                                    >{{ errors.start_date[0] }}</span
                                >
                            </div>

                            <div class="col-6">
                                <label>End Date (or expected)</label>
                                <input
                                    type="month"
                                    v-model="data.end_date"
                                    placeholder="Start Date"
                                    class="d-block w-100 p-1"
                                />
                                <span
                                    class="text-danger"
                                    v-if="errors.end_date"
                                    >{{ errors.url[0] }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted p-3">
                    <div class="d-block">
                        <button
                            class="profile-main-btn mx-2 float-end"
                            @click="save()"
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

        <!--**** Projects ****-->
        <template
            v-if="
                projects != '' && isLoading == false && showProjectForm == false
            "
        >
            <div class="card">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Projects</h5>
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
                <div v-for="(project, index) in projects" :key="index">
                    <div class="card-body">
                        <!--**** For edit ****-->
                        <div class="card mb-2" v-if="editData.id == project.id">
                            <div class="card-header card-header-border p-3">
                                <div class="d-block">
                                    <div class="float-start">
                                        <h5>
                                            Edit Project
                                            {{ project.project_name }}
                                        </h5>
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
                                <div class="mb-2">
                                    <label>Project Name *</label>
                                    <Input
                                        type="text"
                                        v-model="editData.project_name"
                                        placeholder="Project Name"
                                        :ref="`projectName${project.id}`"
                                    />
                                    <span
                                        class="text-danger"
                                        v-if="errors.project_name"
                                        >{{ errors.project_name[0] }}</span
                                    >
                                </div>
                                <div class="mb-2">
                                    <label>Project Type *</label>
                                    <Input
                                        type="text"
                                        v-model="editData.project_type"
                                        placeholder="e.g. Mobile App / Website"
                                    />
                                    <span
                                        class="text-danger"
                                        v-if="errors.project_type"
                                        >{{ errors.project_type[0] }}</span
                                    >
                                </div>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Start Date</label>
                                            <input
                                                type="month"
                                                v-model="editData.start_date"
                                                placeholder="Start Date"
                                                class="d-block w-100 p-1"
                                            />
                                            <span
                                                class="text-danger"
                                                v-if="errors.start_date"
                                                >{{
                                                    errors.start_date[0]
                                                }}</span
                                            >
                                        </div>

                                        <div class="col-6">
                                            <label
                                                >End Date (or expected)</label
                                            >
                                            <input
                                                type="month"
                                                v-model="editData.end_date"
                                                placeholder="Start Date"
                                                class="d-block w-100 p-1"
                                            />
                                            <span
                                                class="text-danger"
                                                v-if="errors.end_date"
                                                >{{ errors.end_date[0] }}</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label>Project URL</label>
                                    <Input
                                        type="url"
                                        v-model="editData.project_url"
                                        placeholder="Project URL"
                                    />
                                    <span
                                        class="text-danger"
                                        v-if="errors.project_url"
                                        >{{ errors.project_url[0] }}</span
                                    >
                                </div>

                                <div class="mb-2">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control form-outline"
                                        v-model="editData.project_description"
                                        rows="4"
                                    ></textarea>
                                    <span
                                        class="text-danger"
                                        v-if="errors.project_description"
                                        >{{
                                            errors.project_description[0]
                                        }}</span
                                    >
                                </div>
                            </div>
                            <div class="card-footer text-muted p-3">
                                <div class="d-block">
                                    <button
                                        class="profile-main-btn mx-2 float-end"
                                        @click="updateProject()"
                                    >
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Save
                                    </button>
                                    <button
                                        class="profile-main-btn mx-2 float-end"
                                        @click="deleteProject()"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <div class="project-header">
                                <h4>{{ project.project_name }}</h4>
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
                                v-if="projects.length - 1 > index"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <!--**** loader ****-->
        <template v-if="isLoading == true">
            <div class="card mb-2">
                <div class="card-header p-3">
                    <div class="profile-info-skeleton">
                        <h5 />
                    </div>
                </div>

                <div class="card-body p-3 profile-info-skeleton">
                    <p />
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header p-3">
                    <div class="profile-info-skeleton">
                        <h5 />
                    </div>
                </div>

                <div class="card-body p-3 profile-info-skeleton">
                    <p />
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header p-3">
                    <div class="profile-info-skeleton">
                        <h5 />
                    </div>
                </div>

                <div class="card-body p-3 profile-info-skeleton">
                    <p />
                </div>
            </div>

            <div class="card mb-2">
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
    components: {},
    data() {
        return {
            showProjectForm: false,
            isLoading: true,
            errors: [],
            projects: [],
            user_id: -1,
            route_id: this.$route.params.id,

            data: {
                type: "",
                title: "",
                author_id: [],
                attachment: "",
                abstract: "",
                url: "",
                images: [],
                pdf: "",
                start_date: "",
                end_date: "",
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
        };
    },

    methods: {
        showForm() {
            this.showProjectForm = true;
        },
        async reset() {
            this.showProjectForm = false;
            this.editData.id = "";
            this.user_id = this.$route.params.id;
            this.data = {
                type: "",
                title: "",
                author_id: [],
                attachment: "",
                abstract: "",
                url: "",
                images: [],
                pdf: "",
                start_date: "",
                end_date: "",
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
            this.data.type = "Project";
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
                this.data.type = "";
                this.data.title = "";
                this.data.author_id = "";
                this.data.attachment = "";
                this.data.abstract = "";
                this.data.start_date = "";
                this.data.end_date = "";
                this.data.url = "";
                this.attachmentName = "";
                this.reset();
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
        editProject(index) {
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

        async updateProject() {
            // if (this.data.project_name.trim() == "")
            //     return this.e("Project Name is required");
            // if (this.data.project_type.trim() == "")
            //     return this.e("Project type is required");
            // if (this.data.start_date.trim() == "")
            //     return this.e("Start date is required");
            this.user_id = this.$route.params.id;
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                "/api/update_project",
                this.editData
            );
            if (res.status === 200) {
                this.s(res.data.msg);
                // this.msg = res.data.msg;
                this.errors = "";
                this.reset();
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

        async deleteProject() {
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                `/api/delete_project/${this.editData.id}`
            );

            if (res.status === 200) {
                this.s(res.data.msg);
                // this.reset();
                this.projects.splice(this.editData.index, 1);
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
    // async created() {
    //     this.token = window.Laravel.csrfToken;
    //     this.user_id = this.$route.params.id;

    //     const res = await this.callApi(
    //         "get",
    //         `/api/get_project/${this.user_id}`
    //     );
    //     if (res.status == 200) {
    //         this.projects = res.data;
    //     } else {
    //         this.swr();
    //     }

    //     this.isLoading = false;
    // },
    async created() {
        this.token = window.Laravel.csrfToken;
        this.user_id = this.$route.params.id;

        const res = await this.callApi("get", `/api/get_post/${this.user_id}`);
        const resuser = await this.callApi("get", `/api/get_all_user`);
        if (res.status == 200) {
            this.posts = res.data;
        }
        if (resuser.status == 200) {
            this.users = resuser.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>

<style scoped>
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
</style>
