<template>
    <div class="container mt-3 col-md-9">
        <section class="tab-section">
            <div class="overview-tab">
                <div class="overview-tab--details">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-2">
                                <h5 class="card-header">Comments</h5>
                                <div class="card-body">
                                    <textarea
                                        v-model="data.comment"
                                        class="form-control form-outline"
                                        rows="5"
                                        placeholder="Add a comment"
                                        autofocus
                                    ></textarea>
                                    <button
                                        class="main-btn mt-3 float-end"
                                        @click="addComment"
                                    >
                                        Add Comment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            isLoading: true,
            data: {
                comment: "",
            },
        };
    },
    methods: {},
    async created() {},
};
</script>
