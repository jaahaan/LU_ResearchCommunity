<template>
    <div class="mt-2">
        <div class="card mb-2 p-3" v-if="authUser.id == this.$route.params.id">
            <button class="add_new_card" v-on:click="showSidebar()">
                <i class="lni lni-pencil-alt"></i> What's on your mind?
            </button>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {};
    },
};
</script>

<style></style>
