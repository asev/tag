<?php

Class Req extends CI_Controller
{

    private $view = "";
    private $request = null;
    private $me = null;

    public function Req()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('request_model', 'reqM');
        $this->load->model('order_model', 'orderM');
    }

    public function index()
    {
        redirect('');
    }

    public function add()
    {
        if ($this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $data = array();
            $this->form_validation->set_rules('full-name', 'Full name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('phoneNumber', 'Phone number', 'trim|max_length[50]|xss_clean');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|min_length[3]|max_length[500]|xss_clean');
            $this->form_validation->set_rules('request-text', 'Request', 'trim|required|min_length[10]|max_length[5000]|xss_clean');
            if ($this->form_validation->run()) {
                $this->reqM->addRequest();
                $this->view = $this->view . $this->load->view('request/success', null, true);
            } else {
                $this->view = $this->view . $this->load->view('request/form', $data, true);
            }
        }
        $this->displayer->DisplayView($this->view);
    }

    public function show($reqId = null, $message = null)
    {
        // Jeigu iesko paskutines
        if ($reqId == 'last') {
            $reqId = $this->reqM->getLastRequestId();
            if (!is_null($reqId)) {
                redirect('req/show/' . $reqId);
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "no-last"), true);
            }
        }

        // Komentaro atnaujinimas
        $this->form_validation->set_rules('comment', 'Komentaras', 'trim|required|max_length[2000]|xss_clean');
        if ($this->form_validation->run()) {
            $data = array(
                'comment' => $this->input->post('comment')
            );
            $this->reqM->setRequest($reqId, $data);
        }

        // Ar jau surinktas request?

        if (!$this->isReq($reqId)) {
            return; // Klaidos pranesimas jau parodytas.
        }

        // Request vaizdavimas
        $data = get_object_vars($this->request);
        $data['mId'] = $this->tank_auth->get_user_id();
        $managers = $this->tank_auth->allUsers();
        $data['managers'] = $this->fixManagers($managers);
        $data['message'] = $message;
        $this->view = $this->view . $this->load->view('request/show', $data, true);
        $this->view = $this->view . $this->load->view('request/manage', $data, true);
        $this->displayer->DisplayView($this->view);
    }

    public function assign($reqId = null)
    {
        if ($this->isReq($reqId)) {
            if ($this->request->state == 0) {
                $data = array(
                    'state' => 1,
                    'manager' => $this->me->id,
                    'assigned' => date("Y-m-d H:i:s")
                );
                $this->reqM->setRequest($reqId, $data);
                $this->show($reqId, "success");
            } else {
                $this->show($reqId, "already-assigned");
            }
        }
    }

    public function reassign($reqId = null)
    {
        if ($this->isReq($reqId)) {
            if ($this->request->state > 0 && $this->request->manager == $this->me->id) {
                $this->form_validation->set_rules('nextManager', 'Manager', 'trim|numeric|xss_clean');
                if ($this->form_validation->run()) {
                    $data = array(
                        'manager' => $this->input->post('nextManager')
                    );
                    $this->reqM->setRequest($reqId, $data);
                }
                $this->show($reqId, "reassigned");
            } else {
                $this->show($reqId, "not-yours");
            }
        }
    }

    public function spam($reqId = null)
    {
        if ($this->isReq($reqId, true)) {
            if ($this->request->spam == 0) {
                $data = array(
                    'spam' => 1,
                    'manager' => $this->me->id
                );
                $this->reqM->setRequest($reqId, $data);
                $this->show($reqId, 'spammed');
            } else {
                $this->show($reqId, 'already-spammed');
            }
        }
    }

    public function unspam($reqId = null)
    {
        if ($this->isReq($reqId, true)) {
            if ($this->request->spam == 1) {
                $data = array(
                    'spam' => 0,
                    'manager' => 0,
                    'state' => 0
                );
                $this->reqM->setRequest($reqId, $data);
                $this->show($reqId, 'unspammed');
            } else {
                $this->show($reqId, 'already-unspammed');
            }
        }
    }

    public function finish($reqId = null, $state=2)
    {
        if ($this->isReq($reqId, true)) {
            if ($state >1 && $state < 4){
                if ($this->request->state == 1) {
                    $data = array(
                        'state' => $state,
                        'completed' => date("Y-m-d H:i:s")
                    );
                    $this->reqM->setRequest($reqId, $data);
                    $this->show($reqId, "success");
                } else {
                    $this->show($reqId, "already-completed");
                }
            } $this->show($reqId, "wrong-state");
        }
    }

    private function fixManagers($old)
    {
        $newarray = array();
        foreach ($old as $value) {
            foreach ($value as $key => $val) {
                if ($key == 'id') {
                    $nid = $val;
                } else {
                    $nname = $val;
                }
            }
            $newarray[$nid] = $nname;
        }
        return $newarray;
    }

    private function isReq($reqId, $auth = false)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            if (!is_null($reqId)) {
                $this->request = $this->reqM->getRequest($reqId);
                if (is_null($this->request)) {
                    $this->view = $this->view . $this->load->view('notfound', $data = array('message' => "not-found"), true);
                } else {
                    $this->me = $this->tank_auth->getUser();
                    if ($this->request->state != 0) {
                        if ($auth == true) {
                            if ($this->request->manager != $this->me->id) {
                                $this->show($reqId, 'not-yours');
                                return false;
                            }
                        }
                    } else {
                        if ($this->reqM->getLastRequestId() != $reqId) {
                            if ($this->request->spam == 0) {
                                $this->view = $this->view . $this->load->view('notfound', array('message' => "denied"), true);
                            }
                        }
                    }
                }
            } else
                $this->view = $this->view . $this->load->view('notfound', array('message' => "not-defined"), true);
        }
        if ($this->view == "") {
            return true;
        } else {
            $this->displayer->DisplayView($this->view);
            return false;
        }
    }
}
