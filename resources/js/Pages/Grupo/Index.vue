<script>
import { Link, useForm} from '@inertiajs/vue3';
import axios from 'axios';
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
        Grupo: { type: Object, required: true },
        grupos: { type: Object, required: true },
        alumnos: { type: Object, required: true },
        profesor: { type: Object, required: true },
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
            grado: '',
            grupo: '',
            tutor: '',
            materia:''
        });
        const eliminar = (id) => {
            Swal.fire({
                title: "¿Esta seguro?",
                text: "Se borraran todos los alumnos y el profesor relacionados a este grupo",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, eliminar Grupo!",
                cancelButtonText: "Cancelar ",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.delete(route("grupo.destroy", id));
                }
            });
        };
        const eliminarAlumno = (recursamientoId, userId) => {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará este alumno de la lista de recursamiento",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route("grupo.remove-alumno", { id: recursamientoId, userId: userId }))
                .then(() => {
                    
                })
                .catch(() => {
                    
                });
        }
    });
};


        return {
            form, eliminar,eliminarAlumno, mdiMonitorCellphone,
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
        <SectionTitleLineWithButton  :title="titulo" main>
            <BaseButton :href="'grupo/create'" color="warning" label="Agregar grupo" />
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="grupos.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>
      
        <CardBox v-else class="mb-6" has-table>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
        <div v-for="item in grupos.data" :key="item.id"
             class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ item.grado }}
                    {{ item.grupo }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-300">
                    Tutor: {{  item.profesor.user.name }} {{  item.profesor.user.apellido_paterno }} {{  item.profesor.user.apellido_materno }}
                </p>
                
                
                <p class="text-sm text-gray-500 dark:text-gray-300">
                    Estudiantes:
                    <span v-for="alumno in item.alumnos" :key="alumno.id">
                        <br> {{ alumno.user.name }} {{ alumno.user.apellido_paterno }} {{ alumno.user.apellido_materno }} {{ alumno.matricula }}
                        <span class="ml-3">
                            <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminarAlumno(item.id, alumno.id)" />
                        </span>
                    </span >
                    
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-300">
                    Materias:
                    <span v-for="materia in item.materias" :key="materia.pivot_materia_id">
                        <br> {{ materia.nombre }}
                    </span>
                </p>
                <br> 
                
            </div>
            <div class="flex justify-end items-end p-4">
                <p class="text-sm text-gray-500 dark:text-gray-300">
                    <BaseButtons type="justify-start lg:justify-end" no-wrap>

                        <a :href="route('grupos.assign-group.view', item.id)" class='ml-2'> <button
                                class="bg-transparent ml-2 dark:text-white dark:border-white hover:bgeve-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500  dark:hover:border-transparent hover:border-transparent rounded">
                                Asignar Estudiante
                            </button>
                        </a>
                    </BaseButtons>
                </p>
                <BaseButtons>
                    <BaseButton color="warning" :icon="mdiApplicationEdit" small
                                :href="route(`${routeName}edit`, item.id)" class='ml-2'/>
                    <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                </BaseButtons>
            </div>
        </div>
    </div>
</CardBox>

    </LayoutMain>
</template>
