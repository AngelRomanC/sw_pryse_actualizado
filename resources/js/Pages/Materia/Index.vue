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
        Materia: {
            type: Object,
            required: true
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
            nombre: '',
            clave: '',
            cuatrimestre: '',
            tipo:'',
            No_horas_presenciales:'',
            No_horas_no_presenciales:'',
            periodo:'',
            nivel:'',
            status: ''
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
                    form.delete(route("materia.destroy", id));
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
        <SectionTitleLineWithButton  :title="titulo" main>
            <BaseButton :href="'materia/create'" color="warning" label="Agregar materia" />
        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="Materia.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Cuatrimestre</th>
                        <th>Tipo</th>
                        <th>No Horas presenciales</th>
                        <th>No Horas no presenciales</th>
                        <th>Nivel</th>
                        <th>Periodo</th>
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in Materia.data" :key="item.id">
                        <td class="align-items-center">
                           
                        </td>
                        <td data-label="Nombre">
                            {{ item.nombre }}
                        </td>
                        <td data-label="clave">
                            {{ item.clave }}
                        </td>
                        <td data-label="cuatrimestre">
                            {{ item.cuatrimestre }}
                        </td>
                        <td data-label="tipo">
                            {{ item.tipo }}
                        </td>
                        <td data-label="No_horas_presenciales">
                            {{ item.No_horas_presenciales }}
                        </td>
                        <td data-label="No_horas_no_presenciales">
                            {{ item.No_horas_no_presenciales }}
                        </td>
                        <td data-label="nivel">
                            {{ item.nivel }}
                        </td>
                        <td data-label="Status">
                            {{ item.periodo }}
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiApplicationEdit" small
                                    :href="route(`${routeName}edit`, item.id)" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="Materia.current_page" :links="Materia.links"
                :total="Materia.links.length - 2"></Pagination>
        </CardBox>

    </LayoutMain>
</template>
