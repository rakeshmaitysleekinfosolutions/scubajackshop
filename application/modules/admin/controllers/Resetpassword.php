<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpassword extends AdminController {
    /**
     * @var mixed
     */
    private $old;
    /**
     * @var mixed
     */
    private $password;
    private $user;
    /**
     * @var mixed
     */
    private $userId;

	public function __constructor() {
		parent::__construct();

    }

    public function index() {
        $this->template->set_template('layout/admin');
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/reset/ResetPassword.js');
        $this->template->content->view('resetpassword/index');
        $this->template->publish();
    }
    public function setRequest() {

        return $this;
    }
    public function updatePassword() {
        if($this->isPost() && $this->isAjaxRequest()) {

            $this->old      = ($this->input->post('old')) ? $this->input->post('old') : '';
            $this->userId   = ($this->input->post('userId')) ? $this->input->post('userId') : '';
            $this->password = ($this->input->post('password')) ? $this->input->post('password') : '';

            if($this->old) {
                $this->user = $this->getUserByPassword($this->old);
                //dd($this->user);
            }
            if(!$this->user) {
                $this->json['warning'] = "Invalid old password, please provide correct password";
            } else {
                $this->changePassword($this->userId, $this->password);
                // Mail Sent to admin
                $subject 						= sprintf('%s - Your Password has been successfully reset!', $this->user->admin_email);
                $this->data['email']            = $this->user->admin_email;
                $this->data['password']         = $this->password;
                $mail 							= new Mail($this->config->item('config_mail_engine'));
                $mail->parameter 				= $this->config->item('config_mail_parameter');
                $mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
                $mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
                $mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
                $mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');
                //$mail->SMTPSecure               = "tls";
                $mail->setTo($this->user->admin_email);
                $mail->setFrom($this->config->item('config_email'));
                $mail->setSender($this->config->item('config_sender_name'));
                $mail->setSubject($subject);

                $mail->setText($this->template->content->view('emails/admin/reset', $this->data));
                //$mail->setHtml(true);

                $mail->send();
                $this->json['success'] = "Password has been successfully updated";
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    public function getUserByPassword($password) {
        $query = $this->db->query("SELECT * FROM bd_admins WHERE admin_password = '" . md5($password) . "'");
        return $query->row();
    }
    public function changePassword($userId, $password) {
        $this->db->query('UPDATE bd_admins SET admin_password = "'.md5($password).'" WHERE admin_id = "'.$userId.'"');
    }
}