<?php

class Order_model extends CI_Model
{
    private $orderTable = "orders";
    private $userTable = "users";

    public function addOrder($reqId, $me)
    {
        $query = $this->db->get_where($this->orderTable, array('managerId' => $me, 'requestId' => $reqId), 1);
        if ($query->num_rows() == 0)
        {
            $data = array(
                'requestId'=>$reqId,
                'createDate'=>date("Y-m-d H:i:s"),
                'managerId'=>$me
            );
            $this->db->insert($this->orderTable, $data);
        } else return NULL;
    }

    public function getOrder($reqId, $me)
    {
        $query = $this->db->get_where($this->orderTable, array('managerId' => $me, 'requestId' => $reqId), 1);
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    public function getOrderById($orderId)
    {
        $query = $this->db->get_where($this->orderTable, array('orderId' => $orderId), 1);
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    public function getOrderId($reqId, $me)
    {
        $this->db->select('orderId');
        $this->db->from($this->orderTable);
        $this->db->where('requestId', $reqId);
        $this->db->where('managerId', $me);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row()->orderId;
        return NULL;
    }

    public function setOrder($orderId, $data)
    {
        $this->db->where('orderId', $orderId);
        $this->db->update($this->orderTable, $data);
    }

    public function checkActive($orderId)
    {
        $this->db->select('active');
        $this->db->from($this->orderTable);
        $this->db->where('orderId', $orderId);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row()->active;
        return NULL;
    }
}
