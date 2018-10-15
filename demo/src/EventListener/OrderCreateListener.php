<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Order;
use App\Message\PrepareOrder;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

final class OrderCreateListener
{
    private $bus;
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function postPersist(Order $order, LifecycleEventArgs $event)
    {
        $this->bus->dispatch(new PrepareOrder($order));
    }
}
