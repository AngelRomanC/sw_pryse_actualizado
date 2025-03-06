<script setup>
import { ref, defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import NotificationBar from "@/components/NotificationBar.vue";
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js"; //agregado
import CardBox from "@/components/CardBox.vue";



// Recibimos el objeto Cuip desde el controlador
const props = defineProps({
    cuip: Object
});
// Inicializamos el formulario con los datos actuales del Canpe
const form = useForm({
    folio_cuip: props.cuip.folio_cuip,
    fecha_expedicion: props.cuip.fecha_expedicion,
    estatus_rfc: props.cuip.estatus_rfc,
    vigencia_ine: props.cuip.vigencia_ine,
    estado_ine: props.cuip.estado_ine,
    valida_ine: props.cuip.valida_ine

});

// Manejar la actualización del Canpe
const submit = () => {
    form.put(route("cuip.update", props.canpe.id));
};
const titulo = "Editar información de Cuip,INE,RFC";


</script>

<template>
    <LayoutMain>

        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>

        </SectionTitleLineWithButton>


        <CardBox class="mb-6" has-table>

            <form @submit.prevent="submit">
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



                <div class="mt-6 flex space-x-4">
                    <BaseButton @click="submit" type="submit" color="info" outline label="Actualizar" />
                    <BaseButton :href="route('canpe.index')" type="reset" color="danger" outline label="Cancelar" />
                </div>

            </form>
        </CardBox>
    </LayoutMain>
</template>
