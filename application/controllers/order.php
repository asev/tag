<?php
Class Order extends CI_Controller {

    private $view = "";

public function Order()
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

public function add($reqId=null)
{
    if (!$this->tank_auth->is_logged_in()) {
        redirect('');
    } else {
        if ($this->reqM->getManager($reqId) == $this->tank_auth->get_user_id()){
            $data = array();
            // Validuojam visus input.
            $this->form_validation->set_rules('full-name', 'Full name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone number', 'trim|min_length[6]|max_length[50]');
            $this->form_validation->set_rules('request-text', 'Request', 'trim|required|min_length[10]|max_length[5000]');

            // Jeigu pavyko validacija
            if($this->form_validation->run())
            {
                $this->orderM->addOrder();
                $this->view = $this->view . $this->load->view('order/success', true);
            }
            $data['reqId'] = $reqId;
            $this->view = $this->view . $this->load->view('order/form', $data, true);
        }
        else {
            redirect('req/show'. $reqId);
        }
    }
    $this->load->view('page', array('view' => $this->view));
}

public function generatePdf($oderId)
{

}

}