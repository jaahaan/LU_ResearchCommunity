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
                            <h2 class="p-3 text-center">Forgot Password!!</h2>

                            <div class="alert alert-dark">
                                <p>
                                    Enter your email address and we will send an
                                    OTP to reset your password.
                                </p>
                            </div>

                            <div class="mb-2">
                                Email Address
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="data.email"
                                    placeholder="Email Address"
                                />
                                <span class="text-danger" v-if="errors.email">{{
                                    errors.email[0]
                                }}</span>
                            </div>

                            <div class="mb-2">
                                <button
                                    :class="[
                                        data.email
                                            ? ' main-btn-change col-12'
                                            : ' main-btn col-12',
                                        ' main-btn col-12',
                                    ]"
                                    @click="send"
                                    :disabled="isSending"
                                    :loading="isSending"
                                >
                                    {{ isSending ? "Sending" : "Send OTP" }}
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
                email: "",
            },
            isSending: false,
            errors: [],
        };
    },
    methods: {
        async send() {
            // if (this.data.email.trim() == "")
            //     return this.e("Email is required");
            this.isSending = true;
            const res = await this.callApi(
                "post",
                "/send_reset_password_otp",
                this.data
            );

            if (res.status == 200) {
                this.s(res.data.msg);
                this.$router.push(`/otp?email=${this.data.email}`);
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
            this.isSending = false;
        },
    },
};
</script>
