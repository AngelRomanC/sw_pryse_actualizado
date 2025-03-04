<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

defineProps({
    titulo: String,
    routeName: String
});

const form = useForm({
    nombre: '',
    registrado_canpe: '',
    estatus_canpe: '',
    correo_canpe: '',
    password_canpe: '',
    inaccesible_canpe: '',
    entidad_nacimiento: ''
    
});

const handleSubmit = () => {
    form.post(route('canpe.store'));
};
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            <a :href="`${route(routeName + 'index')}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x"
                    viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField :error="form.errors.nombre">
                <FormControl v-model="form.nombre" placeholder="Nombre" />
            </FormField>
            <FormField :error="form.errors.apellido_paterno">
                <FormControl v-model="form.apellido_paterno" placeholder="Apellido Paterno" />
            </FormField>
            <FormField :error="form.errors.apellido_materno">
                <FormControl v-model="form.apellido_materno" placeholder="Apellido Materno" />
            </FormField>
            <FormField :error="form.errors.sexo">
                <select v-model="form.sexo" class="w-full p-2 border rounded">
                    <option disabled value="">Selecciona tu sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </FormField>
            <FormField :error="form.errors.fecha_nacimiento">
                <FormControl v-model="form.fecha_nacimiento" type="date" placeholder="Fecha de Nacimiento" />
            </FormField>
            <FormField :error="form.errors.edad">
                <FormControl v-model="form.edad" type="number" placeholder="Edad" />
            </FormField>
            <FormField :error="form.errors.entidad_nacimiento">
                <select v-model="form.entidad_nacimiento" class="w-full p-2 border rounded">
                    <option disabled value="">Selecciona estado de nacimiento</option>
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
            </FormField>

            <BaseButtons>
                <BaseButton @click="handleSubmit" type="submit" color="info" label="Crear" />
                <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
            </BaseButtons>
        </CardBox>
    </LayoutMain>
</template>
