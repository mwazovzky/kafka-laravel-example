<?php

namespace Tests\Unit\Models;

use App\Producers\UserStatusProducer;
use App\Serializers\SerializerBuilder;
use Junges\Kafka\Contracts\MessageProducer;
use Junges\Kafka\Message\Serializers\AvroSerializer;
use Tests\TestCase;

class UserStatusProducerTest extends TestCase
{
    public function testSend(): void
    {
        $topic = 'user-status-updated';
        $schema = 'user-status-updated-value';
        $body = ['user_id' => 123, 'status' => 'blocked'];

        /**
         * @var AvroSerializer $mockAvroSerializer
         */
        $mockAvroSerializer = $this->mock(AvroSerializer::class);

        /**
         * @var SerializerBuilder $mockSerializerBuilder
         */
        $mockSerializerBuilder = $this->mock(SerializerBuilder::class, function ($mock) use ($mockAvroSerializer, $topic, $schema) {
            $mock->shouldReceive('get')
                ->with($topic, $schema)
                ->once()
                ->andReturn($mockAvroSerializer);
        });

        /**
         * @var MessageProducer $mockMessageProducer
         */
        $mockMessageProducer = $this->mock(MessageProducer::class, function ($mock) use ($topic, $mockAvroSerializer, $body) {
            $mock->shouldReceive('onTopic')
                ->with($topic)
                ->once()
                ->andReturn($mock);

            $mock->shouldReceive('usingSerializer')
                ->with($mockAvroSerializer)
                ->once()
                ->andReturn($mock);

            $mock->shouldReceive('withMessage')
                ->withArgs(fn ($message) => $message->getBody() === $body && $message->getKey() === (string) $body['user_id'])
                ->once()
                ->andReturn($mock);

            $mock->shouldReceive('send')->once();
        });

        $producer = new UserStatusProducer($mockSerializerBuilder, $mockMessageProducer);
        $producer->send($body, (string) $body['user_id']);
    }
}
