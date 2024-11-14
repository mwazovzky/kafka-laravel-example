<?php

namespace Tests\Unit\Models;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testBlock(): void
    {
        $user = User::factory()->create(['status' => UserStatus::ACTIVE]);

        $user->block();

        $this->assertEquals(UserStatus::BLOCKED, $user->status);
    }
}
