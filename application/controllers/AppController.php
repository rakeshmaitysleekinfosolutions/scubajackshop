<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppController extends BaseController {
    public function __construct() {
         parent::__construct();
         //Currency_model::factory()->refresh(true, 'USD');

    }

}
