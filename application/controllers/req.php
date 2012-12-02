<?php

/**
 *  Vienos užklausos klasė. Su užklausa atliekami įterpimo, rodymo ir įvairūs keitimo veiksmai.
 */
Class Req extends CI_Controller
{

    /**
     * @var string - vidinis vaizdas kuris bus atvaizduojamas tarp header ir footer.
     */
    private $view = "";
    /**
     * @var null - nagrinėjama užklausa
     */
    private $request = null;
    /**
     * @var null - prisijungusio vartotojo duomenys
     */
    private $me = null;

    /**
     *  Konstruktorius
     */
    public function Req()
    {
        parent::__construct();
        $this->load->model('request_model', 'reqM');
        $this->load->model('order_model', 'orderM');
    }

    /**
     *  Jeigu nenurodomas veiksmas, peradresuojama į pradinį puslapį.
     */
    public function index()
    {
        redirect('');
    }

    /**
     *  Naujos užklausos registravimas
     */
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

    /**
     *  Pasirinktos užklausos atvaizdavimas.
     *
     * @param null $reqId - užklausos Id
     * @param null $message - papildomos žinutės, kuri bus rodoma virš užklausos kodas
     */
    public function show($reqId = null, $message = null)
    {
        // Jeigu iesko paskutines
        if ($reqId == 'last') {
            $reqId = $this->reqM->getLastRequestId();
            if (!is_null($reqId)) {
                redirect('req/show/' . $reqId);
            } else {
                $this->view = $this->view . $this->load->view('notfound', array('message' => "no-last"), true);
                $this->displayer->DisplayView($this->view);
                return;
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
        $data['history'] = $this->reqM->getCondCount(array('email' => $this->request->email));
        $data['message'] = $message;
        $this->view = $this->view . $this->load->view('request/show', $data, true);
        $this->view = $this->view . $this->load->view('request/manage', $data, true);
        $this->displayer->DisplayView($this->view);
    }

    /**
     *  Užklausos priskirimas prisijungusiam vadybininkui
     *
     * @param null $reqId - užklausos Id
     */
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

    /**
     *  Užklausos vadybininko pakeitimas, užklausos perleidmas kitam vadybininkui.
     *
     * @param null $reqId - užklausos Id
     */
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

    /**
     *  Užklausa pažymima kaip šlamštas.
     *
     * @param null $reqId - užklausos Id
     */
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

    /**
     *  Užklausa pažymima kaip nebe šlamštas
     *
     * @param null $reqId - užklausos Id
     */
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

    /**
     *  Užklausa pažymima kaip atlikta.
     *
     * @param null $reqId - užklausos Id
     * @param int $state - naujasis užklausos būvis (2 - pasisekusi, 3 - nepasisekusi)
     */
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

    /**
     *  Iš DB gautas vadybininkų masyvas perdaromas į formatą (managerId => managerName), kuris vėliau naudojamas
     * dropdown formavimui
     *
     * @param $old - iš DB gautas masyvas
     * @return array - pakeistas vadybininkų masyvas
     */
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

    /**
     *  Tikrina ar vartotojas yra prisijungęs, ar užklausa su kuria norima atlikti veiksmą egzistuoja ir yra prieinama.
     * Galima tikrinti ar vartotojas turi teisę atilikti veiksmus su šia užklausa.
     *
     * @param $reqId - užklausos Id
     * @param bool $auth - ar reikia tikrinti vartotojo teisę atlikti veiksmus
     * @return bool - true jeigu užklausa egzistuoja ir yra preinama
     */
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
