<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    // When running tests that will change the db in someway. Use RefreshDatabase trait to reset everything after test
    use WithFaker, RefreshDatabase;

    // @test needed so phpunit treats the function as a test, regardless of name


    /** @test */

    public function guests_cannot_manage_projects()
    {

        $project = factory('App\Project')->create();

        // If a post req is make to endpoint but no title is given
        // then assert that the session has errors
        // $this->post('/projects', $attributes)->assertSessionHasErrors('owner_id');

        $this->get('/projects')->assertRedirect('login');    // If access to dashboard is attempted, redirect to login
        $this->get('/projects/create')->assertRedirect('login');    // Guests can't access create page

        // If access tried to specific project, redirect 
        $this->get($project->path())->assertRedirect('login');

        // If non-logged in user tries to create a project, they're redirected to login
        $this->post('/projects', $project->toArray())->assertRedirect('login');



    }

    /** @test */

    public function guests_cannot_view_projects()
    {
    }

    /** @test */

    public function guests_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();

        // If project path can't be accessed, redirect to login
    }


    /** @test */

    public function a_user_can_create_a_project()
    {

        // Disables Laravels catching and handling of exceptions. Allows the exception to be seen in testing, 
        // otherwise the post('/projects') wouldn't show as an exception
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        // Expect create page to load
        $this->get('/projects/create')->assertStatus(200);

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

    public function a_user_can_view_their_project()
    {
        // Create user and signin to view THEIR project
        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling(); // Disable Laravels exception handling

        // Given a project exists in the db, specify signed in person if the owner
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        // Expect to see the project title and description
        $this->get($project->path()) // Now using Project helper function
            ->assertSee($project->title)
            ->assertSee($project->description);

        }
    /** @test */

    public function an_authenticated_user_cannont_view_projects_of_others()
    {
        $this->be(factory('App\User')->create());

        // $this->withoutExceptionHandling(); // Disable Laravels exception handling

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
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
