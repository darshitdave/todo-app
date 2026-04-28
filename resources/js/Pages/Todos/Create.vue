<template>
    <div>
        <h1>Create Todo</h1>

        <TodoForm
            :form="form"
            submit-label="Create Todo"
            @submitted="submit"
        />
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import TodoForm from '@/Components/TodoForm.vue'; //using todo component for create and update

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    form.post(route('todos.store'), {
        onError: () => {},
    });
};
</script>

