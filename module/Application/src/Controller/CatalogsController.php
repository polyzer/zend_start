<?php

namespace Application\Controller;

use Application\Form\CatalogForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Cars;


class CatalogsController extends AbstractActionController
{
    /**
     * Менеджер сущностей.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $catalogManager;
    private $goodManager;

    // Метод конструктора, используемый для внедрения зависимостей в контроллер.

    /**
     * CatalogsController constructor.
     * @param $entityManager
     * @param $catalogManager
     */
    public function __construct($entityManager, $catalogManager, $goodManager)
    {
        $this->entityManager = $entityManager;
        $this->catalogManager = $catalogManager;
        $this->goodManager = $goodManager;
    }

    /**
     * @return ViewModel
     * @throws \Doctrine\ORM\ORMException
     */
    public function indexAction()
    {
        $cars = $this->entityManager->getRepository(Cars::class)
            ->findAll();
        foreach()

        return new ViewModel(array(
            'cars' => $cars
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    // Это действие отображает страницу, позволяющую отредактировать пост.
    /**
     * @return void|\Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\ORMException
     */
    public function editAction()
    {
        // Получаем ID поста.
        $catalogid = $this->params()->fromRoute('id', -1);

        // Находим существующий пост в базе данных.
        $catalog = $this->entityManager->getRepository(Cars::class)
            ->findOneById($catalogid);

        if ($catalog == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Создаем форму.
        $form = new CatalogForm($this->entityManager, $catalog);

        // Проверяем, является ли пост POST-запросом.
        if ($this->getRequest()->isPost()) {

            // Получаем POST-данные.
            $data = $this->params()->fromPost();

            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {

                // Получаем валидированные данные формы.
                $data = $form->getData();

                // Используем менеджер постов, чтобы добавить новый пост в базу данных.
                $this->catalogManager->updateCatalog($catalog, $data);

                // Перенаправляем пользователя на страницу "admin".
                return $this->redirect()->toRoute('catalogs', ['action'=>'index']);
            }
        } else {
            $data = [
                'model' => $catalog->getModel(),
                'description' => $catalog->getDescription(),
            ];

            $form->setData($data);
        }

        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form,
            'catalog' => $catalog
        ]);
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function addAction()
    {
        // Создаем форму.
        $form = new CatalogForm($this->entityManager);
        // Проверяем, является ли пост POST-запросом.
        if ($this->getRequest()->isPost()) {

            // Получаем POST-данные.
            $data = $this->params()->fromPost();

            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {

                // Получаем валидированные данные формы.
                $data = $form->getData();

                // Используем менеджер постов для добавления нового поста в базу данных.
                $this->catalogManager->addNewCatalog($data);

                // Перенаправляем пользователя на страницу "index".
                return $this->redirect()->toRoute('catalogs');
            }
        }

        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form
        ]);
    }

    // Это действие отображает страницу Delete Post.

    /**
     * @return void|\Zend\Http\Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteAction()
    {
        $carid = $this->params()->fromRoute('id', -1);

        /** @var $car */
        $car = $this->entityManager->getRepository(Cars::class)
            ->findOneById($carid);

        if ($car == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->catalogManager->removeCatalog($car, $this->goodManager);


        // Перенаправляем пользователя на страницу "index".
        return $this->redirect()->toRoute('catalogs', ['action'=>'index']);
    }

}
