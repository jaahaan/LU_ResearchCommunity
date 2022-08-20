<template>
    <div class="bg">
        <div class="container-fluid justify-content-center py-md-4 py-3">
            <div class="row">
                <div
                    class="col-md-6 my-md-auto text-center justify-content-center"
                >
                    <img
                        :src="'images/lurc.png'"
                        alt="img"
                        class="img-fluid scientific"
                    />
                </div>

                <div class="col-md-6 my-md-auto justify-content-center">
                    <div class="container-fluid">
                        <div class="container-fluid card rt col-10 p-5">
                            <h2 class="p-3 text-center">Reset Password</h2>
                            <div class="mb-2">
                                Email Address
                                <Input
                                    type="email"
                                    v-model="data.email"
                                    disabled
                                    placeholder="Email Address"
                                />
                                <span class="text-danger" v-if="errors.email">{{
                                    errors.email[0]
                                }}</span>
                            </div>
                            <div class="mb-2">
                                Enter New Password
                                <Input
                                    type="password"
                                    v-model="data.password"
                                    placeholder="Enter New Password"
                                />
                                <span
                                    class="w-full text-danger"
                                    v-if="errors.password"
                                    >{{ errors.password[0] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                Confirm New Password
                                <Input
                                    type="password"
                                    v-model="data.password_confirmation"
                                    placeholder="Confirm New Password"
                                />
                                <span
                                    class="w-full text-danger"
                                    v-if="errors.password_confirmation"
                                    >{{ errors.password[0] }}
                                </span>
                            </div>

                            <div class="mb-2">
                                <button
                                    :class="[
                                        data.email && data.password
                                            ? 'btn btn-design-change col-12'
                                            : 'btn btn-design col-12',
                                        'btn btn-design col-12',
                                    ]"
                                    @click="submit"
                                    :disabled="isSubmitting"
                                    :loading="isSubmitting"
                                >
                                    {{
                                        isSubmitting
                                            ? "Submitting..."
                                            : "Reset Password"
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "reset",
    data() {
        return {
            data: {
                email: "",
                password: "",
                password_confirmation: "",
                otp: "",
            },
            isSubmitting: false,
            errors: [],
        };
    },

    computed: {
        ...mapGetters({
            passwordReset: "passwordReset",
        }),
    },
    mounted() {
        this.data.email = this.passwordReset.email;
        this.data.otp = this.passwordReset.otp;
    },
    methods: {
        async submit() {
            if (this.data.email.trim() == "")
                return this.e("Email is required");
            if (this.data.password.trim() == "")
                return this.e("Password is required");
            if (this.data.password_confirmation.trim() == "")
                return this.e("Confirm Password is required");

            this.isSubmitting = true;
            const res = await this.callApi(
                "post",
                "/reset_password",
                this.data
            );

            if (res.status == 200) {
                this.s(res.data.msg);
                this.$router.push("/login");
                this.data.email = "";
                this.data.password = "";
                this.data.password_confirmation = "";
            } else {
                if (res.status == 401) {
                    this.e(res.data.msg);
                } else if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.errors = res.data.errors;
                        // this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isSubmitting = false;
        },
    },
};
</script>
