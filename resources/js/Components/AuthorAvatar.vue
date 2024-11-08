<script setup>
import { computed } from "vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    size: {
        type: Number,
        default: 16,
    },
});

const fontSize = computed(() => `${props.size * 0.4}rem`);

const getColorFromName = (name) => {
    let hash = 0;
    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }
    const hue = hash % 360;
    return `hsla(${hue}, 70%, 50%, 0.1)`;
};

const getTextColorFromName = (name) => {
    let hash = 0;
    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }
    const hue = hash % 360;
    return `hsl(${hue}, 70%, 35%)`;
};
</script>

<template>
    <div
        class="rounded-full flex items-center justify-center"
        :style="{
            width: `${size}rem`,
            height: `${size}rem`,
            backgroundColor: getColorFromName(name),
            color: getTextColorFromName(name),
            fontSize,
        }"
    >
        <span class="font-bold">
            {{ name.charAt(0).toUpperCase() }}
        </span>
    </div>
</template>
