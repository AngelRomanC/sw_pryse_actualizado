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
    cuips: Object
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
            router.delete(route("cuip.destroy", id));


        }
    });
};
const titulo = "Información de canpe";

</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
            <BaseButton :href="'cuip/create'" color="warning" label="Nuevo registro canpe" />

        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="'mdi-information'" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="cuips.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table class="w-full border-collapse border mt-4">
                <thead>
                    <tr>
                        <th />
                        <th class="border p-2">Persona</th>
                        <th class="border p-2">Folio CUIP</th>
                        <th class="border p-2">EstatuS RFC</th>
                        <th class="border p-2">Acciones</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cuip in cuips.data" :key="cuip.id">
                        <td class="align-items-center">
                        </td>
                        <td class="border p-2">{{ cuip.persona.nombre }} {{ cuip.persona.apellido_paterno }}</td>
                        <td class="border p-2">{{ cuip.folio_cuip }}</td>
                        <td class="border p-2">{{ cuip.estatus_rfc }}</td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiTagEdit" small
                                    :href="route('cuip.edit', cuip.id)" />
                                <BaseButton color="danger" :icon="mdiDeleteOutline" small @click="destroy(cuip.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :currentPage="cuips.current_page" :links="cuips.links" :total="cuips.links.length - 2">
            </Pagination>

        </CardBox>
    </LayoutMain>
</template>
