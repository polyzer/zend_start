<?php

namespace Application\Form;

use Application\Controller\GoodsController;
use Application\Entity\Engines;
use Application\Entity\Cars;
use Application\Service\CatalogManager;
use Application\Service\GoodManager;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

// Модель формы обратной связи
class ProductForm extends Form
{
    private $em;
    // Конструктор.
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
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
        // Добавляем название
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'attributes' => [
                'id' => 'id',
                'class' => 'form-control',
                'style' => 'display:block; margin-bottom:10px;'
            ],
            'options' => [
                'label' => 'Введите название экрана: ',
            ],
        ]);

        // Добавляем поле мощность
        $this->add([
            'type' => 'text',
            'name' => 'power',
            'attributes' => [
                'rows' => "7",
                'id' => 'id',
                'class' => 'form-control',
                'style' => 'display:block; margin-bottom:10px;'
            ],
            'options' => [
                'label' => 'Введите диагональ: ',
            ],
        ]);

        // Добавляем поле описание
        $this->add([
            'type' => 'textarea',
            'name' => 'description',
            'attributes' => [
                'rows' => "7",
                'id' => 'id',
                'class' => 'form-control',
                'style' => 'display:block; margin-bottom:10px;'
            ],
            'options' => [
                'label' => 'Введите описание экрана: ',
            ],
        ]);


        // Добавляем кнопку отправки формы
        $this->add([
            'type' => 'submit',
            'name' => 'submitadd',
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
            'name' => 'name',
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
                        'max' => 100
                    ],
                ],
            ],
        ]);


    }

}