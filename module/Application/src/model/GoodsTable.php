<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class GoodsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getGoods($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getGoodsFromCatalog($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('catalog_id' => $id));
        //$row = $rowset->current();
        if (!$rowset) {
            throw new \Exception("Could not find row $id");
        }
        return $rowset;
    }

    public function saveGoods(Goods $goods)
    {
        $data = array(
            'price' => $goods->price,
            'name' => $goods->name,
            'desc' => $goods->desc,
            'picture' => $goods->picture['name'],
            'catalog_id' => $goods->catalog_id,
        );

        $id = (int)$goods->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGoods($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteGoods($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
