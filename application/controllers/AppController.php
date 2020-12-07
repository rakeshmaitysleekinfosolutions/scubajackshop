<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppController extends BaseController {

    private $csrfArray;
    public $options = array();
    public function __construct() {
         parent::__construct();
        Currency_model::factory()->refresh(true, 'USD');
         $this->csrfArray =  array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
        );
         $this->options['currency'] =  $this->currency->getCurrency('USD');
         if($this->ecart->hasProducts()) {
             setSession('total',sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code'])));
         } else {
             setSession('total', '0 item(s) - $0.00');
         }

       //$this->clear();
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
    public function clear() {
        $this->ecart->clear();
    }

}
