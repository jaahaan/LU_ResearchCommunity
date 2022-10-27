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
                                <span class="alert-danger" v-if="errors.otp">{{
                                    errors.otp[0]
                                }}</span>
                                <span class="alert-danger" v-if="errors.otp">{{
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                otp: "",
                email: "",
            },
            isSubmitting: false,
            errors: [],
            msg: "",
        };
    },
    methods: {
        async submit() {
            if (this.data.otp.trim() == "") return this.e("OTP is required");
            this.isSubmitting = true;
            const res = await this.callApi(
                "post",
                "/submit_reset_password_otp",
                this.data
            );

            if (res.status == 200) {
                this.msg = res.data.msg;
                this.$store.commit("setPasswordReset", this.data);
                this.$router.push("/reset_password");
                //this.data.otp = "";
            } else {
                if (res.status == 401) {
                    this.msg = res.data.msg;
                }
                if (res.status == 402) {
                    this.msg = res.data.msg;
                    this.$router.push("/forgot");
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
    async created() {
        console.log(this.$route.query.email);
        this.data.email = this.$route.query.email;
    },
};
</script>
