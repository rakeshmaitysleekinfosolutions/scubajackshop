<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppController extends BaseController {

    private $csrfArray;
    public function __construct() {
         parent::__construct();


         $this->csrfArray =  array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
        );

    }
    public  function __token() {
        return (isset($this->csrfArray['name'])) ? $this->csrfArray['name'] : '';
    }
    public	function csrf_token() {
        return (isset($this->csrfArray['hash'])) ? $this->csrfArray['hash'] : '';
    }

    public function isSubscribed() {
        if($this->hasSession('subscribe')) {
            return true;
        }
        return false;
    }
    /*
    public function getConfigMailProtocol() {
        return $this->getSession('settings.mail.config')['protocol'];
    }
    public function getConfigMailParameter() {
        return $this->getSession('settings.mail.config')['parameter'];
    }
    public function getConfigMailHost() {
        return $this->getSession('settings.mail.config')['smtp_hostname'];
    }
    public function getConfigMailUser() {
        return $this->getSession('settings.mail.config')['smtp_username'];
    }
    public function getConfigMailPassword() {
        return $this->getSession('settings.mail.config')['smtp_password'];
    }
    public function getConfigMailPort() {
        return $this->getSession('settings.mail.config')['smtp_port'];
    }
    public function getConfigMailTimeOut() {
        return $this->getSession('settings.mail.config')['smtp_timeout'];
    }
    public function getConfigMailSenderName() {
        return $this->getSession('settings.mail.config')['sender_name'];
    }
    public function getConfigMailSenderEmail() {
        return $this->getSession('settings.mail.config')['sender_email'];
    }

    */

}
