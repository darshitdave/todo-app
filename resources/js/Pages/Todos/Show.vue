<template>
    <div>
        <h1>Todo Details</h1>

        <table>
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ todo.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ todo.name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ todo.description ?? ' ' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ todo.created_at }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ todo.updated_at }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <Link :href="route('todos.edit', todo.id)">
            Edit
        </Link>

        <Link :href="route('todos.index')">
            Back to List
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js'

// Props passed from TodoController@show
defineProps({
    todo: {
        type: Object,
        required: true,
    },
});
</script>