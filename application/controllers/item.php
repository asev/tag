<?php

Class Item extends CI_Controller
{
    /**
     * @var string - vidinis vaizdas kuris bus atvaizduojamas tarp header ir footer.
     */
    private $view = "";

    /**
     * Konstruktorius
     */
    public function Item()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('item_model', 'itemM');
        $this->load->model('order_model', 'orderM');
    }

    /**
     * Jeigu nenurodomas veiksmas, peradresuojama į pradinį puslapį.
     */
    public function index()
    {
        redirect('');
    }

    /**
     * Naujos prekės sudarymas
     *
     * @param null $orderId - užsakymo Id
     */
    public function add($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in() || $this->orderM->checkActive($this->orderM->getOrderById($orderId)->orderId) == 0) {
            redirect('');
        } else {
            $this->form_validation->set_rules('item-name', 'Item Name', 'trim|required|min_length[1]|max_length[300]|xss_clean');
            $this->form_validation->set_rules('item-price', 'Item Price', 'trim|required|numeric|greater_than[0]|min_length[1]|max_length[10]|xss_clean');
            $this->form_validation->set_rules('item-quantity', 'Item Quantity', 'trim|required|is_natural_no_zero|min_length[1]|max_length[8]|xss_clean');

            if ($this->form_validation->run()) {
                $this->itemM->addItem($orderId);
                redirect('order/add/' . $this->orderM->getOrderById($orderId)->requestId);
            } else {
                $data['get_items'] = $this->itemM->getItems($orderId);
                $data['orderId'] = array($orderId);
                $this->view = $this->view . $this->load->view('item/form', $data, true);
            }
        }
        $this->displayer->DisplayView($this->view);
    }

    /**
     * Prekės šalinimas
     *
     * @param null $orderId - užsakymo Id
     */
    public function delete($orderId = null, $itemId = null)
    {
        if (!$this->tank_auth->is_logged_in() || $this->orderM->checkActive($this->orderM->getOrderById($orderId)->orderId) == 0) {
            redirect('');
        } else {
            $this->itemM->deleteItem($orderId, $itemId);
            redirect('order/add/' . $this->orderM->getOrderById($orderId)->requestId);
        }
        $this->displayer->DisplayView($this->view);
    }

}