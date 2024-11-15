<?php

namespace App\Consumers;

use App\Models\User;
use Exception;
use Junges\Kafka\Contracts\ConsumerMessage;
use Throwable;

class UserStatusUpdatedConsumer extends KafkaConsumer
{
    protected const TOPIC = 'user-status-updated';

    private const BLOCKED = 'blocked';

    /**
     * @throws Exception
     */
    protected function handle(ConsumerMessage $message): void
    {
        try {
            $body = $message->getBody();

            if ($body['status'] == self::BLOCKED) {
                User::findOrFail($body['user_id'])->block();
            }

            logger()->info('UserStatusUpdatedConsumer::handle', [
                'user_id' => $body['user_id'],
            ]);
        } catch (Throwable $th) {
            logger()->error('UserStatusUpdatedConsumer::handle', [
                'error_message' => $th->getMessage(),
                'user_id' => $body['user_id'],
            ]);
        }
    }
}
