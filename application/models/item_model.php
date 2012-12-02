<?php

/**
 *  Darbo su DB lentele items klasė.
 */
class Item_model extends CI_Model
{
    /**
     * @var string - prekių lentelės pavadinimas
     */
    private $itemTable = "items";

    /**
     * Naujos prekės talpinimas į DB iš item-form
     *
     * @param $orderId - užsakymo Id
     */
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

    /**
     * Grąžina prekes užsakyme
     *
     * @param $orderId - užsakymo Id
     * @return mixed - užsakymo prekių sąrašas
     */
    public function getItems($orderId)
    {
        $data = $this->db->get_where($this->itemTable, array('orderId' => $orderId))->result_array();
        return $data;
    }

    /**
     * Ištrina prekę
     *
     * @param $orderId - Užsakymo id
     * @param $itemId - Neunikalus prekės Id
     */
    public function deleteItem($orderId, $itemId)
    {
        $this->db->delete($this->itemTable, array('orderId' => $orderId, 'itemId' => $itemId));
    }
}
