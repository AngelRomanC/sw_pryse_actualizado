<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from '@/components/NotificationBar.vue';
import Swal from 'sweetalert2';
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue';
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from '@/components/BaseButtons.vue';
import { mdiTagEdit, mdiDeleteOutline, mdiAlertCircleOutline } from '@mdi/js';
import { Inertia } from '@inertiajs/inertia';
import CardBox from '@/components/CardBox.vue';
import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue';

const props = defineProps(['personas']);
const titulo = 'Lista de Personas y Documentos';
const estadoFiltro = ref('Todos');
const totalDocumentosRequeridos = 9;

const eliminarDocumento = (id) => {
    Swal.fire({
        title: '¿Está seguro?',
        text: 'Esta acción no se puede revertir',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar registro!',
    }).then((res) => {
        if (res.isConfirmed) {
            Inertia.delete(route('documento.destroy', id));
        }
    });
};

const documentosRequeridos = [
    'doc_curp', 'doc_rfc', 'acta_nacimiento', 'doc_cuip', 'ine',
    'cartilla_militar', 'comprobante_domicilio', 'doc_nss', 'firma_digital'
];

const documentosFaltantes = (persona) => {
    return documentosRequeridos.filter(doc => !persona.documentos.some(d => d[doc]));
};

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
            <BaseButton :href="route('documento.create')" color="warning" label="Agregar Documentos" />
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success">{{ $page.props.flash.success }}</NotificationBar>
        <NotificationBar v-if="$page.props.flash.error" color="danger">{{ $page.props.flash.error }}</NotificationBar>

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

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="persona in personasFiltradas" :key="persona.id">
                        <td>{{ `${persona.nombre} ${persona.apellido_paterno} ${persona.apellido_materno}` }}</td>
                        <td>
                            <span :class="{
                                'text-red-500 bg-red-100 px-3 py-1 rounded-full': estadoPersona(persona) === 'Pendiente',
                                'text-green-500 bg-green-100 px-3 py-1 rounded-full': estadoPersona(persona) === 'Completo'
                            }">
                                {{ estadoPersona(persona) }}
                            </span>
                        </td>
                        <td>
                            <BaseButtons>
                                <BaseButton v-if="estadoPersona(persona) === 'Pendiente'" color="info" :icon="mdiAlertCircleOutline" small
                                    @click="Swal.fire('Documentos Faltantes', documentosFaltantes(persona).join(', '), 'info')"
                                    label="Ver faltantes" />
                                <BaseButton color="warning" :icon="mdiTagEdit" small :href="route('documento.edit', persona.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small @click="eliminarDocumento(persona.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :currentPage="personas.current_page" :links="personas.links" :total="personas.links.length - 2" />
        </CardBox>
    </LayoutMain>
</template>
