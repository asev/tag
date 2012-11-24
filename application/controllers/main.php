<?php

class Main extends CI_Controller {

    private $view = "";

    public function Main()
    {
        parent::__construct();
        $this->load->model('request_model', "reqM");
        if ($this->tank_auth->is_logged_in()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('search', 'Search', 'trim|required|max_length[60]|xss_clean');
            if ($this->form_validation->run()) {
                redirect('reqs/search/'. $this->input->post('search'));
            }
        }
    }

    public function index()
    {
        $this->typeRedirect($this->checkType());
    }

    public function client()
    {
        if ($this->checkType() != 0) {
            $this->typeRedirect($this->checkType());
        } else {
            redirect('req/add');
        }
    }

    public function boss()
    {
        if ($this->checkType() != 1) {
            $this->typeRedirect($this->checkType());
        } else {
            echo "Like a Bboss";
        }
    }

    public function manager()
    {
        if ($this->checkType() != 2) {
            $this->typeRedirect($this->checkType());
        } else {
            $data['waiting'] = $this->reqM->getWaitingRequestCount();
           // if ($data['waiting'] > 0) $data['newest'] = $this->reqM->getLastRequestDate();
            $this->view = $this->view . $this->load->view('main/manager', $data, true);

            $this->load->view('page', array('view' => $this->view));
        }
    }



    private function checkType() {
        if ($this->tank_auth->is_logged_in()) {
            return $this->tank_auth->getUserType();
        }
        else return 0;
    }

    private function typeRedirect($type) {
        switch ($type) {
            case "0" :
                redirect('main/client');
                break;
            case "1" :
                redirect('main/boss');
                break;
            case "2" :
                redirect('main/manager');
                break;
        }
    }
}
