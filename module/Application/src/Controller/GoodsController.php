<?php

namespace Application\Controller;

use Application\Entity\Cars;
use Application\Form\ProductForm;
use Application\Service\GoodManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Engines;


/**
 * @property  entityManager
 */
class GoodsController extends AbstractActionController
{
    protected $catalogManager;
    protected $goodManager;
    private $entityManager;

    /**
     * GoodsController constructor.
     * @param $entityManager
     * @param $goodManager
     * @param $catalogManager
     */
    public function __construct($entityManager, $goodManager, $catalogManager)
    {
        $this->entityManager = $entityManager;
        $this->goodManager = $goodManager;
        $this->catalogManager = $catalogManager;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $engines = $this->entityManager->getRepository(Engines::class)->findAll();
        return new ViewModel(array(
            'engines' => $engines
        ));
    }

    private function checkInputData($data, $form)
    {

        if (!$data['description'])
            $errormessage = 'Поле описание не должно быть пустым!';

        if (!$data['power'])
            $errormessage = "Укажите целочисленное значение для поля 'мощность двигателя'";

        return $errormessage;
    }

    /**
     * @return void|\Zend\Http\Response|ViewModel
     * @throws \Exception
     * @return ViewModel
     */
    public function editAction()
    {

        // Создаем форму.
        $form = new ProductForm($this->entityManager);

        // Получаем ID продукта.
        $productId = $this->params()->fromRoute('id', -1);
        // Находим существующий продукт в базе данных.
        $product = $this->entityManager->getRepository(Engines::class)
            ->findOneById($productId);
        if ($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $form->bind($product);
        // Проверяем, является ли пост POST-запросом.
        if ($this->getRequest()->isPost()) {
            // Получаем POST-данные.
            $request = $this->getRequest();


            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {

                // Получаем валидированные данные формы.
                $data = $form->getData();

                //Чекаем полученные данные
                $errormessage = $this->checkInputData($data, $form);
                if ($errormessage) {
                    /** @var $errormessage */
                    return new ViewModel([
                        'form' => $form,
                        'errormessage' => $errormessage,
                        'id' => $productId
                    ]);
                }

                // Используем менеджер продуктов, чтобы обновить продукт в базу данных.
                $this->goodManager->updateProduct($product, $data);

                // Перенаправляем пользователя на главную
                return $this->redirect()->toRoute('goods', ['action'=>'index']);
            }
        } else {
            $data = array(
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'power' =>$product->getPower()
            );

            $form->setData($data);
        }

        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form,
            'product' => $product,
            'id' => $productId
        ]);
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    public function addAction()
    {
        // Создаем форму.
        $form = new ProductForm($this->entityManager);
        $engine = new Engines();
        $form->bind($product);
        // Проверяем, является ли пост POST-запросом.
        if ($this->getRequest()->isPost()) {
            // Получаем POST-данные.
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );


            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {
                // Получаем валидированные данные формы.
                $data = $form->getData();

                //Чекаем полученные данные
                $errormessage = $this->checkInputData($data, $form);
                if ($errormessage) {
                    return new ViewModel([
                        'form' => $form,
                        'errormessage' => $errormessage
                    ]);
                }

                // Используем менеджер продуктов, чтобы обновить продукт в базу данных.
                $this->goodManager->addNewProduct($data);

                // Перенаправляем пользователя на главную
                return $this->redirect()->toRoute('goods', ['action'=>'index']);
            }
        }
        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form
        ]);
    }


    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    // Это действие отображает страницу Delete.
    public function deleteAction()
    {
        $productId = $this->params()->fromRoute('id', -1);

        $product = $this->entityManager->getRepository(Engines::class)
            ->findOneById($productId);
        if ($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        /** @var TYPE_NAME $this */
        $this->goodManager->removeProduct($product);

        // Перенаправляем пользователя на страницу "index".
        return $this->redirect()->toRoute('goods', ['action'=>'index']);
    }

}
