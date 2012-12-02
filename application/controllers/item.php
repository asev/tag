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
     * @param null $orderId - Užsakymo Id
     */
    public function add($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->form_validation->set_rules('item-id', 'Item Id', 'trim|required|is_natural_no_zero|lmin_length[1]|max_length[11]|xss_clean');
            $this->form_validation->set_rules('item-name', 'Item Name', 'trim|required|min_length[1]|max_length[300]|xss_clean');
            $this->form_validation->set_rules('item-price', 'Item Price', 'trim|required|numeric|greater_than[0]|min_length[1]|max_length[10]|xss_clean');
            $this->form_validation->set_rules('item-quantity', 'Item Quantity', 'trim|required|is_natural_no_zero|min_length[1]|max_length[8]|xss_clean');

            $data['comment'] = $this->orderM->getOrderById($orderId)->comment;
            if ($this->form_validation->run()) {
                $this->itemM->addItem($orderId);
                $data['get_items'] = $this->itemM->getItems($orderId);
                $data = array_merge($data, array('orderId' => $orderId));
                $this->view = $this->view . $this->load->view('order/form', $data, true);
            } else {
                $data['get_items'] = $this->itemM->getItems($orderId);
                $data['orderId'] = array($orderId);
                $this->view = $this->view . $this->load->view('item/form', $data, true);
            }
        }
        $this->displayer->DisplayView($this->view);
    }

    /**
     * Prekės pašalinimas
     *
     * @param null $orderId - užsakymo Id
     * @param null $itemId - neunikalus Prekės Id
     */
    public function delete($orderId = null, $itemId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $data['comment'] = $this->orderM->getOrderById($orderId)->comment;
            $this->itemM->deleteItem($orderId, $itemId);
            $data['get_items'] = $this->itemM->getItems($orderId);
            $data = array_merge($data, array('orderId' => $orderId));
            $this->view = $this->view . $this->load->view('order/form', $data, true);
        }
        $this->displayer->DisplayView($this->view);
    }

}