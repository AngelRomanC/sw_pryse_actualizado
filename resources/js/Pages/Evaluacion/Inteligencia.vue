<script>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
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
        respuestas: { type: Object, required: true},
        Evaluacion: { type: Object, required: true},
        preguntas: { type: Object, required: true},
        version: { type: Object, required: true},
        grupo: { type: Object, required: true},
        Inteligencia: { type: Object, required: true},
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
        const versionSeleccionada = ref('');
        const seleccionarVersion = (event) => {
    const seleccion = event.target.value; 
    versionSeleccionada.value = seleccion; // Actualizar el valor de versionSeleccionada
  };
        const form = useForm({
            respuesta: '',
            inteligencia: '',
            evaluacion_id:'',
            version:'',
            formato: 3,
        });
        
        const handleSubmit = (inteligencia) => {
            // Asignar el ID del académico al campo oculto
            form.inteligencia = inteligencia.id;
            form.version =inteligencia.version;
            form.post(route('evaluacion.store'));
        };

        const actualizarObservacion = (inteligencia, evaluacion) => {
    
    form.inteligencia = inteligencia.user_id;
    form.respuesta = evaluacion.respuesta;
    form.evaluacion_id =evaluacion.id;
    form.version =inteligencia.version;
    form.put(route('evaluacion.update', evaluacion.id), {
        respuesta: evaluacion.respuesta // Enviar la respuesta actualizada
    }).then(() => {
        // Aquí puedes agregar lógica adicional después de la actualización, como mostrar una notificación de éxito
        console.log('La observación se ha actualizado correctamente.');
    }).catch(error => {
        // Manejar errores si la solicitud de actualización falla
        console.error('Error al actualizar la observación:', error);
    });
};

        const existeEvaluacionParaInteligencia = (inteligencia) => {
        return props.Evaluacion.some(evaluacion => evaluacion.user_id === inteligencia.user.id && evaluacion.version === inteligencia.version);
    };
        const togglePreguntasRespuestas = (inteligencia) => {
            inteligencia.mostrarPreguntasRespuestas = !inteligencia.mostrarPreguntasRespuestas;

            // Desplazar el elemento seleccionado hacia arriba después de un breve retraso
            setTimeout(() => {
                const elemento = document.getElementById(`inteligencia_${inteligencia.id}`);
                if (elemento && inteligencia.mostrarPreguntasRespuestas) {
                    elemento.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        };

        

        return {
            form,
            versionSeleccionada,
            seleccionarVersion,
         
            mdiMonitorCellphone,
            mdiTableBorder,
            togglePreguntasRespuestas,
            handleSubmit,
            existeEvaluacionParaInteligencia,
            actualizarObservacion,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit,
            mdiTrashCan,
        }
    }
}
</script>

<template>
  <LayoutMain>
      <SectionTitleLineWithButton :title="titulo" main></SectionTitleLineWithButton>
      
      <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
          {{ $page.props.flash.success }}
      </NotificationBar>
      
      <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
          {{ $page.props.flash.error }}
      </NotificationBar>

      <select v-model="versionSeleccionada" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
        <option value="">Seleccionar versión</option>
        <option v-for="version in version" :value="version">{{ version }}</option>
      </select>
      

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
        <div v-for="inteligencia in Inteligencia" :key="inteligencia.id" :ref="`inteligencia_${inteligencia.id}`" :class="{ 'lg:col-span-2': inteligencia.mostrarPreguntasRespuestas, 'lg:col-span-1': !inteligencia.mostrarPreguntasRespuestas }">
          <template v-if="inteligencia.estatus === 1 && inteligencia.version === versionSeleccionada">
            <div class="border border-gray-300 rounded-lg p-4" :class="{ 'bg-gray-200': inteligencia.mostrarPreguntasRespuestas }">
              <div class="font-bold text-xl mb-2">Alumno: {{ inteligencia.user.name }} {{ inteligencia.user.apellido_paterno }} {{ inteligencia.user.apellido_materno }}</div>
              <p class="text-gray-700 text-base">Matrícula: {{ inteligencia.matricula }}</p>
              <p class="text-gray-700 text-base">Grado: {{ inteligencia.grupo.grado }}</p>
              <p class="text-gray-700 text-base">Grupo: {{ inteligencia.grupo.grupo }}</p>
              <button @click="togglePreguntasRespuestas(inteligencia)" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                {{ inteligencia.mostrarPreguntasRespuestas ? 'Ocultar Preguntas y Respuestas' : 'Ver Preguntas y Respuestas' }}
              </button>
              <div v-if="inteligencia.mostrarPreguntasRespuestas" class="mt-4">
                <div v-for="(pregunta, id) in preguntas" :key="id">
                  <template v-if="pregunta.version === inteligencia.version">
                    <strong>{{ pregunta.pregunta }}</strong>
                    <ul>
                      <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id && item.user_id === inteligencia.user_id)" :key="respuesta.id">
                        {{ respuesta.respuesta }}
                      </li>
                    </ul>
                  </template>
                </div>
                <template v-if="existeEvaluacionParaInteligencia(inteligencia)">
                  <!-- Mostrar la observación de la evaluación existente academico-->
                  <div v-for="evaluacion in Evaluacion" :key="evaluacion.id">
                    <template v-if="evaluacion.user_id === inteligencia.user.id  && evaluacion.version === inteligencia.version && evaluacion.formato === 3">
                      <textarea v-model="evaluacion.respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Observación"></textarea>
                      <button @click="actualizarObservacion(inteligencia,evaluacion)" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                        Actualizar Observación
                      </button>
                    </template>
                  </div>
                </template>
                <!-- Si no hay evaluación, mostrar el formulario para crear una nueva observación -->
                <template v-else>
                  <form @submit.prevent="handleSubmit(inteligencia)">
                    <!-- Agregar un campo oculto para almacenar el ID del académico -->
                    <input type="hidden" v-model="form.inteligencia" name="inteligencia_id">
                    <textarea v-model="form.respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Escribe tu observación aquí"></textarea>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                      Enviar Observación
                    </button>
                  </form>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
      
    
  </LayoutMain>
</template>

  
  