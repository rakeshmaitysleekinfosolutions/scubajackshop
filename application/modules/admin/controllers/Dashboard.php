<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends AdminController {



    public function __constructor() {
		parent::__construct();

    }

    public function index() {
        $this->template->set_template('layout/admin');
        $this->template->content->view('dashboard/index');
        $this->template->publish();
    }


//    public function validation() {
//        if(!isset($this->request['old']) && empty($this->results['old'])) {
//            $this->error['error_old'] = "Required";
//        }
//        if(!isset($this->request['old']) && empty($this->results['old'])) {
//            $this->error['error_old'] = "Required";
//        }
//        if ($this->error && !isset($this->error['warning'])) {
//            $this->error['warning'] = $this->lang->line('error_warning');
//        }
//    }
}