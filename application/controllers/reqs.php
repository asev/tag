<?php

/**
 *  Užklausų sąrašo klasė. Įvairūs užklausų sąrašai pagal kriterijus.
 */
Class Reqs extends CI_Controller
{

    /**
     * @var string - vidinis vaizdas kuris bus atvaizduojamas tarp header ir footer.
     */
    private $view = "";
    /**
     * @var null - prisijungusio vartotojo duomenys
     */
    private $me = null;

    /**
     *  Konstruktorius
     */
    public function Reqs()
    {
        parent::__construct();
        $this->load->model('request_model', 'reqM');
    }

    /**
     *  Jeigu nenurodomi jokie kriterijai, demonstruojamas šiuo metu aptarnaujamų užklausų sąrašas
     */
    public function index()
    {
        $this->auth();
        redirect('reqs/current');
    }

    /**
     *  Šiuo metu aptarnaujamų užklausų sąrašas
     */
    public function current() {
        $this->auth();
        $cond = array(
            'spam' => 0,
            'state' => 1
        );
        if ($this->me->type == 2) {
            $cond['manager'] = $this->me->id;
        }
        $this->show($cond, 'current');
    }

    /**
     *  Jau atliktų užklausų sąrašas
     */
    public function past() {
        $this->auth();
        $cond = array(
            'spam' => 0,
            'state >' => 1
        );
        if ($this->me->type == 2) {
            $cond['manager'] = $this->me->id;
        }
        $this->show($cond, 'past');
    }

    /**
     *  Sąrašas užklausų kurios pažymėtos kaip šlamštas
     */
    public function spam() {
        $this->auth();
        $cond = array(
            'spam' => 1
        );
        $this->show($cond, 'spam');
    }

    //@TODO Paieška dabar neveikia, kad duodama užklausa su tarpu. Pvz: "dolor sit". Tą reikia pataisyti
    /**
     *  Užklausų sąrašas sudarytas ieškant pagal raktinį žodį
     *
     * @param $match - paieškos raktažodis
     */
    public function search($match) {
        $this->auth();
        $this->show($match, 'search');
    }

    /**
     *  Užklausų sąrašas atrinktas pagal el. pašto adresą. Skirtas patikrinti ar klientas ir ankčiau buvo pateikęs
     * užklausą.
     */
    public function client() {
        $this->auth();
        $this->form_validation->set_rules('email', 'El. paštas', 'trim|required|xss_clean');
        if ($this->session->flashdata('client')) {
            $client = $this->session->flashdata('client');
        } else {
            if ($this->form_validation->run()) {
                $client = $this->input->post('email');
            }
        }
        if (isset($client)) {
            $cond = array(
                'request.email' => $client
            );
            $this->show($cond, 'client');
            $this->session->set_flashdata('client',$client);
        } else {
            $this->view = $this->view . $this->load->view('notfound', array('message' => "no-client"), true);
            $this->displayer->DisplayView($this->view);
        }
    }

    /**
     *  Patikrinimas ar vartotojas prisijungęs.
     */
    private function auth() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->me = $this->tank_auth->getUser();
        }
    }

    /**
     *  Užklausų sąrašo rodymas pagal nurodytas sąlygas
     *
     * @param $cond - sąlygos pagal kurias išrenkamos užklausos
     * @param $func - sąlygos pavadinimas, reikalingas puslapiavimui
     */
    private function show($cond, $func)
    {
        $this->load->library('pagination');
        $config['base_url'] = site_url('reqs/'. $func);
        if ($func == 'search') {
            $segm = 4;
            $config['base_url'] = site_url('reqs/'. $func . '/' . $cond);
            $config['total_rows'] = $this->reqM->getSearchCount($cond);
        } else {
            $segm = 3;
            $config['base_url'] = site_url('reqs/'. $func);
            $config['total_rows'] = $this->reqM->getCondCount($cond);
        }
        $config['per_page'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $segm;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $config['num_tag_open'] = '<div class="page">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="page current">';
        $config['cur_tag_close'] = '</div>';
        $config['next_tag_open'] = '<div class="next">';
        $config['next_tag_close'] = '</div>';
        $config['prev_tag_open'] = '<div class="prev">';
        $config['prev_tag_close'] = '</div>';
        $currentPage = $this->uri->segment($segm);
        if ($currentPage == 0) {
            $currentPage = 1;
        }
        $start = ($currentPage - 1) * $config['per_page'];

        if ($currentPage >= 1 && $currentPage <= ceil($config['total_rows'] / $config['per_page'])) {
            $this->pagination->initialize($config);
            if ($config['total_rows'] > 0) {
                if ($func == 'search') {
                    $reqs = $this->reqM->getSearch($cond, $start, $config['per_page']);
                } else {
                    $reqs = $this->reqM->getCond($cond, $start, $config['per_page']);
                }
            } else {
                $reqs = array();
            }
            $boss = ($this->me->type == 1 || $func == 'client')? true : false;
            $this->view = $this->view . $this->load->view('requests/req_head', $data = array('length' => $config['total_rows'], 'boss' => $boss), true);
            foreach ($reqs as $req) {
                if (is_null($req['username'])) {
                    $req['username'] = 'NoName' . $req['manager'];
                }
                $req['subject'] = (strlen($req['subject']) > 100) ? substr($req['subject'],0,100) : $req['subject'];
                $req['created'] = date('Y-m-d', strtotime($req['created']));
                $this->view = $this->view . $this->load->view('requests/req_unit', $data = $req, true);
            }
            $this->view = $this->view . $this->load->view('requests/req_foot', $data = array('length' => $config['total_rows'], 'pagination' => $this->pagination->create_links()), true);
        } else if ($currentPage == 1) {
            $this->view = $this->view . $this->load->view('notfound', array('message' => "no-results"), true);
        } else {
            redirect($config['base_url']);
        }
        $this->displayer->DisplayView($this->view);
    }

}
