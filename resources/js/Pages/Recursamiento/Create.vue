<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV4 from "@/components/FormControlV4.vue";

import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        usuarios: { type: Object, required: true },
        periodo: { type: Object, required: true },
        materia: { type: Object, required: true },

    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        FormControlV2,
        FormControlV3,
        FormControlV4,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
    setup() {
        const handleSubmit = () => {
            form.post(route('recursamiento.store'));
        };

        const form = useForm({
            materia_id: '',
            periodo_id: '',
            profesor_id: '',
            horarios:'',
            cupo:'',
            estatus: '',
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
         
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
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
                <FormControl v-model="form.cupo" type="number" placeholder="Cupo máximo de estudiantes" step="1" @keydown.prevent />
            </FormField>
               
            <select v-model="form.estatus" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
                <option disabled value="">Estatus</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
              </select>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                        label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
