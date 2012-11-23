<?php

Class Req extends CI_Controller
{

    private $view = "";

    public function Req()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('request_model', 'reqM');
        $this->load->model('order_model', 'orderM');
    }

    public function index()
    {
        if ($this->tank_auth->is_logged_in()) { // logged in
            redirect('');
        } else {
            redirect('req/add');
        }
    }

    public function add()
    {
        if ($this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $data = array();
            $this->form_validation->set_rules('full-name', 'Full name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone number', 'trim|max_length[50]|xss_clean');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|min_length[3]|max_length[500]|xss_clean');
            $this->form_validation->set_rules('request-text', 'Request', 'trim|required|min_length[10]|max_length[5000]|xss_clean');
            if ($this->form_validation->run()) {
                $this->reqM->addRequest();
                $this->view = $this->view . $this->load->view('request/success', null, true);
            } else {
                $this->view = $this->view . $this->load->view('request/form', $data, true);
            }
        }
        $this->load->view('page', array('view' => $this->view));
    }

    public function last()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $reqId = $this->reqM->getLastRequestId();
            if (!is_null($reqId)){
                $this->show($reqId);
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "no-last"), true);
                $this->load->view('page', array('view' => $this->view));
            }
        }
    }

    public function show($reqId=null, $message=null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            if (!is_null($reqId)) {
                $data = $this->reqM->getRequest($reqId);
                if (is_null($data)) {
                    $this->view = $this->view . $this->load->view('notfound', $data = array('message' => "not-found"), true);
                } else {
                    if ($data->state != 0 || $this->reqM->getLastRequestId() == $reqId) {
                        $data = get_object_vars($data);
                        $data['mId'] = $this->tank_auth->get_user_id();
                        $managers = $this->tank_auth->allUsers();
                        $data['managers'] = $this->fixArray($managers);
                        $data['message'] = $message;
                        $this->view = $this->view . $this->load->view('request/show', $data, true);
                        if ($this->tank_auth->getUserType() == 2) {
                            $this->view = $this->view . $this->load->view('request/manage', $data, true);
                        }
                    } else
                        $this->view = $this->view . $this->load->view('notfound', array('message' => "denied"), true);
                }
            } else
                $this->view = $this->view . $this->load->view('notfound', array('message' => "not-defined"), true);
        }
        $this->load->view('page', array('view' => $this->view));
    }


    public function assign($reqId=null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            if (!is_null($reqId)) {
                if ($this->reqM->getState($reqId) == 0) {
                    $this->reqM->setState($reqId, 1, $this->tank_auth->get_user_id());
                    $this->show($reqId, "success");
                }
                else {
                    $this->show($reqId,"already-assigned");
                }
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "not-defined"), true);
                $this->load->view('page', array('view' => $this->view));
            }
        }
    }

    public function reassign($reqId=null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            if (!is_null($reqId)) {
                if ($this->reqM->getState($reqId) > 0 && $this->reqM->getManager($reqId) == $this->tank_auth->get_user_id()) {
                    $this->reqM->setManager($reqId, $this->input->post('nextManager'));
                    //@TODO nors čia ir dropdown menu, tačiau jam taip pat reiktų validation.
                    $this->show($reqId, "reassigned");
                }
                else {
                    $this->show($reqId,"not-yours");
                }
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "not-defined"), true);
                $this->load->view('page', array('view' => $this->view));
            }
        }
    }

    public function spam($reqId=null)
    {
        //@TODO Pazymeti kaip spam
    }

    public function updateComment($reqId=null)
    {
        //@TODO Validuoja lauką ir atnaujiną komentarą, jeigu tai šio vadybinko užklausa.
    }

    /**@TODO Turi keisti masyva. Dabar yra var_dump($old), o turi būti
     * $managers = array(
     *    'id'  => 'username',
     *    'id'  => 'username'
     * );
     */
    private function fixArray($old)
    {
        foreach ($old as $key => $value) {
            $new = array_shift($value);

            $newarray[$new] = $value;
        }
        //var_dump($newarray);
        return $newarray;
    }

}
