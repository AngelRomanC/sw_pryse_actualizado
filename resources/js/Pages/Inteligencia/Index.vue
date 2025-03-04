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
        preguntas:{ type: Object, required: true },
        Inteligencia: { type: Object, required: true },
        inteligenciaId:{ type: String, required: true },
        respuestas: { type: Object, required: true },
        versions: { type: Object, required: true },
        version_habilitada:{ type: Object, required: true },
        periodo: { type: Object, required: true },
        profesor: { type: Object, required: true },
        grupo:{ type: Object, required: true },
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
    setup() {
        const form = useForm({
            matricula: '',
            tutor:'',
            periodo:'',
            formato:'',
            pregunta:'',
        });
        const buscarformato = () => {
            if (form.version) {
                const url = route('inteligencia.create', { version: form.version.version });
        window.location.href = url;
                }
        };
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
                    form.delete(route("inteligencia.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,buscarformato,
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
        
        <form @submit.prevent="buscarformato">
            <select v-model="form.version">
                <option value="">Formatos disponibles</option>
                <option v-for="version in version_habilitada" :key="version.id" :value="version">
                    <!-- Aquí se aplica la validación del estatus -->
                    <template v-if="version.estatus === 1">
                        {{ version.version }}
                    </template>
                </option>
            </select>
            <button type="submit">Generar formato</button>
        </form>
        
        <CardBox v-for="inteligencia in Inteligencia" :key="inteligencia.id">
            <template v-if="inteligencia.estatus === 1">
            <div>
                <div>
                    <strong>Matrícula:</strong> {{ inteligencia.matricula }}
                </div>
                <div>
                    <strong>Grupo:</strong> {{ grupo.grado }} °{{ grupo.grupo }}
                </div>
                <div > 
                    <strong>Tutor:</strong> {{ profesor.name }}
                </div>
                <div>
                    <strong>Periodo:</strong> {{ periodo.periodo }} {{ periodo.año }}
                </div>
                <div v-for="(pregunta, id) in preguntas" :key="id">
                    <template v-if="pregunta.version === inteligencia.version">
                        <strong>{{ pregunta.pregunta }}</strong>
                        <ul>
                            <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id)" :key="respuesta.id">
                                {{ respuesta.respuesta }}
                            </li>
                        </ul>
                    </template>
                </div>
              
                <BaseButton :href="`inteligencia/${inteligencia.id}/edit/${inteligencia.version}`" color="warning" label="Modificar formato"  style="float: right;"/>

            </div>
            </template>
            </CardBox>

    </LayoutMain>
</template>
