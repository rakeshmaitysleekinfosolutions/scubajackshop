<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends AppController {
    
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model', 'model_user');
        $this->load->model('UserActivity_model', 'model_user_activity');
        $this->lang->load('app/emails/reset_lang');
		$this->lang->load('app/reset_lang');
    }
    public function index() {
        if ($this->user->isLogged()) {
			$this->redirect($this->url(''));
		}
        // $lang_password = __('settings', 'lang_password', true, false);
        // if (!$lang_password) {
		// 	$this->response->redirect(url('signin'));
		// }
		if ($this->input->get('code')) {
            $code = $this->input->get('code');
        } else {
            $code = '';
        }

        $userInfo = $this->model_user->getUserByCode($code);
       
        if ($userInfo) {
            if($this->isAjaxRequest() && $this->isPost()) {

                $this->request = $this->xss_clean($this->input->post());

                if ((strlen($this->request['password']) < 4) || (strlen($this->request['password']) > 20)) {
                    $this->json['error']['password'] = $this->lang->line('error_password');
                }
                if ($this->request['confirm'] != $this->request['password']) {
                    $this->json['error']['confirm'] = $this->lang->line('error_confirm');
                }
                if(!$this->json) {
                    if($this->request['password'] && $this->request['confirm']) {
                        $this->model_user->editPassword($userInfo['email'], $this->request['password']);
                        // $activity_data = array(
                        //     'customer_id' => $userInfo['id'],
                        //     'name'        => $this->request('firstname') . ' ' . $this->request('lastname')
                        // );
                        // $this->customer_account_activity->addActivity('reset_password', $activity_data);
                        
                        $subject 						= sprintf($this->lang->line('text_subject'), $userInfo['firstname']);

                        $this->data['text_welcome'] 	= sprintf($this->lang->line('text_subject'), $userInfo['firstname']);
                        $this->data['text_message']     = sprintf($this->lang->line('text_message'), $this->request['password']);
                        $this->data['text_service'] 	= $this->lang->line('text_service');
                        $this->data['text_thanks'] 		= $this->lang->line('text_thanks');

                        $mail 							= new Mail($this->config->item('config_mail_engine'));
                        $mail->parameter 				= $this->config->item('config_mail_parameter');
                        $mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
                        $mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
                        $mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                        $mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
                        $mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');
                        //$mail->SMTPSecure               = "tls"; 
                        $mail->setTo($userInfo['email']);
                        $mail->setFrom($this->config->item('config_email'));
                        $mail->setSender($this->config->item('config_sender_name'));
                        $mail->setSubject($subject);
                        $mail->setHtml($this->template->content->view('emails/reset', $this->data));

                        $mail->send(); 
                
                        $this->session->userdata('success',$this->lang->line('text_success'));
                        $this->json['success']      = $this->lang->line('text_success');
                        $this->json['redirect']     = url('login');

                        
                    }
                } 
                    return $this->output
                                ->set_content_type('application/json')
                                ->set_status_header(200)
                                ->set_output(json_encode($this->json));
                
              
            }
            $this->data['action'] = url('reset?code=' . $code);
            $this->data['cancel'] = url('login');
            //$this->dd($this->data);

            $this->template->javascript->add('assets/js/jquery.validate.js'); 
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/reset/Reset.js');
        
            $this->template->set_template('layout/app');
            $this->template->content->view('reset/index', $this->data);
            $this->template->publish();
		} else {
			// $this->load->model('Setting_model', 'model_setting_setting');
            // $this->model_setting_setting->editSettingValue('lang', 'lang_password', '0');
            $this->session->userdata('error',$this->lang->line('error_code'));
            $this->redirect('login');
        }
    }
}