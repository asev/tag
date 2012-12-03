<?php

/**
 *  Darbo su DB lentele request klasė.
 */
class Request_model extends CI_Model {

    /**
     * @var string - užklausų lentelės pavadinimas
     */
    private $reqTable = "request";
    /**
     * @var string - vartotojo lentelės pavadinimas
     */
    private $userTable = "users";

    /**
     * Naujos užklausos talpinimas į DB iš request-form
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

    /**
     *  Skaičuojama kiek yra rezultatų atitinkančių užduotą sąlygą
     *
     * @param $conditions - sąlyga pagal kurią skaičuojami rezultatai
     * @return mixed - rezultatų skaičius
     */
    public function getCondCount($conditions) {
        $this->db->select('requestId');
        $this->db->from($this->reqTable);
        $this->db->where($conditions);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     *  Gražinamos užklausos pagal užduotą sąlygą.
     *
     * @param $conditions - sąlyga
     * @param int $start - užklausų išrinkimo pradžios vieta
     * @param int $limit - skaičius kiek užklausų reikia atrinkti
     * @return mixed - atrinktos užklausos
     */
    public function getCond($conditions, $start=0, $limit=20) {
        $this->db->select($this->reqTable .'.*, ' . $this->userTable . '.username');
        $this->db->limit($limit, $start);
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     *  Gražinamas paieškos pagal raktažodį rezultatų skaičius
     *
     * @param $match - paieškos raktažodis
     * @return mixed - rezultatų skaičius
     */
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

    /**
     *  Paieška pagal raktažodį
     *
     * @param $match - paieškos raktažodis
     * @param int $start - užklausų išrinkimo pradžios vieta
     * @param int $limit - skaičius kiek užklausų reikia atrinkti
     * @return mixed - atriktos užklausos
     */
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
     *  Skaičiuojama kiek šiuo metu yra nepriskirtų užklausų
     *
     * @return int - nepriskirtų užklausų skaičius
     */
    public function getWaitingRequestCount()
    {
        $this->db->from($this->reqTable);
        $this->db->where('state', 0);
        $this->db->where('spam', 0);
        return $this->db->count_all_results();

    }

    /**
     *  Gražinamas Id užklausos kuri jau ilgiausiai laukia aptarnavimo
     *
     * @return null - seniausios nepriskirtos užklausos Id
     */
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

    /**
     *  Atrenkama viena užklausa pagal Id
     *
     * @param $id - užklausos Id
     * @return null - užklausa pagal Id
     */
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

    /**
     *  Užklausos atnaujinimas
     *
     * @param $requestId - užklausos Id
     * @param $data - atnaujinami duomenys
     */
    public function setRequest($requestId, $data)
    {
        $this->db->where('requestId', $requestId);
        $this->db->update($this->reqTable, $data);
    }

    /**
     *  Grąžinamas sąlygą atitinkančių užklausų skaičius sugrupuotas pagal vadybininkus ir vadybininko vardas
     *
     * @param $cond - atrinkimo sąlyga
     * @return mixed - sugrupuoti vadybininkų duomenys ir jų vardai
     */
    public function statManagerNames($cond) {
        $this->db->select($this->userTable . '.username,' . $this->reqTable .'.manager, COUNT(' . $this->reqTable . '.requestId) AS \'count\'');
        $this->db->from($this->reqTable);
        $this->db->join($this->userTable, $this->userTable . '.id = ' . $this->reqTable . '.manager', 'left');
        if (!is_null($cond)) { $this->db->where($cond); }
        $this->db->group_by($this->reqTable . '.manager');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     *  Grąžinamas sąlygą atitinkančių užklausų skaičius sugrupuotas pagal vadybininkus
     *
     * @param $cond - atrinkimo sąlyga
     * @return mixed - sugrupuoti vadybininkų duomenys
     */
    public function statManagerCount($cond) {
        $this->db->select($this->reqTable .'.manager, COUNT(' . $this->reqTable . '.requestId) AS \'count\'');
        $this->db->from($this->reqTable);
        $this->db->where($cond);
        $this->db->group_by($this->reqTable . '.manager');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function managersIncome($cond) {
        $this->db->select($this->reqTable .'.manager, SUM(items.itemPrice) AS \'count\'');
        $this->db->from($this->reqTable);
        $this->db->join('orders', 'orders.requestId = ' . $this->reqTable . '.requestId', 'right');
        $this->db->join('items', 'items.orderId = ' . 'orders.orderId', 'right');
        $this->db->where($cond);
        $this->db->group_by('orders.managerId');
        $query = $this->db->get();
        return $query->result_array();
    }
}