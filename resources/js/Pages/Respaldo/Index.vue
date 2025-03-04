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

import axios from "axios";

import { mdiDownload } from '@mdi/js';




export default {
    props: {
        titulo: { type: String, required: true },
        respaldos:{
            type: Object, default:{},
        },
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
    setup() {
        const form = useForm({
            materia: '',
            periodo: '',
            profesor: '',
            horarios:'',
            cupo:'',
           
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
                    form.delete(route("recursamiento.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,
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
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
            <BaseButton :href="'respaldo/create'" color="warning" label="Agregar respaldo" />
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

      
        <CardBox v-if="respaldos < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-3">
                <div v-for="item in respaldos" :key="item.id"
                    class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ item.ubicacion }}

                        </h3>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">
                            ubicacion:
                            <h3 class="text-sm text-gray-500 dark:text-gray-300">
                              
                                {{ item.fecha_modificacion }} 
                            </h3>
                           
                        </p>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">
                            Tamaño:
                            <h3 class="text-sm text-gray-500 dark:text-gray-300">
                              
                                 {{ item.size}} 
                            </h3>
                           
                        </p>
                       
                        <div class="before:hidden ">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiApplicationEdit" small
                                    :href="route(`restaurarRespaldo`, item.ubicacion)" />
                                
                                <BaseButton color="warning" :icon="mdiDownload" small
                                    :href="route(`descargaRespaldo`, item.ubicacion)" />

                                <BaseButton color="danger" :icon="mdiTrashCan" small 
                                :href="route(`eliminarRespaldo`, item.ubicacion)" />
                                
                            </BaseButtons>
                        </div>                    

                     
                       
                        

                    </div>
                   
                </div>
            </div>
        </CardBox>
    </LayoutMain>
</template>
