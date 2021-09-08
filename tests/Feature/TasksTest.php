<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectSetupFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{

    /** @test */
    public function project_can_have_tasks()
    {
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     Project::factory()->raw()
        // );

        $project = ProjectSetupFactory::create();

        $this
            ->actingAs($project->user)
            ->post(route("tasks.store", $project->id), [
                "body" => "test task"
            ]);

        $this->get(route("projects.show", $project))
            ->assertSee("test task");
    }

    /** @test */
    public function task_can_be_updated()
    {
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     Project::factory()->raw()
        // );

        // $task = $project->addTask("test task");

        $project = ProjectSetupFactory::withTasks(1)->create();

        $attributes = [
            "body"      => "changed",
            "completed" => true,
        ];

        $this
            ->actingAs($project->user)
            ->patch(route("tasks.update", [$project, $project->tasks[0]]), $attributes);

        $this->assertDatabaseHas("tasks", $attributes);
    }

    /** @test */
    public function creating_task_require_a_body()
    {
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     Project::factory()->raw()
        // );

        $project = ProjectSetupFactory::create();

        $attributes = Task::factory()->raw(["body" => ""]);

        $this
            ->actingAs($project->user)
            ->post(route("tasks.store", $project->id), $attributes)
            ->assertSessionHasErrors("body");
    }

    /** @test */
    public function only_the_owner_of_a_project_add_a_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $attributes = [
            "body" => "created"
        ];

        $this->post(route("tasks.store", $project), $attributes)->assertStatus(403);

        $this->assertDataBaseMissing("tasks", $attributes);

    }

    /** @test */
    public function only_the_owner_of_a_project_update_a_task()
    {
        $this->signIn();

        // $project = Project::factory()->create();

        // $task = $project->addTask("created");

        $project = ProjectSetupFactory::withTasks(1)->create();

        $attributes = [
            "body" => "updated",
        ];

        $this->patch(route("tasks.update", [$project, $project->tasks[0]]), $attributes)
            ->assertStatus(403);

        $this->assertDataBaseMissing("tasks", $attributes);

    }


}
