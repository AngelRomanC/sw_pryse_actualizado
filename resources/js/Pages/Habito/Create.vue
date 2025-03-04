<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import FormControlV6 from "@/components/FormControlV6.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        preguntas:{ type: Object, required: true },
        usuarios:{ type: Object, required: true },
        periodo:{ type: Object, required: true },
        version: { type: String, required: true },
        grupo:{type: Object, required: true}, 
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        FormControlV2,
        FormControlV3,
        FormControlV6,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
  
   
    setup(props) {
        const handleSubmit = () => {
            form.post(route('habito.store'));
        };

        const form = useForm({
            matricula: '',
            grupo_id:'',
            profesor_id:'',
            periodo_id:'',
            formato:'2',
            version: props.version,
            respuestas:[], 
            pregunta_id: [],
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="`${route(routeName + 'index')}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">


            <FormField label="Información personal">
                <FormControl v-model="form.matricula" placeholder="Matrícula"/>
    
            </FormField>
            <FormField >
                <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
            </FormField>
            <FormField >
                <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
           
            
          
            <FormField label="Habitos de estudio">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <template v-if="pregunta.formato === 2">
                        <p style="font-size: 18px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p> 
                        <select v-model="form.respuestas[pregunta.id]" @change="guardarRespuesta(pregunta.id) " class="w-full">
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                        <br>
                    </template>
                </div>
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
