<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import BaseButton from "@/components/BaseButton.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";

import BaseButtons from "@/components/BaseButtons.vue";


// Propiedades
defineProps({
    personas: { type: Array, required: true }, // Lista de personas para el select
});

// Formulario con datos iniciales
const form = useForm({
    persona_id: '',
    folio_cuip: '',
    fecha_expedicion: '',
    estatus_rfc: '',
    vigencia_ine: '',
    estado_ine: '',
    valida_ine: ''
});

// Enviar formulario
const submit = () => {
    form.post(route('cuip.store'));
};
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton title="Registrar Información Canpe" main>
            <BaseButton :href="route('canpe.index')" color="secondary" label="Volver" />
        </SectionTitleLineWithButton>

        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Persona</label>
                <select v-model="form.persona_id" class="border rounded w-full p-2">
                    <option v-for="persona in personas" :key="persona.id" :value="persona.id">
                        {{ persona.nombre }} {{ persona.apellido_paterno }}
                    </option>
                </select>
            </div>



            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ingresa folio cuip</label>
                <input v-model="form.folio_cuip" type="text" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de expedicion</label>
                <input v-model="form.fecha_expedicion" type="date" class="border rounded w-full p-2">
            </div>



            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Selecciona estatus de RFC</label>
                <select v-model="form.estatus_rfc" class="border rounded w-full p-2">
                    <option value="RFC válido, y susceptible de recibir facturas">
                        RFC válido, y susceptible de recibir facturas
                    </option>
                    <option value="RFC no registrado en el padrón de contribuyentes">
                        RFC no registrado en el padrón de contribuyentes
                    </option>
                </select>
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Vigencia de INE</label>
                <input v-model="form.vigencia_ine" type="text" class="border rounded w-full p-2" maxlength="4">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Selecciona estado del INE</label>
                <select v-model="form.estado_ine" class="w-full p-2 border rounded">
                    <option disabled value="">Seleccionar </option>
                    <option value="Aguascalientes">Aguascalientes</option>
                    <option value="Baja California">Baja California</option>
                    <option value="Baja California Sur">Baja California Sur</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Chiapas">Chiapas</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Ciudad de México">Ciudad de México</option>
                    <option value="Coahuila">Coahuila</option>
                    <option value="Colima">Colima</option>
                    <option value="Durango">Durango</option>
                    <option value="Estado de México">Estado de México</option>
                    <option value="Guanajuato">Guanajuato</option>
                    <option value="Guerrero">Guerrero</option>
                    <option value="Hidalgo">Hidalgo</option>
                    <option value="Jalisco">Jalisco</option>
                    <option value="Michoacán">Michoacán</option>
                    <option value="Morelos">Morelos</option>
                    <option value="Nayarit">Nayarit</option>
                    <option value="Nuevo León">Nuevo León</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro">Querétaro</option>
                    <option value="Quintana Roo">Quintana Roo</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="Sinaloa">Sinaloa</option>
                    <option value="Sonora">Sonora</option>
                    <option value="Tabasco">Tabasco</option>
                    <option value="Tamaulipas">Tamaulipas</option>
                    <option value="Tlaxcala">Tlaxcala</option>
                    <option value="Veracruz">Veracruz</option>
                    <option value="Yucatán">Yucatán</option>
                    <option value="Zacatecas">Zacatecas</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">INE es valida</label>
                <select v-model="form.valida_ine" class="w-full p-2 border rounded">
                    <option disabled value="">Seleccionar </option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                    <option value="N/A">N/A</option>
                </select>
            </div>

            <BaseButtons>
                <BaseButton type="submit" color="info" outline label="Guardar" :disabled="form.processing" />
                <BaseButton :href="route('cuip.index')" type="reset" color="danger" outline label="Cancelar" />
            </BaseButtons>
        </form>
    </LayoutMain>
</template>
