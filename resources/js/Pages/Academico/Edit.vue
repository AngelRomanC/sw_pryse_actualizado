<script setup>
import { ref, defineProps, watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV6 from "@/components/FormControlV6.vue";
import Swal from 'sweetalert2';
import { mdiBallotOutline } from "@mdi/js";
const props = defineProps(['titulo', 'Academico', 'respuestas', 'usuarios','grupo' ,'preguntas','periodo', 'routeName', 'profesor']);


const form = useForm({
    ...props.Academico,
    ...props.profesor,
    ...props.grupo,
    respuestas: {},
    profesor_id: props.profesor,
});



const handleSubmit = () => {
    updateFormWithWatchData();
    console.log('Datos del formulario:', form);
    form.put(route("academico.update", { academico: form, respuestas: Object.values(form.respuestas) }));
};

watch(
    () => form,
    (newValue) => {
        console.log('form:', newValue);
    },
    { deep: true }
);

watch(
    () => props.respuestas,
    (newValue) => {
        console.log('respuestas:', newValue);
    },
    { deep: true }
);
onMounted(() => {
    updateFormWithWatchData();
});
function updateFormWithWatchData() {
    form.respuestas = {};
    props.respuestas.forEach(respuesta => {
        form.respuestas[respuesta.pregunta.id] = respuesta;
    });

}
</script>
<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            
        </SectionTitleLineWithButton>
       
        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Matricula">
                <FormControl v-model="form.matricula" placeholder="Matricula" />
            </FormField>
            <FormField >
                <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
            </FormField>
            <FormField>
                <FormControlV2 v-model="form.profesor_id" :showOption="name" :options="usuarios" />
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
            <FormField label="Materia a recursar">
                <FormControl v-model="form.materia_recursar" placeholder="materia a recursar" />
            </FormField>
            <FormField label="Análisis académico individual">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <p style="font-size: 20px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p>
                    <ul>
                        <li v-for="respuestaForm in respuestas.filter(item => item.pregunta.id === pregunta.id)"
                            :key="respuestaForm.id">

                            <FormControl v-model="respuestaForm.respuesta" />
                        </li>
                    </ul>
                    <br>
                </div>
            </FormField>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" color="warning" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                        label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>

    </LayoutMain>
</template>