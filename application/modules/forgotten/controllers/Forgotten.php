<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forgotten extends AppController {
    
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model', 'model_user');
		$this->load->model('UserActivity_model', 'model_user_activity');
		$this->lang->load('app/forgotten_lang');
		$this->lang->load('app/emails/forgotten_lang');
		;
    }
    public function index() {

		if ($this->user->isLogged()) {
			$this->redirect($this->url(''));
		}

		if($this->isAjaxRequest() && $this->isPost()) {
			
			$this->request = $this->xss_clean($this->input->post());

			if (!$this->request['email']) {
				$this->json['error']['warning'] = $this->lang->line('error_email');
			} elseif (!$this->model_user->getTotalUsersByEmail($this->request['email'])) {
				$this->json['error']['warning'] = $this->lang->line('error_email');
			}

			if (!$this->json) {
				$code = token(40);

				$this->model_user->editCode($this->request['email'], $code);

				if (isset($this->request['email'])) {

					$this->json['success']      = $this->lang->line('text_success');

					
	
				
					
					$this->session->userdata('success',$this->lang->line('text_success'));

					// Add to activity log
					/*
					if ($this->lang->line('lang_customer_activity')) {
						$customer_info = $this->model_user->getCustomerByEmail($this->request('email'));
	
						if ($customer_info) {
	
							$activity_data = array(
								'id_customers' => $customer_info['id_customers'],
								'name'        => $customer_info['firstname'] . ' ' . $customer_info['lastname']
							);
	
							$this->customer_account_activity->addActivity('forgotten', $activity_data);
						}
					}
					*/

					// Sent mail to user
					$subject        = sprintf($this->lang->line('text_subject'), html_entity_decode($this->lang->line('lang_name'), ENT_QUOTES, 'UTF-8'));
					$reset    		= url('reset?code='. $code) . "\n\n";

					$this->data['reset'] 			= $reset;
					$this->data['text_greeting'] 	= sprintf($this->lang->line('text_greeting'), $this->request['email']);
					$this->data['text_change'] 		= $this->lang->line('text_change');
					$this->data['text_ip'] 			= sprintf($this->lang->line('text_ip'), $this->input->server('REMOTE_ADDR')) . "\n\n";
					$this->data['ip'] 				= $this->input->server('REMOTE_ADDR');

					$mail 							= new Mail($this->config->item('config_mail_engine'));
					$mail->parameter 				= $this->config->item('config_mail_parameter');
					$mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
					$mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
					$mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
					$mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');
			
					$mail->setTo($this->request['email']);
					$mail->setFrom($this->config->item('config_email'));
					$mail->setSender($this->config->item('config_sender_name'));
					$mail->setSubject($subject);
					$mail->setHtml($this->template->content->view('emails/forgotten', $this->data));
					$mail->send(); 

					$this->json['redirect'] = url('login');
				} else {
					$this->json['error']['warning'] = $this->lang->line('error_email');
				}
				
			}
			return $this->output
						->set_content_type('application/json')
						->set_status_header(200)
						->set_output(json_encode($this->json));
		}
		

		$this->template->javascript->add('assets/js/jquery.validate.js'); 
		$this->template->javascript->add('assets/js/additional-methods.js');

		// $this->template->stylesheet->add('assets/js/snackbar.min.css'); 
		// $this->template->javascript->add('assets/js/snackbar.min.js');
		
		$this->template->javascript->add('assets/js/forgotten/Forgotten.js');
		
		$this->template->set_template('layout/app');
		$this->template->content->view('forgotten/index');
		$this->template->publish();
	
	}

}