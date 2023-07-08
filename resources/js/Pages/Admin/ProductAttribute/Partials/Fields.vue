<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {onMounted, ref} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import CancelButton from "@/components/CancelButton.vue"

const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    attribute: Object
});

const form = useForm({
    name: '',
    type: 'radio',
    options: []
});
onMounted(() => {

    if (!props.attribute) {
        return
    }
    form.name = props.attribute.name;
    form.type = props.attribute.type;
    form.options = props.attribute.options.map(o=>{delete o.attribute_id; return o});
})

const addOption = () => {
    if (option.value === '') {
        return;
    }
    form.options.push({
        id: form.options.length + 1,
        name: option.value,
        value: option.value
    });
    option.value = '';
}


const option = ref('');
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Attribute Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update Attribute information.
            </p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="submitForm(method,form,url)">

            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    placeholder="Attribute name"
                    type="text"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="type" value="Type"/>

                <select
                    id="type"
                    v-model="form.type"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-gray-600"
                >
                    <option value="radio">Radio</option>
                    <option value="text">Text</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                </select>

                <InputError :message="form.errors.type" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="options" value="Options"/>

                <div class="flex gap-3">
                    <TextInput
                        id="option"
                        v-model="option"
                        class="mt-1 block w-full"
                        placeholder="Option name"
                        type="text"
                    />
                    <button class="bg-teal-500 text-white font-semibold mt-1 px-4 py-1 rounded block"
                            type="button"
                            @click="addOption"
                    >Add
                    </button>
                </div>
                {{form.errors}}
<!--                <InputError v-for="err in form.errors.options" :message="form.errors.options" class="mt-2"/>-->
                <table class="w-full my-4">
                    <caption class="font-bold py-4 border-b">Options</caption>
                    <tr>
                        <th class="bg-blue-100 border-b text-left px-6 py-4 whitespace-nowrap text-sm text-gray-800">#
                        </th>
                        <th class="bg-blue-100 border-b text-left px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            Names
                        </th>
                        <th class="bg-blue-100 border-b text-left px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            Value
                        </th>
                        <th class="bg-blue-100 border-b text-right px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            Action
                        </th>
                    </tr>
                    <tr v-for="(option, index) in form.options" :key="index" class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="border-b px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ index + 1 }}
                        </td>
                        <td class="border-b px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ option.name }}
                        </td>
                        <td class="border-b px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ option.value }}
                        </td>
                        <td class="border-b px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-4">
                            <span class="flex flex-col justify-between gap-4 hidden">
                                <button class="px-1 rounded bg-gray-200 hover:bg-gray-400" type="button">
                                    <i class="fa fa-sort-up"></i>
                                </button>
                                <button class="px-1 rounded bg-gray-200 hover:bg-gray-400" type="button">
                                    <i class="fa fa-sort-down"></i>
                                </button>
                            </span>
                            <button class="text-red-500 hover:text-red-700"
                                    type="button"
                                    @click="form.options.splice(index, 1)"
                            >
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="form.options.length === 0"
                    >
                        <td class="px-6 py-4 whitespace-nowrap text-center font-medium bg-gray-100" colspan="3">Try
                            adding option by typing the name and clicking the add button.
                        </td>
                    </tr>
                </table>

            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <CancelButton :url="route('admin.attributes.index')"/>

                <Transition class="transition ease-in-out" enter-from-class="opacity-0" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
