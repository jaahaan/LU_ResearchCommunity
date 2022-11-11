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
                        <Select
                            v-model="data.publication_type"
                            placeholder="Select Type"
                        >
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
                        <span
                            class="text-danger"
                            v-if="errors.publication_type"
                            >{{ errors.publication_type[0] }}</span
                        >
                    </div>

                    <div class="mb-2">
                        <label>Title *</label>
                        <Input
                            type="text"
                            v-model="data.publication_title"
                            placeholder="Project Name"
                        />
                        <span
                            class="text-danger"
                            v-if="errors.publication_title"
                            >{{ errors.publication_title[0] }}</span
                        >
                    </div>

                    <div class="mb-2">
                        <label>Abstract</label>
                        <textarea
                            class="form-control form-outline"
                            v-model="data.publication_abstract"
                            rows="4"
                        ></textarea>
                        <span
                            class="text-danger"
                            v-if="errors.publication_abstract"
                            >{{ errors.publication_abstract[0] }}</span
                        >
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
                                    >{{ errors.end_date[0] }}</span
                                >
                            </div>
                        </div>
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
                </div>
                <div class="card-footer text-muted p-3">
                    <div class="d-block">
                        <button
                            class="profile-main-btn mx-2 float-end"
                            @click="saveResearch()"
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
        <!-- <template
            v-if="
                researches != '' &&
                isLoading == false &&
                showProjectForm == false
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
                <div v-for="(research, index) in researches" :key="index">
                    <div class="card-body">
                        **** For edit ****
                        <div class="card mb-2" v-if="editData.id == project.id">
                            <div class="card-header card-header-border p-3">
                                <div class="d-block">
                                    <div class="float-start">
                                        <h5>
                                            Edit
                                            {{ research.publication_type }}
                                            {{ project.publication_name }}
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
                                        v-model="editData.publication_url"
                                        placeholder="Project URL"
                                    />
                                    <span
                                        class="text-danger"
                                        v-if="errors.publication_url"
                                        >{{ errors.publication_url[0] }}</span
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
                                v-if="researches.length - 1 > index"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template> -->

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
                publication_type: "",
                publication_title: "",
                author_id: "",
                publication_abstract: "",
                start_date: "",
                end_date: "",
                publication_url: "",
            },
            editData: {
                user_id: "",
                project_name: "",
                project_type: "",
                start_date: "",
                end_date: "",
                project_url: "",
                project_description: "",
                id: "",
                index: "",
            },
        };
    },
    methods: {
        showForm() {
            this.showResearchForm = true;
        },
        async reset() {
            this.showResearchForm = false;
            this.editData.id = "";
            this.user_id = this.$route.params.id;

            const res = await this.callApi(
                "get",
                `/api/get_research/${this.user_id}`
            );
            if (res.status == 200) {
                this.projects = res.data;
            } else {
                this.swr();
            }

            this.isLoading = false;
        },

        async saveResearch() {
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
                `/api/save_research/${this.user_id}`,
                this.data
            );
            this.isLoading = true;
            if (res.status === 200) {
                this.s(res.data.msg);
                // this.msg = res.data.msg;
                // this.data.project_name = "";
                // this.data.project_type = "";
                // this.data.start_date = "";
                // this.data.end_date = "";
                // this.data.project_url = "";
                // this.data.project_description = "";
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

        editResearch(index) {
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

        async updateResearch() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.designation.trim() == "")
            //     return this.e("Designation is required");
            // if (this.data.department.trim() == "")
            //     return this.e("Department is required");
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                "/api/update_research",
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
        async deleteResearch() {
            this.isLoading = true;

            const res = await this.callApi(
                "post",
                `/api/delete_research/${this.editData.id}`
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

        const res = await this.callApi(
            "get",
            `/api/get_research/${this.user_id}`
        );
        const resuser = await this.callApi("get", `/api/get_all_user`);
        if (resuser.status == 200) {
            this.users = resuser.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
};
</script>

<style></style>
