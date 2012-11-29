<?php

Class Reqs extends CI_Controller
{

    private $view = "";
    private $me = null;

    public function Reqs()
    {
        parent::__construct();
        $this->load->model('request_model', 'reqM');
    }

    public function index()
    {
        $this->auth();
        redirect('reqs/current');
    }

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

    public function spam() {
        $this->auth();
        $cond = array(
            'spam' => 1
        );
        $this->show($cond, 'spam');
    }

    //@TODO Paieška dabar neveikia, kad duodama užklausa su tarpu. Pvz: "dolor sit". Tą reikia pataisyti
    public function search($match) {
        $this->auth();
        $this->show($match, 'search');
    }

    private function auth() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->me = $this->tank_auth->getUser();
        }
    }

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
        $config['per_page'] = 15;
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
            $boss = ($this->me->type == 1)? true : false;
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
            $this->view = $this->view . $this->load->view('notfound', array('message' => "wrong-page"), true);
        }
        $this->displayer->DisplayView($this->view);
    }

}
