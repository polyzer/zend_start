<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Engines;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cars")
 */
class Cars
{

     /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Engines", mappedBy="cars")
     */
    protected $engines;

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

    public function __constructor(){
        $this->engines = new ArrayCollection();
    }

    // Возвращает посты, связанные с данным тегом.
    public function getEngines() 
    {
        return $this->engines;
    }
    /**
     * Add Engine entity to collection.
     *
     * @param \TestModule\Entity\Engines $engine
     * @return \TestModule\Entity\Cars
     */
    // Добавляет пост в коллекцию постов, связанных с этим тегом.
    public function addEngine(Engines $engine) 
    {
        $this->engines[] = $engine;       
        
        return $this;
    } 
    /**
     * Remove Engine entity to collection.
     *
     * @param \TestModule\Entity\Engines $engine
     * @return \TestModule\Entity\Cars
     */
  // Добавляет пост в коллекцию постов, связанных с этим тегом.
  public function removeEngine(Engines $engine) 
  {
      $this->engines->removeElement($engine);       
      
      return $this;
  } 

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

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}