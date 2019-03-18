<?php
namespace Application\Service;

use Application\Controller\GoodsController;
use Application\Entity\Engines;
use Doctrine\ORM\EntityManager;

// Сервис The CatalogManager, отвечающий за дополнение новых каталогов
class GoodManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Конструктор, используемый для внедрения зависимостей в сервис.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Этот метод добавляет новый пост.

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNewProduct($data)
    {
        // Создаем новую сущность Post.
        $engines = new Engines();
        $engines->setName($data['name']);
        $engines->setDescription($data['description']);
        $engines->setPower((int)$data['power']);

        // Добавляем сущность в менеджер сущностей.
        $this->entityManager->persist($engines);

        // Применяем изменения к базе данных.
        $this->entityManager->flush();
    }


    // Этот метод позволяет обновлять данные одного поста.

    /**
     * @param $product
     * @param $data
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProduct($product, $data)
    {
        /** @var Engiens $product */
        $product->setName($data['name']);
        $product->setPower($data['power']);
        $product->setDescription($data['description']);

        // Применяем изменения к базе данных.
        $this->entityManager->flush();
    }

    // Удаляет пост и все связанные с ним комментарии.

    /**
     * @param $catalog
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeProduct($product)
    {
        $this->entityManager->remove($product);

        $this->entityManager->flush();
    }

}