<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sev
 * Date: 12.11.17
 * Time: 22.33
 * To change this template use File | Settings | File Templates.
 */
class Request
{
    private $_fullName;
    private $_email;
    private $_phone;
    private $_reqText;
    private $_state;
    private $_manager = NULL;
    private $_order = NULL;
    private $_created;
    private $_lastActivity = NULL;
    private $_completed = NULL;

    public function __construct($name = NULL, $email = NULL, $phone = NULL, $reqText = NULL, $created = NULL, $state = 0, $manager = NULL, $order = NULL, $last = NULL, $compl = NULL)
    {
        $this->_fullName = $name;
        $this->_email = $email;
        $this->_phone = $phone;
        $this->_reqText = $reqText;
        $this->_state = $state;
        $this->_manager = $manager;
        $this->_order = $order;
        $this->_created = $created;
        $this->_lastActivity = $last;
        $this->_completed = $compl;
    }



}
