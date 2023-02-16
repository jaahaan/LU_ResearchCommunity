<template>
    <div class="bg">
        <div class="container-fluid justify-content-center py-md-4 py-3">
            <div class="row">
                <div
                    class="col-md-6 my-md-auto text-center justify-content-center"
                >
                    <img
                        :src="'/images/lurc.png'"
                        alt="img"
                        class="img-fluid scientific"
                    />
                </div>

                <div class="col-md-6 my-md-auto justify-content-center">
                    <div class="container-fluid">
                        <div class="container-fluid rt col-10 p-5">
                            <div class="alert alert-dark">
                                <p>We have sent an OTP to your email.</p>
                            </div>

                            <div class="mb-2">
                                Enter OTP
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="data.token"
                                />
                                <span class="text-danger" v-if="errors.token">{{
                                    errors.token[0]
                                }}</span>
                            </div>

                            <div class="mb-2">
                                <button
                                    :class="[
                                        data.token
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
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    middleware: "guest",
    data() {
        return {
            data: {
                token: "",
                email: "",
                password: "",
            },
            isSubmitting: false,
            errors: [],
        };
    },
    computed: {
        ...mapGetters({
            unauthorizedCredential: "unauthorizedCredential",
        }),
    },
    methods: {
        async submit() {
            if (this.data.token.trim() == "") return this.e("OTP is required");
            this.data.email = this.unauthorizedCredential.email;
            this.data.password = this.unauthorizedCredential.password;
            this.isSubmitting = true;
            const res = await this.callApi(
                "post",
                "/api/verify_email",
                this.data
            );

            if (res.status == 200) {
                this.$store.dispatch("setAuthInfo", res.data.user);
                this.$store.dispatch("setToken", res.data.token);
                this.setCookie("token", res.data.token);
                // window.location = "/home";
                this.$router.push("/home");
                this.s("You are logged In");
                //this.data.token = "";
            } else {
                if (res.status == 401) {
                    this.e(res.data.msg);
                }
                if (res.status == 402) {
                    this.msg = res.data.msg;
                    this.$router.push("/register");
                }
                if (res.status == 422) {
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
    async created() {
        console.log(this.$route.query.email);
        this.data.email = this.$route.query.email;
    },
};
</script>
