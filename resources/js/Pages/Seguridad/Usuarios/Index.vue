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
    mdiApplicationEdit, mdiTagEdit, mdiDeleteOutline, mdiTrashCan
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
        usuarios: { type: Object, required: true },
        admin: { type: Object, required: true },
        alumnos: { type: Object, required: true },
        profesores: { type: Object, required: true },
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
        NotificationBar,
    },

    setup() {
        const form = useForm({
            name: '',
            apellido_paterno: '',
            apellido_materno: '',
            numero: '',
            email: '',
            role: '',
            cuatrimestre: '',
            matricula: '',
            grado_academico: '',
            area: '',

        });
        const eliminar = (id) => {
            console.log(id)
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
                    form.delete(route("alumno.destroy", id));
                }
            });
        };

        const eliminarprofesor = (id) => {
            console.log(id)
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
        const eliminarAdmin = (id) => {
            console.log(id)
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
                    form.delete(route("usuarios.destroy", id));
                }
            });
        };

        return {
            form, eliminar, eliminarprofesor, eliminarAdmin, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit,
            mdiTagEdit,
            
            mdiTrashCan,
            mdiDeleteOutline,

        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton  :title="titulo" main>
            <BaseButton :href="'usuarios/create'" color="warning" label="Agregar administrador" />
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="admin.length < 1">
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
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <!-- Sección para administradores -->
                    <tr v-for="admin in admin" :key="admin.id">
                        <td class="align-items-center"></td>
                        <td data-label="Nombre">{{ admin.name }}</td>
                        <td data-label="Apellido paterno">{{ admin.apellido_paterno }}</td>
                        <td data-label="Apellido materno">{{ admin.apellido_materno }}</td>
                        <td data-label="Número">{{ admin.numero }}</td>
                        <td data-label="Email">{{ admin.email }}</td>
                        <td data-label="Rol">{{ admin.role }}</td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route(`usuarios.edit`, admin.id)" />

                                <BaseButton color="danger" :icon="mdiDeleteOutline" small
                                    @click="eliminarAdmin(admin.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>

    </LayoutMain>
</template>
