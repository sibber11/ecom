<script setup>

import {onMounted, ref} from "vue";
import debounce from "lodash/debounce";
import TextInput from "@/components/TextInput.vue";

const props = defineProps(['modelValue', 'url', 'modelName']);

defineEmits(['update:modelValue']);

const models = ref([]);

//fetch parent models using a function with debounce
const fetchModels = debounce((event) => {
    get_model(event.target.value)
}, 300)

function get_model(value) {
    axios.post(props.url, {
        name: value
    })
        .then((r) => {
            models.value = r.data
        })
}

onMounted(() => {
    if (models.value.length === 0) {
        get_model('');
    }
})

</script>

<template>

    <TextInput
        :id="modelName+'_name'"
        type="text"
        class="mt-1 block w-full"
        @input="fetchModels($event); $emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        :list="modelName+'-list'"
        ref="textinput"
        :placeholder="modelName + ' name'"
    />

    <datalist :id="modelName+'-list'">
        <option v-for="model in models" :value="model.name" :key="model.id"></option>
    </datalist>

</template>
