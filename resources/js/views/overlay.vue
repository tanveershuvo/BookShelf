<template>
    <div class="text-center">
        <v-overlay
            absolute = "true"
            opacity = "0.5"
            v-if="isLoading">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
export default {
    name: "overlay",
    data: () => ({

    }),
    computed: {
        isLoading:function(){
            return this.$store.getters.GET_LOADING
        }
    },
}

</script>

<style scoped>

</style>
