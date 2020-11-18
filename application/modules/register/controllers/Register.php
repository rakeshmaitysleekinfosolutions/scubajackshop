<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends AppController {
    
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model', 'model_user');
		$this->load->model('UserActivity_model', 'model_user_activity');
		$this->lang->load('app/emails/register_lang');
		$this->lang->load('app/register_lang');
		//$this->load->config('mail');
    }
    public function index() {

		if ($this->user->isLogged()) {
			$this->redirect($this->url(''));
		}
		
       
		if($this->isAjaxRequest() && $this->isPost()) {

			$this->request = $this->xss_clean($this->input->post());

			if ((strlen(trim($this->request['firstname'])) < 1) || (strlen(trim($this->request['firstname'])) > 32)) {
				$this->json['error']['firstname'] = $this->lang->line('error_firstname');
			}
			
			if ((strlen(trim($this->request['lastname'])) < 1) || (strlen(trim($this->request['lastname'])) > 32)) {
				$this->json['error']['lastname'] = $this->lang->line('error_lastname');
			}
			
			if ((strlen($this->request['email']) > 96) || !filter_var($this->request['email'], FILTER_VALIDATE_EMAIL)) {
				$this->json['error']['email'] = $this->lang->line('error_email');
			}
			
			if ($this->model_user->getTotalUsersByEmail($this->request['email'])) {
				$this->json['error']['warning'] = $this->lang->line('error_exists');
			}
			
			
			if ((strlen($this->request['password']) < 4) || (strlen($this->request['password']) > 20)) {
				$this->json['error']['password'] = $this->lang->line('error_password');
			}
			
			if ($this->request['confirm'] != $this->request['password']) {
				$this->json['error']['confirm'] = $this->lang->line('error_confirm');
			}
			
			if (!$this->input->post('agree')) {
				$this->json['error']['warning'] = sprintf($this->lang->line('error_agree'), $information_info['title']);
			}
			
            if (!$this->json) {
				// Add new user
				$useId = $this->model_user->addUser($this->request);
				
				if($useId) {
					// Get User
					$userInfo = $this->model_user->getUser($useId);
				}
				// Clear any previous login attempts for unregistered accounts.
				$this->model_user->deleteLoginAttempts($this->request['email']);
				// Login
				$this->user->login($this->request['email'], $this->request['password']);
				// User Activiity
				// $activity_data = array(
				// 			'user_id' => $useId,
				// 			'name'        => $this->request['firstname'] . ' ' . $this->request['lastname']
				// 		);
				// $this->model_user_activity->addActivity('register', $activity_data);


				// Sent mail to user
				$subject 						= sprintf($this->lang->line('text_subject'), "SCUBA JACK");

				$this->data['text_welcome'] 	= sprintf($this->lang->line('text_welcome'), "SCUBA JACK");

				$this->data['text_email'] 		= sprintf($this->lang->line('text_email'), $this->request['email']);
				$this->data['text_password'] 	= sprintf($this->lang->line('text_password'), $this->request['password']);

				$this->data['text_app_name'] 	= "SCUBA JACK";
				$this->data['text_service'] 	= $this->lang->line('text_service');
				$this->data['text_thanks'] 		= $this->lang->line('text_thanks');

				$mail 							= new Mail($this->config->item('config_mail_engine'));
				$mail->parameter 				= $this->config->item('config_mail_parameter');
				$mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
				$mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
				$mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
				$mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');
		
				$mail->setTo($this->config->item('config_email'));
				$mail->setFrom($this->config->item('config_email'));
                $mail->setReplyTo($this->request['email']);
				$mail->setSender($this->config->item('config_sender_name'));
				$mail->setSubject($subject);
				$mail->setHtml($this->template->content->view('emails/registration', $this->data));
				$mail->send(); 

				$this->json['success']          = $this->lang->line('text_success');
				$this->json['redirect'] 		= url('/');
            } 
            return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode($this->json));
        }
		

		$this->template->javascript->add('assets/js/jquery.validate.js'); 
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/register/Register.js');
		$this->template->set_template('layout/app');
        $this->template->content->view('register/index', $this->data);
        $this->template->publish();
	}

}