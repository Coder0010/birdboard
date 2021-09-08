<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;


class TaskTest extends TestCase
{
    /** @test */
    public function task_belongs_to_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }
}
