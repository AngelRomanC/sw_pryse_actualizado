<script>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiApplicationEdit, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        respuestas: { type: Object, required: true},
        Evaluacion: { type: Object, required: true},
        preguntas: { type: Object, required: true},
        version: { type: Object, required: true},
        grupo: { type: Object, required: true},
        Academico: { type: Object, required: true},
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },
    setup(props) {
        const versionSeleccionada = ref('');
        const seleccionarVersion = (event) => {
    const seleccion = event.target.value; 
    versionSeleccionada.value = seleccion; // Actualizar el valor de versionSeleccionada
  };
        const form = useForm({
            respuesta: '',
            academico: '',
            evaluacion_id:'',
            version:'',
            formato: 1,
        });
        
        const handleSubmit = (academico) => {
            // Asignar el ID del académico al campo oculto
            form.academico = academico.id;
            form.version =academico.version;
            form.post(route('evaluacion.store'));
        };
        return {
            form,
            mdiMonitorCellphone,
            mdiTableBorder,
            handleSubmit,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit,
            mdiTrashCan,
        }
    }
}
</script>

<template>
    <LayoutMain>
      <SectionTitleLineWithButton :title="titulo" main></SectionTitleLineWithButton>
        
      <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
        {{ $page.props.flash.success }}
      </NotificationBar>
        
      <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
        {{ $page.props.flash.error }}
      </NotificationBar>
  
      <div class="mt-20 flex justify-between">
        <a href="evaluacionAcademicos" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
          Análisis de académico individual
        </a>
        <a href="habilitar" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
          Habilitar formulario
        </a>
      </div>
  
      <div class="mt-20">
        <a href="evaluacionHabitos" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
          Hábitos de estudio          
        </a>
      </div>
  
      <div class="mt-20">
        <a href="evaluacionInteligencias" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
          Inteligencias múltiples
        </a>
      </div>

      
    </LayoutMain>
  </template>
  