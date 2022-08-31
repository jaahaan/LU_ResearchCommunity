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
                <div
                    class="col-md-6 my-md-auto justify-content-center"
                    v-if="!isLoggingBlock"
                >
                    <div class="container-fluid">
                        <div class="container-fluid card rt col-10 p-5">
                            <h2 class="text-center mb-2">
                                Two Factor Authentication
                            </h2>
                            <div class="alert alert-dark" v-if="msg">
                                {{ msg }}
                            </div>

                            <div class="mb-2">
                                Enter OTP
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="data.otp"
                                />
                                <span class="text-danger" v-if="errors.otp">{{
                                    errors.otp[0]
                                }}</span>
                            </div>

                            <div class="mb-2">
                                <button
                                    :class="[
                                        data.otp
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
                                            : "Submit OTP"
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="col-md-6 my-md-auto justify-content-center"
                    v-else-if="isLoggingBlock"
                >
                    <div class="container-fluid">
                        <div class="container-fluid card rt col-10 p-5">
                            <h2 class="p-3 text-center">Login</h2>
                            <div class="alert alert-dark" v-if="msg">
                                {{ msg }}
                            </div>

                            <div class="mb-2">
                                Email
                                <Input
                                    type="email"
                                    v-model="data.email"
                                    placeholder="Email"
                                />
                                <span class="text-danger" v-if="errors.email">{{
                                    errors.email[0]
                                }}</span>
                            </div>

                            <div class="mb-2">
                                Password
                                <Input
                                    type="password"
                                    v-model="data.password"
                                    placeholder="Password"
                                />
                                <span
                                    class="w-full text-danger"
                                    v-if="errors.password"
                                    >{{ errors.password[0] }}
                                </span>
                                <router-link to="/forgot_password"
                                    >Forgot Password</router-link
                                >
                            </div>

                            <div class="mb-2">
                                <button
                                    type="button"
                                    :class="[
                                        data.email && data.password
                                            ? 'btn btn-design-change col-12'
                                            : 'btn btn-design col-12',
                                        'btn btn-design col-12',
                                    ]"
                                    @click="login"
                                    :disabled="isLogging"
                                    :loading="isLogging"
                                >
                                    {{ isLogging ? "Logging In.." : "Login" }}
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
export default {
    name: "login",
    data() {
        return {
            data: {
                email: "",
                password: "",
                otp: "",
            },
            msg: "",
            isLoggingBlock: true,
            isLogging: false,
            errors: [],
            submitted: false,
            isSubmitting: false,
        };
    },
    methods: {
        async login() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.password.trim() == "")
            //     return this.e("Password is required");
            this.isLogging = true;

            const res = await this.callApi("post", "/login", this.data);

            if (res.status == 200) {
                this.msg = res.data.msg;
                // window.location = "/";
                this.isLoggingBlock = false;
            } else {
                if (res.status == 401) {
                    this.e(res.data.msg);
                } else if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.errors = res.data.errors;
                        // this.e(res.data.errors[i][0]);
                    }
                } else if (res.status == 402) {
                    this.e(res.data.msg);
                    this.$router.push(
                        `/emailVerifyOtp?email=${this.data.email}`
                    );
                } else {
                    this.swr();
                }
            }
            this.isLogging = false;
        },

        async submit() {
            if (this.data.otp.trim() == "") return this.e("OTP is required");
            this.isSubmitting = true;
            const res = await this.callApi(
                "post",
                "/submit_twoFactor_otp",
                this.data
            );

            if (res.status == 200) {
                this.s(res.data.msg);
                window.location = "/";

                //this.data.otp = "";
            } else {
                if (res.status == 401) {
                    this.msg = res.data.msg;
                    // window.location = "/";
                    this.isLoggingBlock = true;
                }
                if (res.status == 402) {
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
