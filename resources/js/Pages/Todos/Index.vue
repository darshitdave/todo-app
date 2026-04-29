<template>
    <div class="container py-5">
       
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold"> Todo List</h1>
            <Link :href="route('todos.create')">
                Create New Todo
            </Link>
        </div>

        <div v-if="showAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $page.props.flash.success }}
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
                @click="showAlert = false"
            ></button>
        </div>

        <div v-if="todos.length > 0" class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="todo in todos" :key="todo.id">
                            <td>{{ todo.id }}</td>
                            <td class="fw-semibold">{{ todo.name }}</td>
                            <td class="text-muted">{{ todo.description ?? '' }}</td>
                            <td class="text-muted">{{ new Date(todo.created_at).toLocaleDateString('en-GB') }}</td>
                            <td>
                                <Link :href="route('todos.show', todo.id)" class="btn btn-sm btn-info me-1">
                                    View
                                </Link>
                                <Link :href="route('todos.edit', todo.id)" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </Link>
                                <button @click="deleteTodo(todo.id)" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-else class="card shadow-sm text-center py-5">
            <p class="text-muted fs-5">No todos found.</p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { Link, router, usePage  } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

// Props passed from TodoController@index
const props = defineProps({
    todos: {
        type: Array,
        required: true,
    },
});

const showAlert = ref(false);
const page = usePage();

/**
 * Handle showing alert and auto hiding after 3 seconds
 */
const handleAlert = (value) => {
    if (value) {
        showAlert.value = true;

        setTimeout(() => {
            showAlert.value = false;
        }, 3000);
    }
};

onMounted(() => {
    handleAlert(page.props.flash.success);
});

watch(
    () => page.props.flash.success,
    (newValue) => {
        handleAlert(newValue);
    }
);

/**
 * Delete a todo with confirmation
 *
 * @param {number} id
 */
const deleteTodo = (id) => {
    if (confirm('Are you sure you want to delete this todo?')) {
        router.delete(route('todos.destroy', id));
    }
};
</script>