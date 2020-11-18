<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends AppController {
   
    public function __construct() {
        parent::__construct();
		$this->lang->load('app/emails/registration_lang');
        $this->load->config('mail');
       
    }

    public function index() {
        $subject 					= sprintf($this->lang->line('text_subject'), "SCUBA JACK");
        $this->data['text_welcome'] = sprintf($this->lang->line('text_welcome'), "SCUBA JACK");
        $this->data['text_app_name'] = "SCUBA JACK";
        $mail 						= new Mail($this->config->item('config_mail_engine'));
        $mail->parameter 			= $this->config->item('config_mail_parameter');
        $mail->smtp_hostname 		= $this->config->item('config_mail_smtp_hostname');
        $mail->smtp_username 		= $this->config->item('config_mail_smtp_username');
        $mail->smtp_password 		= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port 			= $this->config->item('config_mail_smtp_port');
        $mail->smtp_timeout 		= $this->config->item('config_mail_smtp_timeout');

        $mail->setTo("rakesh@gmail.com");
        $mail->setFrom($this->config->item('config_email'));
        $mail->setSender($this->config->item('config_sender_name'));
        $mail->setSubject($subject);
        //$view = $this->load->view('emails/registration', $this->data);
        $mail->setText($this->template->content->view('emails/registration', $this->data));
        $mail->send(); 
        echo "send";
    }
}