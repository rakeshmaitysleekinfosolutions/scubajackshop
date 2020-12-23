<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends AppController {

	public function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'model_user');
		$this->load->model('UserActivity_model', 'model_user_activity');
		$this->lang->load('app/login_lang');
    }
	public function index() {
		if ($this->user->isLogged()) {
			$this->redirect(url(''));
		}

		if($this->isAjaxRequest() && $this->isPost()) {

			$this->request = $this->xss_clean($this->input->post());

            if (!$this->request['identity']) {
                $this->json['error']['warning'] = $this->lang->line('error_email');
            } elseif (!$this->model_user->getTotalUsersByEmail($this->request['identity'])) {
                $this->json['error']['warning'] = $this->lang->line('error_email');
			}
			
            if ((strlen($this->request['password']) < 4) || (strlen($this->request['password']) > 20)) {
                $this->json['error']['password'] = $this->lang->line('error_password');
			}
			
            if (!$this->json) {
                if($this->user->login($this->request['identity'], $this->request['password'])) {
                    if(!empty($this->request['remember'])) {
                        setcookie ("remember_me",$this->request['remember'],time()+ (10 * 365 * 24 * 60 * 60));
                    } else {
                        if(isset($_COOKIE["remember_me"])) {
                            setcookie ("remember_me","");
                        }
                    }
                    $this->json['success']  = $this->lang->line('text_success');
                    if($this->ecart->hasProducts()) {
                        $this->json['redirect'] = url('checkout/cart');
                    } else {
                        $this->json['redirect'] = url('account');
                    }

                } else {
                    $this->json['error']['warning']            = $this->lang->line('error_login');
                    $this->json['redirect'] = url('login');
                }
            }
            return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode($this->json));
		}
		//$this->template->stylesheet->add('assets/css/preloader.css');
		$this->template->javascript->add('assets/js/jquery.validate.js'); 
        $this->template->javascript->add('assets/js/additional-methods.js');
		$this->template->javascript->add('assets/js/login/Login.js');
		
		$this->template->set_template('layout/app');
		$this->template->content->view('login/index');
		$this->template->publish();
	}

	

}