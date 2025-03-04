<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import Swal from "sweetalert2";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";

import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";
import { mdiTagEdit, mdiDeleteOutline, mdiAlertCircleOutline} from "@mdi/js"; // Importar los íconos
import { Inertia } from '@inertiajs/inertia';

import CardBox from "@/components/CardBox.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";



// Recibimos las personas con sus documentos desde el controlador
const props = defineProps(['personas']);
// Definir el título para el componente SectionTitleLineWithButton

const titulo = "Lista de Personas y Documentos";

const eliminarDocumento = (id) => {
    console.log("ID del documento a eliminar:", id); // Depuración: Verifica el ID
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
            // Usar Inertia.delete para enviar la solicitud DELETE
            Inertia.delete(route("documento.destroy", id));


        }
    });
};

// Función para determinar los documentos faltantes
const documentosFaltantes = (persona) => {
    const requeridos = ['doc_curp', 'doc_rfc', 'acta_nacimiento'];
    return requeridos.filter(doc => !persona.documentos[doc]);
};


</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
            <BaseButton :href="'documento/create'" color="warning" label="Agregar Documentos" />

        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="personas.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <!-- Tabla con las personas y sus documentos -->
        <CardBox v-else class="mb-6" has-table>

            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Nombre</th>
                        <th>Documentos</th>
                        <th>Acciones</th>
                        <th />
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="persona in personas.data" :key="persona.id">
                        <td class="align-items-center">
                        </td>

                        <td> {{ persona.nombre }}</td>
                        <td>
                            <ul>
                                <li v-for="documento in persona.documentos" :key="documento.id">
                                    <strong>CURP:</strong> {{ documento.doc_curp }} <br>
                                    <strong>RFC:</strong> {{ documento.doc_rfc }} <br>
                                    <strong>Acta de Nacimiento:</strong> {{ documento.acta_nacimiento }} <br>
                                    <!-- Agrega más campos según sea necesario -->
                                </li>
                            </ul>
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <!-- Botones para los documentos de la persona -->
                            <div v-for="documento in persona.documentos" :key="documento.id" class="mt-2">
                                
                                <BaseButton v-if="persona.documentos.length < totalDocumentosRequeridos" color="info"
                                    :icon="mdiAlertCircleOutline" small
                                    @click="Swal.fire('Documentos Faltantes', documentosFaltantes(persona).join(', '), 'info')"
                                    label="Ver faltantes" />

                                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                    <!-- Botón para editar el documento -->
                                    <BaseButton color="warning" :icon="mdiTagEdit" small
                                        :href="route('documento.edit', documento.id)" />

                                    <!-- Botón para eliminar el documento -->
                                    <BaseButton color="danger" :icon="mdiDeleteOutline" small
                                        @click="eliminarDocumento(documento.id)" />
                                </BaseButtons>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :currentPage="personas.current_page" :links="personas.links" :total="personas.links.length - 2">
            </Pagination>
        </CardBox>



    </LayoutMain>
</template>
