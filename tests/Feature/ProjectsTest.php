<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    // When running tests that will change the db in someway. Use RefreshDatabase trait to reset everything after test
    use WithFaker, RefreshDatabase;

    // @test needed so phpunit treats the function as a test, regardless of name

    /** @test */

    public function a_user_can_create_a_project()
    {

        // Disables Laravels catching and handling of exceptions. Allows the exception to be seen in testing, 
        // otherwise the post('/projects') wouldn't show as an exception
        $this->withoutExceptionHandling();

        // Example attributes
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        // If a post request is made to URL with above attributes, then redirected to /projects
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        // Expected outcome is for attributes to be inserted into 'projects' table
        $this->assertDatabaseHas('projects', $attributes);

        // If a get request made to 'projects', expect to SEE attributes 'title'
        $this->get('/projects')->assertSee($attributes['title']);
    }
}
