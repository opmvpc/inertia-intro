<script setup>
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import AuthorAvatar from "@/Components/AuthorAvatar.vue";
import { ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Link from "@/Components/Link.vue";

const props = defineProps({
    authors: {
        type: Object,
        required: true,
    },
});

const confirmingAuthorDeletion = ref(false);
const authorToDelete = ref(null);

const confirmAuthorDeletion = (author) => {
    authorToDelete.value = author;
    confirmingAuthorDeletion.value = true;
};

const deleteAuthor = () => {
    router.delete(route("authors.destroy", authorToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingAuthorDeletion.value = false;
    authorToDelete.value = null;
};
</script>

<template>
    <AppLayout title="Authors">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Authors
                </h2>
                <Link :href="route('authors.create')"> Add Author </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                        >
                            <div
                                v-for="author in authors.data"
                                :key="author.id"
                                class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 transition-all duration-300 hover:shadow-md"
                            >
                                <div class="p-6">
                                    <div
                                        class="flex items-center justify-center mb-4 w-full"
                                    >
                                        <AuthorAvatar
                                            :name="author.name"
                                            :size="10"
                                        />
                                    </div>

                                    <h3
                                        class="text-xl font-semibold text-center text-gray-900 mb-2"
                                    >
                                        {{ author.name }}
                                    </h3>

                                    <div
                                        class="text-sm text-gray-600 text-center"
                                    >
                                        <p>
                                            {{ author.books_count ?? 0 }} books
                                            published
                                        </p>
                                        <p class="mt-1">
                                            Member since {{ author.created_at }}
                                        </p>
                                    </div>

                                    <div class="mt-4 flex justify-center gap-2">
                                        <Link
                                            :href="
                                                route('authors.show', {
                                                    author: author.id,
                                                })
                                            "
                                            class="inline-flex text-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        >
                                            View Profile
                                        </Link>
                                        <Link
                                            :href="
                                                route('authors.edit', author.id)
                                            "
                                            class="inline-flex items-center p-1 border border-gray-300 rounded-md hover:bg-gray-50"
                                        >
                                            <svg
                                                class="w-5 h-5 text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                        </Link>
                                        <button
                                            @click="
                                                confirmAuthorDeletion(author)
                                            "
                                            class="inline-flex items-center p-1 border border-gray-300 rounded-md hover:bg-gray-50"
                                        >
                                            <svg
                                                class="w-5 h-5 text-red-500"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Author Confirmation Modal -->
        <Modal :show="confirmingAuthorDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this author?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this author is deleted, all of their books will be
                    permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton class="ms-3" @click="deleteAuthor">
                        Delete Author
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
