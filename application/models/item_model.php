<?php

class Item_model extends CI_Model
{
    private $itemTable = "items";

    public function addItem($orderId)
    {
        $data = array(
            'itemId'=>$this->input->post('item-id'),
            'orderId'=>$orderId,
            'itemName'=>$this->input->post('item-name'),
            'itemPrice'=>$this->input->post('item-price'),
            'itemQuantity'=>$this->input->post('item-quantity')
        );
        $this->db->insert($this->itemTable, $data);
    }

    public function getItems($orderId)
    {
        $data = $this->db->get_where($this->itemTable, array('orderId' => $orderId))->result_array();
        return $data;
    }

    public function deleteItem($orderId, $itemId)
    {
        $this->db->delete($this->itemTable, array('orderId' => $orderId, 'itemId' => $itemId));
    }
}
