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
            'phone'=>$this->input->post('phoneNumber'),
            'subject'=>$this->input->post('subject'),
            'reqText'=>$this->input->post('request-text'),
            'created'=>date("Y-m-d H:i:s")
        );
        $this->db->insert($this->reqTable, $data);
    }

    public function getCondCount($conditions) {
        $this->db->select('requestId');
        $this->db->from($this->reqTable);
        $this->db->where($conditions);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCond($conditions, $start=0, $limit=20) {
        $this->db->select($this->reqTable .'.*, ' . $this->userTable . '.username');
        $this->db->limit($limit, $start);
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSearchCount($match) {
        $this->db->select('requestId');
        $this->db->from($this->reqTable);
        $this->db->like('subject', $match);
        $this->db->or_like('reqText', $match);
        $this->db->or_like($this->reqTable . '.email', $match);
        $this->db->or_like('comment', $match);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSearch($match, $start, $limit) {
        $this->db->select($this->reqTable .'.*, ' . $this->userTable . '.username');
        $this->db->limit($limit, $start);
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        $this->db->like('subject', $match);
        $this->db->or_like('reqText', $match);
        $this->db->or_like($this->reqTable . '.email', $match);
        $this->db->or_like('comment', $match);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Calculate waiting requests
     *
     * @return int - re
     */
    public function getWaitingRequestCount()
    {
        $this->db->from($this->reqTable);
        $this->db->where('state', 0);
        $this->db->where('spam', 0);
        return $this->db->count_all_results();

    }

    public function getLastRequestId()
    {
        $this->db->select('requestId');
        $this->db->limit(1);
        $this->db->from($this->reqTable);
        $this->db->where('state', 0);
        $this->db->where('spam', 0);
        $this->db->order_by('created', 'ASC');
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

    public function setRequest($requestId, $data)
    {
        $this->db->where('requestId', $requestId);
        $this->db->update($this->reqTable, $data);
    }

    public function statManagerNames($cond) {
        $this->db->select($this->userTable . '.username,' . $this->reqTable .'.manager, COUNT(' . $this->reqTable . '.requestId) AS \'count\'');
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        if (!is_null($cond)) { $this->db->where($cond); }
        $this->db->group_by($this->reqTable . '.manager');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function statManagerCount($cond) {
        $this->db->select($this->reqTable .'.manager, COUNT(' . $this->reqTable . '.requestId) AS \'count\'');
        $this->db->from($this->reqTable);
        $this->db->where($cond);
        $this->db->group_by($this->reqTable . '.manager');
        $query = $this->db->get();
        return $query->result_array();
    }
}