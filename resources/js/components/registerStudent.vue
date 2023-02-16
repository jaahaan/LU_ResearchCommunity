<template>
    <div class="container-fluid col-10 p-3">
        <div class="alert alert-dark p-2" v-if="msg">{{ msg }}</div>
        <h1 class="text-center mb-3">Register As Student</h1>
        <div class="mb-2">
            <input type="text" v-model="data.name" placeholder="Name" />
            <span class="text-danger" v-if="errors.name">{{
                errors.name[0]
            }}</span>
        </div>
        <div class="mb-2">
            <input type="email" v-model="data.email" placeholder="Email" />
            <span class="text-danger" v-if="errors.email">{{
                errors.email[0]
            }}</span>
        </div>
        <div class="mb-2">
            <input
                type="password"
                v-model="data.password"
                placeholder="Password"
            />
            <span class="text-danger" v-if="errors.password">{{
                errors.password[0]
            }}</span>
        </div>
        <div class="mb-2">
            <input
                type="password"
                v-model="data.password_confirmation"
                placeholder="Comfirm Password"
            />
            <span class="text-danger" v-if="errors.password_confirmation">{{
                errors.password_confirmation[0]
            }}</span>
        </div>
        <div class="mb-2">
            <input type="number" v-model="data.batch" placeholder="Batch" />
            <span class="text-danger" v-if="errors.batch">{{
                errors.batch[0]
            }}</span>
        </div>
        <div class="mb-2">
            <Select v-model="data.department" placeholder="Department">
                <Option
                    v-for="(department, index) in departmentInfo"
                    :key="index"
                    :value="department.id"
                    >{{ department.department_name }}</Option
                >
            </Select>
            <span class="text-danger" v-if="errors.department">{{
                errors.department[0]
            }}</span>
        </div>
        <div class="mb-2">
            <button
                type="button"
                :class="[
                    data.name &&
                    data.email &&
                    data.password &&
                    data.password_confirmation &&
                    data.batch &&
                    data.department
                        ? ' main-btn-change col-12'
                        : ' main-btn col-12',
                    ' main-btn col-12',
                ]"
                @click="register"
                :disabled="isLoading"
                :loading="isLoading"
            >
                {{ isLoading ? "Registering.." : "Register" }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                batch: "",
                department: "",
            },
            isLoading: false,
            msg: "",
            errors: [],
        };
    },
    methods: {
        async register() {
            // if (this.data.name.trim() == "") return this.e("Name is required");
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.password.trim() == "")
            //     return this.e("Password is required");
            // if (this.data.password_confirmation.trim() == "")
            //     return this.e("Confirm Password is required");
            // if (
            //     this.data.password.trim() !==
            //     this.data.password_confirmation.trim()
            // )
            //     return this.e("Password Mismatch!!");
            // if (this.data.batch.trim() == "")
            //     return this.e("Batch is required");
            // if (this.data.department.trim() == "")
            //     return this.e("Department is required");
            this.isLoading = true;
            const res = await this.callApi(
                "post",
                "/api/register_s",
                this.data
            );
            if (res.status === 201) {
                this.msg = res.data.msg;
                let emailPassword = {
                    email: this.data.email,
                    password: this.data.password,
                };
                this.$store.commit("setUnauthorizedCredential", emailPassword);
                this.$router.push(`/auth/account-activation`);

                this.data.name = "";
                this.data.email = "";
                this.data.password = "";
                this.data.password_confirmation = "";
                this.data.batch = "";
                this.data.department = "";
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
    },
    async created() {},
};
</script>
<style scoped>
input {
    display: block;
    padding: 6px 15px;
    width: 100%;
    box-sizing: none;
    border: 1px solid #fff;
    border-radius: 5px;
    color: #555;
}
</style>
