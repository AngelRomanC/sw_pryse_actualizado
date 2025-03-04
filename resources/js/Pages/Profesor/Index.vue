<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {mdiMonitorCellphone,mdiTableBorder,mdiTableOff,mdiGithub,mdiTagEdit,mdiDeleteOutline,mdiApplicationEdit, mdiTrashCan } from "@mdi/js";
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
        Profesor: {type: Object, required: true},
        usuarios: {type: Object, required: true},
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
            grado_academico: '',
            area: '',
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
                    form.delete(route("profesor.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiTagEdit,
            mdiDeleteOutline,
            mdiApplicationEdit, mdiTrashCan,
        }
    },
   
}


</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton  :title="titulo" main>
            <BaseButton :href="'profesor/create'" color="warning" label="Agregar profesor" />

        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        
        <CardBox v-if="usuarios.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                   
                    <tr>
                        <th />
                        <th>Nombre</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Grado academico</th>
                        <th>Area</th>
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>


                    <!-- Sección para alumnos -->
                    <tr v-for="profesor in Profesor" :key="profesor.id">
                        <td class="align-items-center">

                        </td>
                        <td data-label="Nombre">
                            {{ profesor.user.name }}
                        </td>
                        <td data-label="apellido paterno">
                            {{ profesor.user.apellido_paterno }}
                        </td>
                        <td data-label="apellido materno">
                            {{ profesor.user.apellido_materno }}
                        </td>
                        <td data-label="numero">
                            {{ profesor.user.numero }}
                        </td>
                        <td data-label="email">
                            {{ profesor.user.email }}
                        </td>
                        <td data-label="role">
                            {{ profesor.user.role }}
                        </td>
                        <td data-label="Cuatrimestre">
                            {{ profesor.grado_academico }}
                        </td>
                        <td data-label="Matrícula">
                            {{ profesor.area }}
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route(`profesor.edit`, profesor.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small
                                    @click="eliminarprofesor(profesor.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :currentPage="usuarios.current_page" :links="usuarios.links" :total="usuarios.links.length - 2">
            </Pagination>


        </CardBox>
      
    </LayoutMain>
</template>
