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


// Recibimos el objeto Canpe desde el controlador
const props = defineProps({
    canpe: Object
});
// Inicializamos el formulario con los datos actuales del Canpe
const form = useForm({
    registrado_canpe: props.canpe.registrado_canpe,
    estatus_canpe: props.canpe.estatus_canpe,
    correo_canpe: props.canpe.correo_canpe,
    password_canpe: props.canpe.password_canpe,
    inaccesible_canpe: props.canpe.inaccesible_canpe
});

// Manejar la actualización del Canpe
const submit = () => {
    form.put(route("canpe.update", props.canpe.id));
};
const titulo = "Editar información de Canpe";


</script>

<template>
    <LayoutMain>

        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>

        </SectionTitleLineWithButton>


        <CardBox class="mb-6" has-table>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Registrado Canpe</label>
                    <input type="text" v-model="form.registrado_canpe"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"  />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Estatus Canpe</label>
                    <input type="text" v-model="form.estatus_canpe"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"  />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Correo Canpe</label>
                    <input type="email" v-model="form.correo_canpe"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"  />
                </div>

                 <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contraseña </label>
                    <input type="text" v-model="form.password_canpe"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" />
                </div>        

                <div class="mb-4">
                    <label class="text-gray-700 text-sm mr-4">Inaccesible Canpe</label>
                    <input v-model="form.inaccesible_canpe" type="radio" :value="1" class="mr-2"> Sí
                    <input v-model="form.inaccesible_canpe" type="radio" :value="0" class="mr-2"> No
                </div>

                

                <div class="mt-6 flex space-x-4">
                    <BaseButton @click="submit" type="submit" color="info" outline label="Actualizar" />
                    <BaseButton :href="route('canpe.index')" type="reset" color="danger" outline label="Cancelar" />
                </div>

            </form>
        </CardBox>
    </LayoutMain>
</template>
