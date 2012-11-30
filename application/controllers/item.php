<?php

Class Item extends CI_Controller
{
    private $view = "";
    private $item = null;
    private $me = null;
    private $data = array();

    public function Item()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('item_model', 'itemM');
        /*$this->load->model('order_model', 'orderM');*/
    }

    public function index()
    {
        redirect('');
    }

    public function add($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->form_validation->set_rules('item-id', 'Item Id', 'trim|required|is_natura|lmin_length[1]|max_length[11]|xss_clean');
            $this->form_validation->set_rules('item-name', 'Item Name', 'trim|required|min_length[1]|max_length[300]|xss_clean');
            $this->form_validation->set_rules('item-price', 'Item Price', 'trim|required|numeric|min_length[1]|max_length[10]|xss_clean');
            $this->form_validation->set_rules('item-quantity', 'Item Quantity', 'trim|required|is_natural_no_zero|min_length[1]|max_length[8]|xss_clean');
            if ($this->form_validation->run()) {
                $this->itemM->addItem($orderId);
                $data['get_items'] = $this->itemM->getItems($orderId);
                $data = array_merge($data, array('orderId' => $orderId));
                $this->view = $this->view . $this->load->view('order/form', $data, true);
            } else {
                $this->view = $this->view . $this->load->view('item/form', array('orderId' => $orderId), true);
            }
        }
        $this->displayer->DisplayView($this->view);
    }

    public function delete($orderId = null, $itemId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->itemM->deleteItem($orderId, $itemId);
            $data['get_items'] = $this->itemM->getItems($orderId);
            $data = array_merge($data, array('orderId' => $orderId));
            $this->view = $this->view . $this->load->view('order/form', $data, true);
        }
        $this->displayer->DisplayView($this->view);
    }

}