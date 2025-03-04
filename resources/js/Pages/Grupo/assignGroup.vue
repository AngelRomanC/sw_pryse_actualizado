<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV5 from "@/components/FormControlV5.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';
import { 
  mdiAccountSchool,

} from '@mdi/js';

const props = defineProps({
  name: 'Create',
  titulo: { type: String, required: true },
  alumnos: { type: Object, required: true }, 
  grupo: { type: Object, required: true },
  usuarios: { type: Object, required: true },
});

const selectedAlumno = null;
const form = useForm({
  alumno_id: '',
  grupo_id: props.grupo.id
});

const guardar = () => {
  form.post(route("grupos.assign-group.post"));
};

</script>

<template>
  <LayoutMain :title="titulo">
    
    <CardBox form @submit.prevent="guardar">
      <FormField label="Alumnos">
        <FormControlV5 :icon="mdiAccountSchool" v-model="form.alumno_id" :showOption="'name'" :options="usuarios" />
      </FormField>

      
      <template #footer>
        <BaseButtons>
          <BaseButton @click="guardar" type="submit" color="warning" label="Agregar alumno" />
          <BaseButton :href="route(`grupo.index`)" type="reset" color="danger" outline label="Cancelar" />
        </BaseButtons>
      </template>
    </CardBox>
  </LayoutMain>
</template>

