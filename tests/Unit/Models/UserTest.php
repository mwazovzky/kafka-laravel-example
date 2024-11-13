<?php

namespace Tests\Unit\Models;

use App\Enums\UserStatus;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testBlock(): void
    {
        $user = User::factory()->create(['status' => UserStatus::ACTIVE]);

        $user->block();

        $this->assertEquals(UserStatus::BLOCKED, $user->status);
    }
}
