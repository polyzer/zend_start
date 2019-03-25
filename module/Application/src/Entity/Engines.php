<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Cars;
/**
* @ORM\Entity
* @ORM\Table(name="engines")
*/


class Engines
{
/**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Cars", inversedBy="engines")
     * @ORM\JoinTable(name="cars_engines",
     *      joinColumns={@ORM\JoinColumn(name="engine_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="car_id", referencedColumnName="id")}
     *      )
     */
    protected $cars;
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

    public function __constructor(){
        $this->cars = new ArrayCollection(); 
    }

    // Добавляет новый тег к данному посту.
    public function addCars($car) 
    {
        $this->cars[] = $car;        
    }

    // Добавляет новый тег к данному посту.
    public function getCars() 
    {
        return $this->cars;        
    }

    
    // Удаляет связь между этим постом и заданным тегом.
    public function removeCarAssociation($car) 
    {
        $this->cars->removeElement($car);
    }


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
