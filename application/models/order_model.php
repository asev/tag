<?php

class Order_model extends CI_Model
{

    public function addOrder()
    {
        $data=array(
            //@TODO Sudeti order laukelius
            'fullName'=>$this->input->post('full-name'),
            'email'=>$this->input->post('email'),
            'phone'=>$this->input->post('phone'),
            'reqText'=>$this->input->post('request-text')
        );
        $this->db->insert('order', $data);
    }

    public function getOrder($id) {
        $this->db->select('order.*');
        $this->db->limit(1);
        $this->db->from('order');
        $this->db->where('orderId', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }
}
