<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Todo Details</h4>
                    </div>
                    <div class="card-body">
                        <TodoForm
                            :form="form"
                            :readonly="true"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm  } from '@inertiajs/vue3';
import TodoForm from '@/Components/TodoForm.vue';

// Props passed from TodoController@show
const props = defineProps({
    todo: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    id:          props.todo.id,
    name:        props.todo.name,
    description: props.todo.description ?? '',
});
</script>