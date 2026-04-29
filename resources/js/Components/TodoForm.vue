<template>
    <div>
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">
                Name <span class="text-danger" v-if="!readonly">*</span>
            </label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                placeholder="Enter todo name"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
                :readonly="readonly"
            />
            <div v-if="form.errors.name" class="invalid-feedback">
                {{ form.errors.name }}
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label fw-semibold">
                Description <span class="text-muted fw-normal" v-if="!readonly">(optional)</span>
            </label>
            <textarea
                id="description"
                v-model="form.description"
                :placeholder="readonly ? '' : 'Enter todo description'"
                rows="4"
                class="form-control"
                :class="{ 'is-invalid': form.errors.description }"
                :readonly="readonly"
            ></textarea>
            <div v-if="form.errors.description" class="invalid-feedback">
                {{ form.errors.description }}
            </div>
        </div>

        <div class="d-flex gap-2">
            <button
                @click="$emit('submitted')"
                :disabled="form.processing"
                class="btn btn-primary"
                v-if="!readonly"
            >
                {{ submitLabel }}
            </button>

            <Link :href="route('todos.index')" class="btn btn-secondary">
                Cancel
            </Link>
        </div>

        
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
    readonly: {
        type: Boolean,
        default: false,
    },
});

// Emits
defineEmits(['submitted']);
</script>