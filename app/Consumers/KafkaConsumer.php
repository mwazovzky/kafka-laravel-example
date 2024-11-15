<?php

namespace App\Consumers;

use App\Serializers\DeserializerBuilder;
use Junges\Kafka\Contracts\ConsumerBuilder;
use Junges\Kafka\Contracts\ConsumerMessage;

abstract class KafkaConsumer
{
    protected const TOPIC = 'some-topic';

    public function __construct(
        private readonly DeserializerBuilder $deserializerBuilder,
        private readonly ConsumerBuilder $consumerBuilder,
    ) {
        //
    }

    abstract protected function handle(ConsumerMessage $message): void;

    public function consume(): void
    {
        $topic = config('topics.'.static::TOPIC.'.name');
        $schema = config('topics.'.static::TOPIC.'.schema');
        $groupId = config('topics.'.static::TOPIC.'.group_id');

        $deserializer = $this->deserializerBuilder->get($topic, $schema);

        $this->consumerBuilder
            ->subscribe($topic)
            ->withConsumerGroupId($groupId)
            ->withDlq()
            ->withAutoCommit()
            ->usingDeserializer($deserializer)
            ->withMiddleware(fn (ConsumerMessage $message, callable $next) => $this->log($message, $next))
            ->withHandler(fn (ConsumerMessage $message) => $this->handle($message))
            ->build()
            ->consume();
    }

    private function log(ConsumerMessage $message, callable $next): ?callable
    {
        logger()->info(class_basename($this).'::consume', [
            'id' => $message->getMessageIdentifier(),
            'topic_name' => $message->getTopicName(),
            'partition' => $message->getPartition(),
            'key' => $message->getKey(),
            'headers' => $message->getHeaders(),
            'body' => $message->getBody(),
            'offset' => $message->getOffset(),
            'timestamp' => $message->getTimestamp(),
        ]);

        return $next($message);
    }
}
