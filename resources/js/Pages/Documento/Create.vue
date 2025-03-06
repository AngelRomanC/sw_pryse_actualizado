<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";



// Recibimos las personas desde el controlador
const props = defineProps(['personas']);
console.log('Props recibidas:', props.personas);


// Inicializamos el formulario
const form = useForm({
  persona_id: '',
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

// Función para enviar el formulario
const submit = () => {
  form.post(route('documento.store'), {
    onSuccess: () => {

    },
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

    <h1 class="text-2xl font-bold mb-4">Cargar Documentos</h1>

    <form @submit.prevent="submit">
      <!-- Seleccionar persona -->
      <div class="mb-4">
        <select id="id_persona" v-model="form.persona_id"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
          <option value="" disabled>Seleccione una persona</option>
          <!-- Mostrar solo personas con documentos incompletos -->
          <option v-for="persona in personas" :key="persona.id" :value="persona.id">
            {{ persona.nombre + ' ' + persona.apellido_paterno }}
            (Documentos: {{ persona.documentos ? persona.documentos.length : 0 }}/9)
          </option>
        </select>
      </div>

      <!-- Campo para CURP -->
      <div class="mb-4">
        <label for="doc_curp" class="block text-sm font-medium text-gray-700">CURP</label>
        <input type="file" id="doc_curp" @input="form.doc_curp = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para RFC -->
      <div class="mb-4">
        <label for="doc_rfc" class="block text-sm font-medium text-gray-700">RFC</label>
        <input type="file" id="doc_rfc" @input="form.doc_rfc = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para Acta de Nacimiento -->
      <div class="mb-4">
        <label for="acta_nacimiento" class="block text-sm font-medium text-gray-700">Acta de Nacimiento</label>
        <input type="file" id="acta_nacimiento" @input="form.acta_nacimiento = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para CUIP -->
      <div class="mb-4">
        <label for="doc_cuip" class="block text-sm font-medium text-gray-700">CUIP</label>
        <input type="file" id="doc_cuip" @input="form.doc_cuip = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para INE -->
      <div class="mb-4">
        <label for="ine" class="block text-sm font-medium text-gray-700">INE</label>
        <input type="file" id="ine" @input="form.ine = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para Cartilla Militar -->
      <div class="mb-4">
        <label for="cartilla_militar" class="block text-sm font-medium text-gray-700">Cartilla Militar</label>
        <input type="file" id="cartilla_militar" @input="form.cartilla_militar = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para Comprobante de Domicilio -->
      <div class="mb-4">
        <label for="comprobante_domicilio" class="block text-sm font-medium text-gray-700">Comprobante de
          Domicilio</label>
        <input type="file" id="comprobante_domicilio" @input="form.comprobante_domicilio = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para NSS -->
      <div class="mb-4">
        <label for="doc_nss" class="block text-sm font-medium text-gray-700">NSS</label>
        <input type="file" id="doc_nss" @input="form.doc_nss = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Campo para Firma Digital -->
      <div class="mb-4">
        <label for="firma_digital" class="block text-sm font-medium text-gray-700">Firma Digital</label>
        <input type="file" id="firma_digital" @input="form.firma_digital = $event.target.files[0]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Botón de enviar -->
      <div class="mt-6">
        <BaseButtons>
        <BaseButton @click="submit" type="submit" color="info" outline label="Crear" />

        <BaseButton :href="route('documento.index')" type="reset" color="danger" outline label="Cancelar" />
      
      </BaseButtons>
    </div>
    </form>
  </LayoutMain>
</template>
