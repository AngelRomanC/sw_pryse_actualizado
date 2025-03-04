<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
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
        Pregunta: { type: Object, required: true },
        version: { type: Object, required: true },
        Academico: { type: Object, required: true },
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
        const form = useForm({
            pregunta: '',
            formato: '',
            version: '',
        });
        const versions = props.version;
        const eliminar = (id) => {
            Swal.fire({
                title: "¿Esta seguro?",
                text: "Esta acción no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, eliminar registro!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.delete(route("pregunta.destroy", id));
                }
            });
        };
        const habilitarFormulario = () => {
            form.get(route("pregunta.habilitar"))
                .then(() => {
                    // Manejar la respuesta del servidor si es necesario
                })
                .catch(error => {
                    // Manejar cualquier error que ocurra durante la solicitud
                    console.error(error);
                });
        };
        return {
            form, eliminar, mdiMonitorCellphone,versions,habilitarFormulario,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
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
          <a href="AnalisisPreguntas" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
            Análisis de académico individual
          </a>
          <a :href="`pregunta/create`" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
           Crear nueva versión
          </a>
        </div>
    
        <div class="mt-20">
          <a href="HabitoPreguntas" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
            Hábitos de estudio          
          </a>
        </div>
    
        <div class="mt-20">
          <a href="InteligenciaPreguntas" class="border-2 border-yellow-500 hover:bg-purple-700 hover:text-white text-red-500 font-bold h-36 w-80 rounded-lg text-lg flex items-center justify-center">
            Inteligencias múltiples
          </a>
        </div>
  
        
      </LayoutMain>
</template>