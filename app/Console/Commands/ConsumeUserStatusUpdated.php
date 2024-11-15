<?php

namespace App\Console\Commands;

use App\Consumers\UserStatusUpdatedConsumer;
use Illuminate\Console\Command;

class ConsumeUserStatusUpdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume-user-status-updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UserStatusUpdatedConsumer $consumer)
    {
        $consumer->consume();
    }
}
