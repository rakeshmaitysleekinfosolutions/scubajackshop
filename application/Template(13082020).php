<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template
{
	public $CI; 
	
	public function __construct()
	{
		$this->CI = & get_instance();	
	}
	
	public function admin($page = '', $data = array())
	{
		$layout = $data;
		// $layout['user_session'] = $this->CI->session->userdata();
		$this->CI->load->view('adminIncludes/header', $layout);
		$this->CI->load->view('adminIncludes/side_menu', $layout);
		$this->CI->load->view('adminIncludes/top_menu', $layout);
		$this->CI->load->view($page, $layout);
		$this->CI->load->view('adminIncludes/footer', $layout);

	}
	
	public function user($page = '', $data = array())
	{
		$this->CI->load->view('frontendIncludes/header', $data);
		// $this->CI->load->view('frontendIncludes/dashboard/include/banner', $data);
		// $this->CI->load->view('frontendIncludes/menu', $data);
		$this->CI->load->view($page, $data);
		$this->CI->load->view('frontendIncludes/footer', $data);
	}
	public function app($page = '', $data = array()) {
		$this->CI->load->view('app/header', $data);
		$this->CI->load->view($page, $data);
		$this->CI->load->view('app/footer', $data);
	}

}
