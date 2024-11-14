<?php

namespace App\Console\Commands;

use App\Enums\UserStatus;
use App\Producers\UserStatusProducer;
use Illuminate\Console\Command;

class BlockUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:block-user {--user_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UserStatusProducer $producer)
    {
        $userId = $this->option('user_id');

        $producer->send([
            'user_id' => (int) $userId,
            'status' => UserStatus::BLOCKED->value,
        ], $userId);
    }
}
