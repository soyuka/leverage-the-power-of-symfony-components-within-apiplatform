<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Workflow\Exception\TransitionException;
use Symfony\Component\Workflow\Registry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PATCH /orders/{id}/{status}
 */
final class OrderStatusController
{
    public function __construct(Registry $workflows)
    {
        $this->workflows = $workflows;
    }

    public function __invoke(Order $data, $status): Order
    {
        $workflow = $this->workflows->get($data);

        try {
            $workflow->apply($data, $status);
        } catch (TransitionException $exception) {
            throw new HttpException(400, "Can not transition to $status");
        }

        return $data;
    }
}
