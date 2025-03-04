<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'usuario','profesor', 'routeName']);
const form = useForm({ ...props.profesor,...props.usuario });

const guardar = () => {
    form.put(route("profesor.update", props.profesor.id));
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
            <FormField label="Nombre">
                <FormControl v-model="form.name" placeholder="nombre" />
                <FormControl v-model="form.apellido_paterno" placeholder="apellido_paterno" />
                <FormControl v-model="form.apellido_materno" placeholder="apellido_materno" />
                <FormControl v-model="form.numero" placeholder="numero" />
                <FormControl v-model="form.email" placeholder="email" />
               
               
            </FormField>
            <FormField :error="form.errors.grado_academico">
                <select v-model="form.grado_academico"  class="w-full">
                    <option disabled value="">Selecciona tu grado academico</option>
                    <option>Educación superior</option> <option>Maestria</option><option>Doctorado</option> 
                </select>
                      
            </FormField>
            <FormField :error="form.errors.area">
                <select v-model="form.area"  class="w-full">
                    <option disabled value="">Selecciona tu area </option>
                    <option>Programación y Desarrollo de Software</option> <option>Redes de Computadoras</option><option>Sistemas Operativos</option> 
                    <option>Bases de Datos</option> <option>Ciberseguridad</option><option>Desarrollo Web</option> 
                    <option>Inteligencia Artificial y Aprendizaje Automático</option> <option>Gestión de Proyectos de TI</option><option>Tecnologías Emergentes</option> 

                </select>    
            </FormField>    
          

          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`profesor.index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

