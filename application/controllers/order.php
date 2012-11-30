<?php

Class Order extends CI_Controller
{

    private $view = "";
    private $order = null;
    private $me = null;

    public function order()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('order_model', 'orderM');
        $this->load->model('request_model', 'reqM');
    }

    public function index()
    {
        redirect('');
    }

    public function add($reqId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->me = $this->tank_auth->get_user_id();
            $this->orderM->addOrder($reqId, $this->me);
            $this->order = $this->orderM->getOrder($reqId, $this->me);
            $data = get_object_vars($this->order);
            $this->view = $this->view . $this->load->view('order/form', $data, true);
        }
        $this->displayer->DisplayView($this->view);
    }

    public function finish($orderId = null)
    {

    }
}