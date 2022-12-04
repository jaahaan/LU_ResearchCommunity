<template>
    <div>
        <section class="container">
            <div class="teacher-section">
                <div class="teacher-section--table">
                    <div class="d-block pt-5 pb-5">
                        <h4 class="float-start">Faculty Members</h4>
                        <button
                            class="main-btn float-end"
                            @click="addTeacherButton"
                        >
                            Add New Member
                        </button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Department</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(teacher, index) in teachersInfo"
                                :key="index"
                            >
                                <template v-if="editObj.id == teacher.id">
                                    <td>
                                        <input
                                            type="email"
                                            v-model="editObj.email"
                                            placeholder="Email"
                                            :ref="`teacher${teacher.id}`"
                                        />
                                        <span
                                            class="text-danger"
                                            v-if="errors.email"
                                            >{{ errors.email[0] }}</span
                                        >
                                    </td>
                                    <td>
                                        <Select
                                            v-model="editObj.designation"
                                            placeholder="Designation"
                                        >
                                            <Option value="Head">Head</Option>
                                            <Option value="Professor"
                                                >Professor</Option
                                            >
                                            <Option value="Associate Professor"
                                                >Associate Professor</Option
                                            >
                                            <Option value="Assistant Professor"
                                                >Assistant Professor</Option
                                            >
                                            <Option value="Lecturer"
                                                >Lecturer</Option
                                            >
                                        </Select>
                                        <span
                                            class="text-danger"
                                            v-if="errors.designation"
                                            >{{ errors.designation[0] }}</span
                                        >
                                    </td>
                                    <td>
                                        <Select
                                            v-model="editObj.department"
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
                                        <i
                                            class="fa-solid fa-square-check"
                                            @click="updateTeacher()"
                                        ></i>
                                        <i
                                            class="fa-solid fa-xmark"
                                            @click="reset()"
                                        ></i>
                                    </td>
                                </template>
                                <template v-else>
                                    <td>{{ teacher.email }}</td>
                                    <td>{{ teacher.designation }}</td>
                                    <td>{{ teacher.department }}</td>
                                    <td>
                                        <i
                                            class="fa-solid fa-pen-to-square"
                                            @click="showEdit(index)"
                                        ></i>
                                        <i
                                            class="lni lni-trash-can"
                                            @click="showRemove(index)"
                                        ></i>
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <Modal v-model="addTeacherModal" width="400">
            <p slot="header" style="color: #369; text-align: center">
                <Icon type="plus"></Icon>
                <span> Add New Photo with details</span>
            </p>
            <div style="">
                <Form>
                    <Row :gutter="24">
                        <Col span="24">
                            <FormItem
                                label="Email"
                                :error="errorMessages.email"
                                :required="true"
                            >
                                <Input
                                    type="text"
                                    placeholder="email"
                                    v-model="formValue.email"
                                ></Input>
                            </FormItem>
                        </Col>
                        <Col span="24">
                            <FormItem
                                label="Designation"
                                :error="errorMessages.designation"
                                :required="true"
                            >
                                <Select
                                    v-model="formValue.designation"
                                    placeholder="Select Designation"
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
                                <!-- <span
                                    class="text-danger"
                                    v-if="errors.designation"
                                    >{{ errors.designation[0] }}</span
                                > -->
                            </FormItem>
                        </Col>
                        <Col span="24">
                            <FormItem
                                label="Department"
                                :error="errorMessages.department"
                                :required="true"
                            >
                                <Select
                                    v-model="formValue.department"
                                    placeholder="Department"
                                >
                                    <Option value="CSE">CSE</Option>
                                    <Option value="EEE">EEE</Option>
                                    <Option value="ARCH">ARCH</Option>
                                    <Option value="CE">CE</Option>
                                    <Option value="BuA">BuA</Option>
                                    <Option value="ENG">ENG</Option>
                                </Select>
                                <!-- <span
                                    class="text-danger"
                                    v-if="errors.department"
                                    >{{ errors.department[0] }}</span
                                > -->
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
            <div slot="footer">
                <Button @click="addTeacherModal = false"> Cancel</Button>
                <Button type="primary" :loading="loading" @click="addTeacher">
                    <span v-if="!loading">Add</span>
                    <span v-else>Adding...</span>
                </Button>
            </div>
        </Modal>

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
                    @click="remove"
                >
                    <span v-if="!loading">Delete</span>
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
            errors: [],
            search: "",
            height: 30,
            addTeacherModal: false,
            editModal: false,
            visible: false,
            loading: false,
            sending: false,
            isCollapsed: false,
            formValue: {
                email: "",
                designation: "",
                department: "",
            },
            errorMessages: {
                email: "",
                designation: "",
                department: "",
            },
            listMethod: true,
            editObj: {
                id: null,
                email: "",
                designation: "",
                department: "",
            },
            editErrorMessages: {
                id: null,
                email: "",
                designation: "",
                department: "",
            },
            teachersInfo: [],
            UpdateValue: {
                indexNumber: null,
                id: null,
                email: "",
                designation: "",
                department: "",
            },
            deleteValue: {
                id: null,
                indexNumber: null,
                email: "",
            },
            deleteModal: false,
        };
    },
    // async mounted() {
    //     const res = await this.callApi("get", "/api/teachers");

    //     if (res.status == 200) {
    //         this.teachersInfo = res.data;
    //     } else {
    //         this.swr();
    //     }

    //     this.isLoading = false;
    // },
    computed: {
        options() {
            return {
                height: this.height,
                displayValue: false,
            };
        },

        rotateIcon() {
            return ["menu-icon", this.isCollapsed ? "rotate-icon" : ""];
        },
        menuitemClasses() {
            return ["menu-item", this.isCollapsed ? "collapsed-menu" : ""];
        },
    },
    methods: {
        addTeacherButton() {
            this.addTeacherModal = true;
        },
        clearErrorMessage() {
            (this.editErrorMessages = {
                id: null,
                email: "",
                designation: "",
                department: "",
            }),
                (this.errorMessages = {
                    email: "",
                    designation: "",
                    department: "",
                });
        },
        async addTeacher() {
            let validation = true;
            this.clearErrorMessage();

            if (this.formValue.email.trim() == "") {
                this.errorMessages.email = "Email is required!";
                validation = false;
            }
            if (this.formValue.designation.trim() == "") {
                this.errorMessages.designation = "Designation is required!";
                validation = false;
            }
            if (validation == false)
                return this.$Message.error("Validation Failed!");
            console.log("Failed");
            this.loading = true;
            console.log(this.formValue);
            try {
                let { data } = await axios({
                    method: "post",
                    url: "/api/teachers",
                    data: this.formValue,
                });
                this.teachersInfo.unshift(data);
                this.s();

                this.loading = false;
                this.addTeacherModal = false;
                this.imageUrl = "";
                // this.formValue=null
            } catch (e) {
                this.loading = false;
                this.swr();
            }
        },
        showEdit(index) {
            if (this.teachersInfo[index].id) {
                this.editObj.id = this.teachersInfo[index].id;
                this.editObj.email = this.teachersInfo[index].email;
                this.editObj.designation = this.teachersInfo[index].designation;
                this.editObj.department = this.teachersInfo[index].department;

                this.$nextTick(() => {
                    if (this.$refs["teacher" + this.teachersInfo[index].id]) {
                        this.$refs[
                            "teacher" + this.teachersInfo[index].id
                        ][0].focus();
                    }
                });
            }
        },
        async edit() {
            let validation = true;
            this.clearErrorMessage();
            if (this.editObj.email.trim() == "") {
                this.editErrorMessages.email = "Email is required!";
                validation = false;
            }
            if (validation == false)
                return this.$Message.error("Validation Failed!");

            this.sending = true;
            try {
                let { data } = await axios({
                    method: "post",
                    url: "/api/teachers_update",
                    data: this.editObj,
                });
                this.teachersInfo[this.UpdateValue.indexNumber].email =
                    data.email;
                this.teachersInfo[this.UpdateValue.indexNumber].designation =
                    data.designation;
                this.teachersInfo[this.UpdateValue.indexNumber].department =
                    data.department;
                this.s();

                this.sending = false;
                this.editModal = false;
            } catch (e) {
                this.sending = false;
                this.editModal = false;
                this.e("Oops!", "Something went wrong, please try again!");
            }
        },
        showRemove(index) {
            this.deleteValue.email = this.teachersInfo[index].email;
            this.deleteValue.id = this.teachersInfo[index].id;
            console.log(this.deleteValue.id);
            this.deleteValue.indexNumber = index;
            this.deleteModal = true;
        },
        async remove(index) {
            let ob = {
                id: this.deleteValue.id,
            };

            this.sending = true;
            const response = await this.callApi(
                "post",
                "/api/teachers_del",
                ob
            );
            if (response.status == 200) {
                this.teachersInfo.splice(this.deleteValue.indexNumber, 1);
                this.s();
                this.deleteModal = false;
                this.sending = false;
            } else {
                this.sending = false;
                // this.editModal=false
                this.deleteModal = false;
                this.swr();
            }
        },

        async getTeachers() {
            this.loading = true;
            const res = await this.callApi("get", "/api/teachers");
            if (res.status == 200) {
                this.teachersInfo = res.data.data;
            } else {
                this.swr();
            }
            this.loading = false;
        },
        async reset() {
            this.editObj.id = "";
            this.getTeachers();
        },
        async storeTeachers() {
            this.ls();
            const res = await this.callApi("post", "/api/teachers");
            if (res.status == 201 || res.status == 200) {
                this.s();
                this.getTeachers();
            }
        },
    },

    async created() {
        this.getTeachers();
    },
};
</script>
<style scoped>
input {
    display: block;
    padding: 4px;
    border-bottom: 0.5px solid #845007;
    border-radius: 5px;
    color: #555;
    width: 100%;
    text-align: center;
}

.edited {
    color: #198754;
}
.notEdited {
    color: #212529;
}
</style>
