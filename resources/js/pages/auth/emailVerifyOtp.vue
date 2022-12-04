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
                        <div class="container-fluid rt col-10 p-5">
                            <div class="alert alert-dark">
                                <p>We have sent an OTP to your email.</p>
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
export default {
    name: "forgot",
    data() {
        return {
            data: {
                otp: "",
                email: "",
            },
            isSubmitting: false,
            errors: [],
        };
    },
    methods: {
        async submit() {
            if (this.data.otp.trim() == "") return this.e("OTP is required");
            this.isSubmitting = true;
            const res = await this.callApi("post", "/verify_email", this.data);

            if (res.status == 200) {
                this.s(res.data.msg);
                // this.$store.commit("setVerifyEmail", this.data);
                this.$router.push("/home");
                //this.data.otp = "";
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
