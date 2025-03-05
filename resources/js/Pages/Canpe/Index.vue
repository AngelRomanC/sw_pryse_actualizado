<script setup>
import { router } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import BaseButton from "@/components/BaseButton.vue";

defineProps({
    canpes: Object
});

const destroy = (id) => {
    if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        router.delete(route('canpe.destroy', id));
    }
};
</script>

<template>
    <LayoutMain>
        <div class="flex justify-between">
            <h1 class="text-xl font-bold">Lista de Canpe</h1>
            <BaseButton :href="route('canpe.create')" color="primary" label="Nuevo Registro" />
        </div>

        <table class="w-full border-collapse border mt-4">
            <thead>
                <tr>
                    <th class="border p-2">Persona</th>
                    <th class="border p-2">Correo</th>
                    <th class="border p-2">Estatus</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="canpe in canpes.data" :key="canpe.id">
                    <td class="border p-2">{{ canpe.persona.nombre }} {{ canpe.persona.apellido_paterno }}</td>
                    <td class="border p-2">{{ canpe.correo_canpe }}</td>
                    <td class="border p-2">{{ canpe.estatus_canpe }}</td>
                    <td class="border p-2">
                        <BaseButton :href="route('canpe.edit', canpe.id)" color="secondary" label="Editar" />
                        <BaseButton @click="destroy(canpe.id)" color="danger" label="Eliminar" />
                    </td>
                </tr>
            </tbody>
        </table>
    </LayoutMain>
</template>
