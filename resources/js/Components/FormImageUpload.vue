<template>
    <div class="flex items-center gap-4">
        <img class="border object-cover size-40 rounded-lg ring-2 ring-white" :src="imagePreview || placeholderImage" />

        <div class="flex gap-x-4">
            <label :for="id"
                class="py-[5px] px-2 inline-flex justify-center items-center gap-2 rounded-lg font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all text-sm cursor-pointer">
                <Upload />
                Enviar foto
            </label>

            <input :id="id" type="file" class="hidden" ref="fileInput" @change="handleimageChange" accept="image/*" />
        </div>
    </div>
</template>

<script setup>
import { Upload } from "lucide-vue-next";
import { ref, watch, onUnmounted } from "vue";

const props = defineProps({
    id: { type: String, required: true },
    modelValue: [File, String],
    placeholderImage: String,
});

const emits = defineEmits(["update:modelValue"]);

const fileInput = ref(null);
const imagePreview = ref(null);
let objectUrl = null;

const handleimageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        emits("update:modelValue", file);
        updatePreview(file);
    }
};

const updatePreview = (value) => {
    if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
        objectUrl = null;
    }

    if (value instanceof File) {
        objectUrl = URL.createObjectURL(value);
        imagePreview.value = objectUrl;
    } else if (typeof value === "string" && value.trim() !== "") {
        imagePreview.value = value.startsWith("http")
            ? value
            : `/storage/${value}`;
    } else {
        imagePreview.value = props.placeholderImage;
    }
};

watch(() => props.modelValue, updatePreview, { immediate: true });

onUnmounted(() => {
    if (objectUrl) URL.revokeObjectURL(objectUrl);
});
</script>
