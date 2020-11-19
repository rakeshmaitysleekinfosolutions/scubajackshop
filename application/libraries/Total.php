<?php
class Total {
	
	private $ci;
	public function __construct()
	{
		$this->ci = &get_instance();
	}

	public function getTotal($total) {
		$total['totals'][] = array(
			'code'       => 'total',
			'title'      => $this->ci->config->item('text_total'),
			'value'      => $total['total'],
			'sort_order' => __('settings', 'total_sort_order', true, true)
		);
	}

	public function factory($attr = array()) {
		return new Total($attr);
	}
}
