<?php

namespace Tests\Feature;

use App\Models\Task; // Asegúrate de que este modelo existe y está correctamente importado
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase; // Esto restablece la base de datos para cada prueba

    /** @test */
    public function it_can_create_a_task()
    {
        $response = $this->post(route('tasks.store'), [
            'title' => 'Nueva tarea',
        ]);

        $this->assertCount(1, Task::all());
        $this->assertEquals('Nueva tarea', Task::first()->title);
        $response->assertRedirect();
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::create(['title' => 'Tarea original']);

        $response = $this->put(route('tasks.update', $task->id), [
            'title' => 'Tarea actualizada',
        ]);

        $this->assertEquals('Tarea actualizada', $task->fresh()->title);
        $response->assertRedirect();
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::create(['title' => 'Tarea para eliminar']);

        $response = $this->delete(route('tasks.destroy', $task->id));

        $this->assertCount(0, Task::all());
        $response->assertRedirect();
    }
}
