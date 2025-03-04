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
        recursamiento: { type: Object, required: true },
        recursa: { type: Object, required: true },
        usuario: { type: Object, required: true },
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
            pregunta: '',
            formato: '',
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
                    form.delete(route("pregunta.destroy", id));
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
            form.post(route("lista.eliminar-alumno", { id: recursamientoId, userId: userId }))
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
           
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="recursamientos < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-3">
                <div v-for="item in recursamiento" :key="item.id"
                    class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ item.materia.nombre }}

                        </h3>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">
                            Periodo:
                            <h3 class="text-sm text-gray-500 dark:text-gray-300">
                              
                                {{ item.periodo.periodo }} {{ item.periodo.año }}
                            </h3>
                           
                        </p>
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">
                            Profesor:
                            <h3 class="text-sm text-gray-500 dark:text-gray-300">
                              
                                 {{ item.profesor.user.name }} {{ item.profesor.user.apellido_paterno }} {{ item.profesor.user.apellido_materno }}
                            </h3>
                           
                        </p>
                        <p class=" font-semibold text-gray-800 dark:text-white">
                            Horarios: 
                            <h3 class="text-sm text-gray-500 dark:text-gray-300">
                                {{ item.horarios }}
                            </h3>
                        </p>

                        <p class="text-lg font-semibold text-gray-800 dark:text-white">
                            Alumnos en lista:
                            <span v-for="(user, index) in item.users" :key="index" class="text-sm text-gray-500 dark:text-gray-300">
                                <br>
                                {{ user.name }} {{ user.apellido_paterno }} {{ user.apellido_materno }}
                                <span  v-if="user.id === usuario.id" class="ml-3">
                                    <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminarAlumno(item.id, user.id)" />
                                </span>
                            </span>
                        </p>
                    </div>
                    <div class="flex justify-end items-end p-4">
                        <a class="text-sm text-gray-500 dark:text-gray-300" >
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>

                                <a :href="route('lista.assign-lista.view', item.id)"> <button
                                        class="bg-transparent dark:text-white dark:border-white hover:bgeve-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500  dark:hover:border-transparent hover:border-transparent rounded">
                                        Agregarse a la lista
                                    </button>
                                </a>
                            </BaseButtons>
                        </a>

                    </div>
                </div>
            </div>
        </CardBox>
    </LayoutMain>
</template>
