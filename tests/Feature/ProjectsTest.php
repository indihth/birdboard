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

    public function only_authenticated_users_can_create_projects()
    {

        $attributes = factory('App\Project')->raw();

        // If a post req is make to endpoint but no title is given
        // then assert that the session has errors
        // $this->post('/projects', $attributes)->assertSessionHasErrors('owner_id');

        // If non-logged in user tries to create a project, they're redirected to login
        $this->post('/projects', $attributes)->assertRedirect('login');
    }


    /** @test */

    public function a_user_can_create_a_project()
    {

        // Disables Laravels catching and handling of exceptions. Allows the exception to be seen in testing, 
        // otherwise the post('/projects') wouldn't show as an exception
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

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

    /** @test */

    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling(); // Disable Laravels exception handling



        // Given a project exists in the db
        $project = factory('App\Project')->create();

        // Expect to see the project title and description
        $this->get($project->path()) // Now using Project helper function
            ->assertSee($project->title)
            ->assertSee($project->description);
    }


    /** @test */

    public function a_project_requries_a_title()
    {
        // Creates a new user and sets as authenticated
        $this->actingAs(factory('App\User')->create());

        // make() does persist changes in DB, creates data (attributes) but doesn't save it
        // Can overwrite anything in make() - make title an empty string

        // raw() builds up attributes and store as an array, array is expected
        $attributes = factory('App\Project')->raw(['title' => '']);

        // If a post req is make to endpoint but no title is given (empty array)
        // then assert that the session has errors
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }


    /** @test */

    public function a_project_requries_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        // If a post req is make to endpoint but no title is given
        // then assert that the session has errors
        $this->post('/projects', [])->assertSessionHasErrors('description');
    }
}
