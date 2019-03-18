<?php
namespace Application\Controller\Factory;

use Application\Service\GoodManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\CatalogManager;
use Application\Controller\CatalogsController;

/**
 * Это фабрика для CatalogController. Ее целью является инстанцирование
 * контроллера.
 */
class CatalogsControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $catalogManager = $container->get(CatalogManager::class);
        $goodManager = $container->get(GoodManager::class);

        // Инстанцируем контроллер и внедряем зависимости
        return new CatalogsController($entityManager, $catalogManager, $goodManager);
    }
}