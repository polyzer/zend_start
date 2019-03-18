<?php

namespace Application\Form;

use Application\Controller\CatalogsController;
use Application\Entity\Cars;
use Application\Service\CatalogManager;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

// Модель формы обратной связи
class CatalogForm extends Form
{
    private $allCatalogs = [];
    private $em;
    private $curCatalog;

    // Конструктор.
    public function __construct($entityManager, $curCatalog = null)
    {
        $this->em = $entityManager;
        $this->curCatalog = $curCatalog;
        // Определяем имя формы.
        parent::__construct('post-form');

        // Задает для этой формы метод POST.
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
}

    // Этот метод добавляет элементы к форме (поля ввода и
    // кнопку отправки формы).
    private function addElements()
    {
        // Добавляем поле
        $this->add([
            'type' => 'text',
            'name' => 'model',
            'attributes' => [
                'id' => 'catid',
                'class' => 'form-control',
                'style' => 'display:block; margin-bottom:10px;'
            ],
            'options' => [
                'label' => 'Введите имя авто: ',
            ],
        ]);

        // Добавляем поле
        $this->add([
            'type' => 'textarea',
            'name' => 'description',
            'attributes' => [
                'id' => 'catid',
                'class' => 'form-control',
                'style' => 'display:block; margin-bottom:10px;'
            ],
            'options' => [
                'label' => 'Введите описание авто: ',
            ],
        ]);

        // Добавляем кнопку отправки формы
        $this->add([
            'type' => 'submit',
            'name' => 'submitcatadd',
            'attributes' => [
                'value' => 'Добавить',
                'class' => 'btn btn-primary'
            ],
        ]);
    }

    // Этот метод создает фильтр входных данных (используемый для фильтрации/валидации).
    private function addInputFilter()
    {
        // Используем стандартный InputFilter формы
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'model',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 40
                    ],
                ],
            ],
        ]);
    }
}