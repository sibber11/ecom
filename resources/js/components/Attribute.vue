<script setup>
import {ref} from 'vue';

defineProps(['modelValue', 'attribute']);

defineEmits(['update:modelValue']);

const input = ref(null);

</script>

<template>
    <div class="mt-2">
        <h3 class="text-gray-800 mb-2 capitalize font-bold">{{attribute.name}}:</h3>
        <div class="flex gap-2 flex-wrap">
            <template v-if="attribute.type === 'select'">
                <select name="" id=""
                        :value="modelValue"
                        @input="$emit('update:modelValue', $event.target.value)"
                >
                    <option :value="option.value" v-for="option in attribute.options">{{option.name}}</option>
                </select>
            </template>
            <template v-else-if="attribute.type === 'radio'">
                <div v-for="option in attribute.options">
                    <input type="radio" :id="option.value" :name="attribute.name" ref="input"
                           :value="modelValue"
                           @input="$emit('update:modelValue', $event.target.value)"
                    >
                    <label :for="option.value">{{option.name}}</label>
                </div>
            </template>
            <template v-else-if="attribute.type === 'checkbox'">
                <div v-for="option in attribute.options">
                    <input type="checkbox" :id="option.value" :name="attribute.name" ref="input"
                           :value="modelValue"
                           @input="$emit('update:modelValue', $event.target.value)"
                    >
                    <label :for="option.value" class="p-2">{{option.name}}</label>
                </div>
            </template>
<!--            <div v-for="option in attribute.options">-->
<!--                {{option}}-->
<!--                <input :type="attribute.type" name="" :id="attribute.name">-->
<!--            </div>-->
<!--            <div v-for="option in attribute.options" class="color-selector">-->
<!--                <input :id="option.name" v-model="form.options[attribute.name]" :name="attribute.name"-->
<!--                       :type="attribute.type"-->
<!--                       :value="option.name">-->
<!--                <label :for="option.name"-->
<!--                       :style="{'background-color': option.name}"-->
<!--                       class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"></label>-->
<!--            </div>-->

        </div>
    </div>

</template>
