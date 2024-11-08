<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AuthorAvatar from '@/Components/AuthorAvatar.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    author: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <AppLayout :title="author.name">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Author Profile
                </h2>
                <Link :href="route('authors.index')"
                      class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Back to Authors
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col items-center mb-8">
                            <div class="mb-4">
                                <AuthorAvatar :name="author.name" :size="12" />
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ author.name }}
                            </h1>
                            <p class="mt-1">Member since {{ author.created_at }}</p>

                            <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>{{ author.books_count ?? 0 }} books published</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Published Books</h3>
                            <div v-if="author.books?.length" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                <Link v-for="book in author.books" 
                                      :key="book.id"
                                      :href="route('books.show', book.id)"
                                      class="group flex flex-col overflow-hidden rounded-lg bg-white shadow transition duration-300 hover:shadow-lg">
                                    <div class="aspect-[3/4] relative overflow-hidden bg-gray-100">
                                        <img v-if="book.image_path" 
                                             :src="'/storage/'+book.image_path" 
                                             :alt="book.title"
                                             class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                                        <div v-else class="absolute inset-0 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ book.title }}</h3>
                                    </div>
                                </Link>
                            </div>
                            <p v-else class="text-gray-500 text-center py-8">
                                No books published yet.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>