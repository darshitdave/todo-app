<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create Todo</h4>
                    </div>
                    <div class="card-body">
                        <TodoForm
                            :form="form"
                            submit-label="Create Todo"
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

