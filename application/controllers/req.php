<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sev
 * Date: 12.11.17
 * Time: 18.43
 * To change this template use File | Settings | File Templates.
 */




Class Req extends CI_Controller {

    public function Req()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('request_model');
    }

    public function index()
    {
        if ($this->tank_auth->is_logged_in()) {									// logged in
            redirect('');
        } else {
            redirect('req/add');
        }
    }

    public function add()
    {
        if ($this->tank_auth->is_logged_in()) {									// logged ina
            redirect('');
        } else {
            $data = array();
            $this->form_validation->set_rules('full-name', 'Full name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone number', 'trim|min_length[6]|max_length[50]');
            $this->form_validation->set_rules('request-text', 'Request', 'trim|required|min_length[10]|max_length[5000]');
            if($this->form_validation->run())
            {
                $this->request_model->addRequest();
                $this->load->view('request-success');
            }
        }
        $this->load->view('request-form', $data);

    }

    function create()
    {

        $this->form_validation->set_rules('full-name', 'Full name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone number', 'trim|min_length[6]|max_length[50]');
        $this->form_validation->set_rules('request-text', 'Request', 'trim|required|min_length[10]|max_length[5000]');

        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('request-form');
        }
        else
        {
            $this->request_model->addRequest();
            $this->request-succsess();
    }
    }

}
