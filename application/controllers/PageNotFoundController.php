<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageNotFoundController extends MX_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->template->set_template('layout/app');
        $this->template->content->view('404/index');
        $this->template->publish();
    }

}