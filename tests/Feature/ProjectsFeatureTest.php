<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Facades\Tests\Setup\ProjectSetupFactory;
use App\Http\Requests\ProjectRequest;

class ProjectsFeatureTest extends TestCase
{

    /** @test */
    public function geusts_cannot_manage_projects()
    {
        $attributes = Project::factory();

        $this->get(route("projects.index"))->assertRedirect(route("login"));
        $this->get(route("projects.create"))->assertRedirect(route("login"));
        $this->get(route("projects.show", $attributes->create()))->assertRedirect(route("login"));
        $this->post(route("projects.store"), $attributes->raw())->assertRedirect(route("login"));
    }

    /** @test */
    public function creating_project_require_a_title_and_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw([
            "title"       => "",
            "description" => "",
        ]);

        $this->post(route("projects.store"), $attributes)
            ->assertSessionHasErrors("title")
            ->assertSessionHasErrors("description");
    }

    /** @test */
    public function authenticated_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        // $this->signIn();

        // $this->get(route("projects.create"))->assertStatus(200);

        // $attributes = Project::factory()->raw([
        //     "user_id" => auth()->id(),
        // ]);

        // $this->post(route("projects.store"), $attributes);

        $project = ProjectSetupFactory::ownedBy($this->signIn())->create();

        $this
            ->get(route("projects.create"))->assertStatus(200);

        $this->get(route("projects.show", $project))
            ->assertSee($project["title"])
            ->assertSee($project["description"])
            ->assertSee($project["notes"])
            ;

    }

    /** @test */
    public function authenticated_user_can_show_a_project()
    {
        $project = ProjectSetupFactory::ownedBy($this->signIn())->create();

        $this
            ->get(route("projects.show", $project))
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function editing_project_require_a_title_and_description()
    {
        // $this->signIn();

        // $attributes = Project::factory()->create([
        //     "user_id" => auth()->id(),
        // ]);

        $project = ProjectSetupFactory::ownedBy($this->signIn())->create();

        $project->notes  = "";

        $this->patch(route("projects.update", $project), $project->toArray())
            ->assertSessionHasErrors("notes");
    }

    /** @test */
    public function authenticated_user_can_edit_a_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectSetupFactory::ownedBy($this->signIn())->create();

        $this
            ->get(route("projects.edit", $project))->assertStatus(200);

        $project->title       = "updated title";
        $project->description = "updated description";
        $project->notes       = "updated notes";

        $this
            ->patch(route("projects.update", $project), $project->toArray())
            ->assertRedirect(route("projects.show", $project));

        $this->assertDatabaseHas("projects", [
            "title"       => "updated title",
            "description" => "updated description",
            "notes"       => "updated notes",
        ]);

    }

    /** @test */
    public function authenticated_user_can_delete_a_project()
    {
        // $this->withoutExceptionHandling();

        // $this->signIn();

        // $attributes = Project::factory()->create([
        //     "user_id" => auth()->id(),
        // ]);

        $project = ProjectSetupFactory::ownedBy($this->signIn())->create();

        $this->delete(route("projects.destroy", $project));

        $this->assertDeleted("projects", $project->toArray());

    }

}
