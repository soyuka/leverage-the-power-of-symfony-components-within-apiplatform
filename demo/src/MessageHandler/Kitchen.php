<?php

namespace App\MessageHandler;

use App\Message\DeliverOrder;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageHandlerInterface;

final class Kitchen implements MessageHandlerInterface
{
    private $logger;
    private $client;

    public function __construct(LoggerInterface $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function __invoke(DeliverOrder $message)
    {
        $this->logger->info(sprintf('Order #%s is being delivered', $message->order->getId()));

        for($i = 0; $i < 4; $i++) {
            sleep(1);
            $this->logger->info('...');
        }

        $this->logger->info("PATCH /orders/{$message->order->getId()}/deliver");
        $this->client->patch("/orders/{$message->order->getId()}/deliver");
        $this->logger->info(sprintf('Order #%s delivered', $message->order->getId()));
    }
}
