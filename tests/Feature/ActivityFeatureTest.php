<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Facades\Tests\Setup\ProjectSetupFactory;

class ActivityFeatureTest extends TestCase
{
    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = ProjectSetupFactory::create();

        $this->assertCount(1, $project->activities);

        tap($project->activities->last(),function($activity){
            $this->assertEquals("project_created", $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetupFactory::create();

        $original = $project->title;

        $attributes = ["title" => "updated"];

        $project->update($attributes);

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(),function($activity) use ($original, $attributes) {
            $this->assertEquals("project_updated", $activity->description);

            $excepted = [
                'before' => ['title' => $original],
                'after'  => $attributes
            ];

            $this->assertEquals($excepted, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_task_records_activity()
    {
        $project = ProjectSetupFactory::create();

        $task = $project->addTask("Some task");

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(),function($activity){
            $this->assertEquals("task_created", $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals("Some task", $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task_records_activity()
    {
        $project = ProjectSetupFactory::withTasks(1)->create();

        $this
            ->actingAs($project->user)
            ->patch(route("tasks.update", [$project, $project->tasks->first()]), [
                "completed" => true,
            ]);

        $this->assertCount(3, $project->activities);

        tap($project->activities->last(),function($activity){
            $this->assertEquals("task_completed", $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task_records_activity()
    {
        $project = ProjectSetupFactory::withTasks(1)->create([
            // "completed" => true,
        ]);

        $this
            ->actingAs($project->user)
            ->patch(route("tasks.update", [$project, $project->tasks->first()]), [
                "completed" => true,
            ]);

        $this->assertCount(3, $project->activities);

        $this
            ->patch(route("tasks.update", [$project, $project->tasks->first()]), [
                "completed" => false,
            ]);

        $project = $project->fresh();

        $this->assertCount(4, $project->activities);

        tap($project->activities->last(),function($activity){
            $this->assertEquals("task_inComplete", $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function delete_a_task_records_activity()
    {
        $project = ProjectSetupFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activities);

    }
}
