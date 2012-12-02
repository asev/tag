<?php

Class Order extends CI_Controller
{

    /**
     * @var string - vidinis vaizdas kuris bus atvaizduojamas tarp header ir footer.
     */
    private $view = "";

    /**
     * @var null - nagrinėjamas užsakymas
     */
    private $order = null;

    /**
     * @var null - prisijungusio vartotojo duomenys
     */
    private $me = null;

    /**
     *  Konstruktorius
     */
    public function order()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('order_model', 'orderM');
        $this->load->model('request_model', 'reqM');
        $this->load->model('item_model', 'itemM');
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
     * @param null $reqId - Užklausos Id
     */
    public function add($reqId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->me = $this->tank_auth->getUser();
            $this->orderM->addOrder($reqId, $this->me->id);
            $this->order = $this->orderM->getOrder($reqId, $this->me->id);
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

    /**
     * Užsakymo pabaigos nustatymas
     *
     * @param null $orderId - užsakymo Id
     */
    public function finish($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->orderM->setOrder($orderId, array('active'=>0));
            $this->order = $this->orderM->getOrderById($orderId);
            $data['get_order'] = get_object_vars($this->order);
            $data['get_items'] = $this->itemM->getItems($this->order->orderId);
            $data['get_req'] = get_object_vars($this->reqM->getRequest($this->order->requestId));

            $this->view = $this->view . $this->load->view('order/show', $data, true);
            $this->displayer->DisplayView($this->view);
        }
    }

    /**
     * Ataskaitos PDF formatu generavimas
     *
     * @param null $orderId - užsakymo Id
     */
    public function generatePDF($orderId = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('');
        } else {
            $this->orderM->setOrder($orderId, array('active'=>0));
            $this->order = $this->orderM->getOrderById($orderId);
            $data['get_items'] = $this->itemM->getItems($this->order->orderId);

            $this->load->library('TCPDF');

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetTitle('TAG_PDF');

            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->AddPage();
            $html = '<h1 align="center">Užsakymas Nr. ' . $this->order->orderId . ' parengtas pagal užklasa Nr. ' . $this->order->requestId . ':</h1>';

            $html = $html . '<p>Užsakovo duomenys:</p><br/>';
            $html = $html . '<i>Vardas: ' . $this->reqM->getRequest($this->order->requestId)->fullName . ',</i><br/>';
            $html = $html . '<i>Elektroninis paštas: ' . $this->reqM->getRequest($this->order->requestId)->email . ',</i><br/>';
            $html = $html . '<i>Telefono numeris: ' . $this->reqM->getRequest($this->order->requestId)->phone . ',</i><br/>';

            $html = $html . '<p>Vadybininko duomenys:</p><br/>';
            $html = $html . '<i>Vardas: ' . $this->tank_auth->getUser()->username . ',</i><br/>';
            $html = $html . '<i>Elektroninis paštas: ' . $this->tank_auth->getUser()->email . ',</i><br/>';

            $html = $html . '<h1 align="center">Siulomos prekes:</h1>';

            $html = $html . '<table cellspacing="0" cellpadding="1" border="1"><tr><td>Prekes Id</td><td>Pavadinimas</td><td>Kaina</td><td>Kiekis</td></tr>';
            foreach($data['get_items'] as $row)
            {
                $html = $html . '<tr><td>' . $row['itemId'] . '</td><td>' . $row['itemName'] . '</td><td>' . $row['itemPrice'] . '</td><td>' . $row['itemQuantity'] . '</td></tr>';
            }
            $html = $html . '</table><p></p>';

            $html = $html . '<h1 align="center">Papildoma informacija:</h1>';
            $html = $html . '<table cellspacing="0" cellpadding="1" border="1"><tr><td>' . $this->order->comment . '</td></tr></table>';

            $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

            $pdf->Output('TAG_' . $this->order->requestId . '.pdf', 'D');
        }
    }

}