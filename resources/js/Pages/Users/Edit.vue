<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["user"]);
const form = useForm(props.user);

const formAvatar = useForm({
    avatar: null,
});

const handleUploadAvatar = (event) => {
    formAvatar
        .transform((data) => {
            data.avatar = event.target.files[0];
        })
        .put(route("users.avatar", props.user));
};
</script>

<template>
    <AppLayout title="Edit User">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit User
                </h2>
            </div>
        </template>

        <form @submit.prevent="form.put(route('users.update', props.user))">
            <!-- Name -->
            <input type="text" v-model="form.name" placeholder="Nom" />
            <div v-if="form.errors.name">{{ form.errors.name }}</div>

            <!-- Email -->
            <input type="email" v-model="form.email" placeholder="Email" />
            <div v-if="form.errors.email">{{ form.errors.email }}</div>

            <!-- Password -->
            <input
                type="password"
                v-model="form.password"
                placeholder="Mot de passe"
            />
            <div v-if="form.errors.password">{{ form.errors.password }}</div>

            <!-- Submit -->
            <button type="submit" :disabled="form.processing">
                Mettre à jour
            </button>
        </form>

        <form @submit.prevent="handleUploadAvatar">
            <input type="file" @change="handleUploadAvatar" />
            <div v-if="formAvatar.errors.avatar">
                {{ formAvatar.errors.avatar }}
            </div>
            <progress
                v-if="formAvatar.progress"
                :value="formAvatar.progress.percentage"
                max="100"
            >
                {{ formAvatar.progress.percentage }}%
            </progress>
            <div v-if="props.user.profile_photo_path">
                <img
                    :src="props.user.profile_photo_path"
                    alt="Aperçu de l'avatar"
                />
            </div>
        </form>
    </AppLayout>
</template>
