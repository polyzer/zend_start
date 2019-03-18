<?php
namespace Application\Controller\Factory;

use Application\Controller\GoodsController;
use Application\Service\CatalogManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\GoodManager;

/**
 * Это фабрика для GoodController. Ее целью является инстанцирование
 * контроллера.
 */
class GoodsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $goodManager = $container->get(GoodManager::class);
        $catalogManager = $container->get(CatalogManager::class);

        // Инстанцируем контроллер и внедряем зависимости
        return new GoodsController($entityManager, $goodManager, $catalogManager);
    }
}