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
                    <i class="lni lni-folder"></i> What's on your mind?
                </button>
            </div>
        </template>

        <!--****** Add Research form ******-->
        <template v-if="showResearchForm == true">
            <div class="card mb-2">
                <div class="card-header card-header-border p-3">
                    <div class="d-block">
                        <div class="float-start">
                            <h5>Create Post</h5>
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
                        <label>What's on your mind? </label>

                        <editor
                            :headers="{
                                'x-csrf-token': token,
                                'X-Requested-With': 'XMLHttpRequest',
                            }"
                            class="form-control form-outline"
                            ref="editor"
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"
                            :config="config"
                        />
                    </div>

                    <div class="mb-2">
                        <label>Mention</label>

                        <Select
                            filterable
                            multiple
                            placeholder="Select User"
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
            config: {},
            initData: null,
            data: {
                jsonData: null,
                author_id: [],
            },
            articleHTML: "",

            isEditingItem: false,
            attachmentName: "",
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
                `/api/get_post/${this.user_id}`
            );
            if (res.status == 200) {
                this.projects = res.data;
                this.errors = [];
            } else {
                this.swr();
            }

            this.isLoading = false;
        },
        async onSave(response) {
            var data = response;
            await this.outputHtml(data.blocks);
            this.data.post = this.articleHTML;
            this.data.jsonData = JSON.stringify(data);
            if (this.data.post.trim() == "") return this.e("Post is required");
            if (this.data.title.trim() == "")
                return this.e("Title is required");
            if (this.data.post_excerpt.trim() == "")
                return this.e("Post exerpt is required");
            if (this.data.metaDescription.trim() == "")
                return this.e("Meta description is required");
            if (!this.data.tag_id.length) return this.e("Tag is required");
            if (!this.data.category_id.length)
                return this.e("Category is required");
            this.isCreating = true;
            const res = await this.callApi(
                "post",
                "app/create-blog",
                this.data
            );
            if (res.status === 200) {
                this.s("Blog has been created successfully!");
                // redirect...
                this.$router.push("/blogs");
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isCreating = false;
        },

        async save() {
            this.$refs.editor.save();
        },
        outputHtml(articleObj) {
            articleObj.map((obj) => {
                switch (obj.type) {
                    case "paragraph":
                        this.articleHTML += this.makeParagraph(obj);
                        break;
                    case "image":
                        this.articleHTML += this.makeImage(obj);
                        break;
                    case "header":
                        this.articleHTML += this.makeHeader(obj);
                        break;
                    case "raw":
                        this.articleHTML += `<div class="ce-block">
					<div class="ce-block__content">
					<div class="ce-code">
						<code>${obj.data.html}</code>
					</div>
					</div>
				</div>\n`;
                        break;
                    case "code":
                        this.articleHTML += this.makeCode(obj);
                        break;
                    case "list":
                        this.articleHTML += this.makeList(obj);
                        break;
                    case "quote":
                        this.articleHTML += this.makeQuote(obj);
                        break;
                    case "warning":
                        this.articleHTML += this.makeWarning(obj);
                        break;
                    case "checklist":
                        this.articleHTML += this.makeChecklist(obj);
                        break;
                    case "embed":
                        this.articleHTML += this.makeEmbed(obj);
                        break;
                    case "delimeter":
                        this.articleHTML += this.makeDelimeter(obj);
                        break;
                    default:
                        return "";
                }
            });
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
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        this.user_id = this.$route.params.id;

        const res = await this.callApi("get", `/api/get_post/${this.user_id}`);
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
