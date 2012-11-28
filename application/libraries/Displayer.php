<?php

class Displayer
{
    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('request_model', 'reqM');
        $this->ci->load->model('tank_auth/users');
    }

    public function DisplayView($view) {
        $viewArray['view'] = $view;

        $me = $this->ci->users->get_user_by_id($this->ci->session->userdata('user_id'));
        if(!is_null($me)) {
            $viewArray['me'] = $me->username;
        } else {
            $viewArray['me'] = null;
        }

        $viewArray['waiting'] = $this->ci->reqM->getWaitingRequestCount();

        $this->ci->load->view('page', $viewArray);
    }
}
