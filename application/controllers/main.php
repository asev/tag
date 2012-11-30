<?php

/**
 *  Pagrindinio puslapio klasė. Neprisijungęs klientas, vadybininkas ir vadovas turi skirtingus puslapius, čia
 * parenkamas jiems tinkamas puslapis.
 */
class Main extends CI_Controller {

    /**
     * @var string - vidinis vaizdas kuris bus atvaizduojamas tarp header ir footer.
     */
    private $view = "";
    /**
     * @var string - prisijungusio vartotojo vardas.
     */
    private $username;

    /**
     *  Konstruktorius
     */
    public function Main()
    {
        parent::__construct();
        $this->load->model('request_model', "reqM");
        $this->username = $this->tank_auth->getUser()->username;
        if ($this->tank_auth->is_logged_in()) {
            $this->form_validation->set_rules('search', 'Search', 'trim|required|max_length[60]|xss_clean');
            if ($this->form_validation->run()) {
                redirect('reqs/search/'. $this->input->post('search'));
            }
        }
    }

    /**
     *  Pagal vartotojo tipą atidaro parenka pagrindinį puslapį.
     */
    public function index()
    {
        $this->typeRedirect($this->checkType());
    }


    /**
     *  Kliento (neprisijungusio vartotojo puslapis)
     *  Šiuo metu klientui rodoma tik užklausos registracija
     */
    public function client()
    {
        if ($this->checkType() != 0) {
            $this->typeRedirect($this->checkType());
        } else {
            redirect('req/add');
        }
    }

    /**
     *  Vadovo pagrindinis puslpais
     *
     * @param int $stats - statistikos kurią vadovas nuri peržiūrėti indeksas
     * @param int $term - laikotarpio kurio statistika rodoma indeksas
     */
    public function boss($stats=1, $term=2)
    {
        if ($this->checkType() != 2) {
            $this->typeRedirect($this->checkType());
        } else {
            $data = array();
            $this->view = $this->view . $this->load->view('main/boss', $data, true);

            switch ($stats) {
                case "1" :
                    $conditions = $this->condByTerm($term);
                    $stat['managers'] = $this->statManagers($conditions);
                    $this->view = $this->view . $this->load->view('main/managers_stats', $stat, true);
                    break;
                case "2" :
                    $conditions = $this->condByTerm($term);
                    $stat['reqDate'] = $this->statReqDate($conditions);
                    $this->view = $this->view . $this->load->view('main/req_stats', $stat, true);
                    break;
                case "3" :
                    $stat['current'] = $this->statCurrent();
                    $this->view = $this->view . $this->load->view('main/current_stats', $stat, true);
                    break;
            }
            $this->displayer->DisplayView($this->view);
        }
    }

    /**
     *  Vadybininko pagrindinis langas
     */
    public function manager()
    {
        if ($this->checkType() != 2) {
            $this->typeRedirect($this->checkType());
        } else {
            $data = array();
            $this->personalManager(1);
            $this->view = $this->view . $this->load->view('main/manager', $data, true);
            $this->displayer->DisplayView($this->view);
        }
    }

    /**
     *  404 puslapis
     */
    public function _404() {
        $this->view = $this->view . $this->load->view('notfound', array('message' => "404"), true);
        $this->displayer->DisplayView($this->view);
    }

    /**
     *  Asmeninė vadybibko statistika kuri rodoma jam pačiam jo pagrindiniame lange
     *
     * @param $manager - id vadybininko kuriuo statistika norima peržiūrėti
     */
    private function personalManager($manager) {
        $current = $this->reqM->statManagerCount(array('state' => 1, 'manager' => $manager));
        $data['current'] = (isset($current['0']['count'])) ? $current['0']['count'] : 0;
        $titles = array('Iš viso', 'Šiemet', 'Šį mėnesį', 'Šiandien');
        for ($term = 3; $term >= 0; $term--) {
            $c = $this->condByTerm($term);
            $assigned = $this->reqM->statManagerCount(array_merge($c['assignCond'], array('manager' => $manager)));
            $succeed = $this->reqM->statManagerCount(array_merge($c['complCond'], array('state' => 2, 'manager' => $manager)));
            $failed = $this->reqM->statManagerCount(array_merge($c['complCond'], array('state' => 3, 'manager' => $manager)));
            $data['stats'][$term] = array(
                'title' => $titles[$term],
                'assign' => isset($assigned['0']['count']) ? $assigned['0']['count'] : 0,
                'success' => isset($succeed['0']['count']) ? $succeed['0']['count'] : 0,
                'fail' => isset($failed['0']['count']) ? $failed['0']['count'] : 0
            );
        }
        $this->view = $this->view . $this->load->view('main/personal_manager', $data, true);
    }

