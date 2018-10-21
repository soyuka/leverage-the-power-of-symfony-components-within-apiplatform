<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\OrderTransitionController;
use App\EventListener\OrderCreateListener;

/**
 * @ApiResource(
 *   itemOperations={"get", "put", "delete",
 *     "status"={
 *       "method"="PATCH",
 *       "path"="/orders/{id}/{transition}",
 *       "controller"=OrderTransitionController::class
 *     }
 *   }
 * )
 * @ORM\Entity
 * @ORM\EntityListeners({OrderCreateListener::class})
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
