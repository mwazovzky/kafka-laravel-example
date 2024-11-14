<?php

namespace App\Serializers;

use FlixTech\AvroSerializer\Objects\RecordSerializer;
use FlixTech\SchemaRegistryApi\Registry\BlockingRegistry;
use FlixTech\SchemaRegistryApi\Registry\Cache\AvroObjectCacheAdapter;
use FlixTech\SchemaRegistryApi\Registry\CachedRegistry;
use FlixTech\SchemaRegistryApi\Registry\PromisingRegistry;
use GuzzleHttp\ClientInterface;
use Junges\Kafka\Message\KafkaAvroSchema;
use Junges\Kafka\Message\Registry\AvroSchemaRegistry;
use Junges\Kafka\Message\Serializers\AvroSerializer;

class SerializerBuilder
{
    public function __construct(private readonly ClientInterface $client)
    {
        //
    }

    public function get(string $topic, string $schema): AvroSerializer
    {
        $cachedRegistry = new CachedRegistry(
            new BlockingRegistry(new PromisingRegistry($this->client)),
            new AvroObjectCacheAdapter,
        );

        $registry = new AvroSchemaRegistry($cachedRegistry);
        $recordSerializer = new RecordSerializer($cachedRegistry);

        $registry->addBodySchemaMappingForTopic(
            $topic,
            new KafkaAvroSchema($schema),
        );

        return new AvroSerializer($registry, $recordSerializer);
    }
}
