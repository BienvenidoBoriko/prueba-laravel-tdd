<?php

namespace Tests\Feature\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest()
    {
        $this->get('repositories')->assertRedirect('login');
        $this->get('repositories/1')->assertRedirect('login');
        $this->get('repositories/1/edit')->assertRedirect('login');
        $this->put('repositories/1')->assertRedirect('login');
        $this->delete('repositories/1')->assertRedirect('login');
        $this->get('repositories/create')->assertRedirect('login');
        $this->post('repositories', [])->assertRedirect('login');
    }

    public function test_index_empty()
    {
        Repository::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios creados');
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create();
        $repository =  Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
    }

    public function test_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("repositories/create")
            ->assertStatus(200);
    }

    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('repositories', $data)
            ->assertRedirect('repositories');

        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertRedirect("repositories/$repository->id/edit");

        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertStatus(403);
    }

    public function test_validate_store()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('repositories', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_validate_update()
    {
        $repository = Repository::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user)
            ->put("repositories/$repository->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertRedirect("repositories");

        $this->assertDatabaseMissing('repositories', [
            'url' => $repository->url,
            'id'   => $repository->id,
            'description' => $repository->description
        ]);
    }

    public function test_destroy_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();
        $this->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertStatus(403);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(200)
            ->assertSee($repository->id);
    }

    public function test_show_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        $this->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(403);
    }

    public function test_edit()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get("repositories/$repository->id/edit")
            ->assertStatus(200)
            ->assertSee($repository->url)
            ->assertSee($repository->description);
    }

    public function test_edit_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        $this->actingAs($user)
            ->get("repositories/$repository->id/edit")
            ->assertStatus(403);
    }
}
