<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Order;

final class DeliverOrder
{
    public $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }
}
