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
        Recursamiento: { type: Object, required: true },
        encuesta: { type: Object, required: true },
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
            horario: '',
            profesores: '',
            tipo_proyecto: '',
            dificultad:'',
            periodo:'',
            estudiantes:'',
             
        });
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
                    form.delete(route("encuesta.destroy", id));
                }
            });
        };
        const EncuestaPorMateria = (materiaId) => {
    return props.encuesta.some(encuesta => encuesta.materia_id === materiaId);
};

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,EncuestaPorMateria
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
        
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        <CardBox v-if="Recursamiento < 1">
            <CardBoxComponentEmpty />
        </CardBox>
        
        <CardBox v-else class="mb-6" has-table>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-3">
                <div v-for="item in Recursamiento" :key="item.id"
                    class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div>
                        <br>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white ">
                      {{ item.materia.nombre }}
                        <br>
                       Periodo:  {{ item.periodo.periodo }} {{ item.periodo.año }}
                    </h3>
                    </div>  
                    <div v-if="EncuestaPorMateria(item.materia.id)">
                        <div style="color: blue;">En revisión</div>
                    </div>
                    <div v-else>
                        <div style="color: red;">No contestado</div>
                        <div class="p-4">
                            <div class="flex justify-end items-end">
                                <a class="text-sm text-gray-500 dark:text-gray-300">
                                    <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                        <a :href="route('encuesta.create', item.materia.id)">
                                            <button class="bg-transparent dark:text-white dark:border-white hover:bg-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500 dark:hover:border-transparent hover:border-transparent rounded">
                                                Contestar encuesta
                                            </button>
                                        </a>
                                    </BaseButtons>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                   

                        
                </div>
            </div>
        </CardBox>
        
        
    </LayoutMain>
</template>
