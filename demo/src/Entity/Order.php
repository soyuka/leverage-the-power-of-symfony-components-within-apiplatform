<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\OrderStatusController;
use App\Controller\OrderPrepareController;

/**
 * @ApiResource(
 *   itemOperations={"get", "put",
 *     "status"={
 *       "method"="PATCH",
 *       "path"="/orders/{id}/{status}",
 *       "controller"=OrderStatusController::class
 *     }
 *   }
 * )
 * @ORM\Entity
 * @ORM\EntityListeners({"App\EventListener\OrderCreateListener"})
 * @ORM\Table(name="orders")
 */
final class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    public $status;

    public function getId()
    {
        return $this->id;
    }
}
