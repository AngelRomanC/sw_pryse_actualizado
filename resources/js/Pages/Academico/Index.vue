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
        Academico: { type: Object, required: true },
        profesor: { type: Object, required: true },
        respuestas: { type: Object, required: true },
        preguntas:{ type: Object, required: true },
        periodo:{ type: Object, required: true },
        versions:{ type: Object, required: true },
        version_habilitada:{ type: Object, required: true },
        academicoId:{ type: String, required: true },
        grupo:{ type: Object, required: true },
        estatusgrupo:{ type: String, required: true },
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
            materia_recursar:'',
            pregunta:'',
            formato:'',
            version: '',
        });
        const buscarformato = () => {
    if (form.version) {
        const url = route('academico.create', { version: form.version.version });
        window.location.href = url;
    }
};

     

        return {
            form, buscarformato, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
        }
    },
    


}


</script>

<template>
    
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
        </SectionTitleLineWithButton>
        

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        {{ estatus }}
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
        <CardBox v-for="academico in Academico" :key="academico.id">
            <template v-if="academico.estatus === 1  ">
            <div>
                <div>
                    <strong>Matrícula:</strong> {{ academico.matricula }}
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
                <div>
                    <strong>Materia a recursar:</strong> {{ academico.materia_recursar}}
                </div>
                
                
                <div v-for="(pregunta, id) in preguntas" :key="id">
                    <template v-if="pregunta.version === academico.version">
                        <strong>{{ pregunta.pregunta }}</strong>
                        <ul>
                            <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id)" :key="respuesta.id">
                                {{ respuesta.respuesta }}
                            </li>
                        </ul>
                    </template>
                </div>
                <div>
                    <BaseButton :href="`academico/${academicoId}/edit/${academico.version}`" color="warning" label="Modificar formato" style="float: right;"/>

                </div>
            </div>
        </template>
        </CardBox>

    </LayoutMain>
</template>

