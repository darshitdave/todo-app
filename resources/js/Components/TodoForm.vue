<template>
    <div>
        <div>
            <label for="name">Name <span>*</span></label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                placeholder="Enter todo name"
            />
            <span v-if="form.errors.name">
                {{ form.errors.name }}
            </span>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea
                id="description"
                v-model="form.description"
                placeholder="Enter todo description (optional)"
                rows="4"
            ></textarea>
           
            <span v-if="form.errors.description">
                {{ form.errors.description }}
            </span>
        </div>

        <button
            @click="$emit('submitted')"
            :disabled="form.processing"
        >
            {{ submitLabel }}
        </button>

        <Link :href="route('todos.index')">
            Cancel
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

// Props
defineProps({
    form: {
        type: Object,
        required: true,
    },
    submitLabel: {
        type: String,
        default: 'Submit',
    },
});

// Emits
defineEmits(['submitted']);
</script>