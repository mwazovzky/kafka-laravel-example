<?php

namespace App\Producers;

class UserStatusProducer extends KafkaProducer
{
    protected const TOPIC = 'user-status-updated';
}
