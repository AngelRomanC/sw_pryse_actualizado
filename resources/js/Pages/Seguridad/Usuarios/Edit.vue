<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'usuario', 'routeName']);
const form = useForm({ ...props.usuario });

const guardar = () => {
    form.put(route("usuarios.update", props.usuario.id));
};

</script>

<template>
    <LayoutMain :title="titulo">



        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre">
                <FormControl v-model="form.name" placeholder="nombre" />
                <FormControl v-model="form.apellido_paterno" placeholder="apellido_paterno" />
                <FormControl v-model="form.apellido_materno" placeholder="apellido_materno" />
                <FormControl v-model="form.numero" placeholder="numero" />
                <FormControl v-model="form.email" placeholder="email" />

            </FormField>


            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

