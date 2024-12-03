<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="bg-white p-4 sm:rounded-lg sm:p-8 border">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
        </div>

        <div class="bg-white p-4 sm:rounded-lg sm:p-8 border">
            <UpdatePasswordForm class="max-w-xl" />
        </div>
    </AuthenticatedLayout>
</template>
