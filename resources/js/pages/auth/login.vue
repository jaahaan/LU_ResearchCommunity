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

                <!-- Two Factor Form -->
                <div
                    class="col-md-6 my-md-auto justify-content-center"
                    v-if="!isLoggingBlock"
                >
                    <div class="container-fluid">
                        <div class="container-fluid rt col-10 p-5">
                            <h1 class="text-center mb-2">
                                Two Factor Authentication
                            </h1>
                            <div class="alert alert-dark" v-if="msg">
                                {{ msg }}
                            </div>

                            <div class="mb-2">
                                Enter OTP
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="data.twoFactorCode"
                                />
                                <span
                                    class="text-danger"
                                    v-if="errors.twoFactorCode"
                                    >{{ errors.twoFactorCode[0] }}</span
                                ><span class="text-danger" v-if="errmsg">{{
                                    errmsg
                                }}</span>
                            </div>

                            <div class="mb-2">
                                <button
                                    :class="[
                                        data.twoFactorCode
                                            ? ' main-btn-change col-12'
                                            : ' main-btn col-12',
                                        ' main-btn col-12',
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

                <!-- Login Form -->
                <div
                    class="col-md-6 my-md-auto justify-content-center"
                    v-else-if="isLoggingBlock"
                >
                    <div class="container-fluid">
                        <div class="container-fluid rt col-10 p-5">
                            <h1 class="p-3 text-center">Login</h1>
                            <!-- <div class="alert alert-dark" v-if="msg">
                                {{ msg }}
                            </div> -->

                            <div class="mb-2">
                                Email
                                <input
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
                                <input
                                    type="password"
                                    v-model="data.password"
                                    placeholder="Password"
                                />
                                <div class="d-block">
                                    <span
                                        class="w-full text-danger float-start"
                                        v-if="msg"
                                        >{{ msg }}
                                    </span>
                                    <span
                                        class="w-full text-danger float-start"
                                        v-if="errors.password"
                                        >{{ errors.password[0] }}
                                    </span>

                                    <router-link
                                        class="float-end"
                                        to="/forgot_password"
                                        >Forgot Password</router-link
                                    >
                                </div>
                            </div>

                            <div class="mb-2">
                                <button
                                    type="button"
                                    :class="[
                                        data.email && data.password
                                            ? ' main-btn-change col-12'
                                            : ' main-btn col-12',
                                        ' main-btn  col-12',
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
                twoFactorCode: "",
            },
            msg: null,
            errmsg: null,

            isLoggingBlock: true,
            isLogging: false,
            isSubmitting: false,
            errors: [],
            props: ["msg"],
        };
    },
    methods: {
        clearErrorMessage() {
            this.errmsg = [];
            this.errors = [];
        },
        async login() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            // if (this.data.password.trim() == "")
            //     return this.e("Password is required");
            this.clearErrorMessage();
            this.isLogging = true;

            //if we put await in front of it, it will be a response! The await keyword causes code to wait for that Promise to resolve. And whatever data is normally passed to your callback as an argument is instead returned. There is still an asynchronous AJAX call happening, but our code reads a bit more like synchronous code.
            const res = await this.callApi("post", "/login", this.data);

            if (res.status == 200) {
                // this.msg = res.data.msg;
                this.s(res.data.msg);

                window.location = "/";
                this.$router.go();
                this.errors = [];
                this.clearErrorMessage();

                // this.isLoggingBlock = false;
            } else {
                if (res.status == 401) {
                    this.msg = res.data.msg;
                    // this.e(res.data.msg);
                } else if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.errors = res.data.errors;
                        // this.e(res.data.errors[i][0]);
                    }
                }
                // else if (res.status == 402) {
                //     this.e(res.data.msg);
                //     this.$router.push(
                //         `/emailVerifyOtp?email=${this.data.email}`
                //     );
                // }
                else {
                    this.swr();
                }
            }
            this.isLogging = false;
        },

        async submit() {
            // if (this.data.otp.trim() == "") return this.e("OTP is required");
            this.isSubmitting = true;
            const res = await this.callApi(
                "post",
                "/submit_twoFactor_otp",
                this.data
            );

            if (res.status == 200) {
                this.s(res.data.msg);
                window.location = "/";
                this.$router.go();
                // window.location.reload();
                this.errors = [];

                //this.data.otp = "";
            } else {
                if (res.status == 401) {
                    this.errmsg = res.data.msg;
                    this.isLoggingBlock = false;
                } else if (res.status == 402) {
                    this.errmsg = res.data.msg;
                    this.isLoggingBlock = true;
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

    // created(){
    //     if(this.authInfo) this.$router.push('/')
    // }
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
