<script>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        versionAcademico: { type: Object, required: true },
        versionHabito: { type: Object, required: true },
        versionInteligencia: { type: Object, required: true },
        grupos: { type: Object, required: true },
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
    setup(props) {
        const handleSubmit = () => {
            form.post(route('pregunta.store-pregunta'));
        };
        const selectedVersion = ref('');
const selectedGrupo = ref('');
const selectedAccion = ref('');
const formatoid = ref('');
const selectedVersionHabito = ref('');
const selectedGrupoHabito = ref('');
const selectedAccionHabito = ref('');
const formatoidHabito = ref('');
const selectedVersionInteligencia = ref('');
const selectedGrupoInteligencia = ref('');
const selectedAccionInteligencia = ref('');
const formatoidInteligencia = ref('');


function generateRoute(tipo) {
      let formato_id = 0;
      if (tipo === 'Análisis académico') {
        formato_id = 1;
      } else if (tipo === 'Habitos de estudio') {
        formato_id = 2;
      } else if (tipo === 'Inteligencias múltiples') {
        formato_id = 3;
        
      }
      
      return route('pregunta.habilitar-formulario', {
        formato_id: formato_id,
        version_id: tipo === 'Análisis académico' ? selectedVersion.value : tipo === 'Habitos de estudio' ? selectedVersionHabito.value : selectedVersionInteligencia.value,
        estatus: tipo === 'Análisis académico' ? selectedAccion.value : tipo === 'Habitos de estudio' ? selectedAccionHabito.value : selectedAccionInteligencia.value,
        grupo_id: tipo === 'Análisis académico' ? selectedGrupo.value : tipo === 'Habitos de estudio' ? selectedGrupoHabito.value : selectedGrupoInteligencia.value
      });
    }

    return {
      selectedVersion, selectedGrupo, selectedAccion, formatoid,
      selectedVersionHabito, selectedGrupoHabito, selectedAccionHabito, formatoidHabito,
      selectedVersionInteligencia, selectedGrupoInteligencia, selectedAccionInteligencia, formatoidInteligencia,
      generateRoute,
    }

    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
          
        </SectionTitleLineWithButton>

<div>
    <!-- Sección de Análisis académico -->
    <div>
      Análisis académico:
      <select v-model="selectedVersion">
        <option value="">Seleccionar versión</option>
        <option v-for="version in versionAcademico" :value="version">{{ version }}</option>
      </select>
      Seleccionar grupo:
      <select v-model="selectedGrupo">
        <option value="">Seleccionar grupo</option>
        <option v-for="grupo in grupos" :value="grupo.id">{{ grupo.grado }} - {{ grupo.grupo }}</option>
      </select>
      <select v-model="selectedAccion">
        <option value="">Seleccionar acción</option>
        <option value="habilitar">Habilitar</option>
        <option value="deshabilitar">Deshabilitar</option>
      </select>
      <input type="hidden" name="formatoid" v-model="formatoid" >
      <a :href="generateRoute('Análisis académico')" >
        {{ selectedAccion === 'habilitar' ? 'Habilitar' : 'Deshabilitar' }}
      </a>
    </div>
<br>
    <!-- Sección de Habitos de estudio -->
    <div>
      Habitos de estudio:
      <select v-model="selectedVersionHabito">
        <option value="">Seleccionar versión</option>
        <option v-for="version in versionHabito" :value="version">{{ version }}</option>
      </select>
      Seleccionar grupo:
      <select v-model="selectedGrupoHabito">
        <option value="">Seleccionar grupo</option>
        <option v-for="grupo in grupos" :value="grupo.id">{{ grupo.grado }} - {{ grupo.grupo }}</option>
      </select>
      <select v-model="selectedAccionHabito">
        <option value="">Seleccionar acción</option>
        <option value="habilitar">Habilitar</option>
        <option value="deshabilitar">Deshabilitar</option>
      </select>
      <input type="hidden" name="formatoidHabito" v-model="formatoidHabito" >
      <a :href="generateRoute('Habitos de estudio')" >
        {{ selectedAccionHabito === 'habilitar' ? 'Habilitar' : 'Deshabilitar' }}
      </a>
    </div>
    <br>
    <!-- Sección de Inteligencias múltiples -->
    <div>
      Inteligencias múltiples:
      <select v-model="selectedVersionInteligencia">
        <option value="">Seleccionar versión</option>
        <option v-for="version in versionInteligencia" :value="version">{{ version }}</option>
      </select>
      Seleccionar grupo:
      <select v-model="selectedGrupoInteligencia">
        <option value="">Seleccionar grupo</option>
        <option v-for="grupo in grupos" :value="grupo.id">{{ grupo.grado }} - {{ grupo.grupo }}</option>
      </select>
      <select v-model="selectedAccionInteligencia">
        <option value="">Seleccionar acción</option>
        <option value="habilitar">Habilitar</option>
        <option value="deshabilitar">Deshabilitar</option>
      </select>
      <input type="hidden" name="formatoidInteligencia" v-model="formatoidInteligencia" >
      <a :href="generateRoute('Inteligencias múltiples')" >
        {{ selectedAccionInteligencia === 'habilitar' ? 'Habilitar' : 'Deshabilitar' }}
      </a>
    </div>
  </div>
</LayoutMain>
</template>
