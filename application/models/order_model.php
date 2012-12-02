<?php

/**
 *  Darbo su DB lentele orders klasė.
 */
class Order_model extends CI_Model
{
    /**
     * @var string - užsakymų lentelės pavadinimas
     */
    private $orderTable = "orders";

    /**
     * Naujo užsakymo talpinimas į DB iš order-form
     *
     * @param $reqId - užklausos Id
     * @param $me - prisijungusio vartotojo Id
     */
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

    /**
     * Grąžinamas užsakymas
     *
     * @param $reqId - užklausos Id
     * @param $me - prisijungusio vartotojo Id
     */
    public function getOrder($reqId, $me)
    {
        $query = $this->db->get_where($this->orderTable, array('managerId' => $me, 'requestId' => $reqId), 1);
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    /**
     * Grąžinamas užsakymas pagal užsakymo Id
     *
     * @param $orderId - užsakymo Id
     */
    public function getOrderById($orderId)
    {
        $query = $this->db->get_where($this->orderTable, array('orderId' => $orderId), 1);
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    /**
     * Grąžinamas užsakymo Id
     *
     * @param $reqId - užklausos Id
     * @param $me - prisijungusio vartotojo Id
     */
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

    /**
     *  Užsakymo atnaujinimas
     *
     * @param $orderId - užsakymo Id
     * @param $data - atnaujinami duomenys
     */
    public function setOrder($orderId, $data)
    {
        $this->db->where('orderId', $orderId);
        $this->db->update($this->orderTable, $data);
    }

    /**
     * Grąžina 1 jei užsakymas pildomas, 0 - jei baigtas pildyti
     *
     * @param $orderId - užsakymo Id
     * @return null - užsakymo aktyvumo būsena
     */
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
