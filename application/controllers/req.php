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
        $reqId = $this->reqM->getLastRequestId();
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

    public function show($reqId = null, $message = null)
    {
        // Jeigu iesko paskutines
        if ($reqId == 'last') {
            $reqId = $this->reqM->getLastRequestId();
            if (!is_null($reqId)){
                redirect('req/show/' . $reqId);
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "no-last"), true);
            }
        }

        // Komentaro atnaujinimas
        $this->form_validation->set_rules('comment', 'Komentaras', 'trim|max_length[2000]|xss_clean');
        if ($this->form_validation->run()) {
            $this->reqM->setComment($reqId, $this->input->post('comment'));
        }

        // Ar jau surinktas request?
        if ($this->request == null){
          if(!$this->isReq($reqId)) {
              return; // Klaidos pranesimas jau parodytas.
          }
        }

        // Request vaizdavimas
        $data = get_object_vars($this->request);
        $data['mId'] = $this->tank_auth->get_user_id();
        //@TODO Sutaisyti fixManagers
        //$managers = $this->tank_auth->allUsers();
        //$data['managers'] = $this->fixManagers($managers);
        $data['message'] = $message;
        $this->view = $this->view . $this->load->view('request/show', $data, true);
        if ($this->tank_auth->getUserType() == 2) {
            $this->view = $this->view . $this->load->view('request/manage', $data, true);
        }
        $this->load->view('page', array('view' => $this->view));
    }

    public function assign($reqId=null)
    {
        if($this->isReq($reqId)) {
            if ($this->request->state == 0) {
                $this->reqM->setState($reqId, 1, $this->me->id);
                $this->show($reqId, "success");
            }
            else {
                $this->show($reqId,"already-assigned");
            }
        }
    }

  /**
   * Funkcija užkomentuota, kol nesutvarkytas fixManager.
   *
  public function reassign($reqId=null)
    {
        $data = $this->isReq($reqId);
        if (!is_null($data)) {
            if ($this->reqM->getState($reqId) > 0 && $this->reqM->getManager($reqId) == $this->tank_auth->get_user_id()) {
                $this->reqM->setManager($reqId, $this->input->post('nextManager'));
                //@TODO nors čia ir dropdown menu, tačiau jam taip pat reiktų validation.
                $this->show($reqId, "reassigned");
            }
            else {
                $this->show($reqId,"not-yours");
            }
        }
    }*/

    public function spam($reqId=null)
    {
        if($this->isReq($reqId, true)) {
            if ($this->request->spam == 0) {
                $this->reqM->markSpam($reqId, 1);
                $this->show($reqId, 'spammed');
            } else {
                $this->show($reqId, 'already-spammed');
            }
        }
    }

    public function unspam($reqId=null)
    {
        if($this->isReq($reqId, true)) {
            if ($this->request->spam == 1) {
                $this->reqM->markSpam($reqId, 0);
                $this->show($reqId, 'unspammed');
            } else {
                $this->show($reqId, 'already-unspammed');
            }
        }
    }

    /**@TODO Turi keisti masyva. Dabar yra var_dump($old), o turi būti
     * $managers = array(
     *    'id'  => 'username',
     *    'id'  => 'username'
     * );
     */
    private function fixManagers($old)
    {
        foreach ($old as $key => $value) {
            $new = array_shift($value);

            $newarray[$new] = $value;
        }
        //var_dump($newarray);
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
            $this->load->view('page', array('view' => $this->view));
            return false;
        }
    }
}
