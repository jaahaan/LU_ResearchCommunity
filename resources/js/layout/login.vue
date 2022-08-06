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
                    class="col-md-6 my-md-auto text-center justify-content-center"
                >
                    <div class="container-fluid">
                        <div class="container-fluid card rt col-10 p-5">
                            <h1 class="text-center p-3">Login</h1>

                            <div class="mb-2">
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
                                <Input
                                    type="password"
                                    v-model="data.password"
                                    placeholder="Password"
                                />
                                <span
                                    class="w-full text-danger"
                                    v-if="errors.password"
                                    >{{ errors.password[0] }}</span
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
            },
            isLogging: false,
            errors: [],
        };
    },
    methods: {
        async login() {
            if (this.data.email.trim() == "")
                return this.e("Email is required");
            if (this.data.password.trim() == "")
                return this.e("Password is required");
            this.isLogging = true;

            const res = await this.callApi("post", "login", this.data);

            if (res.status == 200) {
                this.s(res.data.msg);
                window.location = "/";
                // this.data.email = "";
                // this.data.password = "";
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
            this.isLogging = false;
        },
    },
};
</script>
