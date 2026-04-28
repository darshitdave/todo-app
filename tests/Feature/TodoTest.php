<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test todo list page loads successfully.
     *
     * @return void
    */
    public function test_todo_index_page_loads_successfully(): void
    {
        $response = $this->get('/todos');

        $response->assertStatus(200);
    }

    /**
     * Test todo list returns all todos.
     *
     * @return void
     */
    public function test_todo_index_returns_all_todos(): void
    {
        Todo::factory()->count(2)->create();

        $response = $this->get('/todos');

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) => $page
                ->component('Todos/Index')
                ->has('todos', 2)
        );
    }

    // ─────────────────────────────────────────
    // CREATE Tests
    // ─────────────────────────────────────────

    /**
     * Test todo create page loads successfully.
     *
     * @return void
    */
    public function test_todo_create_page_loads_successfully(): void
    {
        $response = $this->get('/todos/create');

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) => $page->component('Todos/Create')
        );
    }

    // ─────────────────────────────────────────
    // STORE Tests
    // ─────────────────────────────────────────

    /**
     * Test todo can be created with valid data.
     *
     * @return void
    */
    public function test_todo_can_be_stored_with_valid_data(): void
    {
        $data = [
            'name'        => 'Buy Vehicle Parts',
            'description' => 'Rear Mirron, Front Light, Wipers',
        ];

        $response = $this->post('/todos', $data);

        $response->assertRedirect('/todos');
        $this->assertDatabaseHas('todos', $data);
    }

    /**
     * Test todo cannot be created without name.
     *
     * @return void
    */
    public function test_todo_cannot_be_stored_without_name(): void
    {
        $response = $this->post('/todos', [
            'name'        => '',
            'description' => 'Some description',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('todos', 0);
    }

    /**
     * Test todo cannot be created with short name.
     *
     * @return void
    */
    public function test_todo_cannot_be_stored_with_short_name(): void
    {
        $response = $this->post('/todos', [
            'name' => 'a', // less than 2 characters
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test todo can be created without description.
     *
     * @return void
    */
    public function test_todo_can_be_stored_without_description(): void
    {
        $response = $this->post('/todos', [
            'name'        => 'Buy Accessories',
            'description' => null,
        ]);

        $response->assertRedirect('/todos');
        $this->assertDatabaseHas('todos', [
            'name' => 'Buy Accessories',
        ]);
    }

    // ─────────────────────────────────────────
    // SHOW Tests
    // ─────────────────────────────────────────

    /**
     * Test todo show page loads successfully.
     *
     * @return void
    */
    public function test_todo_show_page_loads_successfully(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->get("/todos/{$todo->id}");

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) => $page
                ->component('Todos/Show')
                ->has('todo')
                ->where('todo.id', $todo->id)
                ->where('todo.name', $todo->name)
        );
    }

    /**
     * Test show returns 404 for non existent todo.
     *
     * @return void
    */
    public function test_todo_show_returns_404_for_non_existent_todo(): void
    {
        $response = $this->get('/todos/999');

        $response->assertStatus(404);
    }

    // ─────────────────────────────────────────
    // EDIT Tests
    // ─────────────────────────────────────────

    /**
     * Test todo edit page loads successfully.
     *
     * @return void
    */
    public function test_todo_edit_page_loads_successfully(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->get("/todos/{$todo->id}/edit");

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) => $page
                ->component('Todos/Edit')
                ->has('todo')
                ->where('todo.id', $todo->id)
        );
    }

    // ─────────────────────────────────────────
    // UPDATE Tests
    // ─────────────────────────────────────────

    /**
     * Test todo can be updated with valid data.
     *
     * @return void
    */
    public function test_todo_can_be_updated_with_valid_data(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->put("/todos/{$todo->id}", [
            'name'        => 'Updated Name',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect('/todos');
        $this->assertDatabaseHas('todos', [
            'id'          => $todo->id,
            'name'        => 'Updated Name',
            'description' => 'Updated Description',
        ]);
    }

    /**
     * Test todo cannot be updated without name.
     *
     * @return void
    */
    public function test_todo_cannot_be_updated_without_name(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->put("/todos/{$todo->id}", [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test todo update returns 404 for non existent todo.
     *
     * @return void
    */
    public function test_todo_update_returns_404_for_non_existent_todo(): void
    {
        $response = $this->put('/todos/999', [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(404);
    }

    // ─────────────────────────────────────────
    // DELETE Tests
    // ─────────────────────────────────────────

    /**
     * Test todo can be deleted.
     *
     * @return void
    */
    public function test_todo_can_be_deleted(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->delete("/todos/{$todo->id}");

        $response->assertRedirect('/todos');
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    /**
     * Test todo delete returns 404 for non existent todo.
     *
     * @return void
     */
    public function test_todo_delete_returns_404_for_non_existent_todo(): void
    {
        $response = $this->delete('/todos/999');

        $response->assertStatus(404);
    }
}
