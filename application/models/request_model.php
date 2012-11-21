<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sev
 * Date: 12.11.17
 * Time: 18.30
 * To change this template use File | Settings | File Templates.
 */

class Request_model extends CI_Model {

    /**
     * Adds new request to database from request-form
     *
     */
    public function addRequest()
    {
        $data=array(
            'fullName'=>$this->input->post('full-name'),
            'email'=>$this->input->post('email'),
            'phone'=>$this->input->post('phone'),
            'reqText'=>$this->input->post('request-text')
        );
        $this->db->insert('request', $data);
    }

    /**
     * Calculate waiting requests
     *
     * @return int - re
     */
    public function getWaitingRequestCount()
    {
        $waiting = 0;
        // $waiting - kiek užklausų laukia atsakymo
        return $waiting;

    }

    /**
     * @return null
     */
    public function getLastRequest()
    {
        $this->db->select('requestId, fullName, email, phone, reqText, created');
        $this->db->limit(1);
        $query = $this->db->get_where('request', array('state' => 0));
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }


    /**
     * Sets manager for request and request state = 0
     *
     * @param $requestId
     * @param $managerId
     * @return bool - true if it was succsessful
     */
    public function setState($requestId, $managerId)
    {
        return false;
    }

}