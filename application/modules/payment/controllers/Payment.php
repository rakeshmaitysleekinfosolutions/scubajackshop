<?php
class Payment extends AppController {
    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');
    }

}