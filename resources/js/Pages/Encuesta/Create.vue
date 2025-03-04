<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        materia:{ type: Object, required: true },
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
    setup(props) {
        const handleSubmit = () => {
            form.post(route('encuesta.store'));
        };

        const form = useForm({
            horario: '',
            profesores: '',
            tipo_proyecto: '',
            dificultad:'',
            periodo:'',
            estudiantes:'',
            materia: props.materia,
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
          
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Recursamiento">
                <FormControl v-model="form.materia.nombre" disabled   />
            </FormField>
            <FormField label="¿Hubo traslapes con otras asignaturas del curso ordinario durante el recursamiento?">
                <FormControl v-model="form.horario"  />
            </FormField>
            <FormField label="¿Cómo evaluarías la experiencia y calidad de los profesores que participaron en el recursamiento?">
                <FormControl v-model="form.profesores"  />
            </FormField>
            <FormField label="¿Se incluyeron proyectos finales durante el proceso de recursamiento?">   
                <FormControl v-model="form.tipo_proyecto"  />    
            </FormField>

            <FormField label="¿Cuál fue la dificultad del curso?"> 
                <FormControl v-model="form.dificultad" />   
            </FormField>

            <FormField label="¿Cómo fue la interacción con nuevos estudiantes de diferentes grupos durante el recursamiento?">
                <FormControl v-model="form.estudiantes"  />
            </FormField>
           
           
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
