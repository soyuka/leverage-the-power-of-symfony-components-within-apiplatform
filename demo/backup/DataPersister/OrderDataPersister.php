<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Order;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Workflow\Registry;

final class OrderDataPersister implements DataPersisterInterface
{
    private $workflows;
    private $managerRegistry;

    public function __construct(Registry $workflows, ManagerRegistry $managerRegistry)
    {
        $this->workflows = $workflows;
        $this->managerRegistry = $managerRegistry;
    }

    public function supports($data): bool
    {
        return $data instanceof Order;
    }

    public function persist($data)
    {
        $manager = $this->managerRegistry->getManagerForClass(Order::class);

        if (!$data->getId()) {
            $workflow = $this->workflows->get($data);
            $workflow->can($data, 'prepare');
        }

        $manager->persist($data);
        $manager->flush();
    }

    public function remove($data) {
        $workflow = $this->workflows->get($data);

        if (!$workflow->can($data, 'cancel')) {
            throw new HttpException(400, 'Order can not be canceled');
        }

        $workflow->apply($data, 'cancel');
        $manager->persist($data);
        $manager->flush();
    }
}
