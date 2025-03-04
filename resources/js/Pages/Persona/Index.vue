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
        personas: { type: Object, required: true },
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
            apellido_paterno: '',
            apellido_materno: '',
            sexo: '',
           
            rfc: '',
           
            curp: '' }
        ); //n index.vue, como no es un formulario de creación ni edición, generalmente no definimos los campos dentro.

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
                    form.delete(route("persona.destroy", id));

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
        <SectionTitleLineWithButton :title="titulo" main>
            <BaseButton :href="'persona/create'" color="warning" label="Agregar persona" />

        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="personas.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>

                    <tr>
                        <th />
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Sexo</th>
                        <th>RFC</th>
                        <th>CURP</th>
                        <th>Acciones</th>
                        <th />
                    </tr>
                </thead>
                <tbody>


                    <!-- Sección para alumnos -->
                    <tr v-for="persona in personas.data" :key="persona.id">
                        <td class="align-items-center">
                        </td>

                        <td>{{ persona.nombre }}</td>
                        <td>{{ persona.apellido_paterno }}</td>
                        <td>{{ persona.apellido_materno }}</td>
                        <td>{{ persona.sexo }}</td>
                        <td>{{ persona.rfc }}</td>
                        <td>{{ persona.curp }}</td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>

                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route('persona.edit', persona.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small
                                    @click="eliminar(persona.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :currentPage="personas.current_page" :links="personas.links" :total="personas.links.length - 2">
            </Pagination>


        </CardBox>

    </LayoutMain>
</template>
