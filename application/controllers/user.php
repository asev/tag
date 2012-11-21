<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sev
 * Date: 12.11.16
 * Time: 22.32
 * To change this template use File | Settings | File Templates.
 */
class User extends CI_Controller {

    public function User()
    {
        parent::CI_Controller();
        $this->load->model('user_model');
    }

    public function index()
    {
    }

    public function selectUser($id)
    {
        // Išrenka vartototoją grąžina jo info pagal tipą.
    }

    public function newUser()
    {
        // Gauna info su $form_data = $this->input->post();
        // pvz $username = $this->input->post("username");
    }


}
{

}