    /**
     *  Tikrinamas vartotojo tipas.
     *
     * @return int - vartotojo tipas
     */
    private function checkType() {
        if ($this->tank_auth->is_logged_in()) {
            return $this->tank_auth->getUserType();
        }
        else return 0;
    }

    /**
     *  Pagrindinio puslapio parinkimas pagal vartotojo tipą.
     *
     * @param $type - tipas pagal kurį atidaromas pagrindinis puslapis.
     */
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

    /**
     *  Visų vadybininkų statistika. Kiek šiuo metu turima užklausų, kiek jų priimta, atlikta ir pan.
     *
     * @param $c - sąlygos pagal kurias atrenkama statistika (dažniausiai laikotarpio sąlyga)
     * @return array|null - duomenų masyvas su spausdinimui paruošta statistika
     */
    private function statManagers($c) {
        $tableArray = array();

        // Duomenų gavimas iš DB
        $assigned = $this->reqM->statManagerNames($c['assignCond']);
        $succeed = $this->reqM->statManagerCount(array_merge($c['complCond'], array('state' => 2)));
        $failed = $this->reqM->statManagerCount(array_merge($c['complCond'], array('state' => 3)));
        $current_requests = $this->reqM->statManagerCount(array('state' => 1));

        // Duomenys sudedami į gražų masyvą.
        foreach($assigned as $a) {
            $tableArray[$a['manager']] = array('name' => $a['username'], 'm_assign' => $a['count']);
        }
        foreach($current_requests as $a) {
            $tableArray[$a['manager']]['m_req'] = $a['count'];
        }
        foreach($succeed as $a) {
            $tableArray[$a['manager']]['m_success'] = $a['count'];
        }
        foreach($failed as $a) {
            $tableArray[$a['manager']]['m_fail'] = $a['count'];
        }

        // Tiems kurie neturi vardų.
        if (!is_null($tableArray)) {
            foreach ($tableArray as $id => $a) {
                if (!isset($a['name'])) {
                    $tableArray[$id]['name'] = "No Name " . $id;
                }
            }
        }
        unset($tableArray[0]);
        return $tableArray;
    }

    /**
     *  Užklausų statistika pagal laikotarpį. Apskaičiuoja kiek tuo buvo užklausų, kiek iš jų buvo atliktos, kiek pasisekę ir pan.
     *
     * @param $c - sąlygos pagal kurias atrenkama statistika (dažniausiai laikotarpio sąlyga)
     * @return mixed - duomenų masyvas su spausdinimui paruošta statistika
     */
    private function statReqDate($c) {
        $r['r_new'] = $this->reqM->getCondCount($c['creatCond']);
        $r['r_spam'] = $this->reqM->getCondCount(array_merge($c['creatCond'], array('spam' => 1)));
        $r['r_success'] = $this->reqM->getCondCount(array_merge($c['complCond'], array('state' => 2)));
        $r['r_fail'] = $this->reqM->getCondCount(array_merge($c['complCond'], array('state' => 3)));
        return $r;
    }

    /**
     *  Dabartinė informacinės sitemos statistika. Užklausų skaičiai pagal įvairius kriterijus
     *
     * @return mixed - duomenų masyvas su spausdinimui paruošta statistika
     */
    private function statCurrent() {
        $r['c_new'] = $this->reqM->getCondCount(array('state' => 0));
        $r['c_assign'] = $this->reqM->getCondCount(array('state' => 1));
        $r['c_success'] = $this->reqM->getCondCount(array('state' => 2));
        $r['c_fail'] = $this->reqM->getCondCount(array('state' => 3));
        $r['c_spam'] = $this->reqM->getCondCount(array('spam' => 1));
        return $r;
    }


    /**
     *  Pagal termino indeksą suformuojama sąlyga, kuri vėliau naudojama atrenkant užklausas
     *
     * @param $term - termino indeksas
     * @return mixed - suformuota sąlyga
     */
    private function condByTerm($term) {
        $c['assignCond'] = array();
        $c['complCond'] = array();
        $c['creatCond'] = array();

        // pasirinkti termino skaičiavimas
        if ($term > 0) {
            $c['creatCond']['YEAR(request.created)'] = date('Y');
            $c['complCond']['YEAR(request.completed)'] = date('Y');
            $c['assignCond']['YEAR(request.assigned)'] = date('Y');
        }
        if ($term > 1) {
            $c['creatCond']['MONTH(request.created)'] = date('m');
            $c['complCond']['MONTH(request.completed)'] = date('m');
            $c['assignCond']['MONTH(request.assigned)'] = date('m');
        }
        if ($term > 2) {
            $c['creatCond']['DAY(request.created)'] = date('d');
            $c['complCond']['DAY(request.completed)'] = date('d');
            $c['assignCond']['DAY(request.assigned)'] = date('d');
        }
        return $c;
    }

}
