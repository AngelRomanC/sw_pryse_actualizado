<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import Swal from "sweetalert2";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";

import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";
import { mdiTagEdit, mdiDeleteOutline, mdiAlertCircleOutline } from "@mdi/js"; // Importar los íconos
import { Inertia } from '@inertiajs/inertia';

import CardBox from "@/components/CardBox.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { mdiInformation } from '@mdi/js';

// Luego, usa el icono en tu componente



// Recibimos las personas con sus documentos desde el controlador
const props = defineProps(['personas']);
// Definir el título para el componente SectionTitleLineWithButton
const titulo = "Lista de Personas y Documentos";

const totalDocumentosRequeridos = 9;
const estadoFiltro = ref('Todos');


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


const documentosRequeridos = [
{ key: 'doc_curp', label: 'Documento CURP' },
  { key: 'doc_rfc', label: 'Documento RFC' },
  { key: 'acta_nacimiento', label: 'Acta de Nacimiento' },
  { key: 'doc_cuip', label: 'Documento CUIP' },
  { key: 'ine', label: 'INE' },
  { key: 'cartilla_militar', label: 'Cartilla Militar' },
  { key: 'comprobante_domicilio', label: 'Comprobante de Domicilio' },
  { key: 'doc_nss', label: 'Documento NSS' },
  { key: 'firma_digital', label: 'Firma Digital' }
];
const documentosFaltantes = (persona) => {
  return documentosRequeridos.filter(doc => !persona.documentos.some(d => d[doc.key]))
    .map(doc => doc.label);
};

// const documentosFaltantes = (persona) => {
//     return documentosRequeridos.filter(doc => !persona.documentos.some(d => d[doc]));
// };

const estadoPersona = (persona) => {
    return documentosFaltantes(persona).length > 0 ? 'Pendiente' : 'Completo';
};

const personasFiltradas = computed(() => {
    if (estadoFiltro.value === 'Todos') return props.personas.data;
    return props.personas.data.filter(persona => estadoPersona(persona) === estadoFiltro.value);
});




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
        <div class="mb-4">
            <label for="filtroEstado">Filtrar por estado:</label>
            <select id="filtroEstado" v-model="estadoFiltro" class="border p-2 rounded">
                <option value="Todos">Todos</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Completo">Completo</option>
            </select>
        </div>


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
                        <th>Estado</th>
                        <th>Acciones</th>
                        <th />
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="persona in personasFiltradas" :key="persona.id"
                        :class="{ 'bg-red-100': persona.documentos.length < totalDocumentosRequeridos }">
                        <td class="align-items-center">
                        </td>

                        <td> {{ persona.nombre + " " + persona.apellido_paterno + " " + persona.apellido_materno }}</td>

                        <td>
                            <span :class="{
                                'text-red-500 bg-red-100 rounded-full px-3 py-1 inline-block': estadoPersona(persona) === 'Pendiente',
                                'text-green-500 bg-green-100 rounded-full px-3 py-1 inline-block': estadoPersona(persona) === 'Completo'
                            }">
                                {{ estadoPersona(persona) }}
                            </span>
                        </td>
                        <td>
                            <template v-if="persona.documentos.length === 0">
                                <BaseButtons>
                                    <BaseButton color="secondary" small disabled label="Sin Documentos" />
                                </BaseButtons>
                            </template>
                            <template v-else>
                                <!-- Botones para los documentos de la persona -->
                                <div v-for="documento in persona.documentos" :key="documento.id" class="mt-2">

                                    <BaseButtons>
                                        <BaseButton v-if="estadoPersona(persona) === 'Pendiente'" color="info"
                                            :icon="mdiAlertCircleOutline" small
                                            @click="Swal.fire('Documentos Faltantes', documentosFaltantes(persona).join(', '), 'info')"
                                            label="Ver faltantes" />

                                        <BaseButton color="warning" :icon="mdiTagEdit" small
                                            :href="route('documento.edit', documento.id)" />

                                        <BaseButton color="danger" :icon="mdiDeleteOutline" small
                                            @click="eliminarDocumento(documento.id)" />
                                    </BaseButtons>
                                </div>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :currentPage="personas.current_page" :links="personas.links" :total="personas.links.length - 2">
            </Pagination>
        </CardBox>



    </LayoutMain>
</template>
