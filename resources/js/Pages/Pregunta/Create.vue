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
        version: { type: Object, required: true },
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
            form.post(route('pregunta.store'));
        };

        const form = useForm({
            preguntas: [],
            formato: '',
            version: props.version[props.version.length - 1]+1,
            estatus:1,
        });
        const generarCamposPreguntas = () => {
            const numPreguntas = parseInt(form.numeroPreguntas);
            form.preguntas = new Array(numPreguntas).fill('').map(() => ({ pregunta: '' }));
        };
        const formato = {
            1: 'Formato de analisis academico',
            2: 'Formato de habitos de estudio',
            3: 'Formato de Inteligencias multiples',
            
        };
        return { 
            handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub,formato,generarCamposPreguntas
        
        }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
          
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Nombre">
                <label for="formato">Selecciona el formato:</label>
                <select v-model="form.formato" id="formato">
                <option disabled value="">Selecciona el formato</option>
                <option v-for="(texto, valor) in formato" :key="valor" :value="valor">{{ texto }}</option>
                </select>

                <FormField label="Número de preguntas">
                    <FormControl v-model="form.numeroPreguntas" type="number" placeholder="Ingresa el número de preguntas" @input="generarCamposPreguntas" />
                </FormField>

                <template v-for="(pregunta, index) in form.preguntas" :key="index" >
                    <CardBox >
                        <FormField label="Pregunta" >
                            <FormControl v-model="pregunta.pregunta" :placeholder="'Ingresa la pregunta número ' + (index + 1)" />
                        </FormField>
                    </CardBox>
                </template>
               
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
