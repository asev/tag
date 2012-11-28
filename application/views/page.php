<?php
$this->load->view('header', array('me' => $me, 'waiting' => $waiting));
echo $view;
$this->load->view('footer');

