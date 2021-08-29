<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function creating_raw_required_authentication()
    {
        $attributes = Project::factory()->raw();

        $this->post(route('projects.store'), $attributes)
            ->assertRedirect('login');
    }

    /** @test */
    public function expected_validation_rules()
    {
        $request = new ProjectRequest();

        $this->assertEquals([
            'title'       => 'required|string',
            'description' => 'required|string',
            'user_id'     => 'required|integer|exists:users,id',
        ], $request->rules());
    }

    /** @test */
    public function creating_raw_require_a_title()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post(route('projects.store'), $attributes)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function creating_raw_require_a_description()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post(route('projects.store'), $attributes)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_create_a_raw()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw();

        $this->post(route('projects.store'), $attributes)
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function user_can_show_a_raw()
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get("/projects/{$project->id}")
            ->assertSee($project->title)
            ->assertSee($project->description);

    }
}
