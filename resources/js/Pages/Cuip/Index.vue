<script setup>
import { router } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import BaseButton from '@/components/BaseButton.vue';
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import Swal from "sweetalert2";
import { mdiTagEdit, mdiDeleteOutline, mdiAlertCircleOutline } from "@mdi/js"; // Importar los íconos

import Pagination from '@/Shared/Pagination.vue';
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import CardBox from "@/components/CardBox.vue";
import NotificationBar from "@/components/NotificationBar.vue";




defineProps({
    canpes: Object
});

const destroy = (id) => {
    console.log("ID del documento a eliminar:", id); // Depuración: Verifica el ID
    Swal.fire({
        title: "¿Esta seguro?",
        text: "Esta acción no se puede revertir",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Si!, eliminar registro!",
    }).then((res) => {
        if (res.isConfirmed) {
            router.delete(route("canpe.destroy", id));


        }
    });
};
const titulo = "Información de canpe";

</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
            <BaseButton :href="'canpe/create'" color="warning" label="Nuevo registro canpe" />

        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="canpes.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table class="w-full border-collapse border mt-4">
                <thead>
                    <tr>
                        <th />
                        <th class="border p-2">Persona</th>
                        <th class="border p-2">Correo</th>
                        <th class="border p-2">Estatus</th>
                        <th class="border p-2">Acciones</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="canpe in canpes.data" :key="canpe.id">
                        <td class="align-items-center">
                        </td>
                        <td class="border p-2">{{ canpe.persona.nombre }} {{ canpe.persona.apellido_paterno }}</td>
                        <td class="border p-2">{{ canpe.correo_canpe }}</td>
                        <td class="border p-2">{{ canpe.estatus_canpe }}</td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route('canpe.edit', canpe.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small @click="destroy(canpe.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :currentPage="canpes.current_page" :links="canpes.links" :total="canpes.links.length - 2">
            </Pagination>

        </CardBox>
    </LayoutMain>
</template>
