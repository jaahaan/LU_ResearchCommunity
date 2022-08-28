<template>
    <div class="container-fluid card rt col-10 p-5">
        <div class="alert alert-dark" v-if="msg">{{ msg }}</div>
        <h2 class="text-center p-3">Register As Student</h2>
        <div class="mb-2">
            <Input type="text" v-model="data.name" placeholder="Name" />
            <span class="text-danger" v-if="errors.name">{{
                errors.name[0]
            }}</span>
        </div>
        <div class="mb-2">
            <Input type="email" v-model="data.email" placeholder="Email" />
            <span class="text-danger" v-if="errors.email">{{
                errors.email[0]
            }}</span>
        </div>
        <div class="mb-2">
            <Input
                type="password"
                v-model="data.password"
                placeholder="Password"
            />
            <span class="text-danger" v-if="errors.password">{{
                errors.password[0]
            }}</span>
        </div>
        <div class="mb-2">
            <Input
                type="password"
                v-model="data.password_confirmation"
                placeholder="Comfirm Password"
            />
            <span class="text-danger" v-if="errors.password_confirmation">{{
                errors.password_confirmation[0]
            }}</span>
        </div>
        <div class="mb-2">
            <Input type="number" v-model="data.batch" placeholder="Batch" />
            <span class="text-danger" v-if="errors.batch">{{
                errors.batch[0]
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
                    data.name &&
                    data.email &&
                    data.password &&
                    data.password_confirmation &&
                    data.batch &&
                    data.department
                        ? 'btn btn-design-change col-12'
                        : 'btn btn-design col-12',
                    'btn btn-design col-12',
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
            if (this.data.name.trim() == "") return this.e("Name is required");
            if (this.data.email.trim() == "")
                return this.e("Email is required");
            if (this.data.password.trim() == "")
                return this.e("Password is required");
            if (this.data.password_confirmation.trim() == "")
                return this.e("Confirm Password is required");
            if (
                this.data.password.trim() !==
                this.data.password_confirmation.trim()
            )
                return this.e("Password Mismatch!!");
            if (this.data.batch.trim() == "")
                return this.e("Batch is required");
            if (this.data.department.trim() == "")
                return this.e("Department is required");
            this.isLoading = true;
            const res = await this.callApi("post", "/register_s", this.data);
            if (res.status === 201) {
                this.msg = res.data.msg;
                this.$router.push(`/emailVerifyOtp?email=${this.data.email}`);

                this.data.name = "";
                this.data.email = "";
                this.data.password = "";
                this.data.password_confirmation = "";
                this.data.batch = "";
                this.data.department = "";
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
};
</script>
