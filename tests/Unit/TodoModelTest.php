<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoModelTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test todo model has correct fillable fields.
     *
     * @return void
     */
    public function test_todo_has_correct_fillable_fields(): void
    {
        $todo = new Todo();
        
        $this->assertEquals(
            ['name', 'description'],
            $todo->getFillable()
        );
    }

    /**
     * Test todo model can be created.
     *
     * @return void
    */
    public function test_todo_can_be_created(): void
    {
        $todo = Todo::factory()->create([
            'name'        => 'Test Todo',
            'description' => 'Test Description',
        ]);

        $this->assertDatabaseHas('todos', [
            'name'        => 'Test Todo',
            'description' => 'Test Description',
        ]);
    }

    /**
     * Test todo model can be updated.
     *
     * @return void
     */
    public function test_todo_can_be_updated(): void
    {
        $todo = Todo::factory()->create([
            'name' => 'Old Name',
        ]);

        $todo->update([
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('todos', [
            'name' => 'New Name',
        ]);
    }

    /**
     * Test todo model can be deleted.
     *
     * @return void
     */
    public function test_todo_can_be_deleted(): void
    {
        $todo = Todo::factory()->create();

        $todo->delete();

        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    /**
     * Test todo description is nullable.
     *
     * @return void
     */
    public function test_todo_description_is_nullable(): void
    {
        $todo = Todo::factory()->create([
            'name'        => 'Test Todo',
            'description' => null,
        ]);

        $this->assertNull($todo->description);
    }
}
