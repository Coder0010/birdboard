<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectUnitTest extends TestCase
{
    /** @test */
    public function project_belongs_to_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->user);
    }

    /** @test */
    public function project_has_tasks()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(Collection::class, $project->tasks);
    }

    /** @test */
    public function project_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('test');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));

    }
}
