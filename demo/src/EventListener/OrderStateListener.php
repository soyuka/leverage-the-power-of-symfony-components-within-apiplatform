<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Message\DeliverOrderMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Event\Event;

final class OrderStateListener implements EventSubscriberInterface
{
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function onPrepare(Event $event)
    {
        $order = $event->getSubject();
        $this->bus->dispatch(new DeliverOrderMessage($order));
    }

    public static function getSubscribedEvents()
    {
        return array(
            'workflow.order.transition.prepare' => 'onPrepare',
        );
    }
}
