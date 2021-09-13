<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;


class TaskUnitTest extends TestCase
{
    /** @test */
    public function task_belongs_to_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->completed);

        $task->completed();

        $this->assertTrue($task->completed);
    }

    /** @test */
    public function it_can_be_inComplete()
    {
        $task = Task::factory()->create(['completed' => true]);

        $this->assertTrue($task->completed);

        $task->inComplete();

        $this->assertFalse($task->completed);
    }
}
