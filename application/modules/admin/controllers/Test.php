<?php
class Test extends AdminController {

	public function index() {
	
		//$this->beforeRender();

		$this->template->set_template('layout/admin');
		
		$this->template->content->view('test/index');
		$this->template->publish();
	}
}