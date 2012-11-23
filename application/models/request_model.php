<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sev
 * Date: 12.11.17
 * Time: 18.30
 * To change this template use File | Settings | File Templates.
 */

class Request_model extends CI_Model {

    private $reqTable = "request";
    private $userTable = "users";

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
            'subject'=>$this->input->post('subject'),
            'reqText'=>$this->input->post('request-text')
        );
        $this->db->insert($this->reqTable, $data);
    }

    /**
     * Calculate waiting requests
     *
     * @return int - re
     */
    public function getWaitingRequestCount()
    {
        $this->db->from($this->reqTable);
        $this->db->where('state', '0');
        return $this->db->count_all_results();

    }

    /**
     * Ar reikalinga???
     *
     * @return null

    public function getLastRequest()
    {
        //@TODO Istrinti sita
        $this->db->select('request.*, users.username');
        $this->db->limit(1);
        $this->db->from('request');
        $this->db->join('users','users.id = request.manager', 'left');
        $this->db->where('state', 0);
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    public function getLastRequestDate()
    {
        $req = $this->getLastRequest();
        return $req->created;
    }
*/
    public function getLastRequestId()
    {
        $this->db->select('requestId');
        $this->db->limit(1);
        $this->db->from($this->reqTable);
        $this->db->where('state', 0);
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row()->requestId;
        return NULL;
    }

    public function getRequest($id) {
        $this->db->select($this->reqTable .'.*, ' . $this->userTable . '.username');
        $this->db->limit(1);
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        $this->db->where('requestId', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }

    public function getManager($id) {
        $this->db->select($this->reqTable . '.manager');
        $this->db->limit(1);
        $this->db->from($this->reqTable);
        $this->db->where('requestId', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row()->manager;
    }

    public function getState($id) {
        $this->db->select($this->reqTable . '.state');
        $this->db->limit(1);
        $this->db->from($this->reqTable);
        $this->db->where('requestId', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row()->state;
    }


    /**
     * Sets manager for request and request state = 0
     *
     * @param $requestId
     * @param $managerId
     * @return bool - true if it was succsessful
     */
    public function setState($requestId, $state, $manager = null)
    {
        $data = array(
            'state' => $state
        );
        if (!is_null($manager)) {
            $data['manager'] = $manager;
        }
        $this->db->where('requestId', $requestId);
        $this->db->update($this->reqTable, $data);
    }

    public function setManager($requestId, $manager)
    {
        $data = array(
            'manager' => $manager
        );
        $this->db->where('requestId', $requestId);
        $this->db->update($this->reqTable, $data);
    }

}