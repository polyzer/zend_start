<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class CatalogsTable
{
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        //$select =  $this->tableGateway->select()->order(array('mp asc'));
        return $this->tableGateway->select();
    }

    public function getCatalogs($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            return null;
        }
        return $row;
    }

    public function saveCatalogs(Catalogs $catalogs)
    {
        $data = array(
            'id' => $catalogs->id,
            'name' => $catalogs->name,
            'parent_id' => $catalogs->parent_id,
            'mp' => $catalogs->mp
        );

        $id = (int)$catalogs->id;

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCatalogs($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCatalogs($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function getAllChildren($currentid)
    {
        $Children = [];
        $table = $this->fetchAll();
        $i = 0;
        foreach ($table as $index => $el) {
            $temp = explode(',', $el->mp); //разделили массив
            if (in_array((string)$currentid, $temp)) { //содержится ли текущий id в mp записи
                $Children[$i] = $el;
                $i++;
            }
        }
        return $Children;
    }
}
