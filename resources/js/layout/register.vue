<template>
    <div class="bg">
        <div class="container-fluid justify-content-center py-md-4 py-3">
            <div class="row">
                <div
                    class="col-md-6 my-md-auto text-center justify-content-center"
                >
                    <div class="container-fluid">
                        <button
                            class="btn btn-design m-auto cext-center col-5"
                            v-for="tab in tabs"
                            :key="tab"
                            @click="component = tab"
                        >
                            {{ tab }}
                        </button>
                        <component :is="component" />
                    </div>
                </div>

                <div
                    class="col-md-6 my-md-auto text-center justify-content-center"
                >
                    <img
                        :src="'images/lurc.png'"
                        alt="img"
                        class="img-fluid scientific"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Teacher from "../pages/register_teacher";
import Student from "../pages/register_student";

export default {
    components: {
        Teacher,
        Student,
    },
    data() {
        return {
            tabs: ["Teacher", "Student"],
            component: "Teacher",
        };
    },
};
</script>

<style></style>
