<template>
    <div>
        <div class="container-fluid card rt col-sm-12 col-md-6 mt-3">
            <div class="alert alert-dark mt-3" v-if="msg">{{ msg }}</div>
            <h4 class="text-center p-3">Add Teacher</h4>
            <div class="mb-2">
                <input type="email" v-model="data.email" placeholder="Email" />
                <span class="text-danger" v-if="errors.email">{{
                    errors.email[0]
                }}</span>
            </div>

            <div class="mb-2">
                <Select v-model="data.designation" placeholder="Designation">
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
                <Select v-model="data.department" placeholder="Department">
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
            <div class="mb-2">
                <button
                    type="button"
                    :class="[
                        data.email && data.designation && data.department
                            ? 'btn btn-design-change col-12'
                            : 'btn btn-design col-12',
                        'btn btn-design col-12',
                    ]"
                    @click="save"
                    :disabled="isLoading"
                    :loading="isLoading"
                >
                    {{ isLoading ? "Saving.." : "Save" }}
                </button>
            </div>
        </div>
        <div class="container-fluid card rt p-4 col-sm-12 col-md-6 mt-3 mb-3">
            <h4 class="text-center p-2">Teachers List</h4>

            <table class="table alert-dark">
                <thead>
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Department</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(teacher, index) in teachersInfo" :key="index">
                        <template v-if="editData.edit_id == teacher.id">
                            <td>
                                <input
                                    type="email"
                                    v-model="editData.email"
                                    placeholder="Email"
                                    :ref="`teacher${teacher.id}`"
                                />
                                <span class="text-danger" v-if="errors.email">{{
                                    errors.email[0]
                                }}</span>
                            </td>
                            <td>
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
                                <span
                                    class="text-danger"
                                    v-if="errors.designation"
                                    >{{ errors.designation[0] }}</span
                                >
                            </td>
                            <td>
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
                                <span
                                    class="text-danger"
                                    v-if="errors.department"
                                    >{{ errors.department[0] }}</span
                                >
                            </td>
                            <td class="text-center">
                                <button
                                    :class="[
                                        editData.email == teacher.email ||
                                        editData.designation ==
                                            teacher.designation ||
                                        editData.department ==
                                            teacher.department
                                            ? 'notEdited'
                                            : 'edited',
                                        'btn',
                                    ]"
                                    @click="updateTeacher()"
                                >
                                    <i class="fa-solid fa-square-check"></i>
                                </button>
                                <button
                                    class="btn btn-sm text-danger"
                                    @click="reset()"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </td>
                        </template>
                        <template v-else>
                            <td>{{ teacher.email }}</td>
                            <td>{{ teacher.designation }}</td>
                            <td>{{ teacher.department }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm text-info"
                                    @click="editTeacher(index)"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm text-danger"
                                    @click="showDeleteModal(index)"
                                >
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal v-model="deleteModal" width="360">
            <p slot="header" style="color: #f60; text-align: center">
                <Icon type="close"></Icon>
                <span> Delete {{ deleteValue.email }}</span>
            </p>
            <div style="text-align: center">
                Are you sure you want delete {{ deleteValue.email }}
            </div>
            <div slot="footer">
                <Button
                    type="error"
                    size="large"
                    long
                    :loading="sending"
                    @click="deleteTeacher"
                >
                    <span v-if="!sending">Delete</span>
                    <span v-else>Deleting...</span>
                </Button>
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teachersInfo: "",
            data: {
                email: "",
                designation: "",
                department: "",
            },
            editData: {
                email: "",
                designation: "",
                department: "",
                edit_id: "",
                edit_index: "",
            },
            deleteValue: {
                id: null,
                indexNumber: null,
                email: "",
            },
            deleteModal: false,
            isLoading: false,
            sending: false,
            msg: "",
            errors: [],
        };
    },
    async mounted() {
        const res = await this.callApi("get", "/api/teachers");

        if (res.status == 200) {
            this.teachersInfo = res.data;
        } else {
            this.swr();
        }

        this.isLoading = false;
    },
    methods: {
        async save() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.designation.trim() == "")
            //     return this.e("Designation is required");
            // if (this.data.department.trim() == "")
            //     return this.e("Department is required");
            this.isLoading = true;
            const res = await this.callApi("post", "/api/teachers", this.data);

            if (res.status === 201) {
                this.msg = res.data.msg;
                this.data.email = "";
                this.data.designation = "";
                this.data.department = "";
                this.reset();
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

        editTeacher(index) {
            if (this.teachersInfo[index].id) {
                this.editData.email = this.teachersInfo[index].email;
                this.editData.designation =
                    this.teachersInfo[index].designation;
                this.editData.department = this.teachersInfo[index].department;
                this.editData.edit_id = this.teachersInfo[index].id;
                this.editData.edit_index = index;
                this.$nextTick(() => {
                    if (this.$refs["teacher" + this.teachersInfo[index].id]) {
                        this.$refs[
                            "teacher" + this.teachersInfo[index].id
                        ][0].focus();
                    }
                });
            }
        },
        async updateTeacher() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.designation.trim() == "")
            //     return this.e("Designation is required");
            // if (this.data.department.trim() == "")
            //     return this.e("Department is required");
            this.isLoading = true;
            const res = await this.callApi(
                "post",
                "/api/teachers",
                this.editData
            );

            if (res.status === 200) {
                this.msg = res.data.msg;
                this.reset();
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

        showDeleteModal(index) {
            this.deleteValue.email = this.teachersInfo[index].email;
            this.deleteValue.id = this.teachersInfo[index].id;
            console.log(this.deleteValue.id);
            this.deleteValue.indexNumber = index;
            this.deleteModal = true;
        },
        async deleteTeacher(index) {
            let ob = {
                id: this.deleteValue.id,
            };

            this.sending = true;
            const response = await this.callApi("post", "/api/teachers", ob);
            if (response.status == 200) {
                this.teachersInfo.splice(this.deleteValue.indexNumber, 1);
                this.s("Teacher information has been deleted successfully!");
                this.deleteModal = false;
                this.sending = false;
            } else {
                this.sending = false;
                this.deleteModal = false;
                this.swr();
            }
        },
        async reset() {
            this.editData.edit_id = "";
            this.editData.edit_index = "";
            this.index = "";
            const res = await this.callApi("get", "/api/teachers");

            if (res.status == 200) {
                this.teachersInfo = res.data;
            } else {
                this.swr();
            }

            this.isLoading = false;
        },
    },

    // async created() {
    //     const res = await this.callApi("get", "/api/teachers");

    //     if (res.status == 200) {
    //         this.teachersInfo = res.data;
    //     } else {
    //         this.swr();
    //     }

    //     this.isLoading = false;
    // },
};
</script>
<style scoped>
input {
    display: block;
    padding: 4px;
    width: 100%;
    box-sizing: none;
    border: 1px solid #845007;
    border-radius: 5px;
    color: #555;
}

.edited {
    color: #198754;
}
.notEdited {
    color: #212529;
}
</style>
