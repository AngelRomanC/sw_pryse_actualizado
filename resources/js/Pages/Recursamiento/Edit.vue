<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV4 from "@/components/FormControlV4.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'Recursamiento','periodo','materia','usuarios','profesor','routeName']);
const form = useForm({
    ...props.Recursamiento,
    profesor_id: props.profesor
   
});


const guardar = () => {
    form.put(route("recursamiento.update", props.Recursamiento.id));
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <Link :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </Link>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField >
                <FormControlV4  v-model="form.materia_id" :showOption="name" :options="materia"/>
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
            <FormField >
                <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
            </FormField>
            <FormField >
                <FormControl v-model="form.horarios" placeholder="horarios" />
            </FormField>
            <FormField >
                <FormControl v-model="form.cupo" placeholder="Cupo maximo de estudiantes" />
            </FormField>
            <select v-model="form.estatus" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
                <option disabled value="">Estatus</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
              </select>
          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

