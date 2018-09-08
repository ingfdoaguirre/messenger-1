<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\Transport\AmqpExt;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * Symfony Messenger sender to send messages to AMQP brokers using PHP's AMQP extension.
 *
 * @author Samuel Roze <samuel.roze@gmail.com>
 */
class AmqpSender implements SenderInterface
{
    private $serializer;
    private $connection;

    public function __construct(SerializerInterface $serializer, Connection $connection)
    {
        $this->serializer = $serializer;
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Envelope $envelope)
    {
        $encodedMessage = $this->serializer->encode($envelope);

        $this->connection->publish($encodedMessage['body'], $encodedMessage['headers']);
    }
}
