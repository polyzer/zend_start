<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="engines")
*/
class Engines
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    private $id;

    /**
     * @ORM\Column(name="name")
     */
    private $name;


    /**
     * @ORM\Column(name="power")
     */
    private $power;

    /**
     * @ORM\Column(name="description")
     */
    private $description;

    // Возвращает ID каталога
    public function getId()
    {
        return $this->id;
    }

    // Возвращает заголовок.
    public function getName()
    {
        return $this->name;
    }

    // Задает заголовок.
    public function setName($name)
    {
        $this->name = $name;
    }


    // Возвращает цену.
    public function getPower()
    {
        return $this->power;
    }

    // Задает цену.
    public function setPower($power)
    {
        $this->power = $power;
    }


    // Возвращает описание.
    public function getDescription()
    {
        return $this->description;
    }

    // Задает описание.
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function __toString(){

        return "";
    }
}
