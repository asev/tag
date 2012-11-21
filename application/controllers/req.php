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
        $this->load->model('request_model', 'reqM');
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
                $this->reqM->addRequest();
                $this->load->view('request/success');
            }
        }
        $this->load->view('request/form', $data);

    }

    public function last() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('main');
        } else {
        $data = null;
        //@TODO Rodo paskutinį nepriskirtą užklausą.
        if (true) {
            // $data = paskutine nepriskirta užklausa.
            $this->load->view('request/show', $data);
        } else {
            $data = array(
                'message' => "Nera neatsakytų užklausų"
            );
            $this->load->view('show-message', $data);
            redirect('main');
        }
        }
    }

    public function show($reqId)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $data = $this->reqM->getRequest($reqId);
            if (is_null($data)) {
                $data = array(
                    'message' => "Užklausa nerasta"
                );
                $this->load->view('notfound', $data);
            }
            else {
                $data = get_object_vars($data);
                $data['mId'] = $this->tank_auth->get_user_id();
                 $managers = $this->tank_auth->allUsers();
                $data['managers'] = $this->fixArray($managers);
                $this->load->view('request/show', $data);
                if ($this->tank_auth->getUserType() == 2) {
                    $this->load->view('request/manage', $data);
                }
            }
        }
    }

    public function assign($reqId)
    {
        //@TODO Priskirti uzklausa vadybininkui
    }

    public function reassign($reqId, $managerId)
    {
        //@TODO Perleidziama uzklausa kitam vadybininkui
        // Reikia sugalvoti kaip gaunamas kito vadybininko id
    }

    public function spam($reqId)
    {
        //@TODO Pazymeti kaip spam
    }

    /**@TODO Turi keisti masyva. Dabar yra var_dump($old), o turi būti
 $managers = array(
    'small'  => 'Small Shirt',
    'med'    => 'Medium Shirt',
    'large'   => 'Large Shirt',
    'xlarge' => 'Extra Large Shirt',
 );
     */
    private function fixArray($old)
    {
        foreach($old as $key => $value) {
            $new = array_shift($value);

            $newarray[$new] = $value;
        }
        var_dump($newarray);
        return $newarray;
    }

}
