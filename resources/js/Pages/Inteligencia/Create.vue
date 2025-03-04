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
        version:{ type: Object, required: true },
        usuarios:{ type: Object, required: true },
        periodo:{ type: Object, required: true },
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
            form.post(route('inteligencia.store'));
        };

        const form = useForm({
            matricula: '',
            grupo_id:'',
            profesor_id:'',
            periodo_id:'',
            formato:'3',
            version: props.version,
            respuestas:[], 
            pregunta_id: [],
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain >
        <SectionTitleLineWithButton  :title="titulo" main>
           
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
            <FormField>
                <div v-for="pregunta in preguntas.filter(item => item.formato === 3)" :key="pregunta.id">
                    <p style="font-size: 18px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p> 
                    <select v-model="form.respuestas[pregunta.id]" class="w-full">
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
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
    </LayoutMain>
</template>
