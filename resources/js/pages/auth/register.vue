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
                        <div class="text-center">
                            <button
                                class="btn btn-design m-auto cext-center col-5"
                                v-for="tab in tabs"
                                :key="tab"
                                @click="component = tab"
                            >
                                {{ tab }}
                            </button>
                        </div>
                        <component :is="component" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Teacher from "../../components/registerTeacher";
import Student from "../../components/registerStudent";

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

<style scoped>
.tab-exact-active {
    color: #c9af98 !important;
    background: #c9af98;
    border-left: 2px solid #c9af98 !important;
}
</style>
