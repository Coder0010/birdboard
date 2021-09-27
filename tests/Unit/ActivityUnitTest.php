<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Facades\Tests\Setup\ProjectSetupFactory;

class ActivityUnitTest extends TestCase
{
    /** @test */
    public function it_has_a_user()
    {

        $project = ProjectSetupFactory::create();

        $this->assertInstanceOf(User::class, $project->activities->first()->user);
    }
}
