<template>
    <div class="flex items-center gap-4">
        <img
            class="border object-cover size-40 rounded-lg ring-2 ring-white"
            :src="photoPreview || placeholderImage"
        />

        <div class="flex gap-x-4">
            <label
                :for="id"
                class="py-[5px] px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm cursor-pointer"
            >
                <Upload />
                Enviar foto
            </label>

            <input
                :id="id"
                type="file"
                class="hidden"
                ref="fileInput"
                @change="handlePhotoChange"
                accept="image/*"
            />
        </div>
    </div>
</template>

<script setup>
import { Upload } from "lucide-vue-next";
import { ref, defineProps, defineEmits, watch } from "vue";

const props = defineProps({
    id: { type: String, required: true },
    modelValue: File,
    placeholderImage: String
});

const emits = defineEmits(["update:modelValue"]);

const fileInput = ref(null);
const photoPreview = ref(props.modelValue ? URL.createObjectURL(props.modelValue) : null);

const handlePhotoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        emits("update:modelValue", file);
        photoPreview.value = URL.createObjectURL(file);
    }
};

watch(() => props.modelValue, (newVal) => {
    photoPreview.value = newVal ? URL.createObjectURL(newVal) : null;
});
</script>
