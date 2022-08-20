<template>
    <div class="container-fluid card rt col-10 p-5">
        <div class="alert alert-dark" v-if="msg">{{ msg }}</div>
        <h2 class="text-center p-3">Register As Student</h2>
        <div class="mb-2">
            <Input type="text" v-model="data.name" placeholder="Name" />
        </div>
        <div class="mb-2">
            <Input type="email" v-model="data.email" placeholder="Email" />
        </div>
        <div class="mb-2">
            <Input
                type="password"
                v-model="data.password"
                placeholder="Password"
            />
        </div>
        <div class="mb-2">
            <Input
                type="password"
                v-model="data.password_confirmation"
                placeholder="Comfirm Password"
            />
        </div>
        <div class="mb-2">
            <Input type="number" v-model="data.batch" placeholder="Batch" />
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
                this.msg =
                    "Registered successfully. Check your email and verify link.";
                this.data.name = "";
                this.data.email = "";
                this.data.password = "";
                this.data.password_confirmation = "";
                this.data.batch = "";
                this.data.department = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.name) {
                        this.e(res.data.errors.name[0]);
                    }
                    if (res.data.errors.email) {
                        this.e(res.data.errors.email[0]);
                    }
                    if (res.data.errors.password) {
                        this.e(res.data.errors.password[0]);
                    }
                    if (res.data.errors.password_confirmation) {
                        this.e(res.data.errors.password_confirmation[0]);
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
            this.isLoading = false;
        },
    },
};
</script>
