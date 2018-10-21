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
 * PATCH /orders/{id}/{transition}
 */
final class OrderTransitionController
{
    public function __construct(Registry $workflows)
    {
        $this->workflows = $workflows;
    }

    public function __invoke(Order $data, $transition): Order
    {
        $workflow = $this->workflows->get($data);

        try {
            $workflow->apply($data, $transition);
        } catch (TransitionException $exception) {
            throw new HttpException(400, "Can not apply transition.");
        }

        return $data;
    }
}
