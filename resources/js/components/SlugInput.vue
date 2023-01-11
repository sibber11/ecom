<script setup>

import debounce from "lodash/debounce";
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    url: String,
    modelValue: String
})

const emit = defineEmits(['update:modelValue']);

defineExpose({get_slug});

function get_slug(value = '') {
    if (value === '') {
        return;
    }
    processApiCall(value);
}

const processApiCall = debounce((value) => {
    axios.post(props.url, {
        name: value
    })
        .then((r) => {
            emit('update:modelValue', r.data.slug);
        })
        .catch(reason => {
            console.log(reason)
        })
}, 300)

</script>
<template>
    <TextInput
        id="slug"
        type="text"
        :value="modelValue"
        disabled
    />
</template>
