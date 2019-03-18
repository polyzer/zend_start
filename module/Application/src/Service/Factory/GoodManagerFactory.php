<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\GoodManager;

/**
 * Это фабрика для GoodManager. Ее целью является
 * инстанцирование сервиса.
 */
class GoodManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Инстанцируем сервис и внедряем зависимости.
        return new GoodManager($entityManager);
    }
}