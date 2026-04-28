<template>
    <div>
        <h1>Edit Todo</h1>

        <TodoForm
            :form="form"
            submit-label="Update Todo"
            @submitted="submit"
        />
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import TodoForm from '@/Components/TodoForm.vue'; //using todo component for create and update

// Props passed from TodoController@edit
const props = defineProps({
    todo: {
        type: Object,
        required: true,
    },
});

//Show existing todo data
const form = useForm({
    name: props.todo.name,
    description: props.todo.description ?? '',
});

/**
 * Submit the update form
 */
const submit = () => {
    form.put(route('todos.update', props.todo.id), {
        onError: () => {
            // Errors are available in form.errors
        },
    });
};
</script>