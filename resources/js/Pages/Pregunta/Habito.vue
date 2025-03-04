<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiApplicationEdit, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";



export default {
    props: {
        titulo: { type: String, required: true },
        Pregunta: { type: Object, required: true },
        version: { type: Object, required: true },
        Academico: { type: Object, required: true },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },
    setup(props) {
        const form = useForm({
            pregunta: '',
            formato: 2,
            version: '',
        });
        const versions = props.version;
        const eliminar = (id) => {
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
                    form.delete(route("pregunta.destroy", id));
                }
            });
        };
        const habilitarFormulario = () => {
            form.get(route("pregunta.habilitar"))
                .then(() => {
                    // Manejar la respuesta del servidor si es necesario
                })
                .catch(error => {
                    // Manejar cualquier error que ocurra durante la solicitud
                    console.error(error);
                });
        };
        return {
            form, eliminar, mdiMonitorCellphone,versions,habilitarFormulario,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
        }
    }

}
</script>
<template>
   
    <LayoutMain>
        <SectionTitleLineWithButton  :title="titulo" main>
            

        </SectionTitleLineWithButton>
       
        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        
        <CardBox v-if="Pregunta.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <form @submit.prevent="buscarPreguntas" class="flex justify-between">
                <select v-model="form.version">
                    <option value="">Todas las versiones</option>
                    <option v-for="version in versions" :value="version">{{ version }}</option>
                </select>
                <button type="submit">Buscar</button>
               
                <div  class="ml-auto">

                    <BaseButton :href="route('pregunta.agregar-pregunta', { id: form.formato, version_id: form.version })" color="warning" label="Agregar nueva pregunta" />

                </div>
               
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Preguntas </th>
                       <th>Version</th>
                        <th></th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in Pregunta.data.filter(item => !form.version || item.version === form.version)" :key="item.id">
                        <td class="align-items-center">
                         
                        </td>
                        <td >
                            {{ item.pregunta }}
                        </td>
                        <td >
                            {{ item.version }}
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="warning" :icon="mdiApplicationEdit" small
                                    :href="route(`${routeName}edit`, item.id)" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Pagination :currentPage="Pregunta.current_page" :links="Pregunta.links"
                :total="Pregunta.links.length - 2"></Pagination>
        </CardBox>

    </LayoutMain>
</template>