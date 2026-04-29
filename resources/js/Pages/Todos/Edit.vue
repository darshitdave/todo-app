<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">Edit Todo</h4>
                    </div>
                    <div class="card-body">
                        <TodoForm
                            :form="form"
                            submit-label="Update Todo"
                            @submitted="submit"
                        />
                    </div>
                </div>
            </div>
        </div>
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