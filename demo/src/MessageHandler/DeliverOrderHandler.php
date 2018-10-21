<?php

namespace App\MessageHandler;

use App\Message\DeliverOrderMessage;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

final class DeliverOrderHandler
{
    private $logger;
    private $client;

    public function __construct(LoggerInterface $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function __invoke(DeliverOrderMessage $message)
    {
        $this->logger->info(sprintf('Order #%s is being delivered', $message->order->getId()));

        for($i = 0; $i < 4; $i++) {
            sleep(1);
            $this->logger->info('...');
        }

        $this->client->patch("/api/orders/{$message->order->getId()}/deliver");
        $this->logger->info(sprintf('Order #%s delivered', $message->order->getId()));
    }
}
