<?php

namespace App\MessageHandler;

use Psr\Log\LoggerInterface;
use App\Message\PrepareOrder;
use GuzzleHttp\Client;

class PrepareOrderHandler
{
    private $logger;
    private $client;

    public function __construct(LoggerInterface $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function __invoke(PrepareOrder $message)
    {
        $this->logger->info(sprintf('Order #%s is being delivered', $message->order->getId()));

        for($i = 0; $i < 2; $i++) {
            sleep(1);
            $this->logger->info('...');
        }

        $this->client->patch("/api/orders/{$message->order->getId()}/deliver");
    }
}
