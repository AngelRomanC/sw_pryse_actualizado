<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import { Inertia } from '@inertiajs/inertia';

import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";
import CardBox from "@/components/CardBox.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";

import { mdiTagEdit, mdiDeleteOutline, mdiAlertCircleOutline } from "@mdi/js";

const props = defineProps(['personas']);
const titulo = "Lista de Personas y Documentos";
const filtroEstado = ref('todos'); 
const totalDocumentosRequeridos = 9; 

const personasFiltradas = computed(() => {
    return props.personas.data.filter(persona => {
        if (filtroEstado.value === 'completos') return persona.documentos.length === totalDocumentosRequeridos;
        if (filtroEstado.value === 'incompletos') return persona.documentos.length < totalDocumentosRequeridos;
        return true;
    });
});

// Función para determinar los documentos faltantes
const documentosFaltantes = (persona) => {
    const requeridos = ['doc_curp', 'doc_rfc', 'acta_nacimiento'];
    return requeridos.filter(doc => !persona.documentos[doc]);
};

const eliminarDocumento = (id) => {
    Swal.fire({
        title: "¿Está seguro?",
        text: "Esta acción no se puede revertir",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar!",
    }).then((res) => {
        if (res.isConfirmed) {
            Inertia.delete(route("documento.destroy", id));
        }
    });
};
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
            <BaseButton :href="'documento/create'" color="warning" label="Agregar Documentos" />
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="'mdi-information'">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="'mdi-information'">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <div class="mb-4">
            <label class="font-semibold">Filtrar por estado:</label>
            <select v-model="filtroEstado" class="p-2 border rounded">
                <option value="todos">Todos</option>
                <option value="completos">Solo completos</option>
                <option value="incompletos">Solo incompletos</option>
            </select>
        </div>

        <CardBox v-if="personasFiltradas.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documentos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="persona in personasFiltradas" :key="persona.id"
                        :class="{'bg-red-100': persona.documentos.length < totalDocumentosRequeridos}">
                        
                        <td>{{ persona.nombre }}</td>
                        <td>
                            <ul>
                                <li :class="{'text-red-500': !persona.documentos.doc_curp}">
                                    <strong>CURP:</strong> {{ persona.documentos.doc_curp ? 'Sí' : 'Faltante' }}
                                </li>
                                <li :class="{'text-red-500': !persona.documentos.doc_rfc}">
                                    <strong>RFC:</strong> {{ persona.documentos.doc_rfc ? 'Sí' : 'Faltante' }}
                                </li>
                                <li :class="{'text-red-500': !persona.documentos.acta_nacimiento}">
                                    <strong>Acta de Nacimiento:</strong> {{ persona.documentos.acta_nacimiento ? 'Sí' : 'Faltante' }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            <span v-if="persona.documentos.length === totalDocumentosRequeridos"
                                class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-200 rounded-full">
                                Completo
                            </span>
                            <span v-else class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-200 rounded-full">
                                Incompleto
                            </span>
                        </td>
                        <td>
                            <div v-for="documento in persona.documentos" :key="documento.id" class="mt-2">

                            <BaseButtons>
                                <BaseButton v-if="persona.documentos.length < totalDocumentosRequeridos"
                                    color="info" :icon="mdiAlertCircleOutline" small
                                    @click="Swal.fire('Documentos Faltantes', documentosFaltantes(persona).join(', '), 'info')" 
                                    label="Ver faltantes" />
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route('documento.edit', documento.id)" />
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
