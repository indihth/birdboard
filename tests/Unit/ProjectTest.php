<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    
    public function it_has_a_path()
    {
        // Assuming a project exists
        $project = factory('App\Project')->create();

        // The path of the project should equal /projects/{id}
       $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    
    public function a_project_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }
}
