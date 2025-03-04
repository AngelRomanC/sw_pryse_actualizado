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
    mdiTagEdit,
    mdiDeleteOutline,
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
        Alumno: {type: Object, required: true},
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
            cutrimestre: '',
            matricula: '',
            name: '',
            apellido_materno: '',
            apellido_paterno: '',
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
                    form.delete(route("alumno.destroy", id));
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
    methods: {
    verDetallesUsuario(usuario) {
        this.$router.push({ name: 'detalles_usuario', params: { id: usuario.id } });
    }
}

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton  :title="titulo" main>
            <BaseButton :href="'alumno/create'" color="warning" label="Agregar alumno" />

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
                        <th>Cuatrimestre</th>
                        <th>Matrícula</th>
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>


                    <!-- Sección para alumnos -->
                    <tr v-for="alumno in Alumno" :key="alumno.id">
                        <td class="align-items-center">

                        </td>
                        <td data-label="Nombre">
                            {{ alumno.user.name }}
                        </td>
                        <td data-label="apellido paterno">
                            {{ alumno.user.apellido_paterno }}
                        </td>
                        <td data-label="apellido materno">
                            {{ alumno.user.apellido_materno }}
                        </td>
                        <td data-label="numero">
                            {{ alumno.user.numero }}
                        </td>
                        <td data-label="email">
                            {{ alumno.user.email }}
                        </td>
                        <td data-label="role">
                            {{ alumno.user.role }}
                        </td>
                        <td data-label="Cuatrimestre">
                            {{ alumno.cuatrimestre }}
                        </td>
                        <td data-label="Matrícula">
                            {{ alumno.matricula }}
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route(`alumno.edit`, alumno.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small @click="eliminar(alumno.id)" />
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
