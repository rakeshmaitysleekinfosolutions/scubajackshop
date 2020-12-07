<?php
class Total {
	
	private $ci;
	public function __construct(){
		$this->ci = &get_instance();
	}
	public function getTotal($total) {
		$total['totals'][] = array(
			'code'       => 'total',
			'title'      => $this->ci->config->item('text_total'),
			'value'      => $total['total'],
			'sort_order' => $this->ci->config->item('total')['value']
		);
	}

	public static function factory($attr = array()) {
		return new Total($attr);
	}
}
