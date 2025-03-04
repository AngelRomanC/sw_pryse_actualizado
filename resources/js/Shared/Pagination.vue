<template>
    <div v-if="(total) > 1" class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
        <BaseLevel>
            <BaseButtons>
                <BaseButton v-for="page in total" :key="page" :active="page === currentPage" :label="page"
                    :href="links[page].url" @click="() => {
                        currentPage = page
                        isLoading = true
                    }"
                    :color="page === currentPage ? 'lightDark' : 'whiteDark'" small />
            </BaseButtons>
            <small> Página {{ currentPage }} de {{
                total
            }}</small>
        </BaseLevel>
    </div>

    <div class="vl-parent">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
    </div>
</template>

<script>
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { ref } from "vue";

export default {
    props: { links: Array, total: Number, currentPage: Number },
    components: {
        BaseLevel,
        BaseButtons,
        BaseButton,
        Loading
    },
    setup() {
        const isLoading = ref(false);

        return { isLoading }
    }
}
</script>

