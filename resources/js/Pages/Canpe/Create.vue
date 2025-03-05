<script setup>
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import BaseButton from "@/components/BaseButton.vue";
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
    form.post(route('canpe.store'), {
        onSuccess: () => {
            Swal.fire("Éxito", "Registro guardado correctamente", "success");
            form.reset();
        }
    });
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
                <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input v-model="form.password_canpe" type="password" class="border rounded w-full p-2">
            </div>

            <div class="mb-4 flex items-center">
                <input v-model="form.inaccesible_canpe" type="checkbox" class="mr-2">
                <label class="text-gray-700 text-sm">Inaccesible Canpe</label>
            </div>

            <BaseButton type="submit" color="primary" label="Guardar" :disabled="form.processing" />
        </form>
    </LayoutMain>
</template>
