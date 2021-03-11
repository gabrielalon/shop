<?php

namespace App\UI\Web;

use App\Components\Account\Application\Widget\UserWidget;
use Psr\Container\ContainerInterface;

final class WidgetRegistry
{
    /** @var ContainerInterface */
    private ContainerInterface $container;

    /**
     * WidgetRegistry constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return UserWidget
     */
    public function user(): UserWidget
    {
        return $this->container->get(UserWidget::class);
    }
}
