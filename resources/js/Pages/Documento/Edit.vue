<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';
import BaseButton from '@/components/BaseButton.vue';
import { mdiInformation } from '@mdi/js';

// Luego, usa el icono en tu componente


// Recibimos el documento y las personas desde el controlador
const props = defineProps({
    documento: Object,
    personas: Array
});

// Inicializamos el formulario con los datos actuales del documento
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
  firma_digital: null,
});

// Manejar la actualización del documento
const submit = () => {
    Inertia.post(route('documento.update', props.documento.id), {
        _method: 'PATCH',
        ...form
    }, {
        forceFormData: true
    });
};

// Encontrar la persona asociada al documento
const personaEncontrada = props.personas.find(persona => persona.id === props.documento.persona_id);
let nombreCompleto = personaEncontrada 
    ? `${personaEncontrada.nombre} ${personaEncontrada.apellido_paterno} ${personaEncontrada.apellido_materno}`.trim() 
    : 'Persona no encontrada';

// Función para mostrar el PDF en SweetAlert2
const mostrarArchivo = (ruta) => {
    Swal.fire({
        html: `
            <div style="width: 100%; height: 500px;">
                <iframe src="${ruta}" style="width: 100%; height: 100%;" frameborder="0"></iframe>
            </div>
        `,
        width: "80%",
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: "Cerrar",
        allowOutsideClick: true, 
        allowEscapeKey: true,  
    });
};
</script>

<template>
  <LayoutMain>
    <NotificationBar v-if="$page.props.flash.success" color="success" :icon="'mdi-information'" :outline="false">
      {{ $page.props.flash.success }}
    </NotificationBar>

    <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="'mdi-information'" :outline="false">
      {{ $page.props.flash.error }}
    </NotificationBar>

    <h1 class="text-2xl font-bold mb-4">Editar Documentos</h1>

    <form @submit.prevent="submit" enctype="multipart/form-data">
      <!-- Mostrar nombre de la persona -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Persona</label>
        <div class="mt-1 p-4 border border-gray-200 rounded-lg bg-white text-gray-900 shadow-lg">
          <span class="font-medium">{{ nombreCompleto }}</span>
        </div>
      </div>

      <!-- Documentos -->
      <div v-for="(label, key) in {
        doc_curp: 'CURP', doc_rfc: 'RFC', acta_nacimiento: 'Acta de Nacimiento', 
        doc_cuip: 'CUIP', ine: 'INE', cartilla_militar: 'Cartilla Militar', 
        comprobante_domicilio: 'Comprobante de Domicilio', doc_nss: 'NSS', firma_digital: 'Firma Digital'
      }" :key="key" class="mb-4">
        <label :for="key" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <input type="file" :id="key" @change="form[key] = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
        
        <!-- Vista previa con SweetAlert2 -->
        <p v-if="documento[key]" class="text-sm text-gray-500 mt-1">
          Archivo actual: 
          <button type="button" @click="mostrarArchivo(`/storage/${documento[key]}`)" 
            class="text-blue-500 underline">
            Ver archivo
          </button>
        </p>
      </div>

      <!-- Botón de enviar -->
      <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
          :disabled="form.processing">
          Actualizar Documento
        </button>
        <BaseButton :href="route('documento.index')" type="reset" color="danger" outline
        label="Cancelar" />
      </div>
    </form>
  </LayoutMain>
</template>
