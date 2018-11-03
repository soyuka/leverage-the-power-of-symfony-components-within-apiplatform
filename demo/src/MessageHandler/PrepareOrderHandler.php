<?php

namespace App\MessageHandler;

use App\Message\PrepareOrderMessage;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

final class PrepareOrderHandler
{
    private $logger;
    private $client;

    public function __construct(LoggerInterface $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function __invoke(PrepareOrderMessage $message)
    {
        $this->logger->info(sprintf('Order #%s is being prepared', $message->order->getId()));

        for($i = 0; $i < 4; $i++) {
            sleep(1);
            $this->logger->info('...');
        }

        $this->client->patch("/orders/{$message->order->getId()}/prepare");
        $this->logger->info(sprintf('Order #%s prepared', $message->order->getId()));
    }
}
