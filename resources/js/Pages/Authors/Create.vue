<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import AuthorAvatar from "@/Components/AuthorAvatar.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref, watch } from "vue";

const preview = ref("");
const form = useForm({
    name: "",
});

watch(
    () => form.name,
    (value) => {
        preview.value = value;
    }
);

const submit = () => {
    form.post(route("authors.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Create Author">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Author
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <div class="flex space-x-8">
                            <div class="w-1/3">
                                <div
                                    class="flex flex-col items-center p-6 bg-gray-50 rounded-lg"
                                >
                                    <div class="mb-4">
                                        <AuthorAvatar
                                            :name="preview || 'New Author'"
                                            :size="12"
                                        />
                                    </div>
                                    <h3
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ preview || "New Author" }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Preview
                                    </p>
                                </div>
                            </div>

                            <form @submit.prevent="submit" class="space-y-6">
                                <div>
                                    <InputLabel for="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autofocus
                                    />
                                    <InputError
                                        :message="form.errors.name"
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        for="biography"
                                        value="Biography"
                                    />
                                    <TextInput
                                        id="biography"
                                        v-model="form.biography"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError
                                        :message="form.errors.biography"
                                        class="mt-2"
                                    />
                                </div>

                                <div class="flex items-center gap-4">
                                    <PrimaryButton
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        Create Author
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
