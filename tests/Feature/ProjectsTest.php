<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    private $model = Project::class;

    /** @test */
    public function creating_raw_required_authentication()
    {
        $attributes = $this->model::factory()->raw();

        $this->post(route("projects.store"), $attributes)
            ->assertRedirect(route("login"));
    }

    /** @test */
    public function expected_validation_create_rules()
    {
        $request = new ProjectRequest();

        $this->assertEquals([
            "title"       => "required|string",
            "description" => "required|string",
            "user_id"     => "required|integer|exists:users,id",
        ], $request->rules());
    }

    /** @test */
    public function creating_raw_require_a_title_and_description()
    {
        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->raw([
            "title"       => "",
            "description" => "",
        ]);

        $this->post(route("projects.store"), $attributes)
            ->assertSessionHasErrors("title")
            ->assertSessionHasErrors("description");
    }

    /** @test */
    public function authenticated_user_can_create_a_raw()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->raw([
            "user_id" => auth()->id()
        ]);

        $this->post(route("projects.store"), $attributes)
            ->assertRedirect(route("projects.index"));

        $this->assertDatabaseHas("projects", $attributes);
        $this->get(route("projects.index"))->assertSee($attributes["title"]);

    }

    /** @test */
    public function authenticated_user_can_show_a_raw()
    {
        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->create();

        $this->get(route("projects.show", $attributes->id))
            ->assertSee($attributes->title)
            ->assertSee($attributes->description);
    }

    /** @test */
    public function editing_raw_require_a_title_and_description()
    {
        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->create([
            "user_id" => auth()->id(),
        ]);

        $attributes->title       = "";
        $attributes->description = "";

        $this->put(route("projects.update", $attributes), $attributes->toArray())
            ->assertSessionHasErrors("title")
            ->assertSessionHasErrors("description");
    }

    /** @test */
    public function authenticated_user_can_edit_a_raw()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->create([
            "user_id" => auth()->id(),
        ]);

        $attributes->title       = "updated title";
        $attributes->description = "updated description";

        $this->put(route("projects.update", $attributes), $attributes->toArray())
            ->assertRedirect(route("projects.show", $attributes));

        $this->assertDatabaseHas("projects", [
            "title"       => "updated title",
            "description" => "updated description",
        ]);

    }

    /** @test */
    public function authenticated_user_can_delete_a_raw()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = $this->model::factory()->create([
            "user_id" => auth()->id(),
        ]);

        $this->delete(route("projects.destroy", $attributes), $attributes->toArray())
            ;

        $this->assertDatabaseMissing("projects", [
            "id" => $attributes->id,
        ]);

    }

}
