<?php

Class Order extends CI_Controller
{

    private $view = "";
    private $order = null;
    private $request = null;
    private $me = null;

    public function order()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('order_model', 'orderM');
        $this->load->model('request_model', 'reqM');
        $this->load->model('item_model', 'itemM');
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
            if($this->orderM->checkActive($this->order->orderId) == 1) {
                $data['get_items'] = $this->itemM->getItems($this->order->orderId);
                $data = array_merge($data, array('orderId' => $this->order->orderId));

                $comment['comment'] = $this->order->comment;

                $this->form_validation->set_rules('comment', 'Komentaras', 'trim|max_length[2000]|xss_clean');
                if ($this->form_validation->run()) {
                    unset($comment['comment']);
                    $comment['comment'] = $this->input->post('comment');
                    $this->orderM->setOrder($this->order->orderId, $comment);
                }
                $data = array_merge($data, $comment);
                $this->view = $this->view . $this->load->view('order/form', $data, true);
            } else {
                redirect('order/finish/' . $this->order->orderId);
            }
        }
        $this->displayer->DisplayView($this->view);

    }

    public function finish($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->orderM->setOrder($orderId, array('active'=>0));
            $this->order = $this->orderM->getOrderById($orderId);
            $data['get_order'] = get_object_vars($this->order);
            $data['get_items'] = $this->itemM->getItems($this->order->orderId);
            $data['get_request'] = $this->reqM->getRequest($this->order->requestId);

            $this->view = $this->view . $this->load->view('order/show', $data, true);
            $this->displayer->DisplayView($this->view);
        }
    }

    public function generatePDF($orderId = null)
    {

        $this->load->library('TCPDF');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    }

}