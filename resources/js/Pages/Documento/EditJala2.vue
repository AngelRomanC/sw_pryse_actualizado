<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Layout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

// Props
const props = defineProps({
    documento: Object,
    personas: Array
});

// Formulario con datos del documento
const form = useForm({
    persona_id: props.documento.persona_id,
    doc_curp: null,
    doc_rfc: null,
    acta_nacimiento: null,
    doc_cuip: null,
    ine: null,
    cartilla_militar: null,
    comprobante_domicilio: null,
    doc_nss: null,
    firma_digital: null
});

// Manejar la actualización del documento
const submit = () => {
    Inertia.post(route('documento.update', props.documento.id), {
        _method: 'PUT',
        ...form
    }, {
        forceFormData: true // Para enviar archivos correctamente
    });
};

// Ruta base donde se almacenan los archivos (ajústala según tu configuración en Laravel)
const storagePath = '/storage/documentos/';
</script>

<template>
    <Layout>
        <div class="container mx-auto px-4 py-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Editar Documento</h2>
                
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-gray-700">Persona</label>
                        <select v-model="form.persona_id" class="w-full border-gray-300 rounded px-3 py-2">
                            <option v-for="persona in personas" :key="persona.id" :value="persona.id">
                                {{ persona.nombre }}
                            </option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="campo in ['doc_curp', 'doc_rfc', 'acta_nacimiento', 'doc_cuip', 'ine', 'cartilla_militar', 'comprobante_domicilio', 'doc_nss', 'firma_digital']" :key="campo">
                            <label :for="campo" class="block text-gray-700">{{ campo.replace('_', ' ').toUpperCase() }}</label>

                            <!-- Mostrar archivo actual si existe -->
                            <div v-if="props.documento[campo]" class="mb-2">
                                <a :href="storagePath + props.documento[campo]" target="_blank" class="text-blue-600 underline">
                                    Ver archivo actual
                                </a>
                            </div>

                            <!-- Input para subir nuevo archivo -->
                            <input type="file" :id="campo" @change="event => form[campo] = event.target.files[0]" class="w-full border-gray-300 rounded px-3 py-2" />
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
