<?php

class Order_model extends CI_Model
{
    private $orderTable = "orders";
    private $userTable = "users";

    public function addOrder($reqId, $me)
    {
        $data = array(
            'requestId'=>$reqId,
            'createDate'=>date("Y-m-d H:i:s"),
            'managerId'=>$me
        );
        $this->db->insert($this->orderTable, $data);
    }

    public function getOrder($reqId, $me)
    {
        $query = $this->db->get_where($this->orderTable, array('managerId' => $me, 'requestId' => $reqId), 1);
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }
}
