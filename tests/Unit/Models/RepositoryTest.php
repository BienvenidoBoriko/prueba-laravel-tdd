<?php

namespace Tests\Unit\Models;

use App\Models\Repository;
use Tests\TestCase;
use App\Models\User;

class RepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_belongs_to_user()
    {
        $repository = Repository::factory()->create();
        $this->assertInstanceOf(User::class, $repository->user);
    }
}
