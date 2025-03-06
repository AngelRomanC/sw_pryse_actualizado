<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { ref } from 'vue';
import Swal from 'sweetalert2';

// Propiedades
defineProps({
    personas: { type: Array, required: true }, // Lista de personas para el select
});

// Formulario con datos iniciales
const form = useForm({
    persona_id: '',
    registrado_canpe: '',
    estatus_canpe: '',
    correo_canpe: '',
    password_canpe: '',
    inaccesible_canpe: false
});

// Enviar formulario
const submit = () => {
    form.post(route('canpe.store'));
};
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton title="Registrar Información Canpe" main>
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
                <label class="block text-gray-700 text-sm font-bold mb-2">Registrado Canpe</label>
                <input v-model="form.registrado_canpe" type="text" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Estatus Canpe</label>
                <input v-model="form.estatus_canpe" type="text" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Correo</label>
                <input v-model="form.correo_canpe" type="email" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña22222</label>
                <input v-model="form.password_canpe" type="text" class="border rounded w-full p-2">
            </div>


            <div class="mb-4">
                <label class="text-gray-700 text-sm mr-4">Inaccesible Canpe</label>
                <input v-model="form.inaccesible_canpe" type="radio" :value="1" class="mr-2"> Sí
                <input v-model="form.inaccesible_canpe" type="radio" :value="0" class="mr-2"> No
            </div>
            <BaseButtons>
                
                <BaseButton @click="submit"  color="info" outline label="Crear" />

                <BaseButton :href="route('canpe.index')" type="reset" color="danger" outline label="Cancelar" />

            </BaseButtons>
        </form>
    </LayoutMain>
</template>
