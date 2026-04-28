<template>
    <div>
        <h1>Todo List</h1>

        <div v-if="$page.props.flash.success">
            {{ $page.props.flash.success }}
        </div>

        <Link :href="route('todos.create')">
            Create New Todo
        </Link>

        <table v-if="todos.length > 0">
            <thead>
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
                    <td>{{ todo.name }}</td>
                    <td>{{ todo.description ?? 'N/A' }}</td>
                    <td>{{ todo.created_at }}</td>
                    <td>
                        <Link :href="route('todos.show', todo.id)">
                            View
                        </Link>

                        <Link :href="route('todos.edit', todo.id)">
                            Edit
                        </Link>

                        <button @click="deleteTodo(todo.id)">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <p v-else>No todos found.</p>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

// Props passed from TodoController@index
const props = defineProps({
    todos: {
        type: Array,
        required: true,
    },
});

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