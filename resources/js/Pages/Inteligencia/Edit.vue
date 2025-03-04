
<script setup>
import { ref, defineProps,watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV6 from "@/components/FormControlV6.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';
import { mdiBallotOutline} from "@mdi/js";
const props = defineProps(['titulo', 'Inteligencia','respuestas','usuarios','grupo' ,'periodo','profesor', 'preguntas','routeName']);


const form = useForm({ 
...props.Inteligencia,
...props.profesor,
...props.grupo,
respuestas:{},
profesor_id: props.profesor,

});


const handleSubmit = () => {
    form.put(route("inteligencia.update", props.Inteligencia.id));
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
        <SectionTitleLineWithButton  :title="titulo" main>
            <Link :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </Link>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Matricula">
                <FormControl v-model="form.matricula"  placeholder="Matricula"/>
             </FormField>
             <FormField >
                <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
            </FormField>
            <FormField >
                <FormControlV2 v-model="form.profesor_id" :showOption="name" :options="usuarios" />
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
             
             
            <FormField label="Inteligencias multiples">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <p style="font-size: 20px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p>
                    <ul>
                        <li v-for="respuestaForm in respuestas.filter(item => item.pregunta.id === pregunta.id)" :key="respuestaForm.id">
                            <select v-model="respuestaForm.respuesta" class="w-full">
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
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