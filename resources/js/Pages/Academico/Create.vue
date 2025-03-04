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
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV6 from "@/components/FormControlV6.vue";


export default {
    props: {
        titulo: { type: String, required: true },
        version: { type: String, required: true },
        routeName: { type: String, required: true },
        preguntas:{type: Object, required: true},
        periodo:{type: Object, required: true},
        grupo:{type: Object, required: true}, 
        usuarios:{type: Object, required: true},
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        FormControlV2,
        FormControlV3,
        FormControlV6,
        CardBox,
        SectionTitleLineWithButton
    },
    setup(props) {
        const handleSubmit = () => {
            form.post(route('academico.store'));
        };

        const form = useForm({
            matricula: '',
            profesor_id:'',
            periodo_id:'',
            grupo_id:'',
            materia_recursar:'',
            formato: '1',
            version: props.version,
            respuestas:[], // Inicializa con un arreglo del tamaño de props.preguntas lleno de undefined
            pregunta_id: [],
            
        });
        const guardarRespuesta = (preguntaId) => {
        form.respuestas[preguntaId] = form.respuestas[preguntaId] || ""; // Inicializa con un string vacío si es undefined
        form.pregunta_id[preguntaId] = preguntaId;
        }

        return { handleSubmit, form, guardarRespuesta, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
     
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            
        </SectionTitleLineWithButton>
    
        <div>

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
                    <FormField>
                        <FormControl v-model="form.materia_recursar" placeholder="Materia a recursar" />
                    </FormField>
                    
                   
                    
                    <FormField label="Análisis académico individual">
                        <div v-for="pregunta in preguntas.filter(item => item.formato === 1)" :key="pregunta.id">
                            <p>{{ pregunta.pregunta }}</p>
                            <FormControl  v-model="form.respuestas[pregunta.id]" @change="guardarRespuesta(pregunta.id)"/>
                            <br>
                        </div>
                    </FormField>
                    
                    <template #footer>
                        <BaseButtons>
                            <BaseButton @click="handleSubmit" type="submit" color="warning" label="Crear" />
                            <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                                label="Cancelar" />
                        </BaseButtons>
                    </template>
                </CardBox>
            

        </div>
       
    </LayoutMain>
    
    
    
</template>
