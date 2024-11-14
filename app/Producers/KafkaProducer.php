<?php

namespace App\Producers;

use App\Serializers\SerializerBuilder;
use Junges\Kafka\Contracts\MessageProducer;
use Junges\Kafka\Message\Message;

abstract class KafkaProducer
{
    protected const TOPIC = 'topic';

    public function __construct(
        private readonly SerializerBuilder $serializerBuilder,
        private readonly MessageProducer $producer,
    ) {
        //
    }

    public function send(array $body, ?string $key): void
    {
        $topic = config('topics.'.static::TOPIC.'.name');
        $schema = config('topics.'.static::TOPIC.'.schema');

        $message = new Message(
            body: $body,
            key: $key,
        );

        $serializer = $this->serializerBuilder
            ->get($topic, $schema);

        $this->producer->onTopic($topic)
            ->usingSerializer($serializer)
            ->withMessage($message)
            ->send();

        logger()->info(class_basename($this).'::send', [
            'id' => $message->getMessageIdentifier(),
            'topic_name' => $message->getTopicName(),
            'partition' => $message->getPartition(),
            'key' => $message->getKey(),
            'headers' => $message->getHeaders(),
            'body' => $message->getBody(),
        ]);
    }
}
