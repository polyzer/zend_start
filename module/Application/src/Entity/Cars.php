<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cars")
 */
class Cars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    private $id;

    /**
     * @ORM\Column(name="model")
     */
    private $model;

    /**
     * @ORM\Column(name="description")
     */
    private $description;

    // Возвращает ID каталога
    public function getId()
    {
        return $this->id;
    }

    // Задает ID каталога (не используется).
    public function setId($id)
    {
        $this->id = $id;
    }

    // Возвращает заголовок.
    public function getModel()
    {
        return $this->model;
    }

    // Задает заголовок.
    public function setModel($model)
    {
        $this->model = $model;
    }

    // Задает заголовок.
    public function setDescription($desc)
    {
        $this->description = $desc;
    }
    // Задает заголовок.
    public function getDescription()
    {
        return $this->description;
    }

    public function __toString(){
        return $this->getmodel();
    }
}